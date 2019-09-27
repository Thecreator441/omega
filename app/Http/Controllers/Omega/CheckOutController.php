<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Bank;
use App\Models\Cash;
use App\Models\Check;
use App\Models\Member;
use App\Models\Operation;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $banks = Bank::all();
                $members = Member::getActiveMembers();
                $operas = Operation::all();

                return view('omega.pages.check_out', [
                    'banks' => $banks,
                    'members' => $members,
                    'operas' => $operas
                ]);
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        DB::beginTransaction();
        $emp = Session::get('employee');

        $writnumb = getWritNumb();
        $member = Request::input('member');
        $idbank = Request::input('bank');
        $accounts = Request::input('accounts');
        $operations = Request::input('operations');
        $amounts = Request::input('amounts');
        $amount = trimOver(Request::input('totrans'), ' ');

        try {
            $accdate = AccDate::getOpenAccDate();
            $cash = Cash::getEmpCashOpen();
            $opera = Operation::getByCode(4);
            $bank = Bank::getBank($idbank);

            foreach ($accounts as $key => $account) {
                if (!empty($amounts[$key]) || $amounts[$key] !== null) {
                    $writing = new Writing();
                    $writing->writnumb = $writnumb;
                    $writing->account = $account;
                    $writing->aux = $member;
                    $writing->operation = $operations[$key];
                    $writing->debitamt = trimOver($amounts[$key], ' ');
                    $writing->accdate = $accdate->idaccdate;
                    $writing->employee = $emp->idemp;
                    $writing->cash = $cash->idcash;
                    $writing->network = $emp->network;
                    $writing->zone = $emp->zone;
                    $writing->institution = $emp->institution;
                    $writing->branch = $emp->branch;
                    $writing->save();
                }
            }

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $bank->theiracc;
            $writing->operation = $opera->idoper;
            $writing->creditamt = $amount;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $check = new Check();
            $check->checknumb = Request::input('checkno');
            $check->bank = $idbank;
            $check->type = 'O';
            $check->amount = $amount;
            $check->member = $member;
            $check->operation = $opera->idoper;
            $check->institution = $emp->institution;
            $check->branch = $emp->branch;
            $check->save();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.cheOutSave'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.cheOutSave'));
        }
    }
}
