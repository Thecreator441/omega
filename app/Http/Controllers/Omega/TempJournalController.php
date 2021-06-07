<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Cash;
use App\Models\Collect_Mem;
use App\Models\Collector;
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
            $writings = null;
            $credit = null;
            $debit = null;

            if ($emp->collector !== null || (int)$emp->code === 2) {
                $cashes = Cash::getEmpCashOpen();
                $writings = Writing::getJournal(['writings.employee' => $emp->iduser]);
                $debit = Writing::getSumDebit(['writings.employee' => $emp->iduser]);
                $credit = Writing::getSumCredit(['writings.employee' => $emp->iduser]);
            } else {
                $cashes = Cash::getCashes();
                $employees = Writing::getEmployees();
                $writings = Writing::getJournal();
                $debit = Writing::getSumDebit();
                $credit = Writing::getSumCredit();
            }

            $collectors = Collector::getCollectorsCash();
            $accounts = Account::getAccounts();
            $operas = Operation::getOperations();
            $members = Member::getMembers();
            $coll_members = Collect_Mem::getMembers();

            return view('omega.pages.temp_journal', compact(
                'writings',
                'debit',
                'credit',
                'accounts',
                'cashes',
                'employees',
                'operas',
                'members',
                'collectors',
                'coll_members'
            ));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }
}
