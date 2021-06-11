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
use App\Models\Priv_Menu;
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
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            if (dateOpen()) {
                if (cashOpen()) {
                    $cash = Cash::getCashBy(['cashes.employee' => $emp->iduser]);
                    $cashes = Cash::getCashesPaginate(['cashes.status' => 'O']);
                    $moneys = Money::getMoneys();
                    $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));
                    $menu->pLevel = Request::input("level");
                    $menu->pMenu = Request::input("menu");

                    return view('omega.pages.cash_reconciliation', compact('cashes', 'moneys', 'menu'));
                }
                return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    public function store()
    {
        // dd(Request::all());
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

            if ($totin < $totbil) {
                $cash->mon1 = trimOver(Request::input('B1'), ' ');
                $cash->mon2 = trimOver(Request::input('B2'), ' ');
                $cash->mon3 = trimOver(Request::input('B3'), ' ');
                $cash->mon4 = trimOver(Request::input('B4'), ' ');
                $cash->mon5 = trimOver(Request::input('B5'), ' ');
                $cash->mon6 = trimOver(Request::input('P1'), ' ');
                $cash->mon7 = trimOver(Request::input('P2'), ' ');
                $cash->mon8 = trimOver(Request::input('P3'), ' ');
                $cash->mon9 = trimOver(Request::input('P4'), ' ');
                $cash->mon10 = trimOver(Request::input('P5'), ' ');
                $cash->mon11 = trimOver(Request::input('P6'), ' ');
                $cash->mon12 = trimOver(Request::input('P7'), ' ');

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
                $cash->mon1 = trimOver(Request::input('B1'), ' ');
                $cash->mon2 = trimOver(Request::input('B2'), ' ');
                $cash->mon3 = trimOver(Request::input('B3'), ' ');
                $cash->mon4 = trimOver(Request::input('B4'), ' ');
                $cash->mon5 = trimOver(Request::input('B5'), ' ');
                $cash->mon6 = trimOver(Request::input('P1'), ' ');
                $cash->mon7 = trimOver(Request::input('P2'), ' ');
                $cash->mon8 = trimOver(Request::input('P3'), ' ');
                $cash->mon9 = trimOver(Request::input('P4'), ' ');
                $cash->mon10 = trimOver(Request::input('P5'), ' ');
                $cash->mon11 = trimOver(Request::input('P6'), ' ');
                $cash->mon12 = trimOver(Request::input('P7'), ' ');

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

                $cashto->mon1 += trimOver(Request::input('B1'), ' ');
                $cashto->mon2 += trimOver(Request::input('B2'), ' ');
                $cashto->mon3 += trimOver(Request::input('B3'), ' ');
                $cashto->mon4 += trimOver(Request::input('B4'), ' ');
                $cashto->mon5 += trimOver(Request::input('B5'), ' ');
                $cashto->mon6 += trimOver(Request::input('P1'), ' ');
                $cashto->mon7 += trimOver(Request::input('P2'), ' ');
                $cashto->mon8 += trimOver(Request::input('P3'), ' ');
                $cashto->mon9 += trimOver(Request::input('P4'), ' ');
                $cashto->mon10 += trimOver(Request::input('P5'), ' ');
                $cashto->mon11 += trimOver(Request::input('P6'), ' ');
                $cashto->mon12 += trimOver(Request::input('P7'), ' ');

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
