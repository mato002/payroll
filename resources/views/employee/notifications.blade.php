@extends('layouts.layout')

@section('title', __('Notifications'))

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('Notifications') }}
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Stay updated with your payroll information') }}
                </p>
            </div>

            @if($notifications->where('read_at', null)->count() > 0)
                <form method="POST" action="{{ route('companies.employee.notifications.read-all', ['company' => currentCompany()?->slug]) }}">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800 min-h-[44px]"
                    >
                        {{ __('Mark all as read') }}
                    </button>
                </form>
            @endif
        </div>

        {{-- Notifications List --}}
        <div class="space-y-3">
            @forelse($notifications as $notification)
                <div
                    class="rounded-lg border {{ $notification->read_at ? 'border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-950' : 'border-indigo-200 bg-indigo-50 dark:border-indigo-900/50 dark:bg-indigo-950/30' }} p-4 shadow-sm"
                >
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </h3>
                                @if(!$notification->read_at)
                                    <span class="inline-flex h-2 w-2 rounded-full bg-indigo-600"></span>
                                @endif
                            </div>
                            <p class="mt-1 text-xs text-gray-600 dark:text-gray-300">
                                {{ $notification->data['message'] ?? '' }}
                            </p>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        @if(!$notification->read_at)
                            <form method="POST" action="{{ route('companies.employee.notifications.read', ['company' => currentCompany()?->slug, 'id' => $notification->id]) }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="text-xs font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300"
                                >
                                    {{ __('Mark as read') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="rounded-lg border border-gray-200 bg-white p-8 text-center dark:border-gray-800 dark:bg-gray-950">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('No notifications found.') }}
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection
