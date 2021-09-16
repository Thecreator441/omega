<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Cash;
use App\Models\Money;
use App\Models\Operation;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CashToCashController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $cash = Cash::getEmpCashOpen();
                $cashes = Cash::getOpenCash();
                $moneys = Money::getMoneys();

                return view('omega.pages.cashtocash', [
                    'cash' => $cash,
                    'cashes' => $cashes,
                    'moneys' => $moneys,
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

        $amt = (int)trimOver(Request::input('totbil'), ' ');
        
        try {
            $writnumb = getWritNumb();
            $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
            $cashto = Cash::getCash(Request::input('cashto'));
            $accdate = AccDate::getOpenAccDate();
            $opera = Operation::getByCode(12);

            $cash_tot = totCash([$cash->mon1, $cash->mon2, $cash->mon3, $cash->mon4, $cash->mon5, $cash->mon6, $cash->mon7, $cash->mon8, $cash->mon9, $cash->mon10, $cash->mon11, $cash->mon12]);
            $cashto_tot = totCash([$cashto->mon1, $cashto->mon2, $cashto->mon3, $cashto->mon4, $cashto->mon5, $cashto->mon6, $cashto->mon7, $cashto->mon8, $cashto->mon9, $cashto->mon10, $cashto->mon11, $cashto->mon12]);

            if (($cash_tot < $cashto_tot) || ($cash_tot === $cashto_tot)) {
                return Redirect::back()->with('danger', trans('alertDanger.suffund'));
            }

            $cashto->mon1 += (int)trimOver(Request::input('B1'), ' ');
            $cashto->mon2 += (int)trimOver(Request::input('B2'), ' ');
            $cashto->mon3 += (int)trimOver(Request::input('B3'), ' ');
            $cashto->mon4 += (int)trimOver(Request::input('B4'), ' ');
            $cashto->mon5 += (int)trimOver(Request::input('B5'), ' ');
            $cashto->mon6 += (int)trimOver(Request::input('P1'), ' ');
            $cashto->mon7 += (int)trimOver(Request::input('P2'), ' ');
            $cashto->mon8 += (int)trimOver(Request::input('P3'), ' ');
            $cashto->mon9 += (int)trimOver(Request::input('P4'), ' ');
            $cashto->mon10 += (int)trimOver(Request::input('P5'), ' ');
            $cashto->mon11 += (int)trimOver(Request::input('P6'), ' ');
            $cashto->mon12 += (int)trimOver(Request::input('P7'), ' ');
            $cashto->update((array)$cashto);

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $cashto->cashacc;
            $writing->operation = $opera->idoper;
            $writing->debitamt = $amt;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->cash = $cashto->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $cash->mon1 -= (int)trimOver(Request::input('B1'), ' ');
            $cash->mon2 -= (int)trimOver(Request::input('B2'), ' ');
            $cash->mon3 -= (int)trimOver(Request::input('B3'), ' ');
            $cash->mon4 -= (int)trimOver(Request::input('B4'), ' ');
            $cash->mon5 -= (int)trimOver(Request::input('B5'), ' ');
            $cash->mon6 -= (int)trimOver(Request::input('P1'), ' ');
            $cash->mon7 -= (int)trimOver(Request::input('P2'), ' ');
            $cash->mon8 -= (int)trimOver(Request::input('P3'), ' ');
            $cash->mon9 -= (int)trimOver(Request::input('P4'), ' ');
            $cash->mon10 -= (int)trimOver(Request::input('P5'), ' ');
            $cash->mon11 -= (int)trimOver(Request::input('P6'), ' ');
            $cash->mon12 -= (int)trimOver(Request::input('P7'), ' ');
            $cash->update((array)$cash);

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $cash->cashacc;
            $writing->operation = $opera->idoper;
            $writing->creditamt = $amt;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.recfund'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.recfund'));
        }
    }
}
