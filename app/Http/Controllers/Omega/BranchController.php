<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Division;
use App\Models\Institution;
use App\Models\Network;
use App\Models\Priv_Menu;
use App\Models\Region;
use App\Models\SubDiv;
use App\Models\Town;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class BranchController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        
        $countries = Country::getCountries();
        $regions = Region::getRegions();
        $divisions = Division::getDivisions();
        $towns = Town::getTowns();
        $subdivs = SubDiv::getSubDivs();
        $networks = Network::getNetworks();
        $zones = Zone::getZones();
        $institutions = Institution::getInstitutions();
        $branches = Branch::getBranches();
        if ($emp->level === 'N') {
            $branches = Branch::getBranches(['network' => $emp->network]);
        } elseif ($emp->level === 'Z') {
            $branches = Branch::getBranches(['zone' => $emp->zone]);
        } elseif ($emp->level === 'I') {
            $branches = Branch::getBranches(['institution' => $emp->institution]);
        }

        $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

        return view('omega.pages.branch', compact('menu', 'countries', 'regions', 'divisions', 'subdivs', 'towns', 'networks', 'zones', 'institutions', 'branches'));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        try {
            $idbranch = Request::input('idbranch');
            $branch = null;

            if ($idbranch === null) {
                $branch = new Branch();
            } else {
                $branch = Branch::getBranch($idbranch);
            }

            $branch->network = Request::input('network');
            $branch->zone = Request::input('zone');
            $branch->institution = Request::input('institution');
            $branch->code = Request::input('code');
            $branch->name = Request::input('name');
            $branch->phone1 = Request::input('phone1');
            $branch->phone2 = Request::input('phone2');
            $branch->email = Request::input('email');
            $branch->country = Request::input('country');
            $branch->region = Request::input('region');
            $branch->division = Request::input('division');
            $branch->subdivision = Request::input('subdiv');
            $branch->town = Request::input('town');
            $branch->address = Request::input('address');
            $branch->postcode = Request::input('postal');
            //$branch->dormem = Request::input('dormem');

            if ($idbranch === null) {
                $branch->save();
            } else {
                $branch->update((array)$branch);
            }

            DB::commit();
            if ($idbranch === null) {
                return Redirect::back()->with('success', trans('alertSuccess.bransave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.branedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idbranch === null) {
                return Redirect::back()->with('danger', trans('alertDanger.bransave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.branedit'));
        }
    }

    public function delete()
    {
//        dd(Request::all());
        $idbranch = Request::input('branch');

        DB::beginTransaction();
        try {
            Branch::getBranch($idbranch)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.brandel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.brandel'));
        }
    }
}
