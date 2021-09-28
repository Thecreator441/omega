<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class LoanListController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $emp = Session::get('employee');

            $members = Member::getMembers(['members.memstatus' => 'A']);

            $loans = Loan::getLoans(['loans.loanstat' => 'A']);
            if ($emp->view_other_tills === 'N') {
                $loans = Loan::getLoans(['loans.loanstat' => 'A', 'loans.employee' => $emp->iduser]);
            }
            $employees = Employee::getEmployees();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.loan_list', compact('members', 'menu', 'employees', 'loans'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

}
