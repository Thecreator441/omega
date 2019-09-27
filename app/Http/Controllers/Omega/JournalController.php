<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class JournalController extends Controller
{
    public function index()
    {
        return view('omega.pages.journal');
    }
}
