<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\Bank;
use App\Models\Cash;
use App\Models\Check;
use App\Models\CheckAccAmt;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CheckSortController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $checks = Check::getNotSortChecks();
            $cash = Cash::getMainCash();
            $accounts = Account::getAccounts();

            return view('omega.pages.check_sort', [
                'checks' => $checks,
                'cash' => $cash,
                'accounts' => $accounts,
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        $emp = Session::get('employee');

        $writnumb = getWritNumb();
        $accounts = Request::input('accounts');
        $operations = Request::input('operations');
        $amounts = Request::input('amounts');
//        $accounts2 = Request::input('accounts2');
//        $operations2 = Request::input('operations2');
//        $amounts2 = Request::input('amounts2');

        try {
            $check = Check::getCheck(Request::input('check'));
            $accdate = AccDate::getOpenAccDate();
            $cash =  Cash::getMainCash();
            $bank = Bank::getBank($check->bank);

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $bank->theiracc;
            $writing->operation = $check->operation;
            $writing->debitamt = trimOver(Request::input('totrans'), ' ');
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->represent = $check->carrier;
            $writing->save();

            if (isset($accounts)) {
                foreach ($accounts as $key => $account) {
                    if ($amounts[$key] !== '0' || $amounts[$key] !== null) {
                        $writing = new Writing();
                        $writing->writnumb = $writnumb;
                        $writing->account = $account;
                        $writing->aux = $check->member;
                        $writing->operation = $operations[$key];
                        $writing->creditamt = trimOver($amounts[$key], ' ');
                        $writing->accdate = $accdate->idaccdate;
                        $writing->employee = $emp->idemp;
                        $writing->cash = $cash->idcash;
                        $writing->network = $emp->network;
                        $writing->zone = $emp->zone;
                        $writing->institution = $emp->institution;
                        $writing->branch = $emp->branch;
                        $writing->represent = $check->carrier;
                        $writing->save();
                    }
                }
            }

//            if (isset($accounts2)) {
//                foreach ($accounts2 as $key => $account) {
//                    if ($amounts2[$key] !== '0' || $amounts2[$key] !== null) {
//                        $writing = new Writing();
//                        $writing->writnumb = $writnumb;
//                        $writing->account = $account;
//                        $writing->aux = $check->member;
//                        $writing->operation = $operations2[$key];
//                        $writing->creditamt = trimOver($amounts2[$key], ' ');
//                        $writing->accdate = $accdate->idaccdate;
//                        $writing->employee = $emp->idemp;
//                        $writing->cash = $cash->idcash;
//                        $writing->network = $emp->network;
//                        $writing->zone = $emp->zone;
//                        $writing->institution = $emp->institution;
//                        $writing->branch = $emp->branch;
//                        $writing->represent = $check->carrier;
//                        $writing->save();
//                    }
//                }
//            }

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
