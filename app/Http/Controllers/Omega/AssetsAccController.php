<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class AssetsAccController extends Controller
{
    public function index()
    {
        return view('omega.pages.assets_acc');
    }
}
