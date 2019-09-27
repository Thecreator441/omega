<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class ProvAccReportController extends Controller
{
    public function index()
    {
        return view('omega.pages.prov_acc_report');
    }
}
