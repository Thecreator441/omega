<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Budget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class BudgetInitController extends Controller
{
    public function index()
    {
        $branches = Branch::getBranches();
//        $accounts = Account::getAccounts();

        return view('omega.pages.budget_init', compact('branches'));
//        return view('omega.pages.budget_init', compact('branches', 'accounts'));
    }

    public function store()
    {
        dd(Request::all());

        DB::beginTransaction();
        try {


            DB::commit();
        } catch (Exception $ex) {

        }
        $budget = new Budget();

        $budget->account = Request::input('account');
        $budget->budgetline = Request::input('budget_line');
        $budget->mode = Request::input('type');
        $budget->budm1 = trimOver(Request::input('jan'));
        $budget->budm2 = trimOver(Request::input('feb'));
        $budget->budm3 = trimOver(Request::input('mar'));
        $budget->budm4 = trimOver(Request::input('apr'));
        $budget->budm5 = trimOver(Request::input('may'));
        $budget->budm6 = trimOver(Request::input('jun'));
        $budget->budm7 = trimOver(Request::input('jul'));
        $budget->budm8 = trimOver(Request::input('aug'));
        $budget->budm9 = trimOver(Request::input('sep'));
        $budget->budm10 = trimOver(Request::input('oct'));
        $budget->budm11 = trimOver(Request::input('nov'));
        $budget->budm12 = trimOver(Request::input('dec'));


    }
}
