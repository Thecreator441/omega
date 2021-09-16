<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\Money;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class CashOpenController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        if (dateOpen()) {
            if (cashOpen()) {
                return Redirect::route('omega')->with('danger', trans('alertDanger.alrcash'));
            }

            if (CashReOpen()) {
                $cash = Cash::getCashBy(['cashes.employee' => $emp->iduser]);
                $moneys = Money::getMoneys();
                $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

                return view('omega.pages.cash_open', compact('cash', 'moneys', 'menu'));
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.accalert'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $cash = Cash::getCash(Request::input('idcash'));

            $cash->status = 'O';

            $cash->update((array)$cash);

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.cashopened'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.cashopened'));
        }
    }
}
