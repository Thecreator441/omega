<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class DelinquencyReportController extends Controller
{
    public function index()
    {
        return view('omega.pages.delinquency_report');
    }
}
