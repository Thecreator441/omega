<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Division;
use App\Models\Region;
use App\Models\SubDiv;
use App\Models\Town;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class TownController extends Controller
{
    public function index()
    {
        $countries = Country::getCountries();
        $regions = Region::getRegions();
        $divisions = Division::getDivisions();
        $subdivisions = SubDiv::getSubDivs();
        $towns = Town::getTowns();

        foreach ($towns as $town) {
            $subdivision = SubDiv::getSubDiv($town->subdivision);
            $division = Division::getDivision($subdivision->division);
            $region = Region::getRegion($division->region);
            $country = Country::getCountry($region->country);

            $town->subdivision = $subdivision->label;
            $town->division = $division->label;
            $town->reg_fr = $region->labelfr;
            $town->reg_en = $region->labeleng;
            $town->cou_fr = $country->labelfr;
            $town->cou_en = $country->labeleng;
        }

        return view('admin.pages.town', compact('countries', 'regions', 'divisions', 'subdivisions', 'towns'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $idtown = Request::input('idtown');
            $town = null;

            if ($idtown === null) {
                $town = new Town();
            } else {
                $town = Town::getTown($idtown);
            }

            $town->label = Request::input('label');
            $town->subdivision = Request::input('subdiv');

            if ($idtown === null) {
                $town->save();
            } else {
                $town->update((array)$town);
            }

            DB::commit();
            if ($idtown === null) {
                return Redirect::back()->with('success', trans('alertSuccess.townsave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.townedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idtown === null) {
                return Redirect::back()->with('danger', trans('alertDanger.townsave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.townedit'));
        }
    }

    public function delete(): \Illuminate\Http\RedirectResponse
    {
        $idtown = Request::input('town');

        DB::beginTransaction();
        try {
            Town::getTown($idtown)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.towndel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.towndel'));
        }
    }
}
