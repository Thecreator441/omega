<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
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

class InstitutionController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        
        $networks = Network::getNetworks();
        $zones = Zone::getZones();
        $institutions = Institution::getInstitutions();
        if ($emp->level === 'N') {
            $institutions = Institution::getinstitutions(['network' => $emp->network]);
        } elseif ($emp->level === 'Z') {
            $institutions = Institution::getinstitutions(['zone' => $emp->zone]);
        }
        $countries = Country::getCountries();
        $regions = Region::getRegions();
        $divisions = Division::getDivisions();
        $towns = Town::getTowns();
        $subdivs = SubDiv::getSubDivs();
        $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

        return view('omega.pages.institution', compact('menu', 'countries', 'regions', 'divisions', 'subdivs', 'towns', 'networks', 'zones', 'institutions'));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        try {
            $idinst = Request::input('idinstitute');
            $network = Request::input('network');
            $zone = Request::input('zone');
            $last = Institution::getLast();
            $inst = null;
            $logo = null;
            $last_id = 1;

            if ($idinst === null) {
                $inst = new Institution();
                if ($last !== null) {
                    $last_id += $last->idinst;
                }
            } else {
                $inst = Institution::getInstitution($idinst);
                $last_id = $inst->idinst;
            }

            if (Request::hasFile('profile')) {
                $reference = pad($network, 2) . '' . pad($zone, 2) . '' . pad($last_id, 3);
                $pic = Request::file('profile');
                $logo = $reference . '.' . $pic->getClientOriginalExtension();

                if (file_exists($logo)) {
                    unlink($logo);
                    $pic->storePubliclyAs('logos', $logo, ['visibility' => true]);
                }
                $pic->storePubliclyAs('logos', $logo, ['visibility' => true]);
            }

            $inst->network = $network;
            $inst->zone = $zone;
            $inst->name = Request::input('name');
            $inst->abbr = Request::input('abbr');
            $inst->slogan = ucwords(Request::input('slogan'));
            if ($logo !== null) {
                $inst->logo = $logo;
            }
            $inst->phone1 = Request::input('phone1');
            $inst->phone2 = Request::input('phone2');
            $inst->email = Request::input('email');
            $inst->country = Request::input('country');
            $inst->region = Request::input('region');
            $inst->division = Request::input('division');
            $inst->subdivision = Request::input('subdiv');
            $inst->town = Request::input('town');
            $inst->address = Request::input('address');
            $inst->postcode = Request::input('postal');
            // $inst->strategy = Request::input('strategy');
            // $inst->comm_remove = Request::input('comm_remove');
            $inst->input_tax = Request::input('input_tax');
            $inst->input_sms = Request::input('input_sms');

            if ($idinst === null) {
                $inst->save();
            } else {
                $inst->update((array)$inst);
            }

            DB::commit();
            if ($idinst === null) {
                return Redirect::back()->with('success', trans('alertSuccess.instsave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.instedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idinst === null) {
                return Redirect::back()->with('danger', trans('alertDanger.instsave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.instedit'));
        }
    }

    public function delete()
    {
//        dd(Request::all());
        $idinst = Request::input('institute');

        DB::beginTransaction();
        try {
            Institution::getInstitution($idinst)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.instdel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            $errorInfo = $ex->getPrevious()->errorInfo;
            $index = array_key_last($errorInfo);
            return Redirect::back()->with('danger', $errorInfo[$index]);
            //return Redirect::back()->with('danger', trans('alertDanger.instdel'));
        }
    }

}
