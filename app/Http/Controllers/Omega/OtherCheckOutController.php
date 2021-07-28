<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\Bank;
use App\Models\Cash;
use App\Models\Check;
use App\Models\Operation;
use App\Models\Priv_Menu;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class OtherCheckOutController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $banks = Bank::getBanks();
            $accounts = Account::getAccounts();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.other_check_out', compact('menu', 'banks', 'accounts'));
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
            $accounts = Request::input('accounts');
            $operations = Request::input('operations');
            $amounts = Request::input('amounts');
            $bank = Bank::getBank(Request::input('bank'));
            $accdate = AccDate::getOpenAccDate();
            $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $bank->theiracc;
            $writing->operation = Request::input('menu_level_operation');
            $writing->creditamt = trimOver(Request::input('totdist'), ' ');
            $writing->accdate = $accdate->accdate;
            $writing->employee = $emp->iduser;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->represent = Request::input('represent');
            $writing->save();

            $bankBal = Account::getAccount($bank->theiracc);
            $bankBal->available -= trimOver(Request::input('totdist'), ' ');
            $bankBal->update((array)$bankBal);

            foreach ($accounts as $key => $account) {
                $amount = (int)trimOver($amounts[$key], ' ');

                if ($amount !== 0) {
                    $writing = new Writing();
                    $writing->writnumb = $writnumb;
                    $writing->account = $account;
                    $writing->operation = $operations[$key];
                    $writing->debitamt = $amount;
                    $writing->accdate = $accdate->accdate;
                    $writing->employee = $emp->iduser;
                    $writing->cash = $cash->idcash;
                    $writing->network = $emp->network;
                    $writing->zone = $emp->zone;
                    $writing->institution = $emp->institution;
                    $writing->branch = $emp->branch;
                    $writing->represent = Request::input('represent');
                    $writing->save();

                    $accBal = Account::getAccount($account);
                    $accBal->available -= $amount;
                    $accBal->update((array)$accBal);
                }
            }

            $check = new Check();
            $check->checknumb = Request::input('checkno');
            $check->bank = Request::input('bank');
            $check->type = 'O';
            $check->amount = trimOver(Request::input('totdist'), ' ');
            $check->carrier = Request::input('represent');
            $check->network = $emp->network;
            $check->zone = $emp->zone;
            $check->institution = $emp->institution;
            $check->branch = $emp->branch;
            $check->save();

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.other_check_out'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return Redirect::back()->with('danger', trans('alertDanger.other_check_out'));
        }
    }
}
