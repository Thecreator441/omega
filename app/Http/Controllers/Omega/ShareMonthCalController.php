<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class ShareMonthCalController extends Controller
{
    public function index()
    {
        return view('omega.pages.share_mon_cal');
    }
}
