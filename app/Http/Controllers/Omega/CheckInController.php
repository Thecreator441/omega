<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Bank;
use App\Models\Check;
use App\Models\CheckAccAmt;
use App\Models\Member;
use App\Models\Operation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CheckInController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $banks = Bank::getBanks();
            $members = Member::getActiveMembers();
            $accounts = Account::getAccounts();
            $operas = Operation::all();

            return view('omega.pages.check_in', [
                'banks' => $banks,
                'members' => $members,
                'accounts' => $accounts,
                'operas' => $operas
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        DB::beginTransaction();
        $emp = Session::get('employee');

        $accounts = Request::input('accounts');
        $operations = Request::input('operations');
        $amounts = Request::input('amounts');
//        $accounts2 = Request::input('accounts2');
//        $operations2 = Request::input('operations2');
//        $amounts2 = Request::input('amounts2');

        try {
            $opera = Operation::getByCode(37);

            $check = new Check();
            $check->checknumb = Request::input('checkno');
            $check->bank = Request::input('bank');
            $check->type = 'I';
            $check->status = 'D';
            $check->sorted = 'N';
            $check->amount = trimOver(Request::input('totrans'), ' ');
            $check->carrier = Request::input('carrier');
            $check->member = Request::input('member');
            $check->operation = $opera->idoper;
            $check->institution = $emp->institution;
            $check->branch = $emp->branch;

            $check->save();

            if (isset($accounts)) {
                foreach ($accounts as $key => $account) {
                    if ($amounts[$key] !== '0' || $amounts[$key] !== null) {
                        $checkaccamt = new CheckAccAmt();
                        $checkaccamt->checkno = $check->idcheck;
                        $checkaccamt->type = 'N';
                        $checkaccamt->account = $account;
                        $checkaccamt->operation = $operations[$key];
                        $checkaccamt->accamt = trimOver($amounts[$key], ' ');

                        $checkaccamt->save();
                    }
                }
            }

//            if (isset($accounts2)) {
//                foreach ($accounts2 as $key => $account) {
//                    if ($amounts2[$key] !== '0' || $amounts2[$key] !== null) {
//                        $checkaccamt = new CheckAccAmt();
//                        $checkaccamt->checkno = $check->idcheck;
//                        $checkaccamt->type = 'L';
//                        $checkaccamt->account = $account;
//                        if (array_key_exists($key, $operations2)) {
//                            $checkaccamt->operation = $operations2[$key];
//                        }
//                        $checkaccamt->accamt = trimOver($amounts2[$key], ' ');
//
//                        $checkaccamt->save();
//                    }
//                }
//            }

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.chesave'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.chesave'));
        }
    }
}
