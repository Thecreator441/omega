<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Country;
use App\Models\Division;
use App\Models\Group;
use App\Models\Member;
use App\Models\RegBenef;
use App\Models\Region;
use App\Models\Register;
use App\Models\SubDiv;
use App\Models\Town;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use function Psy\debug;

class RegistrationController extends Controller
{
    public function index()
    {
        if (AccDate::getOpenAccDate() === null) {
            return Redirect::route('omega');
        }

        $member = Member::getLast();
        $register = Register::getLast();
        $groups = Group::all();
        $countries = Country::all();
        $regions = Region::all();
        $divisions = Division::all();
        $towns = Town::all();
        $subdiv = SubDiv::all();

        return view('omega.pages.registration', [
            'member' => $member,
            'register' => $register,
            'groups' => $groups,
            'countries' => $countries,
            'regions' => $regions,
            'divisions' => $divisions,
            'towns' => $towns,
            'subdivs' => $subdiv
        ]);
    }

    public function store()
    {
        DB::beginTransaction();
        $emp = Session::get('employee');

        $regnumb = Request::input('regnumb');
        $bene_names = Request::input('bene_name');
        $bene_relates = Request::input('bene_relate');
        $bene_ratios = Request::input('bene_ratio');

        try {
            $picPath = null;
            $signPath = null;

            if (Request::hasFile('profile')) {
                $pic = Request::file('profile');
                $profile = formDate() . '' . pad($emp['branch']) . '' . pad($regnumb, 6) . '.' . $pic->getClientOriginalExtension();
                $picPath = 'uploads/profiles/' . $profile;
                $pic->move(public_path('uploads/profiles/'), $profile);
            }

            if (Request::hasFile('signature')) {
                $sign = Request::file('signature');
                $signature = formDate() . '' . pad($emp['branch']) . '' . pad($regnumb, 6) . '.' . $sign->getClientOriginalExtension();
                $signPath = 'uploads/signatures/' . $signature;
                $sign->move(public_path('uploads/signatures/'), $signature);
            }

            $register = new Register();

            $register->regnumb = $regnumb;
            $register->name = Request::input('name');
            $register->surname = Request::input('surname');
            $register->dob = Request::input('dob');
            $register->pob = Request::input('pob');
            $register->gender = Request::input('gender');
            $register->status = Request::input('status');
            $register->cnpsnumb = Request::input('cnpsnumb');
            $register->profession = Request::input('profession');
            $register->pic = $picPath;
            $register->signature = $signPath;
            $register->nic = Request::input('nic');
            $register->issuedate = Request::input('issuedate');
            $register->issueplace = Request::input('issueplace');
            $register->phone1 = Request::input('phone1');
            $register->phone2 = Request::input('phone2');
            $register->email = Request::input('email');
            $register->country = Request::input('country');
            $register->regorigin = Request::input('regorigin');
            $register->region = Request::input('region');
            $register->town = Request::input('town');
            $register->division = Request::input('division');
            $register->subdivision = Request::input('subdiv');
            $register->address = Request::input('address');
            $register->street = Request::input('street');
            $register->quarter = Request::input('quarter');
            $register->memtype = Request::input('memtype');
            $register->taxpaynumb = Request::input('taxpaynumb');
            $register->assno = Request::input('assno');
            $register->asstype = Request::input('asstype');
            $register->assmemno = Request::input('assmemno');
            $register->comregis = Request::input('comregis');
            $register->regime = Request::input('regime');
            $register->witnes_name = Request::input('witnes_name');
            $register->witnes_nic = Request::input('witnes_nic');
            $register->network = $emp->network;
            $register->zone = $emp->zone;
            $register->institution = $emp->institution;
            $register->branch = $emp->branch;

            $register->save();

            foreach ($bene_names as $key => $bene_name) {
                if ($bene_name !== null) {
                    $regBenef = new RegBenef();

                    $regBenef->fullname = $bene_name;
                    $regBenef->relation = $bene_relates[$key];
                    $regBenef->ratio = $bene_ratios[$key];
                    $regBenef->register = $register->id;

                    $regBenef->save();
                }
            }
            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.memsave'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.memsave'));
        }
    }
}
