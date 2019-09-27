<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class AccBalSheetController extends Controller
{
    public function index()
    {
        return view('omega.pages.acc_bal_sheet');
    }
}
