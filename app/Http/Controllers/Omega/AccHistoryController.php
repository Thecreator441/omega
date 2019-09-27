<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class AccHistoryController extends Controller
{
    public function index()
    {
        return view('omega.pages.acc_history');
    }
}
