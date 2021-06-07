<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Bank;
use App\Models\Check;
use App\Models\CheckAccAmt;
use App\Models\Loan;
use App\Models\LoanType;
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

        $loans = Request::input('loans');
        $intamts = Request::input('intamts');
        $loanamts = Request::input('loanamts');

        try {
            $opera = Operation::getByCode(37);
            $opera2 = Operation::getByCode(54);

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

            foreach ($accounts as $key => $account) {
                if (!empty($amounts[$key]) && $amounts[$key] !== null && $amounts[$key] !== '0') {
                    $checkaccamt = new CheckAccAmt();
                    $checkaccamt->checkno = $check->idcheck;
                    $checkaccamt->type = 'N';
                    $checkaccamt->account = $account;
                    $checkaccamt->operation = $operations[$key];
                    $checkaccamt->accamt = trimOver($amounts[$key], ' ');
                    $checkaccamt->save();
                }
            }

            if (isset($loans)) {
                foreach ($loans as $key => $loan) {
                    $memLoan = Loan::getLoan($loan);
                    $loanType = LoanType::getLoanType($memLoan->loantype);

                    $checkaccamt = new CheckAccAmt();
                    $checkaccamt->checkno = $check->idcheck;
                    $checkaccamt->type = 'L';
                    $checkaccamt->account = $loanType->loanacc;
                    $checkaccamt->operation = $opera2->idoper;
                    $checkaccamt->loan = $loan;

                    if (!empty($intamts[$key]) && $intamts[$key] !== null && $intamts[$key] !== '0') {
                        $checkaccamt->intamt = trimOver($intamts[$key], ' ');
                    }

                    if (!empty($loanamts[$key]) && $loanamts[$key] !== null && $loanamts[$key] !== '0') {
                        $checkaccamt->accamt = trimOver($loanamts[$key], ' ');
                    }
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
