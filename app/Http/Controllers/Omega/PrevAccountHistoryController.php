<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class PrevAccountHistoryController extends Controller
{
    public function index()
    {
        return view('omega.pages.prev_acc_history');
    }
}
