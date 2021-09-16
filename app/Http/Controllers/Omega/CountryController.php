<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::getCountries();
        $currencies = Currency::getCurrencies();
        $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

        return view('omega.pages.country', compact('menu', 'countries', 'currencies'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $idcountry = Request::input('idcountry');
            $country = null;

            if ($idcountry === null) {
                $country = new Country();
            } else {
                $country = Country::getCountry($idcountry);
            }

            $country->labelfr = Request::input('labelfr');
            $country->labeleng = Request::input('labeleng');
            $country->code = Request::input('code');
            $country->iso = Request::input('iso');
            $country->iso3 = Request::input('iso3');
            $country->phonecode = Request::input('phonecode');
            $country->currency = Request::input('currency');

            if ($idcountry === null) {
                $country->save();
            } else {
                $country->update((array)$country);
            }

            DB::commit();
            if ($idcountry === null) {
                return Redirect::back()->with('success', trans('alertSuccess.counsave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.counedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idcountry === null) {
                return Redirect::back()->with('danger', trans('alertDanger.counsave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.counedit'));
        }
    }

    public function delete(): \Illuminate\Http\RedirectResponse
    {
        $idcountry = Request::input('country');

        DB::beginTransaction();
        try {
            Country::getCountry($idcountry)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.coundel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.coundel'));
        }
    }
}
