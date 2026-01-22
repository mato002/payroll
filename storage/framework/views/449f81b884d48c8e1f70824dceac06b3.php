<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'notifications' => [],
    'apiEndpoint' => null, // Optional: API endpoint for fetching notifications
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
    'notifications' => [],
    'apiEndpoint' => null, // Optional: API endpoint for fetching notifications
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div 
    x-data="{
        open: false,
        loading: false,
        error: null,
        notifications: <?php echo \Illuminate\Support\Js::from($notifications ?? [])->toHtml() ?>,
        unreadCount: <?php echo \Illuminate\Support\Js::from(collect($notifications ?? [])->where('read', false)->count())->toHtml() ?>,
        processingIds: new Set(),
        
        async init() {
            // Auto-refresh notifications when dropdown opens
            this.$watch('open', (value) => {
                if (value && this.apiEndpoint) {
                    this.fetchNotifications();
                }
            });
        },
        
        async fetchNotifications() {
            if (!this.apiEndpoint) return;
            
            this.loading = true;
            this.error = null;
            
            try {
                const response = await fetch(this.apiEndpoint, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin'
                });
                
                if (!response.ok) {
                    throw new Error('Failed to fetch notifications');
                }
                
                const data = await response.json();
                this.notifications = data.notifications || [];
                this.unreadCount = this.notifications.filter(n => !n.read).length;
            } catch (err) {
                this.error = 'Unable to load notifications. Please try again.';
                console.error('Notification fetch error:', err);
            } finally {
                this.loading = false;
            }
        },
        
        async markAsRead(id) {
            if (this.processingIds.has(id)) return;
            
            const notification = this.notifications.find(n => n.id === id);
            if (!notification || notification.read) return;
            
            this.processingIds.add(id);
            const previousState = notification.read;
            
            // Optimistic update
            notification.read = true;
            this.unreadCount = Math.max(0, this.unreadCount - 1);
            
            try {
                const response = await fetch(`/notifications/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || ''
                    },
                    credentials: 'same-origin'
                });
                
                if (!response.ok) {
                    throw new Error('Failed to mark as read');
                }
                
                if (window.showToast) {
                    window.showToast('success', 'Notification marked as read');
                }
            } catch (err) {
                // Revert on error
                notification.read = previousState;
                this.unreadCount += previousState ? 0 : 1;
                
                if (window.showToast) {
                    window.showToast('error', 'Failed to mark notification as read');
                }
                console.error('Mark as read error:', err);
            } finally {
                this.processingIds.delete(id);
            }
        },
        
        async markAllAsRead() {
            if (this.unreadCount === 0) return;
            if (this.processingIds.has('all')) return;
            
            this.processingIds.add('all');
            const previousNotifications = JSON.parse(JSON.stringify(this.notifications));
            const previousCount = this.unreadCount;
            
            // Optimistic update
            this.notifications.forEach(n => {
                if (!n.read) {
                    n.read = true;
                }
            });
            this.unreadCount = 0;
            
            try {
                const response = await fetch('/notifications/read-all', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || ''
                    },
                    credentials: 'same-origin'
                });
                
                if (!response.ok) {
                    throw new Error('Failed to mark all as read');
                }
                
                if (window.showToast) {
                    window.showToast('success', 'All notifications marked as read');
                }
            } catch (err) {
                // Revert on error
                this.notifications = previousNotifications;
                this.unreadCount = previousCount;
                
                if (window.showToast) {
                    window.showToast('error', 'Failed to mark all notifications as read');
                }
                console.error('Mark all as read error:', err);
            } finally {
                this.processingIds.delete('all');
            }
        },
        
        async deleteNotification(id) {
            if (this.processingIds.has(id)) return;
            
            const notification = this.notifications.find(n => n.id === id);
            if (!notification) return;
            
            this.processingIds.add(id);
            const wasUnread = !notification.read;
            const previousNotifications = [...this.notifications];
            
            // Optimistic update
            this.notifications = this.notifications.filter(n => n.id !== id);
            if (wasUnread) {
                this.unreadCount = Math.max(0, this.unreadCount - 1);
            }
            
            try {
                const response = await fetch(`/notifications/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || ''
                    },
                    credentials: 'same-origin'
                });
                
                if (!response.ok) {
                    throw new Error('Failed to delete notification');
                }
                
                if (window.showToast) {
                    window.showToast('success', 'Notification deleted');
                }
            } catch (err) {
                // Revert on error
                this.notifications = previousNotifications;
                if (wasUnread) {
                    this.unreadCount += 1;
                }
                
                if (window.showToast) {
                    window.showToast('error', 'Failed to delete notification');
                }
                console.error('Delete notification error:', err);
            } finally {
                this.processingIds.delete(id);
            }
        }
    }"
    class="relative"
