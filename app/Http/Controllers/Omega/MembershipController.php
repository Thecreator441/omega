<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\MemBalance;
use App\Models\Benef;
use App\Models\Cash;
use App\Models\Member;
use App\Models\MemSetting;
use App\Models\Money;
use App\Models\Priv_Menu;
use App\Models\RegBenef;
use App\Models\Register;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class MembershipController extends Controller
{
    public function index()
    {
        $emp = Session::get('employee');
        $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
        $registers = Register::getRegisters();
        $moneys = Money::getMoneys();
        $mem_sets = MemSetting::getMemSettings();
        $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

        return view('omega.pages.membership', compact('menu', 'registers', 'cash', 'moneys', 'mem_sets'));
    }

    public function store()
    {
        try {
            DB::beginTransaction();
            
            $emp = Session::get('employee');

            $idreg = Request::input('register');
            $memnumb = 1;

            $accounts = Request::input('accounts');
            $operations = Request::input('operations');
            $amounts = Request::input('amounts');

            $profile = null;
            $signature = null;
            $signature2 = null;
            $signature3 = null;

            $writnumb = getWritNumb();
            $accdate = AccDate::getOpenAccDate();
            $register = Register::getRegister($idreg);
            $member = Member::getLast();
            if ($member !== null) {
                $memnumb += $member->memnumb;
            }

            $reference = formWriting(now(), $emp->network, $emp->zone, $emp->institution, $emp->branch, $memnumb);

            $member = new Member();

            if ($register->pic !== null) {
                $profile = $reference . '.' . explode('.', $register->pic)[1];
                $file = storage_path('app/public/registereds/profiles/' . $register->pic);
                if (file_exists($file)) {
                    $rename = rename($file, storage_path('app/public/members/profiles/' . $profile));
                    move_uploaded_file($rename, storage_path('app/public/members/profiles'));
                }
            }

            if ($register->grptype === 'E' || $register->grptype === null) {
                if ($register->signature !== null) {
                    $signature = $reference . '.' . explode('.', $register->signature)[1];
                    $file = storage_path('app/public/registereds/signatures/' . $register->signature);
                    if (file_exists($file)) {
                        $rename = rename($file, storage_path('app/public/members/signatures/' . $signature));
                        move_uploaded_file($rename, storage_path('app/public/members/signatures'));
                    }
                }
            }

            if ($register->grptype === 'A') {
                if ($register->signature !== null) {
                    $signature = $reference . '-' . explode('-', $register->signature)[1];
                    $file = storage_path('app/public/registereds/signatures/' . $register->signature);
                    if (file_exists($file)) {
                        $rename = rename($file, storage_path('app/public/members/signatures/' . $signature));
                        move_uploaded_file($rename, storage_path('app/public/members/signatures'));
                    }
                }

                if ($register->sign2 !== null) {
                    $signature2 = formSeries($memnumb) . '-' . explode('-', $register->sign2)[1];
                    $file = storage_path('app/public/registereds/signatures/' . $register->sign2);
                    if (file_exists($file)) {
                        $rename = rename($file, storage_path('app/public/members/signatures/' . $signature2));
                        move_uploaded_file($rename, storage_path('app/public/members/signatures'));
                    }
                }

                if ($register->sign3 !== null) {
                    $signature3 = $reference . '-' . explode('-', $register->sign3)[1];
                    $file = storage_path('app/public/registereds/signatures/' . $register->sign3);
                    if (file_exists($file)) {
                        $rename = rename($file, storage_path('app/public/members/signatures/' . $signature3));
                        move_uploaded_file($rename, storage_path('app/public/members/signatures'));
                    }
                }
            }

            $member->memnumb = $memnumb;
            $member->name = $register->name;
            $member->surname = $register->surname;
            $member->dob = $register->dob;
            $member->pob = $register->pob;
            $member->gender = $register->gender;
            $member->grptype = $register->grptype;
            $member->memgroup = $register->memgroup;
            $member->status = $register->status;
            $member->cnpsnumb = $register->cnpsnumb;
            $member->profession = $register->profession;
            $member->assno = $register->assno;
            $member->assmemno = $register->assmemno;
            $member->taxpaynumb = $register->taxpaynumb;
            $member->comregis = $register->comregis;
            $member->regime = $register->regime;
            $member->pic = $profile;
            $member->signature = $signature;
            $member->sign2 = $signature2;
            $member->sign3 = $signature3;
            $member->nic = $register->nic;
            $member->issuedate = $register->issuedate;
            $member->issueplace = $register->issueplace;
            $member->phone1 = $register->phone1;
            $member->phone2 = $register->phone2;
            $member->email = $register->email;
            $member->country = $register->country;
            $member->regorigin = $register->regorigin;
            $member->region = $register->region;
            $member->town = $register->town;
            $member->division = $register->division;
            $member->subdivision = $register->subdivision;
            $member->address = $register->address;
            $member->quarter = $register->quarter;
            $member->witnes_name = $register->witnes_name;
            $member->witnes_phone = $register->witnes_phone;
            $member->witnes_nic = $register->witnes_nic;
            $member->network = $emp->network;
            $member->zone = $emp->zone;
            $member->institution = $emp->institution;
            $member->branch = $register->branch;

            $member->save();

            $regBenefs = RegBenef::getRegBenefs($register->idregister);

            foreach ($regBenefs as $regBenef) {
                $benef = new Benef();

                $benef->fullname = $regBenef->fullname;
                $benef->relation = $regBenef->relation;
                $benef->phone = $regBenef->phone;
                $benef->member = $member->idmember;
                $benef->ratio = $regBenef->ratio;
                $benef->network = $emp->network;
                $benef->zone = $emp->zone;
                $benef->institution = $emp->institution;
                $benef->branch = $register->branch;
                $benef->save();

                $regBenef->delete();
            }

            $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
            $cash->mon1 += (int)trimOver(Request::input('B1'), ' ');
            $cash->mon2 += (int)trimOver(Request::input('B2'), ' ');
            $cash->mon3 += (int)trimOver(Request::input('B3'), ' ');
            $cash->mon4 += (int)trimOver(Request::input('B4'), ' ');
            $cash->mon5 += (int)trimOver(Request::input('B5'), ' ');
            $cash->mon6 += (int)trimOver(Request::input('P1'), ' ');
            $cash->mon7 += (int)trimOver(Request::input('P2'), ' ');
            $cash->mon8 += (int)trimOver(Request::input('P3'), ' ');
            $cash->mon9 += (int)trimOver(Request::input('P4'), ' ');
            $cash->mon10 += (int)trimOver(Request::input('P5'), ' ');
            $cash->mon11 += (int)trimOver(Request::input('P6'), ' ');
            $cash->mon12 += (int)trimOver(Request::input('P7'), ' ');
            $cash->update((array)$cash);

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $cash->cashacc;
            $writing->operation = Request::input('menu_level_operation');
            $writing->debitamt = (int)trimOver(Request::input('totrans'), ' ');
            $writing->accdate = $accdate->accdate;
            $writing->employee = $emp->iduser;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->writ_type = 'I';
            $writing->represent = Request::input('represent');
            $writing->save();

            $cashBal = Account::getAccount($cash->cashacc);
            $cashBal->available += (int)trimOver(Request::input('totrans'), ' ');
            $cashBal->update((array)$cashBal);

            foreach ($accounts as $key => $account) {
                $amount = (int)trimOver($amounts[$key], ' ');

                if ($amount !== 0) {
                    $writing = new Writing();
                    $writing->writnumb = $writnumb;
                    $writing->account = $account;
                    $writing->mem_aux = $member->idmember;
                    $writing->operation = $operations[$key];
                    $writing->creditamt = $amount;
                    $writing->accdate = $accdate->accdate;
                    $writing->employee = $emp->iduser;
                    $writing->cash = $cash->idcash;
                    $writing->network = $emp->network;
                    $writing->zone = $emp->zone;
                    $writing->institution = $emp->institution;
                    $writing->branch = $emp->branch;
                    $writing->writ_type = 'I';
                    $writing->represent = Request::input('represent');
                    $writing->save();

                    $balance = new MemBalance();
                    $balance->member = $member->idmember;
                    $balance->account = $account;
                    $balance->operation = $operations[$key];
                    $balance->available += $amount;
                    $balance->save();
                }
            }

            $register->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.member_save'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.member_save'));
        }
    }
}
