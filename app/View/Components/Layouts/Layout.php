<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class Layout extends Component
{
    /**
     * The page title.
     */
    public ?string $title;

    /**
     * Create a new component instance.
     */
    public function __construct(?string $title = null)
    {
        $this->title = $title ?? config('app.name', 'Payroll SaaS');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('layouts.layout');
    }
}
