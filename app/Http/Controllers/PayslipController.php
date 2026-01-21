<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Payslip;
use App\Services\Payroll\PayslipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PayslipController extends Controller
{
    public function __construct(
        protected PayslipService $payslipService
    ) {
    }

    /**
     * Employee: list own payslips.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $payslips = Payslip::query()
            ->where('employee_id', $user->employee?->id)
            ->orderByDesc('issue_date')
            ->paginate(20);

        return view('payslips.index', compact('payslips'));
    }

    /**
     * Download a single payslip PDF securely from private storage.
     */
    public function download(Request $request, Payslip $payslip)
    {
        Gate::authorize('download', $payslip);

        if (! $payslip->pdf_url) {
            // Generate on demand if missing
            $this->payslipService->generateForItem($payslip->payrollItem);
            $payslip->refresh();
        }

        $disk = Storage::disk('payslips');

        if (! $disk->exists($payslip->pdf_url)) {
            abort(404, 'Payslip file not found');
        }

        // Log the download for audit trail
        AuditLog::create([
            'company_id'  => $payslip->company_id,
            'user_id'     => $request->user()->id,
            'event_type'  => 'payslip_download',
            'description' => sprintf('Payslip %s downloaded', $payslip->payslip_number),
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'entity_type' => Payslip::class,
            'entity_id'   => $payslip->id,
        ]);

        return $disk->download($payslip->pdf_url, $payslip->payslip_number . '.pdf');
    }
}