>
    
    <button
        type="button"
        @click="open = !open"
        :disabled="loading"
        class="relative inline-flex items-center justify-center rounded-full border border-gray-200 bg-white p-2 text-gray-500 shadow-sm hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
        aria-label="Notifications"
    >
        <template x-if="loading">
            <?php if (isset($component)) { $__componentOriginal5c29929acf227acd7c5fa56a39e71fcc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.loading-spinner','data' => ['size' => 'sm','color' => 'gray']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('loading-spinner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'sm','color' => 'gray']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc)): ?>
<?php $attributes = $__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc; ?>
<?php unset($__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c29929acf227acd7c5fa56a39e71fcc)): ?>
<?php $component = $__componentOriginal5c29929acf227acd7c5fa56a39e71fcc; ?>
<?php unset($__componentOriginal5c29929acf227acd7c5fa56a39e71fcc); ?>
<?php endif; ?>
        </template>
        <template x-if="!loading">
            <svg 
                class="h-5 w-5" 
                xmlns="http://www.w3.org/2000/svg" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke-width="1.5" 
                stroke="currentColor"
            >
                <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" 
                />
            </svg>
        </template>
        
        
        <span 
            x-show="unreadCount > 0 && !loading"
            x-cloak
            class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-semibold text-white ring-2 ring-white dark:ring-gray-800"
        >
            <span x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
        </span>
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
        class="absolute right-0 mt-2 w-80 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800 dark:ring-gray-700 z-50"
        style="display: none;"
    >
        
        <div class="flex items-center justify-between border-b border-gray-200 px-4 py-3 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                Notifications
            </h3>
            <div class="flex items-center space-x-2">
                <button
                    x-show="unreadCount > 0 && !loading && !error"
                    x-cloak
                    @click="markAllAsRead()"
                    :disabled="processingIds.has('all')"
                    class="text-xs font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center space-x-1"
                >
                    <template x-if="processingIds.has('all')">
                        <?php if (isset($component)) { $__componentOriginal5c29929acf227acd7c5fa56a39e71fcc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.loading-spinner','data' => ['size' => 'sm','color' => 'indigo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('loading-spinner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'sm','color' => 'indigo']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc)): ?>
<?php $attributes = $__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc; ?>
<?php unset($__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c29929acf227acd7c5fa56a39e71fcc)): ?>
<?php $component = $__componentOriginal5c29929acf227acd7c5fa56a39e71fcc; ?>
<?php unset($__componentOriginal5c29929acf227acd7c5fa56a39e71fcc); ?>
<?php endif; ?>
                    </template>
                    <span x-show="!processingIds.has('all')">Mark all read</span>
                </button>
                <button
                    x-show="!loading && !error && notifications.length > 0"
                    @click="fetchNotifications()"
                    class="rounded p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                    title="Refresh"
                >
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </button>
            </div>
        </div>

        
        <div class="max-h-96 overflow-y-auto">
            
            <template x-if="loading && notifications.length === 0">
                <div class="flex flex-col items-center justify-center px-4 py-12">
                    <?php if (isset($component)) { $__componentOriginal5c29929acf227acd7c5fa56a39e71fcc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.loading-spinner','data' => ['size' => 'lg','color' => 'indigo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('loading-spinner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'lg','color' => 'indigo']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc)): ?>
<?php $attributes = $__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc; ?>
<?php unset($__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c29929acf227acd7c5fa56a39e71fcc)): ?>
<?php $component = $__componentOriginal5c29929acf227acd7c5fa56a39e71fcc; ?>
<?php unset($__componentOriginal5c29929acf227acd7c5fa56a39e71fcc); ?>
<?php endif; ?>
                    <p class="mt-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                        Loading notifications...
                    </p>
                </div>
            </template>

            
            <template x-if="error && notifications.length === 0">
                <div class="flex flex-col items-center justify-center px-4 py-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-rose-100 dark:bg-rose-900/20">
                        <svg 
                            class="h-6 w-6 text-rose-600 dark:text-rose-400" 
                            xmlns="http://www.w3.org/2000/svg" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke-width="1.5" 
                            stroke="currentColor"
                        >
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" 
                            />
                        </svg>
                    </div>
                    <p class="mt-4 text-sm font-semibold text-gray-900 dark:text-gray-100">
                        Failed to load notifications
                    </p>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 max-w-sm" x-text="error"></p>
                    <button
                        @click="fetchNotifications()"
                        class="mt-4 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-xs font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors"
                    >
                        Try again
                    </button>
                </div>
            </template>

            
            <template x-if="!loading && !error && notifications.length === 0">
                <div class="flex flex-col items-center justify-center px-4 py-12 text-center">
                    <svg 
                        class="h-12 w-12 text-gray-400 dark:text-gray-500" 
                        xmlns="http://www.w3.org/2000/svg" 
                        fill="none" 
                        viewBox="0 0 24 24" 
                        stroke-width="1.5" 
                        stroke="currentColor"
                    >
                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" 
                        />
                    </svg>
                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                        No notifications
                    </p>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        You're all caught up! We'll notify you when there's something new.
                    </p>
                </div>
            </template>

            
            <template x-if="!loading && !error && notifications.length > 0">
                <div>
                    <template x-for="(notification, index) in notifications" :key="notification.id">
                        <div 
                            :class="{
                                'bg-indigo-50 dark:bg-indigo-900/10': !notification.read,
                                'bg-white dark:bg-gray-800': notification.read
                            }"
                            class="border-b border-gray-200 dark:border-gray-700 transition-colors hover:bg-gray-50 dark:hover:bg-gray-700/50"
                        >
                            <div class="flex items-start px-4 py-3">
                                
                                <div 
                                    x-show="!notification.read"
                                    x-cloak
                                    class="mt-2 mr-3 h-2 w-2 flex-shrink-0 rounded-full bg-indigo-600"
                                ></div>
                                <div 
                                    x-show="notification.read"
                                    class="mt-2 mr-3 h-2 w-2 flex-shrink-0"
                                ></div>

                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <p 
                                                :class="{
                                                    'font-semibold text-gray-900 dark:text-gray-100': !notification.read,
                                                    'font-medium text-gray-700 dark:text-gray-300': notification.read
                                                }"
                                                class="text-sm"
                                                x-text="notification.title"
                                            ></p>
                                            <p 
                                                class="mt-1 text-xs text-gray-500 dark:text-gray-400 line-clamp-2"
                                                x-text="notification.message"
                                            ></p>
                                            <p 
                                                class="mt-1 text-xs text-gray-400 dark:text-gray-500"
                                                x-text="notification.time"
                                            ></p>
                                        </div>

                                        
                                        <div class="ml-2 flex items-center space-x-1">
                                            <button
                                                x-show="!notification.read && !processingIds.has(notification.id)"
                                                x-cloak
                                                @click="markAsRead(notification.id)"
                                                class="rounded p-1 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:hover:bg-gray-600 dark:hover:text-gray-300 transition-colors"
                                                title="Mark as read"
                                            >
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                            <div
                                                x-show="processingIds.has(notification.id)"
                                                class="p-1"
                                            >
                                                <?php if (isset($component)) { $__componentOriginal5c29929acf227acd7c5fa56a39e71fcc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.loading-spinner','data' => ['size' => 'sm','color' => 'gray']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('loading-spinner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'sm','color' => 'gray']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc)): ?>
