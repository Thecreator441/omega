<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Division;
use App\Models\Network;
use App\Models\Priv_Menu;
use App\Models\Region;
use App\Models\SubDiv;
use App\Models\Town;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class ZoneController extends Controller
{
    public function index()
    {
        $emp = Session::get('employee');
        
        $networks = Network::getNetworks();
        $zones = Zone::getZones();
        if ($emp->level === 'N') {
            $zones = Zone::getZones(['network' => $emp->network]);
        }
        $countries = Country::getCountries();
        $regions = Region::getRegions();
        $divisions = Division::getDivisions();
        $towns = Town::getTowns();
        $subdivs = SubDiv::getSubDivs();
        $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

        foreach ($zones as $zone) {
            $network = Network::getNetwork($zone->network);

            $zone->net = $network->abbr;
        }

        return view('omega.pages.zone', compact('menu', 'countries', 'regions', 'divisions', 'subdivs', 'towns', 'networks', 'zones'));
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
