<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccDate;
use App\Models\MemBalance;
use App\Models\Bank;
use App\Models\Cash;
use App\Models\Check;
use App\Models\CheckAccAmt;
use App\Models\Comaker;
use App\Models\Loan;
use App\Models\LoanType;
use App\Models\Member;
use App\Models\Mortgage;
use App\Models\Operation;
use App\Models\Priv_Menu;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class OtherCheckSortController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $checks = Check::getChecks(['checks.status' => 'P', 'checks.sorted' => 'N', 'checks.member' => NULL]);
                $banks = Bank::getBanks();
                $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

                return view('omega.pages.other_check_sort', compact('checks', 'banks', 'menu'));
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        // dd(Request::all());
        try {
            DB::beginTransaction();
            $emp = Session::get('employee');

            $writnumb = getWritNumb();
            $accounts = Request::input('accounts');
            $operations = Request::input('operations');
            $amounts = Request::input('amounts');

            $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
            $check = Check::getCheckOnly(Request::input('check'));
            $accdate = AccDate::getOpenAccDate();
            $bank = Bank::getBank($check->bank);

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $bank->theiracc;
            $writing->operation = Request::input('menu_level_operation');
            $writing->debitamt = (int)trimOver(Request::input('totrans'), ' ');
            $writing->accdate = $accdate->accdate;
            $writing->employee = $emp->iduser;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->represent = $check->carrier;
            $writing->save();

            $bankBal = Account::getAccount($bank->theiracc);
            $bankBal->available += (int)trimOver(Request::input('totrans'), ' ');
            $bankBal->update((array)$bankBal);

            if (isset($accounts)) {
                foreach ($accounts as $key => $account) {
                    if ($amounts[$key] !== '0' || $amounts[$key] !== null) {
                        $writing = new Writing();
                        $writing->writnumb = $writnumb;
                        $writing->account = $account;
                        $writing->operation = $operations[$key];
                        $writing->creditamt = trimOver($amounts[$key], ' ');
                        $writing->accdate = $accdate->accdate;
                        $writing->employee = $emp->iduser;
                        $writing->cash = $cash->idcash;
                        $writing->network = $emp->network;
                        $writing->zone = $emp->zone;
                        $writing->institution = $emp->institution;
                        $writing->branch = $emp->branch;
                        $writing->represent = $check->carrier;
                        $writing->save();

                        $accBal = Account::getAccount($account);
                        $accBal->available += (int)trimOver(Request::input('totrans'), ' ');
                        $accBal->update((array)$accBal);
                    }
                }
            }

            $check->sorted = 'Y';
            $check->update((array)$check);

            $checAccs = CheckAccAmt::getChecksAcc($check->idcheck);
            foreach ($checAccs as $checAcc) {
                $checAcc->delete();
            }

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.checksort'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return Redirect::back()->with('danger', trans('alertDanger.checksort'));
        }
    }
}
