<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\Cash;
use App\Models\Money;
use App\Models\Operation;
use App\Models\Priv_Menu;
use App\Models\ValWriting;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class OtherCashInController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $cash = Cash::getEmpCashOpen();
                $moneys = Money::getMoneys();
                $accounts = Account::getAccounts();
                $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

                return view('omega.pages.other_cash_in', compact('menu', 'cash', 'moneys', 'accounts'));
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

            if (!dateOpen()) {
                return Redirect::back()->with('danger', trans('alertDanger.opdate'));
                if (!cashOpen()) {
                    return Redirect::back()->with('danger', trans('alertDanger.opencash'));   
                }
            }
            
            $emp = Session::get('employee');

            $writnumb = getWritNumb();
            $accdate = AccDate::getOpenAccDate();

            $accounts = Request::input('accounts');
            $operations = Request::input('operations');
            $amounts = Request::input('amounts');
            $represent = Request::input('represent');

            $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
            $cash->mon1 += trimOver(Request::input('B1'), ' ');
            $cash->mon2 += trimOver(Request::input('B2'), ' ');
            $cash->mon3 += trimOver(Request::input('B3'), ' ');
            $cash->mon4 += trimOver(Request::input('B4'), ' ');
            $cash->mon5 += trimOver(Request::input('B5'), ' ');
            $cash->mon6 += trimOver(Request::input('P1'), ' ');
            $cash->mon7 += trimOver(Request::input('P2'), ' ');
            $cash->mon8 += trimOver(Request::input('P3'), ' ');
            $cash->mon9 += trimOver(Request::input('P4'), ' ');
            $cash->mon10 += trimOver(Request::input('P5'), ' ');
            $cash->mon11 += trimOver(Request::input('P6'), ' ');
            $cash->mon12 += trimOver(Request::input('P7'), ' ');
            $cash->update((array)$cash);

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $cash->cashacc;
            $writing->operation = Request::input('menu_level_operation');
            $writing->debitamt = trimOver(Request::input('totrans'), ' ');
            $writing->accdate = $accdate->accdate;
            $writing->employee = $emp->iduser;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->represent = $represent;
            $writing->save();

            $cashBal = Account::getAccount($cash->cashacc);
            $cashBal->available += trimOver(Request::input('totrans'), ' ');
            $cashBal->update((array)$cashBal);

            foreach ($accounts as $key => $account) {
                $amount = (int)trimOver($amounts[$key], ' ');

                if ($amount !== 0) {
                    $writing = new Writing();
                    $writing->writnumb = $writnumb;
                    $writing->account = $account;
                    $writing->operation = $operations[$key];
                    $writing->creditamt = $amount;
                    $writing->accdate = $accdate->accdate;
                    $writing->employee = $emp->iduser;
                    $writing->cash = $cash->idcash;
                    $writing->network = $emp->network;
                    $writing->zone = $emp->zone;
                    $writing->institution = $emp->institution;
                    $writing->branch = $emp->branch;
                    $writing->represent = $represent;
                    $writing->save();

                    $accBal = Account::getAccount($account);
                    $accBal->available += $amount;
                    $accBal->update((array)$accBal);
                }
            }

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.other_cash_in'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return Redirect::back()->with('danger', trans('alertDanger.other_cash_in'));
        }
    }
}
