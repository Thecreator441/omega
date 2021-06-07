<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Device;
use App\Models\Institution;
use App\Models\Network;
use App\Models\Priv_Menu;
use App\Models\Zone;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class DeviceController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/');
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $networks = Network::getNetworks();
            $zones = Zone::getZones();
            $institutions = Institution::getInstitutions();
            $branches = Branch::getBranches();
            $devices = Device::getDevices();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            foreach ($devices as $device) {
                $device->os_name_vers = Crypt::decrypt($device->os_name) . ' ' . Crypt::decrypt($device->os_version);
                $device->dev_model = Crypt::decrypt($device->dev_model);

                if ($device->dev_type === 'C') {
                    $device->dev_type = trans('label.computer');
                } elseif ($device->dev_type === 'T') {
                    $device->dev_type = trans('label.tablet');
                } else {
                    $device->dev_type = trans('label.mobile');
                }
            }

            return view('admin.pages.device', compact(
                'menu',
                'networks',
                'zones',
                'institutions',
                'branches',
                'devices'
            ));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    public function store()
    {
        dd(Request::input());
        DB::beginTransaction();
        try {
            $iddevice = Request::input('idinstitute');
            $network = Request::input('network');
            $zone = Request::input('zone');
            $institution = Request::input('institution');
            $branch = Request::input('branch');
            $devices = null;
            $reference = null;

            if ($network !== null) {
                $devices = Device::getDevices(['network' => $network]);
            }
            if ($zone !== null) {
                $devices = Device::getDevices(['zone' => $zone]);
            }
            if ($institution !== null) {
                $devices = Device::getDevices(['institution' => $institution]);
            }
            if ($branch !== null) {
                $devices = Device::getDevices(['branch' => $branch]);
            }
            if ($network === null) {
                $devices = Device::getDevices(['network' => null]);
            }

            $device = null;
            $profile = null;

            if ($iddevice === null) {
                $device = new Device();
            } else {
                $device = Device::getDevice($iddevice);
            }

            if ($network !== null || $zone !== null || $institution !== null || $branch !== null) {
                $reference = formSeries($devices->count() + 1, $branch);
            } else {
                $reference = formSeries($devices->count());
            }

            if (Request::hasFile('profile')) {
                $pic = Request::file('profile');
                $profile = $reference . '.' . $pic->getClientOriginalExtension();
                $pic->storePubliclyAs('devices', $profile, ['visibility' => true]);
            }

            $device->dev_type = Request::input('dev_type');
            $device->dev_name = Request::input('name');
            $device->dev_model = Crypt::encrypt(Request::input('dev_model'));
            $device->os_name = Crypt::encrypt(Request::input('os_name'));
            $device->os_version = Crypt::encrypt(Request::input('os_version'));
            $device->pic = $profile;
            $device->network = $network;
            $device->zone = $zone;
            $device->institution = $institution;
            $device->branch = $branch;

            if ($iddevice === null) {
                $device->save();
            } else {
                $device->update((array)$device);
            }

            DB::commit();
            if ($iddevice === null) {
                return Redirect::back()->with('success', trans('alertSuccess.devicesave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.deviceedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            if ($iddevice === null) {
                return Redirect::back()->with('danger', trans('alertDangerdevicersave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.deviceedit'));
        }
    }

    public function blun()
    {
        DB::beginTransaction();
        try {
            $device = Device::getDevice(Request::input('userBlun'));

            if ($device->status === 'F') {
                $device->status = 'B';
            } else {
                $device->status = 'F';
            }

            $device->update((array)$device);

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.deviceblun'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.deviceblun'));
        }
    }

    public function delete()
    {
        $iddevice = Request::input('institute');

        DB::beginTransaction();
        try {
            Device::getDevice($iddevice)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.devicedel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.devicedel'));
        }
    }

    public function getFilterDevices(int $network = null, int $zone = null, int $institution = null, int $branch = null) {

    }
}
