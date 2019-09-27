<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class MemHistoryController extends Controller
{
    public function index()
    {
        return view('omega.pages.mem_history');
    }
}
