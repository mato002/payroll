# Design System

A comprehensive, reusable design system built with Tailwind CSS for the Payroll System application.

## Table of Contents

- [Buttons](#buttons)
- [Badges](#badges)
- [Alerts](#alerts)
- [Modals](#modals)
- [Tables](#tables)
- [Form Inputs](#form-inputs)
- [Utility Classes](#utility-classes)

---

## Buttons

### Component Usage

```blade
<x-button variant="primary" size="md">Click Me</x-button>
```

### Variants

- `primary` - Indigo background (default)
- `secondary` - Gray background
- `success` - Emerald background
- `danger` - Rose background
- `warning` - Amber background
- `outline` - Outlined style
- `ghost` - Transparent background

### Sizes

- `sm` - Small (px-3 py-1.5 text-xs)
- `md` - Medium (px-4 py-2 text-sm) - default
- `lg` - Large (px-6 py-3 text-base)

### Examples

```blade
{{-- Primary button --}}
<x-button variant="primary">Save</x-button>

{{-- With icon --}}
<x-button variant="primary" icon='<svg>...</svg>'>Save</x-button>

{{-- Outline button --}}
<x-button variant="outline">Cancel</x-button>

{{-- Danger button --}}
<x-button variant="danger">Delete</x-button>

{{-- Disabled --}}
<x-button variant="primary" disabled>Disabled</x-button>
```

### Direct Tailwind Classes

```html
<!-- Primary Button -->
<button class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm transition-colors">
    Button Text
</button>

<!-- Outline Button -->
<button class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800">
    Button Text
</button>
```

---

## Badges

### Component Usage

```blade
<x-badge variant="success">Active</x-badge>
```

### Variants

- `default` - Gray
- `primary` - Indigo
- `success` - Emerald
- `danger` - Rose
- `warning` - Amber
- `info` - Sky

### Sizes

- `sm` - Small (px-2 py-0.5 text-xs)
- `md` - Medium (px-2.5 py-0.5 text-xs) - default
- `lg` - Large (px-3 py-1 text-sm)

### Rounded Options

- `full` - Fully rounded (default)
- `md` - Medium rounded
- `lg` - Large rounded

### Examples

```blade
<x-badge variant="success">Active</x-badge>
<x-badge variant="danger" size="lg">Inactive</x-badge>
<x-badge variant="primary" rounded="md">New</x-badge>
```

### Direct Tailwind Classes

```html
<!-- Success Badge -->
<span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
    Active
</span>

<!-- Danger Badge -->
<span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300">
    Inactive
</span>
```

---

## Alerts

### Component Usage

```blade
<x-alert variant="success" title="Success!" dismissible>
    Your changes have been saved.
</x-alert>
```

### Variants

- `info` - Sky blue (default)
- `success` - Emerald green
- `warning` - Amber yellow
- `danger` - Rose red

### Props

- `variant` - Alert style variant
- `title` - Optional alert title
- `dismissible` - Show close button

### Examples

```blade
{{-- Info alert --}}
<x-alert variant="info">
    This is an informational message.
</x-alert>

{{-- Success with title --}}
<x-alert variant="success" title="Success!" dismissible>
    Your action was completed successfully.
</x-alert>

{{-- Warning --}}
<x-alert variant="warning" title="Warning">
    Please review your input.
</x-alert>

{{-- Danger --}}
<x-alert variant="danger" title="Error" dismissible>
    Something went wrong.
</x-alert>
```

### Direct Tailwind Classes

```html
<!-- Success Alert -->
<div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-800 dark:bg-emerald-900/20">
    <div class="flex items-start">
        <div class="flex-shrink-0 text-emerald-400">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="ml-3 flex-1">
            <p class="text-sm text-emerald-800 dark:text-emerald-200">
                Your message here.
            </p>
        </div>
    </div>
</div>
```

---

## Modals

### Component Usage

```blade
<x-modal name="example-modal" title="Example Modal" size="md">
    Modal content here
</x-modal>

{{-- Trigger button --}}
<button @click="$dispatch('open-modal', 'example-modal')">Open Modal</button>
```

### Props

- `name` - Unique modal identifier (required)
- `title` - Modal title
- `size` - Modal size: `sm`, `md`, `lg`, `xl`, `full`
- `closeOnBackdrop` - Close when clicking backdrop (default: true)

### Examples

```blade
{{-- Simple modal --}}
<x-modal name="confirm-delete" title="Confirm Delete">
    <p>Are you sure you want to delete this item?</p>
    
    @slot('footer')
        <div class="flex justify-end gap-2">
            <x-button variant="outline" @click="$dispatch('close-modal', 'confirm-delete')">Cancel</x-button>
            <x-button variant="danger" @click="deleteItem(); $dispatch('close-modal', 'confirm-delete')">Delete</x-button>
        </div>
    @endslot
</x-modal>

{{-- Custom header --}}
<x-modal name="custom-modal" size="lg">
    @slot('header')
        <h3 class="text-lg font-semibold">Custom Header</h3>
    @endslot
    
    Content here
</x-modal>
```

### JavaScript Events

```javascript
// Open modal
window.dispatchEvent(new CustomEvent('open-modal', { detail: 'modal-name' }));

// Close modal
window.dispatchEvent(new CustomEvent('close-modal', { detail: 'modal-name' }));
```

---

## Tables

### Component Usage

```blade
<x-table striped hover>
    <x-slot:thead>
        <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Name</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Email</th>
        </tr>
    </x-slot:thead>
    
    <tr>
        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">John Doe</td>
        <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">john@example.com</td>
    </tr>
</x-table>
```

### Props

- `striped` - Alternate row colors
- `hover` - Hover effect on rows

### Examples

```blade
{{-- Basic table --}}
<x-table>
    <thead class="bg-gray-50 dark:bg-gray-900/40">
        <tr>
            <th class="px-6 py-3 text-left">Column 1</th>
            <th class="px-6 py-3 text-left">Column 2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="px-6 py-4">Data 1</td>
            <td class="px-6 py-4">Data 2</td>
        </tr>
    </tbody>
</x-table>

{{-- Striped and hoverable --}}
<x-table striped hover>
    <!-- table content -->
</x-table>
```

### Direct Tailwind Classes

```html
<div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
    <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800">
        <thead class="bg-gray-50 dark:bg-gray-900/40">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Header</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-950">
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">Data</td>
            </tr>
        </tbody>
    </table>
</div>
```

---

## Form Inputs

### Label

```blade
<x-label for="email" required>Email Address</x-label>
```

### Input

```blade
<x-input 
    name="email" 
    label="Email Address" 
    type="email"
    placeholder="Enter your email"
    required
    :error="$errors->first('email')"
    hint="We'll never share your email"
/>
```

### Textarea

```blade
<textarea 
    name="description" 
    label="Description"
    rows="4"
    placeholder="Enter description"
    required
    :error="$errors->first('description')"
>Old value</textarea>
```

### Select

```blade
<x-select name="status" label="Status" required>
    <option value="">Select status</option>
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
</x-select>
```

### Checkbox

```blade
<x-checkbox 
    name="terms" 
    label="I agree to the terms and conditions"
    required
    :checked="old('terms')"
/>
```

### Radio

```blade
<x-radio 
    name="plan" 
    value="basic" 
    label="Basic Plan"
    :checked="old('plan') === 'basic'"
/>
```

### Direct Tailwind Classes

```html
<!-- Text Input -->
<div class="space-y-1">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Label <span class="text-rose-500">*</span>
    </label>
    <input 
        type="text"
        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
    />
    <p class="text-sm text-gray-500 dark:text-gray-400">Hint text</p>
</div>

<!-- Input with Error -->
<div class="space-y-1">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Email
    </label>
    <input 
        type="email"
        class="block w-full rounded-md border-rose-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 dark:border-rose-600 dark:bg-gray-700 dark:text-white sm:text-sm"
    />
    <p class="text-sm text-rose-600 dark:text-rose-400">Error message</p>
</div>
```

---

## Utility Classes

### Card Container

```html
<div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
    Content here
</div>
```

### Section Header

```html
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Title</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Subtitle</p>
    </div>
</div>
```

### Loading Spinner

```html
<div class="flex items-center justify-center">
    <svg class="h-6 w-6 animate-spin text-indigo-600" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
</div>
```

### Empty State

```html
<div class="text-center py-12">
    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
    </svg>
    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No items</h3>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new item.</p>
</div>
```

---

## Color Palette

### Primary Colors
- Indigo: `indigo-50` through `indigo-900`
- Used for: Primary actions, links, focus states

### Status Colors
- Success: `emerald-50` through `emerald-900`
- Danger: `rose-50` through `rose-900`
- Warning: `amber-50` through `amber-900`
- Info: `sky-50` through `sky-900`

### Neutral Colors
- Gray: `gray-50` through `gray-900`
- Used for: Text, borders, backgrounds

### Dark Mode
All components support dark mode using Tailwind's `dark:` prefix. The design system automatically adapts colors for dark mode.

---

## Best Practices

1. **Consistency**: Always use components instead of raw HTML when possible
2. **Accessibility**: Include proper labels, ARIA attributes, and keyboard navigation
3. **Responsive**: All components are mobile-friendly by default
4. **Dark Mode**: All components support dark mode automatically
5. **Error Handling**: Always show error messages for form inputs
6. **Loading States**: Use spinners or skeleton loaders for async operations

---

## Component Location

All components are located in: `resources/views/components/`

- `button.blade.php`
- `badge.blade.php`
- `alert.blade.php`
- `modal.blade.php`
- `table.blade.php`
- `input.blade.php`
- `textarea.blade.php`
- `select.blade.php`
- `checkbox.blade.php`
- `radio.blade.php`
- `label.blade.php`
