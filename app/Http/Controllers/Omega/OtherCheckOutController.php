<?php

namespace App\Http\Controllers\Omega;

use App\Models\AccDate;
use App\Models\Account;
use App\Models\Bank;
use App\Models\Cash;
use App\Models\Check;
use App\Models\CheckAccAmt;
use App\Models\Member;
use App\Models\Operation;
use App\Http\Controllers\Controller;
use App\Models\ValWriting;
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
            if (cashOpen()) {
                $banks = Bank::getBanks();
                $members = Member::getActiveMembers();
                $accounts = Account::getAccounts();
                $operas = Operation::all();

                return view('omega.pages.other_check_out', [
                    'banks' => $banks,
                    'members' => $members,
                    'accounts' => $accounts,
                    'operas' => $operas
                ]);
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        $emp = Session::get('employee');

        $writnumb = getWritNumb();
        $idbank = Request::input('bank');
        $accounts = Request::input('accounts');
        $operations = Request::input('operations');
        $amounts = Request::input('amounts');
        $amount = trimOver(Request::input('totdist'), ' ');
        $represent = Request::input('represent');

        try {
            $opera = Operation::getByCode(41);
            $bank = Bank::getBank($idbank);
            $accdate = AccDate::getOpenAccDate();
            $cash = Cash::getEmpCashOpen();

            foreach ($accounts as $key => $account) {
                if (!empty($amounts[$key]) || $amounts[$key] !== null) {
                    $writing = new Writing();
                    $writing->writnumb = $writnumb;
                    $writing->account = $account;
                    $writing->operation = $operations[$key];
                    $writing->debitamt = trimOver($amounts[$key], ' ');
                    $writing->accdate = $accdate->idaccdate;
                    $writing->employee = $emp->idemp;
                    $writing->cash = $cash->idcash;
                    $writing->network = $emp->network;
                    $writing->zone = $emp->zone;
                    $writing->institution = $emp->institution;
                    $writing->branch = $emp->branch;
                    $writing->represent = $represent;
                    $writing->save();
                }
            }

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $bank->theiracc;
            $writing->operation = $opera->idoper;
            $writing->creditamt = $amount;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->represent = $represent;
            $writing->save();

            $check = new Check();
            $check->checknumb = Request::input('checkno');
            $check->bank = $idbank;
            $check->type = 'O';
            $check->amount = $amount;
            $check->carrier = $represent;
            $check->operation = $opera->idoper;
            $check->institution = $emp->institution;
            $check->branch = $emp->branch;
            $check->save();

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.ocin'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return Redirect::back()->with('danger', trans('alertDanger.ocin'));
        }
    }
}
