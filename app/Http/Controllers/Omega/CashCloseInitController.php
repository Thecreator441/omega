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

class CashCloseInitController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        if (dateOpen()) {
            if (cashOpen()) {
                $cash = Cash::getCashBy(['cashes.employee' => $emp->iduser]);
                $cashes = Cash::getCashesPaginate(['cashes.employee' => $emp->iduser, 'cashes.status' => 'O']);
                if ($cash->view_other_tills === 'Y') {
                    $cashes = Cash::getCashesPaginate(['cashes.status' => 'O']);
                }
                $moneys = Money::getMoneys();
                $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));
                
                return view('omega.pages.cash_close_init', compact('cashes', 'moneys', 'menu'));
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $cash = Cash::getCash(Request::input('idcash'));
            $cash->status = 'I';
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
