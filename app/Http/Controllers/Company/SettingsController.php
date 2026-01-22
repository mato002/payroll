<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        // TODO: Implement company settings
        return view('company.settings.index');
    }

    public function update(Request $request)
    {
        // TODO: Implement settings update
        return redirect()->route('companies.settings.index', ['company' => currentCompany()?->slug])
            ->with('success', 'Settings updated successfully.');
    }
}
