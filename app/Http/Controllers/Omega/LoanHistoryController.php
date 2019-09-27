<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class LoanHistoryController extends Controller
{
    public function index()
    {
        return view('omega.pages.loan_history');
    }
}
