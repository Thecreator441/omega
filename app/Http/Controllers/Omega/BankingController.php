<?php

namespace App\Http\Controllers\Omega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankingController extends Controller
{
    public function index()
    {
        return view('omega.pages.banking');
    }
}
