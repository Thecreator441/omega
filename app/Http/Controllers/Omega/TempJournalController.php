<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Cash;
use App\Models\Employee;
use App\Models\Member;
use App\Models\Operation;
use App\Models\Writing;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TempJournalController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $emp = Session::get('employee');

            $cashes = null;
            $employees = null;
            if ($emp->privilege === 5) {
                $cashes = Cash::getCashes();
                $employees = Employee::getEmployees(['privilege' => 3]);
            } else {
                $cashes = Cash::getEmpCashOpen();
            }
            $writings = Writing::getJournal();
            $debit = Writing::getSumDebit();
            $credit = Writing::getSumCredit();
            $accounts = Account::getAccounts();
            $operas = Operation::all();
            $members = Member::all();

            return view('omega.pages.temp_journal', [
                'writings' => $writings,
                'debit' => $debit,
                'credit' => $credit,
                'accounts' => $accounts,
                'cashes' => $cashes,
                'employees' => $employees,
                'operas' => $operas,
                'members' => $members
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }
}
