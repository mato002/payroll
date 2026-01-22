<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'exportUrl' => '#',
    'formats' => ['xlsx' => 'Excel (.xlsx)', 'csv' => 'CSV (.csv)', 'pdf' => 'PDF (.pdf)'],
    'defaultFormat' => 'xlsx',
    'label' => 'Export',
    'icon' => true,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'exportUrl' => '#',
    'formats' => ['xlsx' => 'Excel (.xlsx)', 'csv' => 'CSV (.csv)', 'pdf' => 'PDF (.pdf)'],
    'defaultFormat' => 'xlsx',
    'label' => 'Export',
    'icon' => true,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div x-data="exportManager('<?php echo e($exportUrl); ?>', <?php echo e(json_encode($formats)); ?>, '<?php echo e($defaultFormat); ?>')" class="relative">
    
    <div class="relative inline-block text-left">
        <button
            type="button"
            @click="open = !open"
            @click.away="open = false"
            :disabled="exporting"
            class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
        >
            <?php if($icon): ?>
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
            <?php endif; ?>
            <span><?php echo e($label); ?></span>
            <svg class="-mr-1 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
        </button>

        
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            x-cloak
            class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800 dark:ring-gray-700"
        >
            <div class="py-1">
                <div class="px-4 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400">
                    Export Format
                </div>
                <?php $__currentLoopData = $formats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $format => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button
                        type="button"
                        @click="startExport('<?php echo e($format); ?>')"
                        :disabled="exporting"
                        class="flex w-full items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        <span><?php echo e($label); ?></span>
                        <svg x-show="selectedFormat === '<?php echo e($format); ?>'" class="h-4 w-4 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    
    <div
        x-show="exporting"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm"
        @click.away="cancelExport()"
    >
        <div class="mx-4 w-full max-w-md rounded-lg bg-white p-6 shadow-xl dark:bg-gray-800">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Exporting...</h3>
                <button
                    type="button"
                    @click="cancelExport()"
                    class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <span class="sr-only">Cancel</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                </button>
            </div>

            <div class="mb-4">
                <div class="mb-2 flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400" x-text="progressMessage"></span>
                    <span class="font-medium text-gray-900 dark:text-gray-100" x-text="progressPercent + '%'"></span>
                </div>
                <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                    <div
                        class="h-full bg-indigo-600 transition-all duration-300 ease-out dark:bg-indigo-500"
                        :style="'width: ' + progressPercent + '%'"
                    ></div>
                </div>
            </div>

            <p class="text-sm text-gray-500 dark:text-gray-400" x-text="statusMessage"></p>
        </div>
    </div>

    
    <div
        x-show="showSuccess"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed bottom-4 right-4 z-50 max-w-sm rounded-lg bg-white p-4 shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800 dark:ring-gray-700"
    >
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3 w-0 flex-1">
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Export successful!</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" x-text="successMessage"></p>
            </div>
            <div class="ml-4 flex flex-shrink-0">
                <button
                    type="button"
                    @click="showSuccess = false"
                    class="inline-flex rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    
    <div
        x-show="showError"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed bottom-4 right-4 z-50 max-w-sm rounded-lg bg-white p-4 shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800 dark:ring-gray-700"
    >
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3 w-0 flex-1">
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Export failed</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" x-text="errorMessage"></p>
            </div>
            <div class="ml-4 flex flex-shrink-0">
                <button
                    type="button"
                    @click="showError = false"
                    class="inline-flex rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function exportManager(exportUrl, formats, defaultFormat) {
    return {
        open: false,
        exporting: false,
        selectedFormat: defaultFormat,
        progressPercent: 0,
        progressMessage: 'Preparing export...',
        statusMessage: 'Please wait while we generate your file.',
        showSuccess: false,
        showError: false,
        successMessage: '',
        errorMessage: '',
        abortController: null,
        progressInterval: null,

        startExport(format) {
            this.selectedFormat = format;
            this.open = false;
            this.exporting = true;
            this.progressPercent = 0;
            this.progressMessage = 'Preparing export...';
            this.statusMessage = 'Please wait while we generate your file.';
            this.showSuccess = false;
            this.showError = false;

            // Create abort controller for cancellation
            this.abortController = new AbortController();

            // Simulate progress for better UX
            this.simulateProgress();

            // Start actual export
            this.performExport(format);
        },

        simulateProgress() {
            let currentProgress = 0;
            this.progressInterval = setInterval(() => {
                if (currentProgress < 90) {
                    currentProgress += Math.random() * 15;
                    if (currentProgress > 90) currentProgress = 90;
                    this.progressPercent = Math.floor(currentProgress);
                    
                    if (currentProgress < 30) {
                        this.progressMessage = 'Gathering data...';
                        this.statusMessage = 'Collecting records for export.';
                    } else if (currentProgress < 60) {
                        this.progressMessage = 'Processing...';
                        this.statusMessage = 'Formatting data and generating file.';
                    } else {
                        this.progressMessage = 'Finalizing...';
                        this.statusMessage = 'Almost done! Preparing download.';
                    }
                }
            }, 300);
        },

        async performExport(format) {
            try {
                const url = new URL(exportUrl, window.location.origin);
                url.searchParams.set('format', format);

                const response = await fetch(url, {
                    method: 'GET',
                    signal: this.abortController.signal,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                clearInterval(this.progressInterval);
                this.progressPercent = 100;
                this.progressMessage = 'Complete!';

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({ message: 'Export failed' }));
                    throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                }

                // Check if response is a file download
                const contentType = response.headers.get('content-type');
                if (contentType && (contentType.includes('application/vnd') || contentType.includes('application/pdf') || contentType.includes('text/csv'))) {
                    // Handle file download
                    const blob = await response.blob();
                    
                    // Check file size (warn if > 50MB)
                    const fileSizeMB = blob.size / (1024 * 1024);
                    if (fileSizeMB > 50) {
                        this.showError = true;
                        this.errorMessage = `File is too large (${fileSizeMB.toFixed(1)}MB). Please contact support for large exports.`;
                        this.exporting = false;
                        return;
                    }

                    const downloadUrl = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = downloadUrl;
                    a.download = response.headers.get('content-disposition')?.split('filename=')[1]?.replace(/"/g, '') || `export.${format}`;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(downloadUrl);

                    this.successMessage = `File downloaded successfully (${fileSizeMB.toFixed(2)}MB).`;
                    this.showSuccess = true;
                    setTimeout(() => {
                        this.showSuccess = false;
                    }, 5000);
                } else {
                    // Handle JSON response (async export)
                    const data = await response.json();
                    if (data.job_id) {
                        this.statusMessage = 'Large file detected. Processing in background...';
                        this.pollExportStatus(data.job_id);
                    } else {
                        throw new Error(data.message || 'Unexpected response format');
                    }
                }

                this.exporting = false;
            } catch (error) {
                clearInterval(this.progressInterval);
                this.exporting = false;
                
                if (error.name === 'AbortError') {
                    this.progressMessage = 'Cancelled';
                    this.statusMessage = 'Export was cancelled.';
                } else {
                    this.showError = true;
                    this.errorMessage = error.message || 'An error occurred during export. Please try again.';
                    console.error('Export error:', error);
                }
            }
        },

        async pollExportStatus(jobId) {
            const maxAttempts = 60; // 5 minutes max
            let attempts = 0;

            const checkStatus = async () => {
                try {
                    const response = await fetch(`/api/exports/${jobId}/status`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });

                    if (!response.ok) throw new Error('Status check failed');

                    const data = await response.json();

                    if (data.status === 'completed') {
                        clearInterval(this.progressInterval);
                        this.progressPercent = 100;
                        this.progressMessage = 'Complete!';
                        
                        // Trigger download
                        window.location.href = data.download_url;
                        
                        this.successMessage = 'Large file export completed! Download started.';
                        this.showSuccess = true;
                        setTimeout(() => {
                            this.showSuccess = false;
                        }, 5000);
                        this.exporting = false;
                    } else if (data.status === 'failed') {
                        throw new Error(data.error || 'Export failed');
                    } else {
                        // Still processing
                        this.progressPercent = Math.min(90, 30 + (attempts * 2));
                        this.statusMessage = `Processing... (${attempts}/${maxAttempts})`;
                        attempts++;

                        if (attempts >= maxAttempts) {
                            throw new Error('Export timeout. Please try again later.');
                        } else {
                            setTimeout(checkStatus, 5000); // Check every 5 seconds
                        }
                    }
                } catch (error) {
                    clearInterval(this.progressInterval);
                    this.exporting = false;
                    this.showError = true;
                    this.errorMessage = error.message || 'Failed to check export status.';
                }
            };

            checkStatus();
        },

        cancelExport() {
            if (this.abortController) {
                this.abortController.abort();
            }
            if (this.progressInterval) {
                clearInterval(this.progressInterval);
            }
            this.exporting = false;
            this.progressPercent = 0;
        }
    }
}
</script>
<?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/components/export-dropdown.blade.php ENDPATH**/ ?>