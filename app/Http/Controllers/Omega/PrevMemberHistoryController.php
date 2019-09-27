<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class PrevMemberHistoryController extends Controller
{
    public function index()
    {
        return view('omega.pages.prev_mem_history');
    }
}
