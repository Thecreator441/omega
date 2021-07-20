<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\MemBalance;
use App\Models\Bank;
use App\Models\Cash;
use App\Models\Check;
use App\Models\Member;
use App\Models\Priv_Menu;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $members = Member::getActiveMembers();
            $banks = Bank::getBanks();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.check_out', compact('menu', 'banks', 'members'));
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
            $fees = Request::input('fees');

            $accdate = AccDate::getOpenAccDate();
            $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
            $bank = Bank::getBank(Request::input('bank'));

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $bank->theiracc;
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

            $bankBal = Account::getAccount($bank->theiracc);
            $bankBal->available -= trimOver(Request::input('totrans'), ' ');
            $bankBal->update((array)$bankBal);

            foreach ($accounts as $key => $account) {
                $amount = (int)trimOver($amounts[$key], ' ') + (int)trimOver($fees[$key], ' ');

                if ($amount !== 0) {
                    $writing = new Writing();
                    $writing->writnumb = $writnumb;
                    $writing->account = $account;
                    $writing->mem_aux = Request::input('member');
                    $writing->operation = $operations[$key];
                    $writing->debitamt = $amount;
                    $writing->accdate = $accdate->accdate;
                    $writing->employee = $emp->iduser;
                    $writing->cash = $cash->idcash;
                    $writing->network = $emp->network;
                    $writing->zone = $emp->zone;
                    $writing->institution = $emp->institution;
                    $writing->branch = $emp->branch;
                    $writing->save();

                    $memBal = MemBalance::getMemAcc(Request::input('member'), $account);
                    $memBal->available -= $amount;
                    $memBal->update((array)$memBal);
                }
            }

            $check = new Check();
            $check->checknumb = Request::input('checkno');
            $check->bank = Request::input('bank');
            $check->type = 'O';
            $check->amount = trimOver(Request::input('totrans'), ' ');
            $check->carrier = Request::input('represent');
            $check->member = Request::input('member');
            $check->network = $emp->network;
            $check->zone = $emp->zone;
            $check->institution = $emp->institution;
            $check->branch = $emp->branch;
            $check->save();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.check_out'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.check_out'));
        }
    }
}
