<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Loan;
use App\Models\LoanPur;
use App\Models\LoanType;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class LoanListController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $loans = Loan::getLoans(['loanstat' => 'Ar']);
            $members = Member::getActiveMembers();
            $ltypes = LoanType::getLoanTypes();
            $lpurs = LoanPur::all();
            $accounts = Account::getAccounts();
            $employees = User::getEmployees(['privilege' => 6]);

            return view('omega.pages.loan_list', compact(
                'loans',
                'members',
                'ltypes',
                'lpurs',
                'accounts',
                'employees'
            ));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

}
