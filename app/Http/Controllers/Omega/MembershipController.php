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
use App\Models\ValWriting;
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
        dd(Request::all());
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

        try {
            $cash = Cash::getEmpCashOpen();
            $accdate = AccDate::getOpenAccDate();
            $opera = Operation::getByCode(42);
            $register = Register::getRegister($idreg);
            $member = Member::getLast();
            if ($member !== null) {
                $memnumb += $member->memnumb;
            }

            if (!empty($mon1) || $mon1 !== null) {
                $cash->mon1 += trimOver($mon1, ' ');
            }
            if (!empty($mon2) || $mon2 !== null) {
                $cash->mon2 += trimOver($mon2, ' ');
            }
            if (!empty($mon3) || $mon3 !== null) {
                $cash->mon3 += trimOver($mon3, ' ');
            }
            if (!empty($mon4) || $mon4 !== null) {
                $cash->mon4 += trimOver($mon4, ' ');
            }
            if (!empty($mon5) || $mon5 !== null) {
                $cash->mon5 += trimOver($mon5, ' ');
            }
            if (!empty($mon6) || $mon6 !== null) {
                $cash->mon6 += trimOver($mon6, ' ');
            }
            if (!empty($mon7) || $mon7 !== null) {
                $cash->mon7 += trimOver($mon7, ' ');
            }
            if (!empty($mon8) || $mon8 !== null) {
                $cash->mon8 += trimOver($mon8, ' ');
            }
            if (!empty($mon9) || $mon9 !== null) {
                $cash->mon9 += trimOver($mon9, ' ');
            }
            if (!empty($mon10) || $mon10 !== null) {
                $cash->mon10 += trimOver($mon10, ' ');
            }
            if (!empty($mon11) || $mon11 !== null) {
                $cash->mon11 += trimOver($mon11, ' ');
            }
            if (!empty($mon12) || $mon12 !== null) {
                $cash->mon12 += trimOver($mon12, ' ');
            }
            $cash->save();

            $member = new Member();
            $member->memnumb = $memnumb;
            $member->name = $register->name;
            $member->surname = $register->surname;
            $member->dob = $register->dob;
            $member->pob = $register->pob;
            $member->gender = $register->gender;
            $member->status = $register->status;
            $member->cnpsnumb = $register->cnpsnumb;
            $member->profession = $register->profession;
            $member->pic = $register->pic;
            $member->signature = $register->signature;
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
            $member->memtype = $register->memtype;
            $member->taxpaynumb = $register->taxpaynumb;
            $member->comregis = $register->comregis;
            $member->assno = $register->assno;
            $member->asstype = $register->asstype;
            $member->assmemno = $register->assmemno;
            $member->sign2 = $register->sign2;
            $member->sign3 = $register->sign3;
            $member->regime = $register->regime;
            $member->witnes_name = $register->witnes_name;
            $member->witnes_nic = $register->witnes_nic;
            $member->network = $emp->network;
            $member->zone = $emp->zone;
            $member->institution = $emp->institution;
            $member->branch = $register->branch;
            $member->save();

            $register->delete();
//            $register->regstatus = 'M';
//            $register->update((array)$register);

            $regBenefs = RegBenef::getRegBenef(['register' => null]);

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
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->represent = $represent;
            $writing->save();

            foreach ($accounts as $key => $account) {
                if (!empty($amounts[$key]) || $amounts[$key] !== null) {
                    $writing = new Writing();
                    $writing->writnumb = $writnumb;
                    $writing->account = $account;
                    $writing->aux = $member->idmember;
                    $writing->operation = $operations[$key];
                    $writing->creditamt = trimOver($amounts[$key], ' ');
                    $writing->accdate = $accdate->idaccdate;
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
                    $balance->initbal = trimOver($amounts[$key], ' ');
                    $balance->save();
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
