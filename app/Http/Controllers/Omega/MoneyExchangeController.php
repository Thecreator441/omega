<?php

namespace App\Http\Controllers\Omega;

use App\Models\Cash;
use App\Models\Money;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class MoneyExchangeController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $cash = Cash::getEmpCashOpen();
                $moneys = Money::getMoneys();

                return view('omega.pages.money_exchange', [
                    'cash' => $cash,
                    'moneys' => $moneys
                ]);
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $cashOut = Cash::getEmpCashOpen();
            $cashOut->mon1 -= Request::input('B1Out');
            $cashOut->mon2 -= Request::input('B2Out');
            $cashOut->mon3 -= Request::input('B3Out');
            $cashOut->mon4 -= Request::input('B4Out');
            $cashOut->mon5 -= Request::input('B5Out');
            $cashOut->mon6 -= Request::input('P1Out');
            $cashOut->mon7 -= Request::input('P2Out');
            $cashOut->mon8 -= Request::input('P3Out');
            $cashOut->mon9 -= Request::input('P4Out');
            $cashOut->mon10 -= Request::input('P5Out');
            $cashOut->mon11 -= Request::input('P6Out');
            $cashOut->mon12 -= Request::input('P7Out');
            $cashOut->save();

            $cashIn = Cash::getEmpCashOpen();
            $cashIn->mon1 += Request::input('B1In');
            $cashIn->mon2 += Request::input('B2In');
            $cashIn->mon3 += Request::input('B3In');
            $cashIn->mon4 += Request::input('B4In');
            $cashIn->mon5 += Request::input('B5In');
            $cashIn->mon6 += Request::input('P1In');
            $cashIn->mon7 += Request::input('P2In');
            $cashIn->mon8 += Request::input('P3In');
            $cashIn->mon9 += Request::input('P4In');
            $cashIn->mon10 += Request::input('P5In');
            $cashIn->mon11 += Request::input('P6In');
            $cashIn->mon12 += Request::input('P7In');
            $cashIn->save();

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.monexc'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.monexc'));
        }
    }
}
