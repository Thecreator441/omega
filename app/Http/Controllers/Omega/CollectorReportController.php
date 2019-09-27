<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class CollectorReportController extends Controller
{
    public function index()
    {
        return view('omega.pages.collector_report');
    }
}
