<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class PrevDelinquencyController extends Controller
{
    public function index()
    {
        return view('omega.pages.prev_delinquency');
    }
}
