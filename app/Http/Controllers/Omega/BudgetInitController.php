<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class BudgetInitController extends Controller
{
    public function index()
    {
        return view('omega.pages.budget_init');
    }
}
