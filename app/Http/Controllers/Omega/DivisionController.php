<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Division;
use App\Models\Priv_Menu;
use App\Models\Region;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $countries = Country::getCountries();
            $regions = Region::getRegions();
            $divisions = Division::getDivisions();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            foreach ($divisions as $division) {
                $region = Region::getRegion($division->region);
                $country = Country::getCountry($region->country);
    
                $division->reg_fr = $region->labelfr;
                $division->reg_en = $region->labeleng;
                $division->cou_fr = $country->labelfr;
                $division->cou_en = $country->labeleng;
            }

            return view('omega.pages.division', compact('menu', 'countries', 'regions', 'divisions'));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $iddivision = Request::input('iddivision');
            $division = null;

            if ($iddivision === null) {
                $division = new Division();
            } else {
                $division = Division::getDivision($iddivision);
            }

            $division->label = Request::input('label');
            $division->region = Request::input('region');

            if ($iddivision === null) {
                $division->save();
            } else {
                $division->update((array)$division);
            }

            DB::commit();
            if ($iddivision === null) {
                return Redirect::back()->with('success', trans('alertSuccess.divsave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.divedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($iddivision === null) {
                return Redirect::back()->with('danger', trans('alertDanger.divsave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.divedit'));
        }
    }

    public function delete(): \Illuminate\Http\RedirectResponse
    {
        $iddivision = Request::input('division');

        DB::beginTransaction();
        try {
            Division::getDivision($iddivision)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.divdel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.divdel'));
        }
    }
}
