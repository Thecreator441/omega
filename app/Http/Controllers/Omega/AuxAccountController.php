<?php

namespace App\Http\Controllers\Omega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuxAccountController extends Controller
{
    public function index()
    {
        return view('omega.pages.aux_account');
    }
}
