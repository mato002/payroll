<?php

namespace App\Services\Reporting;

use App\Models\Company;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PDF; // barryvdh/laravel-dompdf facade

class ReportExporter
{
    /**
     * Generate PDF report and return storage path.
     */
    public function toPdf(
        Collection $data,
        string $view,
        string $title,
        Company $company,
        array $additionalData = []
    ): string {
        $viewData = array_merge([
            'data' => $data,
            'company' => $company,
            'title' => $title,
            'generatedAt' => now(),
        ], $additionalData);

        $pdf = PDF::loadView($view, $viewData)->setPaper('A4', 'portrait');

        $fileName = sprintf(
            'reports/%s/%s-%s.pdf',
            $company->id,
            Str::slug($title),
            now()->format('Y-m-d-His')
        );

        Storage::disk('local')->put($fileName, $pdf->output());

        return $fileName;
    }

    /**
     * Generate Excel report and return storage path.
     */
    public function toExcel(
        Collection $data,
        string $filename,
        array $headings = [],
        ?callable $mapping = null
    ): string {
        $export = new class($data, $headings, $mapping) implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle {
            public function __construct(
                private Collection $data,
                private array $headings,
                private ?callable $mapping
            ) {}

            public function collection(): Collection
            {
                return $this->data;
            }

            public function headings(): array
            {
                return $this->headings;
            }

            public function map($row): array
            {
                if ($this->mapping) {
                    return ($this->mapping)($row);
                }

                return is_array($row) ? $row : $row->toArray();
            }

            public function styles(Worksheet $sheet): void
            {
                // Style header row
                $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E5E7EB'],
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Auto-size columns
                foreach (range('A', $sheet->getHighestColumn()) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }

            public function title(): string
            {
                return 'Report';
            }
        };

        $filePath = 'reports/' . $filename . '.xlsx';
        Excel::store($export, $filePath, 'local');

        return $filePath;
    }

    /**
     * Download PDF report.
     */
    public function downloadPdf(
        Collection $data,
        string $view,
        string $title,
        Company $company,
        array $additionalData = []
    ) {
        $viewData = array_merge([
            'data' => $data,
            'company' => $company,
            'title' => $title,
            'generatedAt' => now(),
        ], $additionalData);

        $pdf = PDF::loadView($view, $viewData)->setPaper('A4', 'portrait');

        return $pdf->download(Str::slug($title) . '-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Download Excel report.
     */
    public function downloadExcel(
        Collection $data,
        string $filename,
        array $headings = [],
        ?callable $mapping = null
    ) {
        $export = new class($data, $headings, $mapping) implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle {
            public function __construct(
                private Collection $data,
                private array $headings,
                private ?callable $mapping
            ) {}

            public function collection(): Collection
            {
                return $this->data;
            }

            public function headings(): array
            {
                return $this->headings;
            }

            public function map($row): array
            {
                if ($this->mapping) {
                    return ($this->mapping)($row);
                }

                return is_array($row) ? $row : $row->toArray();
            }

            public function styles(Worksheet $sheet): void
            {
                $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E5E7EB'],
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                foreach (range('A', $sheet->getHighestColumn()) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }

            public function title(): string
            {
                return 'Report';
            }
        };

        return Excel::download($export, $filename . '.xlsx');
    }
}
