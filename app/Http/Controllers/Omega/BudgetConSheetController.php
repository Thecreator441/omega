<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class BudgetConSheetController extends Controller
{
    public function index()
    {
        return view('omega.pages.budget_con_sheet');
    }
}
