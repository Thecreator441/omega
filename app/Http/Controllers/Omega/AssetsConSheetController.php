<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class AssetsConSheetController extends Controller
{
    public function index()
    {
        return view('omega.pages.assets_con_sheet');
    }
}
