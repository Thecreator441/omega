<?php

namespace App\Http\Controllers\Omega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccFileController extends Controller
{
    public function index()
    {
        return view('omega.pages.acc_file');
    }
}
