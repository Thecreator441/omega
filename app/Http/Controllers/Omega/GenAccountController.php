<?php

namespace App\Http\Controllers\Omega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenAccountController extends Controller
{
    public function index()
    {
        return view('omega.pages.gen_account');
    }
}
