<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\LoanPur;
use App\Models\LoanType;
use App\Models\Member;
use Illuminate\Support\Facades\Redirect;

class LoanListController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $loans = Loan::getLoans();
            $members = Member::getActiveMembers();
            $ltypes = LoanType::all();
            $lpurs = LoanPur::all();
            $accounts = Account::getAccounts();
            $employees = Employee::getEmployees(['privilege' => 6]);

            return view('omega.pages.loan_list', [
                'loans' => $loans,
                'members' => $members,
                'ltypes' => $ltypes,
                'lpurs' => $lpurs,
                'accounts' => $accounts,
                'employees' => $employees
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

}
