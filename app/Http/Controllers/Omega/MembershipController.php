<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\Balance;
use App\Models\Benef;
use App\Models\Cash;
use App\Models\Member;
use App\Models\MemSetting;
use App\Models\Money;
use App\Models\Operation;
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
        if (dateOpen()) {
            if (cashOpen()) {
                $registers = Register::getRegisters();
                $cash = Cash::getEmpCashOpen();
                $moneys = Money::getMoneys();
                $mem_sets = MemSetting::getMemSettings();
                $accounts = Account::getAccounts();
//dd($mem_sets);
                return view('omega.pages.membership')->with([
                    'registers' => $registers,
                    'cash' => $cash,
                    'moneys' => $moneys,
                    'mem_sets' => $mem_sets,
                    'accounts' => $accounts,
                ]);
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {

        try {
            DB::beginTransaction();
            $emp = Session::get('employee');

            $writnumb = getWritNumb();
            $memnumb = 1;
            $accounts = Request::input('account');
            $operations = Request::input('operation');
            $amounts = Request::input('amount');
            $idreg = Request::input('register');
            $represent = Request::input('represent');
            $mon1 = Request::input('B1');
            $mon2 = Request::input('B2');
            $mon3 = Request::input('B3');
            $mon4 = Request::input('B4');
            $mon5 = Request::input('B5');
            $mon6 = Request::input('P1');
            $mon7 = Request::input('P2');
            $mon8 = Request::input('P3');
            $mon9 = Request::input('P4');
            $mon10 = Request::input('P5');
            $mon11 = Request::input('P6');
            $mon12 = Request::input('P7');
            $profile = null;
            $signature = null;
            $signature2 = null;
            $signature3 = null;

            $cash = Cash::getEmpCashOpen();
            $accdate = AccDate::getOpenAccDate();
            $opera = Operation::getByCode(42);
            $register = Register::getRegister($idreg);
            $member = Member::getLast();
            if ($member !== null) {
                $memnumb += $member->memnumb;
            }
            $reference = formSeries($memnumb);

            if ($mon1 !== null) {
                $cash->mon1 += trimOver($mon1, ' ');
            }
            if ($mon2 !== null) {
                $cash->mon2 += trimOver($mon2, ' ');
            }
            if ($mon3 !== null) {
                $cash->mon3 += trimOver($mon3, ' ');
            }
            if ($mon4 !== null) {
                $cash->mon4 += trimOver($mon4, ' ');
            }
            if ($mon5 !== null) {
                $cash->mon5 += trimOver($mon5, ' ');
            }
            if ($mon6 !== null) {
                $cash->mon6 += trimOver($mon6, ' ');
            }
            if ($mon7 !== null) {
                $cash->mon7 += trimOver($mon7, ' ');
            }
            if ($mon8 !== null) {
                $cash->mon8 += trimOver($mon8, ' ');
            }
            if ($mon9 !== null) {
                $cash->mon9 += trimOver($mon9, ' ');
            }
            if ($mon10 !== null) {
                $cash->mon10 += trimOver($mon10, ' ');
            }
            if ($mon11 !== null) {
                $cash->mon11 += trimOver($mon11, ' ');
            }
            if ($mon12 !== null) {
                $cash->mon12 += trimOver($mon12, ' ');
            }
            $cash->update((array)$cash);

            $member = new Member();

            if ($register->pic !== null) {
                $profile = $reference . '.' . explode('.', $register->pic)[1];
//                $rename = rename(storage_path('app/public/registereds/profiles/' . $register->pic), storage_path('app/public/members/profiles/' . $profile));
//                move_uploaded_file($rename, storage_path('app/public/members/profiles'));
            }

            if (($register->gender === 'M' || $register->gender === 'F' || $register->gender === 'G') &&
                ($register->grptype === 'E' || $register->grptype === null)) {
                if ($register->signature !== null) {
                    $signature = $reference . '.' . explode('.', $register->signature)[1];
                    $file = storage_path('app/public/registereds/signatures/' . $register->signature);
                    if (file_exists($file)) {
                        $rename = rename($file, storage_path('app/public/members/signatures/' . $signature));
                        move_uploaded_file($rename, storage_path('app/public/members/signatures'));
                    }
                }
            }

            if ($register->gender === 'G' && $register->grptype === 'A') {
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
            $member->street = $register->street;
            $member->quarter = $register->quarter;
            $member->witnes_name = $register->witnes_name;
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
                $benef->member = $member->idmember;
                $benef->ratio = $regBenef->ratio;
                $benef->save();

                $regBenef->delete();
            }

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $cash->cashacc;
            $writing->operation = $opera->idoper;
            $writing->debitamt = trimOver(Request::input('totrans'), ' ');
            $writing->accdate = $accdate->accdate;
            $writing->employee = $emp->idemp;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->represent = $represent;
            $writing->save();

            foreach ($accounts as $key => $account) {
                if (!empty($amounts[$key]) && $amounts[$key] !== null && $amounts[$key] !== '0') {
                    $writing = new Writing();
                    $writing->writnumb = $writnumb;
                    $writing->account = $account;
                    $writing->aux = $member->idmember;
                    $writing->operation = $operations[$key];
                    $writing->creditamt = trimOver($amounts[$key], ' ');
                    $writing->accdate = $accdate->accdate;
                    $writing->employee = $emp->idemp;
                    $writing->cash = $cash->idcash;
                    $writing->network = $emp->network;
                    $writing->zone = $emp->zone;
                    $writing->institution = $emp->institution;
                    $writing->branch = $emp->branch;
                    $writing->represent = $represent;
                    $writing->save();

                    $balance = new Balance();
                    $balance->member = $member->idmember;
                    $balance->account = $account;
                    $balance->operation = $operations[$key];
                    $balance->available = trimOver($amounts[$key], ' ');
                    $balance->save();
                }
            }

            $register->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.memsave'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.memsave'));
        }
    }
}
