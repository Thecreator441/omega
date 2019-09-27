<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class PayDeductDistController extends Controller
{
    public function index()
    {
        return view('omega.pages.pay_deduct_dist');
    }
}
