<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class WithdrawalInitController extends Controller
{
    public function index()
    {
        return view('omega.pages.withdrawal_init');
    }
}
