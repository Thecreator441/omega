<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class PrevTrialBalanceController extends Controller
{
    public function index()
    {
        return view('omega.pages.prev_trial_balance');
    }
}
