<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\Money;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CashOpenController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                return Redirect::route('omega')->with('danger', trans('alertDanger.alrcash'));
            }

            if (CashReOpen()) {
                $cashs = Cash::getEmpCash();
                $moneys = Money::getMoneys();

                return view('omega.pages.cash_open', [
                    'cash' => $cashs,
                    'moneys' => $moneys,
                ]);
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.accalert'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        $idcash = Request::input('idcash');

        DB::beginTransaction();
        try {
            $cash = Cash::getCash($idcash);

            if (getsDate(now()) === $cash->closed_at) {
                $cash->status = 'R';
            } else {
                $cash->status = 'O';
            }

            $cash->save();

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.cashopened'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.cashopened'));
        }
    }
}
