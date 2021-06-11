<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Institution;
use App\Models\Network;
use App\Models\Platform;
use App\Models\Priv_Menu;
use App\Models\Privilege;
use App\Models\Region;
use App\Models\SubDiv;
use App\Models\Town;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
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
            $subdivs = SubDiv::getSubDivs();
            $towns = Town::getTowns();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));
            $privileges = Privilege::getPrivileges();
            if ($emp->level !== 'P') {
                $privileges = Privilege::getPrivileges(['level' => $emp->level]);
            }

            $networks = Network::getNetworks();
            $zones = Zone::getZones();
            $institutions = Institution::getInstitutions();
            $branches = Branch::getBranches();

            $users = User::getUsers();
            if ($emp->level !== 'P') {
                $users = User::getUsers(['P.level' => $emp->level]);
            }

            foreach ($users as $user) {
                $priv = Privilege::getPrivilege($user->privilege);

                foreach ($priv->getAttributes() as $index => $value) {
                    if ($user->offsetExists($index) === false) {
                        $user->$index = $value;
                    }
                }

                $empl = null;
                if ($user->platform !== null) {
                    $empl = Platform::getPlatform($user->platform);
                } elseif ($user->employee !== null) {
                    $empl = Employee::getEmployee($user->employee);
                }

                if($empl !== null) {
                    foreach ($empl->getAttributes() as $index => $value) {
                        if ($user->offsetExists($index) === false) {
                            $user->$index = $value;
                        }
                    }
                }
            }

            return view('omega.pages.user', compact(
                'menu',
                'countries',
                'regions',
                'divisions',
                'subdivs',
                'towns',
                'users',
                'privileges',
                'networks',
                'zones',
                'institutions',
                'branches'
            ));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    public function store()
    {
        // dd(Request::input());
        DB::beginTransaction();
        try {
            $emp = verifSession('employee');
            if($emp === null) {
                return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
            }

            $idemployee = Request::input('idemp');
            $iduser = Request::input('idinstitute');
            $empmat = 1;
            $privilege = Privilege::getPrivilege(Request::input('privilege'));

            $employee = null;
            if ($privilege->level === 'N') {
                $employee = Employee::getLast(['network' => Request::input('network'), 'zone' => NULL, 'institution' => NULL, 'branch' => NULL]);
            } elseif ($privilege->level === 'Z') {
                $employee = Employee::getLast(['zone' => Request::input('zone'), 'institution' => NULL, 'branch' => NULL]);
            } elseif ($privilege->level === 'I') {
                $employee = Employee::getLast(['institution' => Request::input('institution'), 'branch' => NULL]);
            } elseif ($privilege->level === 'B') {
                $employee = Employee::getLast(['branch' => Request::input('branch')]);
            } elseif ($privilege->level === 'P') {
                $employee = Platform::getLast();
            }

            $emplo = null;
            $reference = null;
            $profile = null;
            $signature = null;
            if ($idemployee === null) {
                if ($privilege->level !== 'P') {
                    $emplo = new Employee();
                    if ($employee !== null) {
                        $empmat += $employee->empmat;
                    }
                } elseif ($privilege->level === 'P') {
                    $emplo = new Platform();
                    if ($employee !== null) {
                        $empmat += $employee->platmat;
                    }
                }
            } else {
                if ($privilege->level !== 'P') {
                    $emplo = Employee::getEmployee($idemployee);
                    $empmat = $employee->empmat;
                } else {
                    $emplo = Platform::getPlatform($idemployee);
                    $empmat = $employee->platmat;
                }
            }

            if ($privilege->level !== 'P') {
                $reference = formWriting(null, (int)Request::input('network'), (int)Request::input('zone'), (int)Request::input('institution'), (int)Request::input('branch'), $empmat);
            } elseif ($privilege->level === 'P') {
                $reference = formSeries($empmat, 1);
            }

            if (Request::hasFile('profile')) {
                $pic = Request::file('profile');
                $profile = $reference . '.' . $pic->getClientOriginalExtension();
                if ($privilege->level !== 'P') {
                    $pic->storePubliclyAs('employees/profiles', $profile, ['visibility' => true]);
                } elseif ($privilege->level === 'P') {
                    $pic->storePubliclyAs('platforms/profiles', $profile, ['visibility' => true]);
                }
            }

            if (Request::hasFile('signature')) {
                $sign = Request::file('signature');
                $signature = $reference . '.' . $sign->getClientOriginalExtension();
                if ($privilege->level !== 'P') {
                    $sign->storePubliclyAs('employees/signatures', $signature, ['visibility' => true]);
                } elseif ($privilege->level === 'P') {
                    $sign->storePubliclyAs('platforms/signatures', $signature, ['visibility' => true]);
                }
            }

            if ($privilege->level !== 'P') {
                $emplo->empmat = $empmat;
            } elseif ($privilege->level === 'P') {
                $emplo->platmat = $empmat;
            }
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
            $emplo->quarter = Request::input('quarter');
            $emplo->post = Request::input('post');
            if ($emp->level !== 'P') {
                $emplo->empdate = getsDate(now());
                $emplo->network = $emp->network;
                $emplo->zone = $emp->zone;
                $emplo->institution = $emp->institution;
                $emplo->branch = $emp->branch;
            } elseif ($emp->level === 'P') {
                if ($privilege->level !== 'P') {
                    $emplo->empdate = getsDate(now());
                    $emplo->network = Request::input('network');
                    $emplo->zone = Request::input('zone');
                    $emplo->institution = Request::input('institution');
                    $emplo->branch = Request::input('branch');
                } elseif ($privilege->level === 'P') {
                    $emplo->platdate = getsDate(now());
                }
            }

            if ($idemployee === null) {
                $emplo->save();

                $user = new User();
                $user->username = Request::input('username');
                $user->email = Request::input('email');
                $user->password = Hash::make('user');
                $user->privilege = $privilege->idpriv;
                if ($privilege->level !== 'P') {
                    $user->employee = $emplo->idemp;
                    $user->network = Request::input('network');
                    $user->zone = Request::input('zone');
                    $user->institution = Request::input('institution');
                    $user->branch = Request::input('branch');
                } elseif ($privilege->level === 'P') {
                    $user->platform = $emplo->idplat;
                }

                $user->save();
            } else {
                $emplo->update((array)$emplo);

                $user = User::getUser($iduser);
                $user->username = Request::input('username');
                $user->email = Request::input('email');
                $user->privilege = $privilege->idpriv;
                if ($privilege->level !== 'P') {
                    $user->employee = $emplo->idemp;
                    $user->network = Request::input('network');
                    $user->zone = Request::input('zone');
                    $user->institution = Request::input('institution');
                    $user->branch = Request::input('branch');
                } elseif ($privilege->level === 'P') {
                    $user->platform = $emplo->idplat;
                }

                $user->update((array)$user);
            }

            DB::commit();
            if ($idemployee === null) {
                return Redirect::back()->with('success', trans('alertSuccess.usersave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.useredit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            // $errorInfo = $ex->getPrevious()->errorInfo;
            // $index = array_key_last($errorInfo);
            // return Redirect::back()->with('danger', $errorInfo[$index]);

            if ($idemployee === null) {
                return Redirect::back()->with('danger', trans('alertDanger.usersave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.useredit'));
        }
    }

    public function reset()
    {
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
            $errorInfo = $ex->getPrevious()->errorInfo;
            $index = array_key_last($errorInfo);
            return Redirect::back()->with('danger', $errorInfo[$index]);
            //return Redirect::back()->with('danger', trans('alertDanger.userres'));
        }
    }

    public function blun()
    {
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
            $errorInfo = $ex->getPrevious()->errorInfo;
            $index = array_key_last($errorInfo);
            return Redirect::back()->with('danger', $errorInfo[$index]);
            //return Redirect::back()->with('danger', trans('alertDanger.userblun'));
        }
    }

    public function change()
    {
        DB::beginTransaction();
        try {
            $emp = User::getUser(Request::input('user'));

            $emp->password = Hash::make(Request::input('password'));

            $log_date = date($emp->first_login, strtotime('+30 days'));
            $today = date('yy-m-d');

            $new_log_date = new \DateTime($log_date);
            $new_today = new \DateTime($today);

            $interval = $new_log_date->diff($new_today);

            if ($emp->login_no === null || $interval->days >= 30) {
              $emp->first_login = getsDate(now());
            }
            $emp->login_no = ++$emp->login_no;

            $emp->update((array)$emp);

            DB::commit();
            return Redirect::route('change_logout', ['user' => Request::input('user')]);
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            return Redirect::back()->with('danger', trans('alertDanger.useredit'));
        }
    }

    public function update()
    {
        DB::beginTransaction();
        try {
            $emp = User::getUser(Request::input('user'));

            if (Hash::check(Request::input('oldpass'), $emp->password)) {
                $emp->password = Hash::make(Request::input('password'));

                $log_date = date($emp->first_login, strtotime('+30 days'));
                $today = date('yy-m-d');

                $new_log_date = new \DateTime($log_date);
                $new_today = new \DateTime($today);

                $interval = $new_log_date->diff($new_today);

                if ($emp->login_no === null || $interval->days >= 30) {
                  $emp->first_login = getsDate(now());
                }
                $emp->login_no = ++$emp->login_no;

                $emp->update((array)$emp);

                $sessions = Session::all();
                foreach ($sessions as $index => $session) {
                  if ($index !== 'device_token') {
                    Session::forget($index);
                  }
                }
            } else {
                return Redirect::back()->with('danger', trans('alertDanger.oldpasserror'));
            }

            DB::commit();
            Log::info("{$emp->username} " . trans('label.logout') . " " . trans('label.at') . " " . getsDateTime(now()));
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            return Redirect::back()->with('danger', trans('alertDanger.useredit'));
        }
    }

    public function delete()
    {
        $iduser = Request::input('institute');

        DB::beginTransaction();
        try {
            $user = User::getUser($iduser);

            if ($user->employee !== null) {
                Employee::getEmployee($user->employee)->delete();
            }

            if ($user->platform !== null) {
                Platform::getPlatform($user->platform)->delete();
            }

            $user->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.userdel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            $errorInfo = $ex->getPrevious()->errorInfo;
            $index = array_key_last($errorInfo);
            return Redirect::back()->with('danger', $errorInfo[$index]);
            //return Redirect::back()->with('danger', trans('alertDanger.userdel'));
        }
    }
}