<?php $attributes = $__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc; ?>
<?php unset($__attributesOriginal5c29929acf227acd7c5fa56a39e71fcc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c29929acf227acd7c5fa56a39e71fcc)): ?>
<?php $component = $__componentOriginal5c29929acf227acd7c5fa56a39e71fcc; ?>
<?php unset($__componentOriginal5c29929acf227acd7c5fa56a39e71fcc); ?>
<?php endif; ?>
                                            </div>
                                            <button
                                                x-show="!processingIds.has(notification.id)"
                                                @click="deleteNotification(notification.id)"
                                                class="rounded p-1 text-gray-400 hover:bg-gray-200 hover:text-red-600 dark:hover:bg-gray-600 dark:hover:text-red-400 transition-colors"
                                                title="Delete"
                                            >
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    
                                    <template x-if="notification.action_url">
                                        <a 
                                            :href="notification.action_url"
                                            class="mt-2 inline-block text-xs font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors"
                                        >
                                            View details →
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        
        <div 
            x-show="notifications.length > 0 && !loading && !error"
            class="border-t border-gray-200 px-4 py-2 dark:border-gray-700"
        >
            <a 
                href="#"
                class="block text-center text-xs font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors"
            >
                View all notifications
            </a>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/components/notification-bell.blade.php ENDPATH**/ ?>