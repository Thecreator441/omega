<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Cash;
use App\Models\Collect_Mem;
use App\Models\Collector;
use App\Models\Member;
use App\Models\Operation;
use App\Models\Priv_Menu;
use App\Models\ValWriting;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
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
                $writings = ValWriting::getValJournal(['writings.employee' => $emp->iduser]);
                $debit = ValWriting::getSumDebit(['writings.employee' => $emp->iduser]);
                $credit = ValWriting::getSumCredit(['writings.employee' => $emp->iduser]);
            } else {
                $cashes = Cash::getCashes();
                $employees = ValWriting::getEmployees();
                $writings = ValWriting::getValJournal();
                $debit = ValWriting::getSumDebit();
                $credit = ValWriting::getSumCredit();
            }

            $collectors = Collector::getCollectorsCash();
            $accounts = Account::getAccounts();
            $operas = Operation::getOperations();
            $members = Member::getMembers();
            $coll_members = Collect_Mem::getMembers();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.transaction', compact(
                'writings',
                'debit',
                'credit',
                'accounts',
                'cashes',
                'employees',
                'operas',
                'members',
                'collectors',
                'coll_members',
                'menu'
            ));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }
}
