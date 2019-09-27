<?php

namespace App\Http\Controllers\Omega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccToAccController extends Controller
{
    public function index()
    {
        return view('omega.pages.acc_to_acc');
    }
}
