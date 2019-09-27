<?php

namespace App\Http\Controllers\Omega;

use App\Models\Cash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CashRegularisationController extends Controller
{
    public function index()
    {
        if (Session::has('acc_date')) {
            $employee = session()->get('employee');
            $cashs = Cash::getData(['idbranch' => $employee->idbranch]);

            return view('omega.pages.cash_regularisation')->with('cashs', $cashs);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }
}
