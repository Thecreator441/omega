<?php

namespace App\Http\Controllers\Omega;

use App\Models\Account;
use App\Models\Bank;
use App\Models\Country;
use App\Models\Division;
use App\Models\Region;
use App\Models\SubDiv;
use App\Models\Town;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BankController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $banks = Bank::getPaginate();
            $countries = Country::all();
            $regions = Region::all();
            $divisions = Division::all();
            $towns = Town::all();
            $subdiv = SubDiv::all();
            $accounts = Account::getAccounts();

            return view('omega.pages.bank')->with([
                'banks' => $banks,
                'countries' => $countries,
                'regions' => $regions,
                'divisions' => $divisions,
                'towns' => $towns,
                'subdivs' => $subdiv,
                'accounts' => $accounts
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        DB::beginTransaction();
        $emp = Session::get('employee');

        $idbank = Request::input('idbank');
        try {
            $bank = null;

            if ($idbank === null) {
                $bank = new Bank();
            } else {
                $bank = Bank::getBank($idbank);
            }

            $bank->bankcode = pad(Request::input('bankcode'), 6);
            $bank->name = Request::input('bankname');
            $bank->ouracc = Request::input('ouracc');
            $bank->phone1 = trimOver(Request::input('phone1'));
            $bank->phone2 = trimOver(Request::input('phone2'));
            $bank->email = Request::input('email');
            $bank->country = Request::input('country');
            $bank->region = Request::input('region');
            $bank->division = Request::input('division');
            $bank->subdivision = Request::input('subdiv');
            $bank->town = Request::input('town');
            $bank->address = Request::input('address');
            $bank->postcode = Request::input('postal');
            $bank->theiracc = Request::input('theiracc');
            $bank->checasacc = Request::input('checasacc');
            $bank->cheaccre = Request::input('cheaccre');
            $bank->corecacc = Request::input('corecacc');
            $bank->institution = $emp->institution;
            $bank->branch = $emp->branch;

            if ($idbank === null) {
                $bank->save();
            } else {
                $bank->update((array)$bank);
            }


            DB::commit();
            if ($idbank === null) {
                return Redirect::route('omega')->with('success', trans('alertSuccess.bansave'));
            }
            return Redirect::route('omega')->with('success', trans('alertSuccess.banedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            if ($idbank === null) {
                return Redirect::back()->with('danger', trans('alertDanger.bansave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.banedit'));
        }
    }

    public function delete()
    {
        $idbank = Request::input('idbank');

        DB::beginTransaction();
        try {
            Bank::getBank($idbank)->delete();

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.bandel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.bandel'));
        }
    }
}
