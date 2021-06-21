<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Division;
use App\Models\Group;
use App\Models\Priv_Menu;
use App\Models\Profession;
use App\Models\RegBenef;
use App\Models\Region;
use App\Models\Register;
use App\Models\SubDiv;
use App\Models\Town;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $registers = Register::getRegisters();
            $groups = Group::getGroups();
            $countries = Country::getCountries();
            $regions = Region::getRegions();
            $divisions = Division::getDivisions();
            $towns = Town::getTowns();
            $subdivs = SubDiv::getSubDivs();
            $profs = Profession::getProfessions();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.registration', compact(
                'registers',
                'menu',
                'groups',
                'countries',
                'regions',
                'divisions',
                'towns',
                'subdivs',
                'profs'
            ));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    public function store()
    {
        // dd(Request::all());
        try {
            DB::beginTransaction();

            $emp = verifSession('employee');
            if($emp === null) {
                return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
            }

            $idregis = Request::input('idregister');
            $regnumb = 1;
            $regLast = Register::getLast();

            $bene_names = Request::input('bene_name');
            $bene_relates = Request::input('bene_relate');
            $bene_phones = Request::input('bene_phone');
            $bene_ratios = Request::input('bene_ratio');

            $gender = Request::input('gender');
            $grptype = Request::input('grptype');

            $profile = null;
            $signature = null;
            $signature2 = null;
            $signature3 = null;
        
            if ($idregis === null) {
                $register = new Register();
                if ($regLast !== null) {
                    $regnumb += $regLast->regnumb;
                }
            } else {
                $register = Register::getRegister($idregis);
                $regnumb = $register->regnumb;
            }

            $reference = formWriting(now(), $emp->network, $emp->zone, $emp->institution, $emp->branch, $regnumb);

            if (Request::hasFile('profile')) {
                $pic = Request::file('profile');
                $profile = $reference . '.' . $pic->getClientOriginalExtension();
                $pic->storePubliclyAs('registereds/profiles', $profile, ['visibility' => true]);
            }

            if (Request::hasFile('signature')) {
                $sign = Request::file('signature');
                $signature = $reference . '.' . $sign->getClientOriginalExtension();
                $sign->storePubliclyAs('registereds/signatures', $signature, ['visibility' => true]);
            }

            $register->regnumb = $regnumb;
            $register->gender = $gender;
            $register->memgroup = Request::input('group');
            $register->name = Request::input('name');
            $register->surname = ucwords(strtolower(Request::input('surname')));
            $register->dob = Request::input('dob');
            $register->pob = Request::input('pob');
            $register->status = Request::input('status');
            $register->profession = Request::input('profession');
            $register->cnpsnumb = Request::input('cnpsnumb');
            $register->pic = $profile;
            $register->signature = $signature;
            $register->nic_type = Request::input('nic_type');
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
            $register->quarter = Request::input('quarter');
            $register->witnes_name = Request::input('witnes_name');
            $register->witnes_phone = Request::input('witnes_phone');
            $register->witnes_nic = Request::input('witnes_nic');
            $register->network = $emp->network;
            $register->zone = $emp->zone;
            $register->institution = $emp->institution;
            $register->branch = $emp->branch;

            if ($gender === 'G') {
                $register->grptype = $grptype;
                $register->dob = Request::input('moral_dob');
                $register->pob = Request::input('moral_pob');
                $register->liveper = Request::input('liveper');

                if ($grptype === 'A') {
                    $register->name = Request::input('assoc_name');
                    $register->assno = Request::input('assno');
                    $register->assmemno = Request::input('assmemno');
                    
                    if (Request::hasFile('signature2')) {
                        $sign = Request::file('signature2');
                        $signature2 = $reference . '-2.' . $sign->getClientOriginalExtension();
                        $sign->storePubliclyAs('registereds/signatures', $signature2);
                    }
    
                    if (Request::hasFile('signature3')) {
                        $sign = Request::file('signature3');
                        $signature3 = $reference . '-3.' . $sign->getClientOriginalExtension();
                        $sign->storePubliclyAs('registereds/signatures', $signature3);
                    }

                    $register->sign2 = $signature2;
                    $register->sign3 = $signature3;     
                } else {
                    $register->name = Request::input('moral_name');
                    $register->taxpaynumb = Request::input('taxpaynumb');
                    $register->comregis = Request::input('comregis');
                    $register->regime = Request::input('regime');
                }
            }

            if ($idregis === null) {
                $register->save();

                foreach ($bene_names as $key => $bene_name) {
                    if ($bene_name !== null) {
                        $regBenef = new RegBenef();

                        $regBenef->fullname = $bene_name;
                        $regBenef->relation = $bene_relates[$key];
                        $regBenef->phone = $bene_phones[$key];
                        $regBenef->ratio = $bene_ratios[$key];
                        $regBenef->register = $register->idregister;
                        $regBenef->network = $emp->network;
                        $regBenef->zone = $emp->zone;
                        $regBenef->institution = $emp->institution;
                        $regBenef->branch = $emp->branch;

                        $regBenef->save();
                    }
                }
            } else {
                $register->update((array)$register);

                $benefs = RegBenef::getRegBenefs($idregis);

                if ($benefs->count() < count($bene_names)) {
                    foreach ($bene_names as $index => $bene_id) {
                        if (array_key_exists($index, $benefs)) {
                            $benefs[$index]->fullname = $bene_names[$index];
                            $benefs[$index]->relation = $bene_relates[$index];
                            $benefs[$index]->phone = $bene_phones[$index];
                            $benefs[$index]->ratio = $bene_ratios[$index];
                            $benefs->network = $emp->network;
                            $benefs->zone = $emp->zone;
                            $benefs->institution = $emp->institution;
                            $benefs->branch = $emp->branch;

                            $benefs[$index]->update((array)$benefs[$index]);
                        } else {
                            $newBenef = new RegBenef();
                            $newBenef->fullname = $bene_names[$index];
                            $newBenef->relation = $bene_relates[$index];
                            $newBenef->phone = $bene_phones[$index];
                            $newBenef->ratio = $bene_ratios[$index];
                            $newBenef->network = $emp->network;
                            $newBenef->zone = $emp->zone;
                            $newBenef->institution = $emp->institution;
                            $newBenef->branch = $emp->branch;
                            $newBenef->collect_mem = $idregis;

                            $newBenef->save();
                        }
                    }
                }

                if ($benefs->count() === count($bene_names)) {
                    foreach ($benefs as $index => $benef) {
                        $benef->fullname = $bene_names[$index];
                        $benef->relation = $bene_relates[$index];
                        $benef->phone = $bene_phones[$index];
                        $benef->ratio = $bene_ratios[$index];
                        $benef->network = $emp->network;
                        $benef->zone = $emp->zone;
                        $benef->institution = $emp->institution;
                        $benef->branch = $emp->branch;

                        $benef->update((array)$benef);
                    }
                }

                if ($benefs->count() > count($bene_names)) {
                    foreach ($benefs as $index => $benef) {
                        if (array_key_exists($index, $bene_names)) {
                            $benef->fullname = $bene_names[$index];
                            $benef->relation = $bene_relates[$index];
                            $benef->phone = $bene_phones[$index];
                            $benef->ratio = $bene_ratios[$index];
                            $benef->network = $emp->network;
                            $benef->zone = $emp->zone;
                            $benef->institution = $emp->institution;
                            $benef->branch = $emp->branch;

                            $benef->update((array)$benef);
                        } else {
                            $benef->delete();
                        }
                    }
                }
            }

            DB::commit();
            if ($idregis === null) {
                return Redirect::back()->with('success', trans('alertSuccess.register_save'));
            } else {
                return Redirect::back()->with('success', trans('alertSuccess.register_edit'));
            }
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            if ($idregis === null) {
                return Redirect::back()->with('danger', trans('alertDanger.register_save'));
            } else {
                return Redirect::back()->with('danger', trans('alertDanger.register_edit'));
            }
        }
    }       
}
