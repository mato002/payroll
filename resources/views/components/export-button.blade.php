@props([
    'exportUrl' => '#',
    'format' => 'xlsx',
    'label' => 'Export',
    'icon' => true,
    'size' => 'default', // 'sm', 'default', 'lg'
])

@php
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-xs',
        'default' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];
@endphp

<div x-data="simpleExportManager('{{ $exportUrl }}', '{{ $format }}')" class="inline-block">
    <button
        type="button"
        @click="startExport()"
        :disabled="exporting"
        class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white {{ $sizeClasses[$size] }} font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
    >
        <template x-if="!exporting">
            <div class="flex items-center gap-2">
                @if($icon)
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                @endif
                <span>{{ $label }}</span>
            </div>
        </template>
        <template x-if="exporting">
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Exporting...</span>
            </div>
        </template>
    </button>

    {{-- Success/Error Toasts (reuse from export-dropdown) --}}
    <div
        x-show="showSuccess"
        x-cloak
        x-transition
        class="fixed bottom-4 right-4 z-50 max-w-sm rounded-lg bg-white p-4 shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800"
    >
        <div class="flex items-center gap-3">
            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="successMessage"></p>
        </div>
    </div>

    <div
        x-show="showError"
        x-cloak
        x-transition
        class="fixed bottom-4 right-4 z-50 max-w-sm rounded-lg bg-white p-4 shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800"
    >
        <div class="flex items-center gap-3">
            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
            </svg>
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="errorMessage"></p>
        </div>
    </div>
</div>

<script>
function simpleExportManager(exportUrl, format) {
    return {
        exporting: false,
        showSuccess: false,
        showError: false,
        successMessage: 'File downloaded successfully!',
        errorMessage: '',

        async startExport() {
            this.exporting = true;
            this.showSuccess = false;
            this.showError = false;

            try {
                const url = new URL(exportUrl, window.location.origin);
                url.searchParams.set('format', format);

                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({ message: 'Export failed' }));
                    throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                }

                const contentType = response.headers.get('content-type');
                if (contentType && (contentType.includes('application/vnd') || contentType.includes('application/pdf') || contentType.includes('text/csv'))) {
                    const blob = await response.blob();
                    const fileSizeMB = blob.size / (1024 * 1024);
                    
                    if (fileSizeMB > 50) {
                        throw new Error(`File is too large (${fileSizeMB.toFixed(1)}MB). Please contact support for large exports.`);
                    }

                    const downloadUrl = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = downloadUrl;
                    a.download = response.headers.get('content-disposition')?.split('filename=')[1]?.replace(/"/g, '') || `export.${format}`;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(downloadUrl);

                    this.successMessage = `File downloaded (${fileSizeMB.toFixed(2)}MB)`;
                    this.showSuccess = true;
                    setTimeout(() => {
                        this.showSuccess = false;
                    }, 3000);
                } else {
                    const data = await response.json();
                    if (data.job_id) {
                        this.errorMessage = 'Large file detected. You will receive a notification when ready.';
                        this.showError = true;
                    } else {
                        throw new Error(data.message || 'Unexpected response format');
                    }
                }
            } catch (error) {
                this.showError = true;
                this.errorMessage = error.message || 'An error occurred during export. Please try again.';
                console.error('Export error:', error);
            } finally {
                this.exporting = false;
            }
        }
    }
}
</script>
