<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Division;
use App\Models\Priv_Menu;
use App\Models\Region;
use App\Models\SubDiv;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class SubDivisionController extends Controller
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
            $subdivisions = SubDiv::getSubDivs();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            foreach ($subdivisions as $subdivision) {
                $division = Division::getDivision($subdivision->division);
                $region = Region::getRegion($division->region);
                $country = Country::getCountry($region->country);
    
                $subdivision->division = $division->label;
                $subdivision->reg_fr = $region->labelfr;
                $subdivision->reg_en = $region->labeleng;
                $subdivision->cou_fr = $country->labelfr;
                $subdivision->cou_en = $country->labeleng;
            }

            return view('omega.pages.subdivision', compact('menu', 'countries', 'regions', 'divisions', 'subdivisions'));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $idsubdiv = Request::input('idsubdivision');
            $subDiv = null;

            if ($idsubdiv === null) {
                $subDiv = new SubDiv();
            } else {
                $subDiv = SubDiv::getSubDiv($idsubdiv);
            }

            $subDiv->label = Request::input('label');
            $subDiv->division = Request::input('division');

            if ($idsubdiv === null) {
                $subDiv->save();
            } else {
                $subDiv->update((array)$subDiv);
            }

            DB::commit();
            if ($idsubdiv === null) {
                return Redirect::back()->with('success', trans('alertSuccess.subsave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.subedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idsubdiv === null) {
                return Redirect::back()->with('danger', trans('alertDanger.subsave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.subedit'));
        }
    }

    public function delete(): \Illuminate\Http\RedirectResponse
    {
        $idsubdiv = Request::input('subdivision');

        DB::beginTransaction();
        try {
            SubDiv::getSubDiv($idsubdiv)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.subdel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.subdel'));
        }
    }
}
