<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Division;
use App\Models\Network;
use App\Models\Region;
use App\Models\SubDiv;
use App\Models\Town;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class ZoneController extends Controller
{
    public function index()
    {
        $networks = Network::getNetworks();
        $zones = Zone::getZones();
        $countries = Country::getCountries();
        $regions = Region::getRegions();
        $divisions = Division::getDivisions();
        $towns = Town::getTowns();
        $subdivs = SubDiv::getSubDivs();

        foreach ($zones as $zone) {
            $network = Network::getNetwork($zone->network);

            $zone->net = $network->abbr;
        }

        return view('admin.pages.zone', compact(
            'networks', 'zones', 'countries',
            'regions', 'divisions', 'subdivs', 'towns'
        ));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        try {
            $idzone = Request::input('idzone');
            $zone = null;

            if ($idzone === null) {
                $zone = new Zone();
            } else {
                $zone = Zone::getZone($idzone);
            }

            $zone->network = Request::input('network');
            $zone->name = Request::input('name');
            $zone->phone1 = Request::input('phone1');
            $zone->phone2 = Request::input('phone2');
            $zone->email = Request::input('email');
            $zone->country = Request::input('country');
            $zone->region = Request::input('region');
            $zone->division = Request::input('division');
            $zone->subdivision = Request::input('subdiv');
            $zone->town = Request::input('town');
            $zone->address = Request::input('address');
            $zone->postcode = Request::input('postal');

            if ($idzone === null) {
                $zone->save();
            } else {
                $zone->update((array)$zone);
            }

            DB::commit();
            if ($idzone === null) {
                return Redirect::back()->with('success', trans('alertSuccess.zonesave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.zoneedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idzone === null) {
                return Redirect::back()->with('danger', trans('alertDanger.zonesave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.zoneedit'));
        }
    }

    public function delete()
    {
//        dd(Request::all());
        $idzone = Request::input('zone');

        DB::beginTransaction();
        try {
            Zone::getZone($idzone)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.zonedel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.zonedel'));
        }
    }
}
