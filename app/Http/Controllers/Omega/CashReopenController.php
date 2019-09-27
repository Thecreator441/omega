<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\Money;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CashReopenController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $cashes = Cash::getReopenPaginate();
            $moneys = Money::getMoneys();

            return view('omega.pages.cash_reopen', [
                'cashes' => $cashes,
                'moneys' => $moneys,
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        $idcash = Request::input('idcash');

        DB::beginTransaction();
        try {
            $cash = Cash::getCash($idcash);
            $cash->status = 'R';
            $cash->closed_at = null;
            $cash->save();

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.cashreopened'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.cashreopened'));
        }
    }
}
