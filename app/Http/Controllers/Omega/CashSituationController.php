<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\Money;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CashSituationController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $emp = Session::get('employee');

                $cashes = null;
                if ($emp->collector === null && $emp->coll_mem === null) {
                    $cashes = Cash::getPaginateAll();
                } else {
                    $cashes = Cash::getEmpCashOpen();
                }

                $employees = User::getCollectors();
                $moneys = Money::getMoneys();

                return view('omega.pages.cash_situation', [
                    'cashes' => $cashes,
                    'employees' => $employees,
                    'moneys' => $moneys
                ]);
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }
}
