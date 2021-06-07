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
//        return Request::all();
        $toke = Request::input('_token');

        DB::beginTransaction();
        if ($toke === null) {
            $mon1In = Request::input('B1In');
            $mon2In = Request::input('B2In');
            $mon3In = Request::input('B3In');
            $mon4In = Request::input('B4In');
            $mon5In = Request::input('B5In');
            $mon6In = Request::input('P1In');
            $mon7In = Request::input('P2In');
            $mon8In = Request::input('P3In');
            $mon9In = Request::input('P4In');
            $mon10In = Request::input('P5In');
            $mon11In = Request::input('P6In');
            $mon12In = Request::input('P7In');

            $mon1Out = Request::input('B1Out');
            $mon2Out = Request::input('B2Out');
            $mon3Out = Request::input('B3Out');
            $mon4Out = Request::input('B4Out');
            $mon5Out = Request::input('B5Out');
            $mon6Out = Request::input('P1Out');
            $mon7Out = Request::input('P2Out');
            $mon8Out = Request::input('P3Out');
            $mon9Out = Request::input('P4Out');
            $mon10Out = Request::input('P5Out');
            $mon11Out = Request::input('P6Out');
            $mon12Out = Request::input('P7Out');

            try {
                $cash = Cash::getEmpCashOpen(Request::input('collector'));

                if ($mon1In !== null) {
                    $cash->mon1 += trimOver($mon1In, ' ');
                }
                if ($mon2In !== null) {
                    $cash->mon2 += trimOver($mon2In, ' ');
                }
                if ($mon3In !== null) {
                    $cash->mon3 += trimOver($mon3In, ' ');
                }
                if ($mon4In !== null) {
                    $cash->mon4 += trimOver($mon4In, ' ');
                }
                if ($mon5In !== null) {
                    $cash->mon5 += trimOver($mon5In, ' ');
                }
                if ($mon6In !== null) {
                    $cash->mon6 += trimOver($mon6In, ' ');
                }
                if ($mon7In !== null) {
                    $cash->mon7 += trimOver($mon7In, ' ');
                }
                if ($mon8In !== null) {
                    $cash->mon8 += trimOver($mon8In, ' ');
                }
                if ($mon9In !== null) {
                    $cash->mon9 += trimOver($mon9In, ' ');
                }
                if ($mon10In !== null) {
                    $cash->mon10 += trimOver($mon10In, ' ');
                }
                if ($mon11In !== null) {
                    $cash->mon11 += trimOver($mon11In, ' ');
                }
                if ($mon12In !== null) {
                    $cash->mon12 += trimOver($mon12In, ' ');
                }


                if ($mon1Out !== null) {
                    $cash->mon1 -= trimOver($mon1Out, ' ');
                }
                if ($mon2Out !== null) {
                    $cash->mon2 -= trimOver($mon2Out, ' ');
                }
                if ($mon3Out !== null) {
                    $cash->mon3 -= trimOver($mon3Out, ' ');
                }
                if ($mon4Out !== null) {
                    $cash->mon4 -= trimOver($mon4Out, ' ');
                }
                if ($mon5Out !== null) {
                    $cash->mon5 -= trimOver($mon5Out, ' ');
                }
                if ($mon6Out !== null) {
                    $cash->mon6 -= trimOver($mon6Out, ' ');
                }
                if ($mon7Out !== null) {
                    $cash->mon7 -= trimOver($mon7Out, ' ');
                }
                if ($mon8Out !== null) {
                    $cash->mon8 -= trimOver($mon8Out, ' ');
                }
                if ($mon9Out !== null) {
                    $cash->mon9 -= trimOver($mon9Out, ' ');
                }
                if ($mon10Out !== null) {
                    $cash->mon10 -= trimOver($mon10Out, ' ');
                }
                if ($mon11Out !== null) {
                    $cash->mon11 -= trimOver($mon11Out, ' ');
                }
                if ($mon12Out !== null) {
                    $cash->mon12 -= trimOver($mon12Out, ' ');
                }

                $cash->update((array)$cash);

                DB::commit();
                return ['success' => trans('alertSuccess.monexc')];
            } catch (\Exception $ex) {
                DB::rollBack();
                return ['danger' => trans('alertDanger.monexc')];
            }
        } else {
            $mon1In = Request::input('B1In');
            $mon2In = Request::input('B2In');
            $mon3In = Request::input('B3In');
            $mon4In = Request::input('B4In');
            $mon5In = Request::input('B5In');
            $mon6In = Request::input('P1In');
            $mon7In = Request::input('P2In');
            $mon8In = Request::input('P3In');
            $mon9In = Request::input('P4In');
            $mon10In = Request::input('P5In');
            $mon11In = Request::input('P6In');
            $mon12In = Request::input('P7In');

            $mon1Out = Request::input('B1Out');
            $mon2Out = Request::input('B2Out');
            $mon3Out = Request::input('B3Out');
            $mon4Out = Request::input('B4Out');
            $mon5Out = Request::input('B5Out');
            $mon6Out = Request::input('P1Out');
            $mon7Out = Request::input('P2Out');
            $mon8Out = Request::input('P3Out');
            $mon9Out = Request::input('P4Out');
            $mon10Out = Request::input('P5Out');
            $mon11Out = Request::input('P6Out');
            $mon12Out = Request::input('P7Out');

            try {
                $cash = Cash::getEmpCashOpen();

                if ($mon1In !== null) {
                    $cash->mon1 += trimOver($mon1In, ' ');
                }
                if ($mon2In !== null) {
                    $cash->mon2 += trimOver($mon2In, ' ');
                }
                if ($mon3In !== null) {
                    $cash->mon3 += trimOver($mon3In, ' ');
                }
                if ($mon4In !== null) {
                    $cash->mon4 += trimOver($mon4In, ' ');
                }
                if ($mon5In !== null) {
                    $cash->mon5 += trimOver($mon5In, ' ');
                }
                if ($mon6In !== null) {
                    $cash->mon6 += trimOver($mon6In, ' ');
                }
                if ($mon7In !== null) {
                    $cash->mon7 += trimOver($mon7In, ' ');
                }
                if ($mon8In !== null) {
                    $cash->mon8 += trimOver($mon8In, ' ');
                }
                if ($mon9In !== null) {
                    $cash->mon9 += trimOver($mon9In, ' ');
                }
                if ($mon10In !== null) {
                    $cash->mon10 += trimOver($mon10In, ' ');
                }
                if ($mon11In !== null) {
                    $cash->mon11 += trimOver($mon11In, ' ');
                }
                if ($mon12In !== null) {
                    $cash->mon12 += trimOver($mon12In, ' ');
                }


                if ($mon1Out !== null) {
                    $cash->mon1 -= trimOver($mon1Out, ' ');
                }
                if ($mon2Out !== null) {
                    $cash->mon2 -= trimOver($mon2Out, ' ');
                }
                if ($mon3Out !== null) {
                    $cash->mon3 -= trimOver($mon3Out, ' ');
                }
                if ($mon4Out !== null) {
                    $cash->mon4 -= trimOver($mon4Out, ' ');
                }
                if ($mon5Out !== null) {
                    $cash->mon5 -= trimOver($mon5Out, ' ');
                }
                if ($mon6Out !== null) {
                    $cash->mon6 -= trimOver($mon6Out, ' ');
                }
                if ($mon7Out !== null) {
                    $cash->mon7 -= trimOver($mon7Out, ' ');
                }
                if ($mon8Out !== null) {
                    $cash->mon8 -= trimOver($mon8Out, ' ');
                }
                if ($mon9Out !== null) {
                    $cash->mon9 -= trimOver($mon9Out, ' ');
                }
                if ($mon10Out !== null) {
                    $cash->mon10 -= trimOver($mon10Out, ' ');
                }
                if ($mon11Out !== null) {
                    $cash->mon11 -= trimOver($mon11Out, ' ');
                }
                if ($mon12Out !== null) {
                    $cash->mon12 -= trimOver($mon12Out, ' ');
                }

                $cash->update((array)$cash);

                DB::commit();
                return Redirect::route('omega')->with('success', trans('alertSuccess.monexc'));
            } catch (\Exception $ex) {
                DB::rollBack();
                return Redirect::back()->with('danger', trans('alertDanger.monexc'));
            }
        }
    }
}
