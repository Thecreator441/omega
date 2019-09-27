<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class ProvisionReportController extends Controller
{
    public function index()
    {
        return view('omega.pages.provision_report');
    }
}
