<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Collector;
use App\Models\Country;
use App\Models\Device;
use App\Models\Division;
use App\Models\Region;
use App\Models\SubDiv;
use App\Models\Town;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CollectorController extends Controller
{
    public function index()
    {
        $countries = Country::getCountries();
        $regions = Region::getRegions();
        $divisions = Division::getDivisions();
        $towns = Town::getTowns();
        $subdivs = SubDiv::getSubDivs();
        $collectors = Collector::getCollectors();
        $devices = Device::getDevices(['status' => 'N']);

        return view('omega.pages.collector', compact(
            'countries',
            'regions',
            'divisions',
            'subdivs',
            'towns',
            'devices',
            'collectors'
        ));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        try {
            $emp = Session::get('employee');

            $idcoll = Request::input('idinstitute');
            $code = 1;
            $collLast = Collector::getLast();
            $collector = null;
            $profile = null;
            $signature = null;

            if ($idcoll === null) {
                $collector = new Collector();
                if ($collLast !== null) {
                    $code += $collLast->code;
                }
            } else {
                $collector = Collector::getCollector($idcoll);
                $code = $collector->code;
            }

            $reference = formSeries($code);

            if (Request::hasFile('profile')) {
                $pic = Request::file('profile');
                $profile = $reference . '.' . $pic->getClientOriginalExtension();
                $pic->storePubliclyAs('collectors/profiles', $profile, ['visibility' => true]);
            }

            if (Request::hasFile('signature')) {
                $sign = Request::file('signature');
                $signature = $reference . '.' . $sign->getClientOriginalExtension();
                $sign->storePubliclyAs('collectors/signatures', $signature, ['visibility' => true]);
            }

            $collector->code = $code;
            $collector->name = Request::input('name');
            $collector->surname = ucwords(Request::input('surname'));
            $collector->dob = Request::input('dob');
            $collector->pob = Request::input('pob');
            $collector->gender = Request::input('gender');
            $collector->status = Request::input('status');
            if ($profile !== null) {
                $collector->pic = $profile;
            }
            if ($signature !== null) {
                $collector->signature = $signature;
            }
            $collector->nic_type = Request::input('nic_type');
            $collector->nic = Request::input('nic');
            $collector->issuedate = Request::input('issuedate');
            $collector->issueplace = Request::input('issueplace');
            $collector->phone1 = Request::input('phone1');
            $collector->phone2 = Request::input('phone2');
            $collector->email = Request::input('email');
            $collector->country = Request::input('country');
            $collector->regorigin = Request::input('regorigin');
            $collector->region = Request::input('region');
            $collector->town = Request::input('town');
            $collector->division = Request::input('division');
            $collector->subdivision = Request::input('subdiv');
            $collector->address = Request::input('address');
//            $collect->street = Request::input('street');
            $collector->quarter = Request::input('quarter');
//            $collect->device = Request::input('device');
            $collector->network = $emp->network;
            $collector->zone = $emp->zone;
            $collector->institution = $emp->institution;
            $collector->branch = $emp->branch;

            if ($idcoll === null) {
                $collector->save();

                $user = new User();
                $user->username = Request::input('name');
                $user->email = Request::input('email');
                $user->password = Hash::make('user');
                $user->collector = $collector->idcoll;
                $user->network = $emp->network;
                $user->zone = $emp->zone;
                $user->institution = $emp->institution;
                $user->branch = $emp->branch;
                $user->privilege = 4;

                $user->save();
            } else {
                $collector->update((array)$collector);
            }

            DB::commit();
            if ($idcoll === null) {
                return Redirect::back()->with('success', trans('alertSuccess.collsave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.colledit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idcoll === null) {
                return Redirect::back()->with('danger', trans('alertDanger.collsave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.colledit'));
        }
    }

    public function delete()
    {
//        dd(Request::all());
        $idcoll = Request::input('institute');

        DB::beginTransaction();
        try {
            Collector::getCollector($idcoll)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.colldel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.colldel'));
        }
    }

}
