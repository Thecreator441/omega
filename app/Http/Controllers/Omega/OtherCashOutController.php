<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\Cash;
use App\Models\Money;
use App\Models\Operation;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class OtherCashOutController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $cash = Cash::getEmpCashOpen();
                $moneys = Money::getMoneys();
                $accounts = Account::getAccounts();
                $operas = Operation::all();

                return view('omega.pages.other_cash_out', [
                    'cash' => $cash,
                    'moneys' => $moneys,
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
        DB::beginTransaction();
        $emp = Session::get('employee');

        $writnumb = getWritNumb();
        $accounts = Request::input('accounts');
        $descs = Request::input('operations');
        $amounts = Request::input('amounts');
        $represent = Request::input('represent');
        $mon1 = Request::input('B1');
        $mon2 = Request::input('B2');
        $mon3 = Request::input('B3');
        $mon4 = Request::input('B4');
        $mon5 = Request::input('B5');
        $mon6 = Request::input('P1');
        $mon7 = Request::input('P2');
        $mon8 = Request::input('P3');
        $mon9 = Request::input('P4');
        $mon10 = Request::input('P5');
        $mon11 = Request::input('P6');
        $mon12 = Request::input('P7');

        try {
            $accdate = AccDate::getOpenAccDate();
            $cash = Cash::getEmpCashOpen();
            $opera = Operation::getByCode(34);

            if (!empty($mon1) || $mon1 !== null) {
                $cash->mon1 -= trimOver($mon1, ' ');
            }
            if (!empty($mon2) || $mon2 !== null) {
                $cash->mon2 -= trimOver($mon2, ' ');
            }
            if (!empty($mon3) || $mon3 !== null) {
                $cash->mon3 -= trimOver($mon3, ' ');
            }
            if (!empty($mon4) || $mon4 !== null) {
                $cash->mon4 -= trimOver($mon4, ' ');
            }
            if (!empty($mon5) || $mon5 !== null) {
                $cash->mon5 -= trimOver($mon5, ' ');
            }
            if (!empty($mon6) || $mon6 !== null) {
                $cash->mon6 -= trimOver($mon6, ' ');
            }
            if (!empty($mon7) || $mon7 !== null) {
                $cash->mon7 -= trimOver($mon7, ' ');
            }
            if (!empty($mon8) || $mon8 !== null) {
                $cash->mon8 -= trimOver($mon8, ' ');
            }
            if (!empty($mon9) || $mon9 !== null) {
                $cash->mon9 -= trimOver($mon9, ' ');
            }
            if (!empty($mon10) || $mon10 !== null) {
                $cash->mon10 -= trimOver($mon10, ' ');
            }
            if (!empty($mon11) || $mon11 !== null) {
                $cash->mon11 -= trimOver($mon11, ' ');
            }
            if (!empty($mon12) || $mon12 !== null) {
                $cash->mon12 -= trimOver($mon12, ' ');
            }
            $cash->save();

            foreach ($accounts as $key => $account) {
                if (!empty($amounts[$key]) || $amounts[$key] !== null) {
                    $writing = new Writing();
                    $writing->writnumb = $writnumb;
                    $writing->account = $account;
                    $writing->operation = $descs[$key];
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
            $writing->account = $cash->cashacc;
            $writing->operation = $opera->idoper;
            $writing->creditamt = trimOver(Request::input('totrans'), ' ');
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->represent = $represent;
            $writing->save();

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.ocin'));
        } catch (\Exception $ex) {
            DB::rollback();
            return Redirect::back()->with('danger', trans('alertDanger.ocin'));
        }
    }
}
