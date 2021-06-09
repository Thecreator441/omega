<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Collect_Bal;
use App\Models\Collect_Mem;
use App\Models\Collect_Mem_Benef;
use App\Models\Country;
use App\Models\Division;
use App\Models\Group;
use App\Models\Inst_Param;
use App\Models\Member;
use App\Models\Profession;
use App\Models\RegBenef;
use App\Models\Region;
use App\Models\Register;
use App\Models\SubDiv;
use App\Models\Town;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class RegistrationController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $clients = Register::getRegisters();
            if ($emp->collector !== null) {
                $clients = Collect_Mem::getCollectMems($emp->idcoll);
            }
            $groups = Group::getGroups();
            $countries = Country::getCountries();
            $regions = Region::getRegions();
            $divisions = Division::getDivisions();
            $towns = Town::getTowns();
            $subdivs = SubDiv::getSubDivs();
            $profs = Profession::getProfessions();

            return view('omega.pages.registration', compact(
                'clients',
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
        $toke = Request::input('_token');

        if ($toke === null) {
            DB::beginTransaction();
            try {
                $emp = User::getUser(Request::input('collector'));

                $idregis = Request::input('idinstitute');
                $regnumb = 1;
                $regLast = Collect_Mem::getLast($emp->branch, $emp->collector);
                $collect_Mem = null;
                $profile = null;
                $signature = null;
                $bene_names = Request::input('bene_name');
                $bene_relates = Request::input('bene_relate');
                $bene_ratios = Request::input('bene_ratio');
                $iParam = Inst_Param::getInstParam($emp->institution);

                if ($idregis === null) {
                    $collect_Mem = new Collect_Mem();
                    if ($regLast !== null) {
                        $regnumb += $regLast->coll_memnumb;
                    }
                } else {
                    $collect_Mem = Collect_Mem::getMember($idregis);
                    $regnumb = $collect_Mem->coll_memnumb;
                }

                $reference = formSeries($regnumb, $emp->branch);

                if (Request::hasFile('profile')) {
                    $pic = Request::file('profile');
                    $profile = $reference . '.' . $pic->getClientOriginalExtension();
                    $pic->storePubliclyAs('coll_members/profiles', $profile, ['visibility' => true]);
                }

                if (Request::hasFile('signature')) {
                    $sign = Request::file('signature');
                    $signature = $reference . '.' . $sign->getClientOriginalExtension();
                    $sign->storePubliclyAs('coll_members/signatures', $signature, ['visibility' => true]);
                }

                $collect_Mem->coll_memnumb = $regnumb;
                $collect_Mem->name = Request::input('name');
                $collect_Mem->surname = ucwords(Request::input('surname'));
                $collect_Mem->dob = Request::input('dob');
                $collect_Mem->pob = Request::input('pob');
                $collect_Mem->gender = Request::input('gender');
                $collect_Mem->status = Request::input('status');
                $collect_Mem->cnpsnumb = Request::input('cnpsnumb');
                $collect_Mem->profession = Request::input('profession');
                if ($profile !== null) {
                    $collect_Mem->pic = $profile;
                }
                if ($signature !== null) {
                    $collect_Mem->signature = $signature;
                }
                $collect_Mem->nic_type = Request::input('nic_type');
                $collect_Mem->nic = Request::input('nic');
                $collect_Mem->issuedate = Request::input('issuedate');
                $collect_Mem->issueplace = Request::input('issueplace');
                $collect_Mem->phone1 = Request::input('phone1');
                $collect_Mem->phone2 = Request::input('phone2');
                $collect_Mem->email = Request::input('email');
                $collect_Mem->country = Request::input('country');
                $collect_Mem->regorigin = Request::input('regorigin');
                $collect_Mem->region = Request::input('region');
                $collect_Mem->town = Request::input('town');
                $collect_Mem->division = Request::input('division');
                $collect_Mem->subdivision = Request::input('subdiv');
                $collect_Mem->address = Request::input('address');
                $collect_Mem->street = Request::input('street');
                $collect_Mem->quarter = Request::input('quarter');
                $collect_Mem->collector = $emp->collector;
                $collect_Mem->network = $emp->network;
                $collect_Mem->zone = $emp->zone;
                $collect_Mem->institution = $emp->institution;
                $collect_Mem->branch = $emp->branch;

                if ($idregis === null) {
                    $collect_Mem->save();

                    $memBal = new Collect_Bal();
                    $memBal->member = $collect_Mem->idcollect_mem;
                    $memBal->account = $iParam->client_acc;
                    $memBal->network = $emp->network;
                    $memBal->zone = $emp->zone;
                    $memBal->institution = $emp->institution;
                    $memBal->branch = $emp->branch;

                    $memBal->save();

                    foreach ($bene_names as $key => $bene_name) {
                        if ($bene_name !== null) {
                            $regBenef = new Collect_Mem_Benef();

                            $regBenef->fullname = $bene_name;
                            $regBenef->relation = $bene_relates[$key];
                            $regBenef->ratio = $bene_ratios[$key];
                            $regBenef->collect_mem = $collect_Mem->idcollect_mem;
                            $regBenef->network = $emp->network;
                            $regBenef->zone = $emp->zone;
                            $regBenef->institution = $emp->institution;
                            $regBenef->branch = $emp->branch;

                            $regBenef->save();
                        }
                    }
                } else {
                    $collect_Mem->update((array)$collect_Mem);

                    $benefs = Collect_Mem_Benef::getCollectMemBenefs($idregis);

                    if ($benefs->count() < count($bene_names)) {
                        foreach ($bene_names as $index => $bene_id) {
                            if (array_key_exists($index, $benefs)) {
                                $benefs[$index]->fullname = $bene_names[$index];
                                $benefs[$index]->relation = $bene_relates[$index];
                                $benefs[$index]->ratio = $bene_ratios[$index];
                                $benefs->network = $emp->network;
                                $benefs->zone = $emp->zone;
                                $benefs->institution = $emp->institution;
                                $benefs->branch = $emp->branch;

                                $benefs[$index]->update((array)$benefs[$index]);
                            } else {
                                $newBenef = new Collect_Mem_Benef();
                                $newBenef->fullname = $bene_names[$index];
                                $newBenef->relation = $bene_relates[$index];
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
                    return ['success' => trans('alertSuccess.memsave')];
                } else {
                    return ['success' => trans('alertSuccess.memedit')];
                }

            } catch (\Exception $ex) {
                DB::rollBack();
//                if ($idregis === null) {
//                    return ['danger' => $ex->getTrace()];
//                } else {
//                    return ['danger' => $ex->getMessage()];
//                }
                if ($idregis === null) {
                    return ['danger' => trans('alertDanger.memsave')];
                } else {
                    return ['danger' => trans('alertDanger.memedit')];
                }
            }
        } else {
            DB::beginTransaction();

            $emp = Session::get('employee');

            if ($emp->colector !== null) {
                try {
                    $emp = Session::get('employee');

                    $idregis = Request::input('idinstitute');
                    $regnumb = 1;
                    $regLast = Collect_Mem::getLast();
                    $collect_Mem = null;
                    $profile = null;
                    $signature = null;
                    $bene_names = Request::input('bene_name');
                    $bene_relates = Request::input('bene_relate');
                    $bene_ratios = Request::input('bene_ratio');
                    $iParam = Inst_Param::getInstParam($emp->institution);

                    if ($idregis === null) {
                        $collect_Mem = new Collect_Mem();
                        if ($regLast !== null) {
                            $regnumb += $regLast->coll_memnumb;
                        }
                    } else {
                        $collect_Mem = Collect_Mem::getMember($idregis);
                        $regnumb = $collect_Mem->coll_memnumb;
                    }

                    $reference = formSeries($regnumb);

                    if (Request::hasFile('profile')) {
                        $pic = Request::file('profile');
                        $profile = $reference . '.' . $pic->getClientOriginalExtension();
                        $pic->storePubliclyAs('coll_members/profiles', $profile, ['visibility' => true]);
                    }

                    if (Request::hasFile('signature')) {
                        $sign = Request::file('signature');
                        $signature = $reference . '.' . $sign->getClientOriginalExtension();
                        $sign->storePubliclyAs('coll_members/signatures', $signature, ['visibility' => true]);
                    }

                    $collect_Mem->coll_memnumb = $regnumb;
                    $collect_Mem->name = Request::input('name');
                    $collect_Mem->surname = ucwords(Request::input('surname'));
                    $collect_Mem->dob = Request::input('dob');
                    $collect_Mem->pob = Request::input('pob');
                    $collect_Mem->gender = Request::input('gender');
                    $collect_Mem->status = Request::input('status');
                    $collect_Mem->cnpsnumb = Request::input('cnpsnumb');
                    $collect_Mem->profession = Request::input('profession');
                    if ($profile !== null) {
                        $collect_Mem->pic = $profile;
                    }
                    if ($signature !== null) {
                        $collect_Mem->signature = $signature;
                    }
                    $collect_Mem->nic_type = Request::input('nic_type');
                    $collect_Mem->nic = Request::input('nic');
                    $collect_Mem->issuedate = Request::input('issuedate');
                    $collect_Mem->issueplace = Request::input('issueplace');
                    $collect_Mem->phone1 = Request::input('phone1');
                    $collect_Mem->phone2 = Request::input('phone2');
                    $collect_Mem->email = Request::input('email');
                    $collect_Mem->country = Request::input('country');
                    $collect_Mem->regorigin = Request::input('regorigin');
                    $collect_Mem->region = Request::input('region');
                    $collect_Mem->town = Request::input('town');
                    $collect_Mem->division = Request::input('division');
                    $collect_Mem->subdivision = Request::input('subdiv');
                    $collect_Mem->address = Request::input('address');
//                $collect_Mem->street = Request::input('street');
                    $collect_Mem->quarter = Request::input('quarter');
                    $collect_Mem->collector = $emp->idcoll;
                    $collect_Mem->network = $emp->network;
                    $collect_Mem->zone = $emp->zone;
                    $collect_Mem->institution = $emp->institution;
                    $collect_Mem->branch = $emp->branch;

                    if ($idregis === null) {
                        $collect_Mem->save();

                        $memBal = new Collect_Bal();
                        $memBal->member = $collect_Mem->idcollect_mem;
                        $memBal->account = $iParam->client_acc;
                        $memBal->network = $emp->network;
                        $memBal->zone = $emp->zone;
                        $memBal->institution = $emp->institution;
                        $memBal->branch = $emp->branch;

                        $memBal->save();

                        foreach ($bene_names as $key => $bene_name) {
                            if ($bene_name !== null) {
                                $regBenef = new Collect_Mem_Benef();

                                $regBenef->fullname = $bene_name;
                                $regBenef->relation = $bene_relates[$key];
                                $regBenef->ratio = $bene_ratios[$key];
                                $regBenef->collect_mem = $collect_Mem->idcollect_mem;
                                $regBenef->network = $emp->network;
                                $regBenef->zone = $emp->zone;
                                $regBenef->institution = $emp->institution;
                                $regBenef->branch = $emp->branch;

                                $regBenef->save();
                            }
                        }
                    } else {
                        $collect_Mem->update((array)$collect_Mem);

                        $benefs = Collect_Mem_Benef::getCollectMemBenefs($idregis);

                        if ($benefs->count() < count($bene_names)) {
                            foreach ($bene_names as $index => $bene_id) {
                                if (array_key_exists($index, $benefs)) {
                                    $benefs[$index]->fullname = $bene_names[$index];
                                    $benefs[$index]->relation = $bene_relates[$index];
                                    $benefs[$index]->ratio = $bene_ratios[$index];
                                    $benefs->network = $emp->network;
                                    $benefs->zone = $emp->zone;
                                    $benefs->institution = $emp->institution;
                                    $benefs->branch = $emp->branch;

                                    $benefs[$index]->update((array)$benefs[$index]);
                                } else {
                                    $newBenef = new Collect_Mem_Benef();
                                    $newBenef->fullname = $bene_names[$index];
                                    $newBenef->relation = $bene_relates[$index];
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
                        return Redirect::back()->with('success', trans('alertSuccess.memsave'));
                    } else {
                        return Redirect::back()->with('success', trans('alertSuccess.memedit'));
                    }

                } catch (\Exception $ex) {
                    DB::rollBack();
                    if ($idregis === null) {
                        return Redirect::back()->with('danger', trans('alertDanger.memsave'));
                    } else {
                        return Redirect::back()->with('danger', trans('alertDanger.memedit'));
                    }
                }
            } else {
                $idregis = Request::input('idinstitute');
                $regnumb = 1;
                $regLast = Register::getLast();
                $bene_names = Request::input('bene_name');
                $bene_relates = Request::input('bene_relate');
                $bene_ratios = Request::input('bene_ratio');
                $gender = Request::input('gender');
                $grptype = Request::input('grptype');
                $profile = null;
                $signature = null;
                $signature2 = null;
                $signature3 = null;

                try {
                    if ($idregis === null) {
                        $register = new Register();
                        if ($regLast !== null) {
                            $regnumb += $regLast->idregister;
                        }
                    } else {
                        $register = Register::getRegister($idregis);
                        $regnumb = $register->idregister;
                    }

                    $reference = formSeries($regnumb);

                    if ($gender === 'M' || $gender === 'F') {
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
                        $register->name = Request::input('name');
                        $register->surname = ucwords(Request::input('surname'));
                        $register->dob = Request::input('dob');
                        $register->pob = Request::input('pob');
                        $register->gender = $gender;
                        $register->memgroup = Request::input('group');
                        $register->status = Request::input('status');
                        $register->cnpsnumb = Request::input('cnpsnumb');
                        $register->profession = Request::input('profession');
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
//                        $register->street = Request::input('street');
                        $register->quarter = Request::input('quarter');
                        $register->witnes_name = Request::input('witnes_name');
                        $register->witnes_nic = Request::input('witnes_nic');
                        $register->network = $emp->network;
                        $register->zone = $emp->zone;
                        $register->institution = $emp->institution;
                        $register->branch = $emp->branch;
                    } else if ($gender === 'G') {
                        if (Request::hasFile('profile1')) {
                            $pic = Request::file('profile1');
                            $profile = $reference . '.' . $pic->getClientOriginalExtension();
                            $pic->storePubliclyAs('registereds/profiles', $profile);
                        }

                        if ($grptype === 'A') {
                            if (Request::hasFile('signature1')) {
                                $sign = Request::file('signature1');
                                $signature = $reference . '-1.' . $sign->getClientOriginalExtension();
                                $sign->storePubliclyAs('registereds/signatures', $signature);
                            }

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
                        } else if (($grptype === 'E') && Request::hasFile('entsignature1')) {
                            $sign = Request::file('entsignature1');
                            $signature = $reference . '.' . $sign->getClientOriginalExtension();
                            $sign->storePubliclyAs('registereds/signatures', $signature);
                        }

                        $register->regnumb = $regnumb;
                        $register->name = Request::input('grpname');
                        $register->surname = Request::input('grpsurname');
                        $register->dob = Request::input('grpdob');
                        $register->pob = Request::input('grppob');
                        $register->gender = $gender;
                        $register->grptype = $grptype;
                        $register->pic = $profile;
                        $register->signature = $signature;
                        if ($grptype === 'A') {
                            $register->sign2 = $signature2;
                            $register->sign3 = $signature3;
                            $register->assno = Request::input('assno');
                            $register->assmemno = Request::input('assmemno');
                        } else {
                            $register->taxpaynumb = Request::input('taxpaynumb');
                            $register->comregis = Request::input('comregis');
                            $register->regime = Request::input('regime');
                        }
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
                        $register->witnes_name = Request::input('witnes_name');
                        $register->witnes_nic = Request::input('witnes_nic');
                        $register->network = $emp->network;
                        $register->zone = $emp->zone;
                        $register->institution = $emp->institution;
                        $register->branch = $emp->branch;
                    }

                    if ($idregis === null) {
                        $register->save();

                        foreach ($bene_names as $key => $bene_name) {
                            if ($bene_name !== null) {
                                $regBenef = new RegBenef();

                                $regBenef->fullname = $bene_name;
                                $regBenef->relation = $bene_relates[$key];
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
                    return Redirect::back()->with('success', trans('alertSuccess.memsave'));
                } catch (\Exception $ex) {
                    dd($ex);
                    DB::rollBack();
                    return Redirect::back()->with('danger', trans('alertDanger.memsave'));
                }
            }
        }
    }
}
