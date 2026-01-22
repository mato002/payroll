<?php
    $user = auth()->user();
    $companies = $user ? $user->companies()
        ->where('company_user.status', 'active')
        ->orderBy('companies.name')
        ->get() : collect();
    $currentCompany = app(\App\Tenancy\CurrentCompany::class)->get();
?>

<?php if($companies->count() > 1): ?>
    <div class="relative" x-data="{ open: false }">
        <button 
            @click="open = !open"
            class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
            <span class="truncate max-w-[150px]">
                <?php echo e($currentCompany ? $currentCompany->name : 'Select Company'); ?>

            </span>
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div 
            x-show="open"
            @click.away="open = false"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg z-50 border border-gray-200"
            style="display: none;"
        >
            <div class="py-1">
                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <form action="<?php echo e(route('companies.switch.store', $company)); ?>" method="POST" class="block">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="redirect_to" value="<?php echo e(url()->current()); ?>">
                        <button 
                            type="submit"
                            class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 transition-colors flex items-center justify-between
                            <?php echo e($currentCompany && $currentCompany->id === $company->id ? 'bg-blue-50 text-blue-700' : 'text-gray-700'); ?>"
                        >
                            <span class="truncate"><?php echo e($company->name); ?></span>
                            <?php if($currentCompany && $currentCompany->id === $company->id): ?>
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            <?php endif; ?>
                        </button>
                    </form>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <div class="border-t border-gray-200 mt-1">
                    <a href="<?php echo e(route('companies.switch.index')); ?>" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Manage companies
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php elseif($currentCompany): ?>
    <div class="px-3 py-2 text-sm font-medium text-gray-700">
        <?php echo e($currentCompany->name); ?>

    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/components/company-switcher.blade.php ENDPATH**/ ?>