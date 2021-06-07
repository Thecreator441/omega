<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class RegionController extends Controller
{
    public function index()
    {
        $countries = Country::getCountries();
        $regions = Region::getRegions();

        foreach ($regions as $region) {
            $country = Country::getCountry($region->country);

            $region->cou_fr = $country->labelfr;
            $region->cou_en = $country->labeleng;
        }

        return view('admin.pages.region', compact('regions', 'countries'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $idregion = Request::input('idregion');
            $region = null;

            if ($idregion === null) {
                $region = new Region();
            } else {
                $region = Region::getRegion($idregion);
            }

            $region->labelfr = Request::input('labelfr');
            $region->labeleng = Request::input('labeleng');
            $region->country = Request::input('country');

            if ($idregion === null) {
                $region->save();
            } else {
                $region->update((array)$region);
            }

            DB::commit();
            if ($idregion === null) {
                return Redirect::back()->with('success', trans('alertSuccess.regsave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.regedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idregion === null) {
                return Redirect::back()->with('danger', trans('alertDanger.regsave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.regedit'));
        }
    }

    public function delete(): \Illuminate\Http\RedirectResponse
    {
        $idregion = Request::input('region');

        DB::beginTransaction();
        try {
            Region::getRegion($idregion)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.regdel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.regdel'));
        }
    }
}
