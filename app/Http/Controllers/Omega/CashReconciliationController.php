<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\Cash;
use App\Models\Cash_Diff;
use App\Models\Cash_Writing;
use App\Models\Money;
use App\Models\Operation;
use App\Models\User;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CashReconciliationController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $emp = Session::get('employee');

                $cashes = null;

                if ($emp->privilege === 5) {
                    $cashes = Cash::getPaginateOpen();
                } else {
                    $cashes = Cash::getEmpCashOpen();
                }

                $employees = User::getCollectors();
                $moneys = Money::getMoneys();

                return view('omega.pages.cash_reconciliation', compact(
                    'cashes',
                    'employees',
                    'moneys'
                ));
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
//dd(Request::all());
        DB::beginTransaction();
        try {
            $emp = Session::get('employee');

            $opera1 = Operation::getByCode(12);
            $opera2 = Operation::getByCode(7);
            $opera3 = Operation::getByCode(8);
            $totin = trimOver(Request::input('totin'), ' ');
            $totbil = trimOver(Request::input('totbil'), ' ');
            $diff = trimOver(Request::input('diff'), ' ');
            $cash = Cash::getCash(Request::input('idcash'));
            $cashto = Cash::getEmpCashOpen();
            $accdate = AccDate::getOpenAccDate();

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

            if ($totin < $totbil) {
                if ($mon1 !== null) {
                    $cash->mon1 = trimOver($mon1, ' ');
                }
                if ($mon2 !== null) {
                    $cash->mon2 = trimOver($mon2, ' ');
                }
                if ($mon3 !== null) {
                    $cash->mon3 = trimOver($mon3, ' ');
                }
                if ($mon4 !== null) {
                    $cash->mon4 = trimOver($mon4, ' ');
                }
                if ($mon5 !== null) {
                    $cash->mon5 = trimOver($mon5, ' ');
                }
                if ($mon6 !== null) {
                    $cash->mon6 = trimOver($mon6, ' ');
                }
                if ($mon7 !== null) {
                    $cash->mon7 = trimOver($mon7, ' ');
                }
                if ($mon8 !== null) {
                    $cash->mon8 = trimOver($mon8, ' ');
                }
                if ($mon9 !== null) {
                    $cash->mon9 = trimOver($mon9, ' ');
                }
                if ($mon10 !== null) {
                    $cash->mon10 = trimOver($mon10, ' ');
                }
                if ($mon11 !== null) {
                    $cash->mon11 = trimOver($mon11, ' ');
                }
                if ($mon12 !== null) {
                    $cash->mon12 = trimOver($mon12, ' ');
                }
                $cash->update((array)$cash);


                $writnumb = getWritNumb();

                $writing = new Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $cash->cashacc;
                $writing->operation = $opera2->idoper;
                $writing->debitamt = abs($diff);
                $writing->accdate = $accdate->accdate;
                $writing->employee = $emp->iduser;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->save();

                $cashBal = Account::getAccount($cash->cashacc);
                $cashBal->available += abs($diff);
                $cashBal->update((array)$cashBal);

                $writing = new Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $cash->excacc;
                $writing->operation = $opera2->idoper;
                $writing->creditamt = abs($diff);
                $writing->accdate = $accdate->accdate;
                $writing->employee = $emp->iduser;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->save();

                $excBal = Account::getAccount($cash->excacc);
                $excBal->available -= abs($diff);
                $excBal->update((array)$excBal);

                $cash_diff = new Cash_Diff();
                $cash_diff->cash = $cash->idcash;
                $cash_diff->diff_type = 'E';
                $cash_diff->amount = abs($diff);
                $cash_diff->account = $cash->excacc;
                $cash_diff->network = $emp->network;
                $cash_diff->zone = $emp->zone;
                $cash_diff->institution = $emp->institution;
                $cash_diff->branch = $emp->branch;
                $cash_diff->save();

                if ($emp->lang === 'fr') {
                    Log::info($opera2->labelfr);
                } else {
                    Log::info($opera2->labeleng);
                }
            } elseif ($totin > $totbil) {
                if ($mon1 !== null) {
                    $cash->mon1 = trimOver($mon1, ' ');
                }
                if ($mon2 !== null) {
                    $cash->mon2 = trimOver($mon2, ' ');
                }
                if ($mon3 !== null) {
                    $cash->mon3 = trimOver($mon3, ' ');
                }
                if ($mon4 !== null) {
                    $cash->mon4 = trimOver($mon4, ' ');
                }
                if ($mon5 !== null) {
                    $cash->mon5 = trimOver($mon5, ' ');
                }
                if ($mon6 !== null) {
                    $cash->mon6 = trimOver($mon6, ' ');
                }
                if ($mon7 !== null) {
                    $cash->mon7 = trimOver($mon7, ' ');
                }
                if ($mon8 !== null) {
                    $cash->mon8 = trimOver($mon8, ' ');
                }
                if ($mon9 !== null) {
                    $cash->mon9 = trimOver($mon9, ' ');
                }
                if ($mon10 !== null) {
                    $cash->mon10 = trimOver($mon10, ' ');
                }
                if ($mon11 !== null) {
                    $cash->mon11 = trimOver($mon11, ' ');
                }
                if ($mon12 !== null) {
                    $cash->mon12 = trimOver($mon12, ' ');
                }
                $cash->update((array)$cash);

                $writnumb = getWritNumb();

                $writing = new Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $cash->misacc;
                $writing->operation = $opera3->idoper;
                $writing->debitamt = abs($diff);
                $writing->accdate = $accdate->accdate;
                $writing->employee = $emp->iduser;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->save();

                $cashBal = Account::getAccount($cash->misacc);
                $cashBal->available -= abs($diff);
                $cashBal->update((array)$cashBal);

                $writing = new Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $cash->cashacc;
                $writing->operation = $opera3->idoper;
                $writing->creditamt = abs($diff);
                $writing->accdate = $accdate->accdate;
                $writing->employee = $emp->iduser;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->save();

                $misBal = Account::getAccount($cash->misacc);
                $misBal->available += abs($diff);
                $misBal->update((array)$misBal);

                $cash_diff = new Cash_Diff();
                $cash_diff->cash = $cash->idcash;
                $cash_diff->diff_type = 'S';
                $cash_diff->amount = abs($diff);
                $cash_diff->account = $cash->misacc;
                $cash_diff->network = $emp->network;
                $cash_diff->zone = $emp->zone;
                $cash_diff->institution = $emp->institution;
                $cash_diff->branch = $emp->branch;
                $cash_diff->save();

                if ($emp->lang === 'fr') {
                    Log::info($opera3->labelfr);
                } else {
                    Log::info($opera3->labeleng);
                }
            }

            if ($cash->cashcode !== 'PC') {
                $writnumb = getCashWritNumb();

                if ($mon1 !== null) {
                    $cashto->mon1 += trimOver($mon1, ' ');
                }
                if ($mon2 !== null) {
                    $cashto->mon2 += trimOver($mon2, ' ');
                }
                if ($mon3 !== null) {
                    $cashto->mon3 += trimOver($mon3, ' ');
                }
                if ($mon4 !== null) {
                    $cashto->mon4 += trimOver($mon4, ' ');
                }
                if ($mon5 !== null) {
                    $cashto->mon5 += trimOver($mon5, ' ');
                }
                if ($mon6 !== null) {
                    $cashto->mon6 += trimOver($mon6, ' ');
                }
                if ($mon7 !== null) {
                    $cashto->mon7 += trimOver($mon7, ' ');
                }
                if ($mon8 !== null) {
                    $cashto->mon8 += trimOver($mon8, ' ');
                }
                if ($mon9 !== null) {
                    $cashto->mon9 += trimOver($mon9, ' ');
                }
                if ($mon10 !== null) {
                    $cashto->mon10 += trimOver($mon10, ' ');
                }
                if ($mon11 !== null) {
                    $cashto->mon11 += trimOver($mon11, ' ');
                }
                if ($mon12 !== null) {
                    $cashto->mon12 += trimOver($mon12, ' ');
                }
                $cashto->update((array)$cashto);

                $writing = new Cash_Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $cashto->cashacc;
                $writing->operation = $opera1->idoper;
                $writing->debitamt = $totbil;
                $writing->accdate = $accdate->accdate;
                $writing->employee = $emp->iduser;
                $writing->cash = $cashto->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->save();

                $cashtoBal = Account::getAccount($cashto->cashacc);
                $cashtoBal->available += $totbil;
                $cashtoBal->update((array)$cashtoBal);

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

                $writing = new Cash_Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $cash->cashacc;
                $writing->operation = $opera1->idoper;
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
            } else {
                $cashes = Cash::getCashes();

                foreach ($cashes as $cashe) {
                    if (($cashe->cashcode !== 'PC') && $cashe->status === 'O') {
                        return Redirect::back()->with('danger', trans('alertDanger.firstclose'));
                    }
                }
            }

            $cash->status = 'C';
            $cash->update((array)$cash);

            if ($emp->lang === 'fr') {
                Log::info($opera1->labelfr);
            } else {
                Log::info($opera1->labeleng);
            }

            DB::commit();
            $cashs = Cash::getOpenCash();

            if ($cashs->count() === 0) {
                return Redirect::route('omega')->with('success', trans('alertSuccess.cashclosed'));
            }
            return Redirect::route('cash_reconciliation')->with('success', trans('alertSuccess.cashclosed'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.cashclosed'));
        }
    }
}
