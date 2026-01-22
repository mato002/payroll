<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeHelpController extends Controller
{
    /**
     * Show the help and support page.
     */
    public function index(Request $request)
    {
        return view('employee.help');
    }
}
