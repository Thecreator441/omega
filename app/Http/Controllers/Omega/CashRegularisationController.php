<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\Cash;
use App\Models\Cash_Diff;
use App\Models\Collector;
use App\Models\Money;
use App\Models\Operation;
use App\Models\User;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CashRegularisationController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $cash = Cash::getEmpCashOpen();
                $moneys = Money::getMoneys();
                $cashes = Cash::getCashes();

                foreach ($cashes as $cashs) {
                    $user = User::getUser($cashs->employee);

                    if ($user->collector !== null) {
                        $collector = Collector::getCollector($user->collector);

                        $cashs->col_id = $collector->idcoll;
                        $cashs->col_name = $collector->name;
                        $cashs->col_surname = $collector->surname;
                    }
                }
//dd($cashes);
                return view('omega.pages.cash_regularisation', compact(
                    'cash',
                    'moneys',
                    'cashes'
                ));
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();

        try {
            $emp = Session::get('employee');

//dd(Cash::sumBillet(Request::input('cash_diff')));
            $writnumb = getWritNumb();
            $totbil = trimOver(Request::input('totbil'), ' ');
            $cashDiff = Cash_Diff::getCashDiff(Request::input('cash_diff'));
            $amount = $cashDiff->amount - $cashDiff->paid_amt;
            $opera = Operation::getByCode(22);
            $account = $cashDiff->account;
            if ($cashDiff->diff_type === 'E') {
                $opera = Operation::getByCode(21);
            }
            $accdate = AccDate::getOpenAccDate();
            $cash = Cash::getCash($cashDiff->cash);
//            $cash = Cash::getEmpCashOpen();

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

            if ($cashDiff->diff_type === 'E') {
                if (cashEmpty($cash->idcash)) {
                    if ($mon1 !== null) {
                        $cash->mon1 -= trimOver($mon1, ' ');
                    }
                    if ($mon2 !== null) {
                        $cash->mon2 -= trimOver($mon2, ' ');
                    }
                    if ($mon3 !== null) {
                        $cash->mon3 -= trimOver($mon3, ' ');
                    }
                    if ($mon4 !== null) {
                        $cash->mon4 -= trimOver($mon4, ' ');
                    }
                    if ($mon5 !== null) {
                        $cash->mon5 -= trimOver($mon5, ' ');
                    }
                    if ($mon6 !== null) {
                        $cash->mon6 -= trimOver($mon6, ' ');
                    }
                    if ($mon7 !== null) {
                        $cash->mon7 -= trimOver($mon7, ' ');
                    }
                    if ($mon8 !== null) {
                        $cash->mon8 -= trimOver($mon8, ' ');
                    }
                    if ($mon9 !== null) {
                        $cash->mon9 -= trimOver($mon9, ' ');
                    }
                    if ($mon10 !== null) {
                        $cash->mon10 -= trimOver($mon10, ' ');
                    }
                    if ($mon11 !== null) {
                        $cash->mon11 -= trimOver($mon11, ' ');
                    }
                    if ($mon12 !== null) {
                        $cash->mon12 -= trimOver($mon12, ' ');
                    }
                    $cash->update((array)$cash);

                    $writing = new Writing();
                    $writing->writnumb = $writnumb;
                    $writing->account = $account;
                    $writing->operation = $opera->idoper;
                    $writing->debitamt = $totbil;
                    $writing->accdate = $accdate->accdate;
                    $writing->employee = $emp->iduser;
                    $writing->cash = $cash->idcash;
                    $writing->network = $emp->network;
                    $writing->zone = $emp->zone;
                    $writing->institution = $emp->institution;
                    $writing->branch = $emp->branch;
                    $writing->save();

                    $excBal = Account::getAccount($account);
                    $excBal->available += $totbil;
                    $excBal->update((array)$excBal);

                    $writing = new Writing();
                    $writing->writnumb = $writnumb;
                    $writing->account = $cash->cashacc;
                    $writing->operation = $opera->idoper;
                    $writing->creditamt = $totbil;
                    $writing->accdate = $accdate->accdate;
                    $writing->employee = $emp->iduser;
                    $writing->cash = $cash->idcash;
                    $writing->network = $emp->network;
                    $writing->zone = $emp->zone;
                    $writing->institution = $emp->institution;
                    $writing->branch = $emp->branch;
                    $writing->save();

                    $cashBal = Account::getAccount($cash->cashacc);
                    $cashBal->available -= $totbil;
                    $cashBal->update((array)$cashBal);
                }
                return Redirect::back()->with('danger', trans('alertDanger.emptycash'));
            }
            
            if ($cashDiff->diff_type === 'S') {
                if ($mon1 !== null) {
                    $cash->mon1 += trimOver($mon1, ' ');
                }
                if ($mon2 !== null) {
                    $cash->mon2 += trimOver($mon2, ' ');
                }
                if ($mon3 !== null) {
                    $cash->mon3 += trimOver($mon3, ' ');
                }
                if ($mon4 !== null) {
                    $cash->mon4 += trimOver($mon4, ' ');
                }
                if ($mon5 !== null) {
                    $cash->mon5 += trimOver($mon5, ' ');
                }
                if ($mon6 !== null) {
                    $cash->mon6 += trimOver($mon6, ' ');
                }
                if ($mon7 !== null) {
                    $cash->mon7 += trimOver($mon7, ' ');
                }
                if ($mon8 !== null) {
                    $cash->mon8 += trimOver($mon8, ' ');
                }
                if ($mon9 !== null) {
                    $cash->mon9 += trimOver($mon9, ' ');
                }
                if ($mon10 !== null) {
                    $cash->mon10 += trimOver($mon10, ' ');
                }
                if ($mon11 !== null) {
                    $cash->mon11 += trimOver($mon11, ' ');
                }
                if ($mon12 !== null) {
                    $cash->mon12 += trimOver($mon12, ' ');
                }
                $cash->update((array)$cash);

                $writing = new Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $cash->cashacc;
                $writing->operation = $opera->idoper;
                $writing->debitamt = $totbil;
                $writing->accdate = $accdate->accdate;
                $writing->employee = $emp->iduser;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->save();

                $cashBal = Account::getAccount($cash->cashacc);
                $cashBal->available += $totbil;
                $cashBal->update((array)$cashBal);

                $writing = new Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $account;
                $writing->operation = $opera->idoper;
                $writing->creditamt = $totbil;
                $writing->accdate = $accdate->accdate;
                $writing->employee = $emp->iduser;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->save();

                $misBal = Account::getAccount($account);
                $misBal->available -= $totbil;
                $misBal->update((array)$misBal);
            }

//            $diffBal = Account::getAccount($account);
//            $diffBal->available -= $totbil;
//            $diffBal->update((array)$diffBal);

            if ((int)$amount === (int)$totbil) {
                $cashDiff->diff_status = 'R';
                $cashDiff->paid_amt = $amount;
            } else {
                $cashDiff->paid_amt += $amount - $totbil;
            }
            $cashDiff->update((array)$cashDiff);

            if ($emp->lang === 'fr') {
                Log::info($opera->labelfr);
            } else {
                Log::info($opera->labeleng);
            }

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.ocin'));
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            DB::rollback();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.ocin'));
        }
    }
}
