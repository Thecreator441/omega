<?php

namespace App\Http\Controllers\Omega;

use App\Models\Cash;
use App\Models\Money;
use App\Models\Priv_Menu;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CashCloseController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $emp = Session::get('employee');
                $cash = Cash::getEmpCashOpen();

                $cashes = Cash::getCashesPaginate(['cashes.employee' => $emp->iduser, 'cashes.status' => 'O']);
                if ($cash->view_other_tills === 'Y') {
                    $cashes = Cash::getCashesPaginate(['cashes.status' => 'O']);
                }
                $moneys = Money::getMoneys();
                $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

                return view('omega.pages.cash_close', compact('cashes', 'moneys', 'menu'));
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        // dd(Request::all());
        try {
            DB::beginTransaction();

            if (!dateOpen()) {
                return Redirect::back()->with('danger', trans('alertDanger.opdate'));
                if (!cashOpen()) {
                    return Redirect::back()->with('danger', trans('alertDanger.opencash'));   
                }
            }
            
            $emp = Session::get('employee');

            $cash = Cash::getCash(Request::input('idcash'));
            $cash->status = 'C';
            $cash->closed_at = getsDate(now());

            $cash->update((array)$cash);

            // Session::pull('cash');

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.cashclosed'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::route('omega')->with('danger', trans('alertDanger.cashclosed'));
        }
    }
}
