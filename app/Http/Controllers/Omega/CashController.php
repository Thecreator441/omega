<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Cash;
use App\Models\Employee;
use App\Models\Money;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CashController extends Controller
{
    public function index()
    {
        $cashes = Cash::getPaginate();
        $accounts = Account::getAccounts();
        $employees = Employee::getEmployees();
        $moneys = Money::getMoneys();

        return view('omega.pages.cash', [
            'cashes' => $cashes,
            'accounts' => $accounts,
            'employees' => $employees,
            'moneys' => $moneys
        ]);
    }

    public function store()
    {
        DB::beginTransaction();
        $emp = Session::get('employee');

        $idcash = Request::input('idcash');
        try {
            $cash = null;

            if ($idcash === null) {
                $cash = new Cash();
            } else {
                $cash = Cash::getCash($idcash);
            }

            $cash->cashcode = Request::input('cashcode');
            $cash->labelfr = Request::input('cashfr');
            $cash->labeleng = Request::input('casheng');
            $cash->cashacc = Request::input('cashacc');
            $cash->misacc = Request::input('misacc');
            $cash->excacc = Request::input('excacc');
//            $cash->employee = Request::input('employee');
            $cash->institution = $emp->institution;
            $cash->branch = $emp->branch;

            if ($idcash === null) {
                $cash->save();
            } else {
                $cash->update((array)$cash);
            }

            DB::commit();
            if ($idcash === null) {
                return Redirect::back()->with('success', trans('alertSuccess.cashsave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.cashedit'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            if ($idcash === null) {
                return Redirect::back()->with('danger', trans('alertDanger.cashsave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.cashedit'));
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            Cash::getCash(Request::input('idcash'))->delete();

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.cashdel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.cashdel'));
        }
    }
}
