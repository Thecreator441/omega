<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Cash;
use App\Models\Employee;
use App\Models\Member;
use App\Models\Operation;
use App\Models\ValWriting;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $writings = ValWriting::getValJournal();
            $debit = ValWriting::getSumDebit();
            $credit = ValWriting::getSumCredit();
            $members = Member::all();
            $cashes = Cash::getCashes();
            $accounts = Account::getAccounts();
            $operas = Operation::all();
            $employees = Employee::getEmployees();

            return view('omega.pages.transaction', [
                'writings' => $writings,
                'debit' => $debit,
                'credit' => $credit,
                'members' => $members,
                'cashes' => $cashes,
                'accounts' => $accounts,
                'operas' => $operas,
                'employees' => $employees
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }
}
