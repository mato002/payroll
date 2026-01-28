<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\PayrollRun;
use Illuminate\Http\Request;

class PayrollRunController extends Controller
{
    public function index()
    {
        $runs = PayrollRun::query()
            ->withCount('items')
            ->latest('pay_date')
            ->latest('created_at')
            ->paginate(15);

        return view('payroll.runs.index', [
            'runs' => $runs,
        ]);
    }
}
