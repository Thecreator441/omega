<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Institution;
use App\Models\Network;
use App\Models\Zone;

class EmployeeListController extends Controller
{
    public function index()
    {
        $networks = Network::getNetworks();
        $zones = Zone::getZones();
        $institutions = Institution::getInstitutions();
        $branches = Branch::getBranches();
        $employees = Employee::getEmployees();

//        foreach ($employees as $employee) {
//            $user = User::getUserBy(['employee' => $employee->idemp]);
//            $priv = Privilege::getPrivilege($user->privilege);
//            foreach ($user->getAttributes() as $index => $item) {
//                $employee->$index = $item;
//            }
//            foreach ($priv->getAttributes() as $index => $item) {
//                $employee->$index = $item;
//            }
//        }

//        dd($employees);

        return view('omega.pages.employee_list', compact(
            'networks',
            'zones',
            'institutions',
            'branches',
            'employees'
        ));
    }
}
