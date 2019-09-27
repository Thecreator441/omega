<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class IndivBalanceHistoryController extends Controller
{
    public function index()
    {
        return view('omega.pages.indiv_bal_history');
    }
}
