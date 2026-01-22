@extends('layouts.layout')

@section('title', 'Design System Examples')

@section('content')
<div class="flex-1">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Design System Examples</h1>

        {{-- Buttons --}}
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Buttons</h2>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <div class="flex flex-wrap gap-4">
                    <x-button variant="primary">Primary</x-button>
                    <x-button variant="secondary">Secondary</x-button>
                    <x-button variant="success">Success</x-button>
                    <x-button variant="danger">Danger</x-button>
                    <x-button variant="warning">Warning</x-button>
                    <x-button variant="outline">Outline</x-button>
                    <x-button variant="ghost">Ghost</x-button>
                    <x-button variant="primary" size="sm">Small</x-button>
                    <x-button variant="primary" size="lg">Large</x-button>
                    <x-button variant="primary" disabled>Disabled</x-button>
                </div>
            </div>
        </section>

        {{-- Badges --}}
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Badges</h2>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <div class="flex flex-wrap gap-4 items-center">
                    <x-badge variant="default">Default</x-badge>
                    <x-badge variant="primary">Primary</x-badge>
                    <x-badge variant="success">Success</x-badge>
                    <x-badge variant="danger">Danger</x-badge>
                    <x-badge variant="warning">Warning</x-badge>
                    <x-badge variant="info">Info</x-badge>
                    <x-badge variant="success" size="sm">Small</x-badge>
                    <x-badge variant="success" size="lg">Large</x-badge>
                </div>
            </div>
        </section>

        {{-- Alerts --}}
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Alerts</h2>
            <div class="space-y-4">
                <x-alert variant="info" title="Information">
                    This is an informational message.
                </x-alert>
                <x-alert variant="success" title="Success!" dismissible>
                    Your action was completed successfully.
                </x-alert>
                <x-alert variant="warning" title="Warning">
                    Please review your input.
                </x-alert>
                <x-alert variant="danger" title="Error" dismissible>
                    Something went wrong.
                </x-alert>
            </div>
        </section>

        {{-- Form Inputs --}}
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Form Inputs</h2>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <div class="grid gap-6 md:grid-cols-2">
                    <x-input 
                        name="email" 
                        label="Email Address" 
                        type="email"
                        placeholder="Enter your email"
                        required
                        hint="We'll never share your email"
                    />
                    
                    <x-input 
                        name="password" 
                        label="Password" 
                        type="password"
                        placeholder="Enter password"
                        required
                        error="Password is required"
                    />
                    
                    <x-select name="status" label="Status" required>
                        <option value="">Select status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </x-select>
                    
                    <x-textarea 
                        name="description" 
                        label="Description"
                        rows="4"
                        placeholder="Enter description"
                        hint="Maximum 500 characters"
                    />
                    
                    <x-checkbox 
                        name="terms" 
                        label="I agree to the terms and conditions"
                        required
                    />
                    
                    <div>
                        <x-label>Select Plan</x-label>
                        <div class="mt-2 space-y-2">
                            <x-radio name="plan" value="basic" label="Basic Plan" />
                            <x-radio name="plan" value="pro" label="Pro Plan" />
                            <x-radio name="plan" value="enterprise" label="Enterprise Plan" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Table --}}
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Table</h2>
            <x-table striped hover>
                @slot('thead')
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                @endslot
                
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">John Doe</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">john@example.com</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-badge variant="success">Active</x-badge>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <x-button variant="ghost" size="sm">Edit</x-button>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">Jane Smith</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">jane@example.com</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-badge variant="warning">Pending</x-badge>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <x-button variant="ghost" size="sm">Edit</x-button>
                    </td>
                </tr>
            </x-table>
        </section>

        {{-- Modal --}}
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Modal</h2>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <x-button variant="primary" @click="$dispatch('open-modal', 'example-modal')">
                    Open Modal
                </x-button>
            </div>
        </section>

        {{-- Modal Component --}}
        <x-modal name="example-modal" title="Example Modal" size="md">
            <p class="text-gray-700 dark:text-gray-300">
                This is an example modal. You can add any content here.
            </p>
            
            @slot('footer')
                <div class="flex justify-end gap-2">
                    <x-button variant="outline" @click="$dispatch('close-modal', 'example-modal')">
                        Cancel
                    </x-button>
                    <x-button variant="primary" @click="$dispatch('close-modal', 'example-modal')">
                        Confirm
                    </x-button>
                </div>
            @endslot
        </x-modal>
    </div>
</div>
@endsection
