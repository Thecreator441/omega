<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Institution;
use App\Models\Network;
use App\Models\Privilege;
use App\Models\Region;
use App\Models\SubDiv;
use App\Models\Town;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    public function index()
    {
        $countries = Country::getCountries();
        $regions = Region::getRegions();
        $divisions = Division::getDivisions();
        $subdivs = SubDiv::getSubDivs();
        $towns = Town::getTowns();
        $collectors = User::getUsers('P.code = 0 OR P.code = 34 OR P.code = 35 OR P.code = 36 OR P.code = 37 OR P.code = 38');
        $privileges = Privilege::getPrivileges();
        $networks = Network::getNetworks();
        $zones = Zone::getZones();
        $institutions = Institution::getInstitutions();

        return view('admin.pages.user', compact(
            'countries',
            'regions',
            'divisions',
            'subdivs',
            'towns',
            'collectors',
            'privileges',
            'networks',
            'zones',
            'institutions'
        ));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        try {
            $idemployee = Request::input('idinstitute');
            $branch = Request::input('branch');
            $empmat = 1;
            $employee = Employee::getLast();
            $privilege = Privilege::getPrivilege(Request::input('privilege'));
            $emplo = null;
            $profile = null;
            $signature = null;

            if ($idemployee === null) {
                $emplo = new Employee();
                if ($employee !== null) {
                    $empmat += $employee->empmat;
                }
            } else {
                $emplo = Employee::getEmployee($idemployee);
                $empmat = $employee->empmat;
            }
            $reference = formSeries($empmat, $branch);

            if (Request::hasFile('profile')) {
                $pic = Request::file('profile');
                $profile = $reference . '.' . $pic->getClientOriginalExtension();
                $pic->storePubliclyAs('employees/profiles', $profile, ['visibility' => true]);
            }

            if (Request::hasFile('signature')) {
                $sign = Request::file('signature');
                $signature = $reference . '.' . $sign->getClientOriginalExtension();
                $sign->storePubliclyAs('employees/signatures', $signature, ['visibility' => true]);
            }

            $emplo->empmat = $empmat;
            $emplo->name = Request::input('name');
            $emplo->surname = ucwords(Request::input('surname'));
            $emplo->dob = Request::input('dob');
            $emplo->pob = Request::input('pob');
            $emplo->gender = Request::input('gender');
            $emplo->status = Request::input('status');
            if ($profile !== null) {
                $emplo->pic = $profile;
            }
            if ($signature !== null) {
                $emplo->signature = $signature;
            }
            $emplo->nic_type = Request::input('nic_type');
            $emplo->nic = Request::input('nic');
            $emplo->issuedate = Request::input('issuedate');
            $emplo->issueplace = Request::input('issueplace');
            $emplo->phone1 = Request::input('phone1');
            $emplo->phone2 = Request::input('phone2');
            $emplo->email = Request::input('email');
            $emplo->country = Request::input('country');
            $emplo->regorigin = Request::input('regorigin');
            $emplo->region = Request::input('region');
            $emplo->town = Request::input('town');
            $emplo->division = Request::input('division');
            $emplo->subdivision = Request::input('subdiv');
            $emplo->address = Request::input('address');
//            $emplo->street = Request::input('street');
            $emplo->quarter = Request::input('quarter');
            $emplo->post = Request::input('post');
            $emplo->empdate = getsDate(now());
            $emplo->network = Request::input('network');
            $emplo->zone = Request::input('zone');
            $emplo->institution = Request::input('institution');

            if ($idemployee === null) {
//                dd(['Save' => $emplo]);
                $emplo->save();

                $user = new User();
                $user->username = Request::input('name');
                $user->email = Request::input('email');
                $user->password = Hash::make('user');
                $user->employee = $emplo->idemp;
                $user->privilege = $privilege->idpriv;
                $user->network = Request::input('network');
                $user->zone = Request::input('zone');
                $user->institution = Request::input('institution');
                if ($privilege->level === 'B') {
                    $user->branch = $branch;
                }

                $user->save();
            } else {
//                dd(['Update' => $emplo]);
                $emplo->update((array)$emplo);

                $user = User::getUserBy(['employee' => $emplo->idemp]);
                $user->username = Request::input('name');
                $user->email = Request::input('email');
                $user->employee = $emplo->idemp;
                $user->privilege = $privilege->idpriv;
                $user->network = Request::input('network');
                $user->zone = Request::input('zone');
                $user->institution = Request::input('institution');
                if ($privilege->level === 'B') {
                    $user->branch = $branch;
                }

            }

            DB::commit();
            if ($idemployee === null) {
                return Redirect::back()->with('success', trans('alertSuccess.usersave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.useredit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idemployee === null) {
                return Redirect::back()->with('danger', trans('alertDanger.usersave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.useredit'));
        }
    }

    public function delete()
    {
//        dd(Request::all());
        $iduser = Request::input('institute');

        DB::beginTransaction();
        try {
            User::getUser($iduser)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.userdel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.userdel'));
        }
    }

    public function reset()
    {
//        dd(Request::all());

        DB::beginTransaction();
        try {
            $user = User::getUser(Request::input('userRes'));

            $user->login_no = null;
            $user->first_login = null;
            $user->password = Hash::make('user');

            $user->update((array)$user);

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.userres'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.userres'));
        }
    }

    public function blun()
    {
//        dd(Request::all());

        DB::beginTransaction();
        try {
            $user = User::getUser(Request::input('userBlun'));

            if ($user->login_status === 'F') {
                $user->login_status = 'B';
            } else {
                $user->login_status = 'F';
            }

            $user->update((array)$user);

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.userblun'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.userblun'));
        }
    }

}
