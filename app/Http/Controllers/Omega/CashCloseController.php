<?php

namespace App\Http\Controllers\Omega;

use App\Models\Cash;
use App\Models\Money;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CashCloseController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $cash = Cash::getEmpCashOpen();
                $moneys = Money::getMoneys();

                return view('omega.pages.cash_close', [
                    'moneys' => $moneys,
                    'cash' => $cash
                ]);
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        $cash = Cash::getEmpCashOpen();

        DB::beginTransaction();
        try {
            $cash->status = 'C';
            $cash->closed_at = getsDate(now());

            $cash->save();

            Session::pull('cash');

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.cashclosed'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::route('omega')->with('danger', trans('alertDanger.cashclosed'));
        }
    }
}
