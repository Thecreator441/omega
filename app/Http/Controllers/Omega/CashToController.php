<?php

namespace App\Http\Controllers\Omega;

use App\Models\AccDate;
use App\Models\Account;
use App\Models\Bank;
use App\Models\Cash;
use App\Models\Money;
use App\Models\Operation;
use App\Models\Priv_Menu;
use App\Models\Writing;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CashToController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $emp = Session::get('employee');
                
                $cash = Cash::getEmpCashOpen();
                $banks = Bank::getBanks();
                $moneys = Money::getMoneys();
                $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

                foreach ($banks as $bank) {
                    $account = Account::getAccount($bank->theiracc);

                    $bank->idaccount = $account->idaccount;
                    $bank->accnumb = $account->accnumb;
                    $bank->acc_labeleng = $account->labeleng;
                    if ($emp->lang === 'fr') {
                        $bank->acc_labelfr = $account->labelfr;
                    }
                }

                return view('omega.pages.cash_to', compact('menu', 'cash', 'moneys', 'banks'));
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

            if (!dateOpen()) {
                return Redirect::back()->with('danger', trans('alertDanger.opdate'));
                if (!cashOpen()) {
                    return Redirect::back()->with('danger', trans('alertDanger.opencash'));   
                }
            }

            $writnumb = getWritNumb();
            $accdate = AccDate::getOpenAccDate();

            $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
            $cash->mon1 -= trimOver(Request::input('B1'), ' ');
            $cash->mon2 -= trimOver(Request::input('B2'), ' ');
            $cash->mon3 -= trimOver(Request::input('B3'), ' ');
            $cash->mon4 -= trimOver(Request::input('B4'), ' ');
            $cash->mon5 -= trimOver(Request::input('B5'), ' ');
            $cash->mon6 -= trimOver(Request::input('P1'), ' ');
            $cash->mon7 -= trimOver(Request::input('P2'), ' ');
            $cash->mon8 -= trimOver(Request::input('P3'), ' ');
            $cash->mon9 -= trimOver(Request::input('P4'), ' ');
            $cash->mon10 -= trimOver(Request::input('P5'), ' ');
            $cash->mon11 -= trimOver(Request::input('P6'), ' ');
            $cash->mon12 -= trimOver(Request::input('P7'), ' ');
            $cash->update((array)$cash);

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $cash->cashacc;
            $writing->operation = Request::input('menu_level_operation');
            $writing->creditamt = trimOver(Request::input('totrans'), ' ');
            $writing->accdate = $accdate->accdate;
            $writing->employee = $emp->iduser;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $cashBal = Account::getAccount($cash->cashacc);
            $cashBal->available -= trimOver(Request::input('totrans'), ' ');
            $cashBal->update((array)$cashBal);

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = Request::input('account');
            $writing->operation = Request::input('menu_level_operation');
            $writing->debitamt = trimOver(Request::input('totrans'), ' ');
            $writing->accdate = $accdate->accdate;
            $writing->employee = $emp->iduser;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $bankBal = Account::getAccount(Request::input('account'));
            $bankBal->available += trimOver(Request::input('totrans'), ' ');
            $bankBal->update((array)$bankBal);

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.cash_to_bank'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('success', trans('alertDanger.cash_to_bank'));
        }
    }
}
