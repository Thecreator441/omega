<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\Cash;
use App\Models\Cash_Diff;
use App\Models\Money;
use App\Models\Priv_Menu;
use App\Models\Operation;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class CashRegularisationController extends Controller
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
                    $cashes = Cash::getCashes();
                    $moneys = Money::getMoneys();
                    $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

                    return view('omega.pages.cash_regularisation', compact('cash', 'cashes', 'moneys', 'menu'));
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
            $emp = verifSession('employee');
            if($emp === null) {
                return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
            }

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

            if ($cashDiff->diff_type === 'E') {
                if (cashEmpty($cash->idcash)) {
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
                $cash->mon1 += trimOver(Request::input('B1'), ' ');
                $cash->mon2 += trimOver(Request::input('B2'), ' ');
                $cash->mon3 += trimOver(Request::input('B3'), ' ');
                $cash->mon4 += trimOver(Request::input('B4'), ' ');
                $cash->mon5 += trimOver(Request::input('B5'), ' ');
                $cash->mon6 += trimOver(Request::input('P1'), ' ');
                $cash->mon7 += trimOver(Request::input('P2'), ' ');
                $cash->mon8 += trimOver(Request::input('P3'), ' ');
                $cash->mon9 += trimOver(Request::input('P4'), ' ');
                $cash->mon10 += trimOver(Request::input('P5'), ' ');
                $cash->mon11 += trimOver(Request::input('P6'), ' ');
                $cash->mon12 += trimOver(Request::input('P7'), ' ');

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
