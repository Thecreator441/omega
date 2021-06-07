<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\Money;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
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
                $emp = Session::get('employee');

                $cash = Cash::getEmpCash($emp->iduser);
                $moneys = Money::getMoneys();

                return view('omega.pages.cash_open', compact('cash', 'moneys'));
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.accalert'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        $toke = Request::input('_token');

        DB::beginTransaction();
        if ($toke === null) {
            try {
                $cash = Cash::getEmpCash(Request::input('collector'));

                $cash->status = 'O';

                $cash->update((array)$cash);

                DB::commit();
                return ['success' => trans('alertSuccess.cashopened')];
            } catch (\Exception $ex) {
                DB::rollBack();
                return ['danger' => trans('alertDanger.cashopened')];
            }
        } else {
            try {
                $emp= Session::get('employee');

                $cash = Cash::getEmpCash($emp->iduser);

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
}
