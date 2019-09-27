<?php

namespace App\Http\Controllers\Omega;

use App\Models\Account;
use App\Models\Bank;
use App\Models\Check;
use App\Models\CheckAccAmt;
use App\Models\Member;
use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

class OtherCheckInController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $banks = Bank::all();
            $members = Member::getActiveMembers();
            $accounts = Account::getAccounts();

            return view('omega.pages.other_check_in', [
                'banks' => $banks,
                'members' => $members,
                'accounts' => $accounts
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        $emp = Session::get('employee');

        $accounts = Request::input('accounts');
        $operations = Request::input('operations');
        $amounts = Request::input('amounts');

        try {
            $opera = Operation::getByCode(40);

            $check = new Check();
            $check->checknumb = Request::input('checkno');
            $check->bank = Request::input('bank');
            $check->type = 'I';
            $check->status = 'D';
            $check->sorted = 'N';
            $check->amount = trimOver(Request::input('totdist'), ' ');
            $check->carrier = Request::input('represent');
            $check->operation = $opera->idoper;
            $check->institution = $emp->institution;
            $check->branch = $emp->branch;

            $check->save();

            foreach ($accounts as $key => $account) {
                if ($amounts[$key] !== '0' || $amounts[$key] !== null) {
                    $checkaccamt = new CheckAccAmt();
                    $checkaccamt->checkno = $check->idcheck;
                    $checkaccamt->account = $account;
                    $checkaccamt->operation = $operations[$key];
                    $checkaccamt->accamt = trimOver($amounts[$key], ' ');

                    $checkaccamt->save();
                }
            }

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.chesave'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.chesave'));
        }
    }
}
