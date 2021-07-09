<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Bank;
use App\Models\Check;
use App\Models\CheckAccAmt;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class OtherCheckInController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $banks = Bank::getBanks();
            $accounts = Account::getAccounts();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.other_check_in', compact('menu', 'banks', 'accounts'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        // dd(Request::all());
        try {
            DB::beginTransaction();

            $emp = Session::get('employee');

            $accounts = Request::input('accounts');
            $operations = Request::input('operations');
            $amounts = Request::input('amounts');

            $check = new Check();
            $check->checknumb = Request::input('checkno');
            $check->bank = Request::input('bank');
            $check->type = 'I';
            $check->status = 'D';
            $check->sorted = 'N';
            $check->amount = trimOver(Request::input('totdist'), ' ');
            $check->carrier = Request::input('represent');
            $check->network = $emp->network;
            $check->zone = $emp->zone;
            $check->institution = $emp->institution;
            $check->branch = $emp->branch;

            $check->save();

            foreach ($accounts as $key => $account) {
                $amount = (int)trimOver($amounts[$key], ' ');
                if ($amount !== 0) {
                    $checkaccamt = new CheckAccAmt();
                    $checkaccamt->checkno = $check->idcheck;
                    $checkaccamt->account = $account;
                    $checkaccamt->operation = $operations[$key];
                    $checkaccamt->accamt = $amount;
                    $checkaccamt->network = $emp->network;
                    $checkaccamt->zone = $emp->zone;
                    $checkaccamt->institution = $emp->institution;
                    $checkaccamt->branch = $emp->branch;

                    $checkaccamt->save();
                }
            }

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.other_check_in'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.other_check_in'));
        }
    }
}
