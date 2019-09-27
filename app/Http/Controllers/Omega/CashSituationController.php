<?php

namespace App\Http\Controllers\Omega;

use App\Models\Cash;
use App\Models\Employee;
use App\Models\Money;
use App\Http\Controllers\Controller;
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
                if ($emp->privilege === 5) {
                    $cashes = Cash::getPaginateAll();
                } else {
                    $cashes = Cash::getEmpCashOpen();
                }

                $employees = Employee::getEmployees();
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
