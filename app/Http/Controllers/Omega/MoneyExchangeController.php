<?php

namespace App\Http\Controllers\Omega;

use App\Models\Cash;
use App\Models\Money;
use App\Models\Priv_Menu;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class MoneyExchangeController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $cash = Cash::getEmpCashOpen();
                $moneys = Money::getMoneys();
                $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

                return view('omega.pages.money_exchange', compact('cash', 'moneys', 'menu'));
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        dd(Request::all());        
        try {
            DB::beginTransaction();
        
            $cash = Cash::getEmpCashOpen();

            $cash->mon1 += trimOver(Request::input('B1In'), ' ');
            $cash->mon2 += trimOver(Request::input('B2In'), ' ');
            $cash->mon3 += trimOver(Request::input('B3In'), ' ');
            $cash->mon4 += trimOver(Request::input('B4In'), ' ');
            $cash->mon5 += trimOver(Request::input('B5In'), ' ');
            $cash->mon6 += trimOver(Request::input('P1In'), ' ');
            $cash->mon7 += trimOver(Request::input('P2In'), ' ');
            $cash->mon8 += trimOver(Request::input('P3In'), ' ');
            $cash->mon9 += trimOver(Request::input('P4In'), ' ');
            $cash->mon10 += trimOver(Request::input('P5In'), ' ');
            $cash->mon11 += trimOver(Request::input('P6In'), ' ');
            $cash->mon12 += trimOver(Request::input('P7In'), ' ');
            
            $cash->mon1 -= trimOver(Request::input('B1Out'), ' ');
            $cash->mon2 -= trimOver(Request::input('B2Out'), ' ');
            $cash->mon3 -= trimOver(Request::input('B3Out'), ' ');
            $cash->mon4 -= trimOver(Request::input('B4Out'), ' ');
            $cash->mon5 -= trimOver(Request::input('B5Out'), ' ');
            $cash->mon6 -= trimOver(Request::input('P1Out'), ' ');
            $cash->mon7 -= trimOver(Request::input('P2Out'), ' ');
            $cash->mon8 -= trimOver(Request::input('P3Out'), ' ');
            $cash->mon9 -= trimOver(Request::input('P4Out'), ' ');
            $cash->mon10 -= trimOver(Request::input('P5Out'), ' ');
            $cash->mon11 -= trimOver(Request::input('P6Out'), ' ');
            $cash->mon12 -= trimOver(Request::input('P7Out'), ' ');
            
            $cash->update((array)$cash);

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.monexc'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.monexc'));
        }
    }
}
