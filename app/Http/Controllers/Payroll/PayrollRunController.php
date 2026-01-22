<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayrollRunController extends Controller
{
    public function index()
    {
        // TODO: Implement payroll runs list
        return view('payroll.runs.index');
    }
}
