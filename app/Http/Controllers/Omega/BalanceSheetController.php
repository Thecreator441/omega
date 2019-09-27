<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class BalanceSheetController extends Controller
{
    public function index()
    {
        return view('omega.pages.balance_sheet');
    }
}
