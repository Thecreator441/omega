<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Division;
use App\Models\Network;
use App\Models\Region;
use App\Models\SubDiv;
use App\Models\Town;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class NetworkController extends Controller
{
    public function index()
    {
        $countries = Country::getCountries();
        $regions = Region::getRegions();
        $divisions = Division::getDivisions();
        $subdivs = SubDiv::getSubDivs();
        $towns = Town::getTowns();
        $networks = Network::getNetworks();

        return view('admin.pages.network', compact('countries', 'regions', 'divisions', 'subdivs', 'towns', 'networks'));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        try {
            $idnetwork = Request::input('idnetwork');
            $network = null;

            if ($idnetwork === null) {
                $network = new Network();
            } else {
                $network = Network::getNetwork($idnetwork);
            }

            $network->name = Request::input('name');
            $network->abbr = Request::input('abbr');
            $network->slogan = ucwords(Request::input('slogan'));
            $network->category = Request::input('category');
            //$network->startdel = Request::input('startdel');
            $network->phone1 = Request::input('phone1');
            $network->phone2 = Request::input('phone2');
            $network->email = Request::input('email');
            $network->country = Request::input('country');
            $network->region = Request::input('region');
            $network->division = Request::input('division');
            $network->subdivision = Request::input('subdiv');
            $network->town = Request::input('town');
            $network->address = Request::input('address');
            $network->postcode = Request::input('postal');

            if ($idnetwork === null) {
                $network->save();
            } else {
                $network->update((array)$network);
            }

            DB::commit();
            if ($idnetwork === null) {
                return Redirect::back()->with('success', trans('alertSuccess.netsave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.netedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idnetwork === null) {
                return Redirect::back()->with('danger', trans('alertDanger.netsave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.netedit'));
        }
    }

    public function delete()
    {
//        dd(Request::all());
        $idnetwork = Request::input('network');

        DB::beginTransaction();
        try {
            Network::getNetwork($idnetwork)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.netdel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.netdel'));
        }
    }
}
