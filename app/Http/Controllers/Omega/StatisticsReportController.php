<?php

namespace App\Http\Controllers\Omega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticsReportController extends Controller
{
    public function index()
    {
        return view('omega.pages.statistics_report');
    }
}
