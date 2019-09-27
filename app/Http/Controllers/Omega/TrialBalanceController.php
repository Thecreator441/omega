<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class TrialBalanceController extends Controller
{
    public function index()
    {
        return view('omega.pages.trial_balance');
    }
}
