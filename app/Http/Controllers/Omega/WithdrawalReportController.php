<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class WithdrawalReportController extends Controller
{
    public function index()
    {
        return view('omega.pages.withdrawal_report');
    }
}
