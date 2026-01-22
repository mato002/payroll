<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ExportStatusController extends Controller
{
    /**
     * Check the status of an async export job.
     */
    public function status(Request $request, string $jobId)
    {
        $status = Cache::get("export_job_{$jobId}");

        if (!$status) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Export job not found',
            ], 404);
        }

        if ($status['status'] === 'completed') {
            // Generate a signed URL for download (expires in 1 hour)
            $downloadUrl = Storage::disk('local')->temporaryUrl(
                $status['file_path'],
                now()->addHour()
            );

            return response()->json([
                'status' => 'completed',
                'download_url' => $downloadUrl,
                'file_size' => $status['file_size'] ?? null,
            ]);
        }

        if ($status['status'] === 'failed') {
            return response()->json([
                'status' => 'failed',
                'error' => $status['error'] ?? 'Export failed',
            ], 500);
        }

        return response()->json([
            'status' => 'processing',
            'progress' => $status['progress'] ?? 0,
        ]);
    }
}
