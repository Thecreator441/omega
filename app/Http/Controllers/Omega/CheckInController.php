<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Check;
use App\Models\CheckAccAmt;
use App\Models\Loan;
use App\Models\LoanType;
use App\Models\Member;
use App\Models\Operation;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CheckInController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $members = Member::getActiveMembers();
            $banks = Bank::getBanks();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.check_in', compact('menu', 'banks', 'members'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        // dd(Request::all());
        try {
            DB::beginTransaction();
        
            $emp = Session::get('employee');

            $accounts = Request::input('accounts');
            $operations = Request::input('operations');
            $amounts = Request::input('amounts');

            // $loans = Request::input('loans');
            // $intamts = Request::input('intamts');
            // $loanamts = Request::input('loanamts');

            // $opera = Operation::getByCode(54);

            $check = new Check();
            $check->checknumb = Request::input('checkno');
            $check->bank = Request::input('bank');
            $check->type = 'I';
            $check->status = 'D';
            $check->sorted = 'N';
            $check->amount = trimOver(Request::input('totrans'), ' ');
            $check->carrier = Request::input('represent');
            $check->member = Request::input('member');
            $check->network = $emp->network;
            $check->zone = $emp->zone;
            $check->institution = $emp->institution;
            $check->branch = $emp->branch;
            $check->save();

            foreach ($accounts as $key => $account) {
                $amount = (int)trimOver($amounts[$key], ' ');
                if ($amount !== 0) {
                    $checkaccamt = new CheckAccAmt();
                    $checkaccamt->checkno = $check->idcheck;
                    $checkaccamt->type = 'N';
                    $checkaccamt->account = $account;
                    $checkaccamt->operation = $operations[$key];
                    $checkaccamt->accamt = $amount;
                    $checkaccamt->network = $emp->network;
                    $checkaccamt->zone = $emp->zone;
                    $checkaccamt->institution = $emp->institution;
                    $checkaccamt->branch = $emp->branch;
                    $checkaccamt->save();
                }
            }

            // if (isset($loans)) {
            //     foreach ($loans as $key => $loan) {
            //         $memLoan = Loan::getLoan($loan);
            //         $loanType = LoanType::getLoanType($memLoan->loantype);

            //         $checkaccamt = new CheckAccAmt();
            //         $checkaccamt->checkno = $check->idcheck;
            //         $checkaccamt->type = 'L';
            //         $checkaccamt->account = $loanType->loanacc;
            //         $checkaccamt->operation = $opera->idoper;
            //         $checkaccamt->loan = $loan;
            //         $checkaccamt->network = $emp->network;
            //         $checkaccamt->zone = $emp->zone;
            //         $checkaccamt->institution = $emp->institution;
            //         $checkaccamt->branch = $emp->branch;

            //         if (!empty($intamts[$key]) && $intamts[$key] !== null && $intamts[$key] !== '0') {
            //             $checkaccamt->intamt = trimOver($intamts[$key], ' ');
            //         }

            //         if (!empty($loanamts[$key]) && $loanamts[$key] !== null && $loanamts[$key] !== '0') {
            //             $checkaccamt->accamt = trimOver($loanamts[$key], ' ');
            //         }
            //         $checkaccamt->save();
            //     }
            // }

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.check_in'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.check_in'));
        }
    }
}
