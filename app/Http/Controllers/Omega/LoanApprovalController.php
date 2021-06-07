<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\Balance;
use App\Models\Comaker;
use App\Models\DemComaker;
use App\Models\DemLoan;
use App\Models\DemMortgage;
use App\Models\Installment;
use App\Models\Loan;
use App\Models\LoanType;
use App\Models\Mortgage;
use App\Models\Operation;
use App\Models\Writing;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class LoanApprovalController extends Controller
{
    public static function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        $emp = Session::get('employee');

        $idloan = Request::input('loan');
        $loanno = 1;
        $amount = trimOver(Request::input('amount'), ' ');
        $nos = Request::input('nos');
        $capitals = Request::input('capitals');
        $amortAmts = Request::input('amortAmts');
        $intAmts = Request::input('intAmts');
        $annAmts = Request::input('annAmts');
        $taxAmts = Request::input('taxAmts');
        $totAmts = Request::input('totAmts');
        $dates = Request::input('dates');

        try {
            $last = Loan::getLast();
            if ($last !== null) {
                $loanno = $last->loanno + 1;
            }
            $demLoan = DemLoan::getLoan($idloan);
            $loanType = LoanType::getLoanType($demLoan->loantype);
            $writnumb = getWritNumb();
            $accdate = AccDate::getOpenAccDate();
            $opera1 = Operation::getByCode(19);
            $opera2 = Operation::getByCode(33);

            $loan = new Loan();

            $loan->loanno = $loanno;
            $loan->member = $demLoan->member;
            $loan->memacc = $loanType->transacc;
            $loan->amount = $amount;
            $loan->vat = $demLoan->vat;
            $loan->amortype = $demLoan->amortype;
            $loan->periodicity = $demLoan->periodicity;
            $loan->grace = $demLoan->grace;
            $loan->instdate1 = $demLoan->instdate1;
            $loan->nbrinst = $demLoan->nbrinst;
            $loan->intrate = $demLoan->intrate;
            $loan->appdate = getsDate(now());
            $loan->demdate = getsDate($demLoan->created_at);
            $loan->lastdate = $demLoan->instdate1;
            $loan->loanpur = $demLoan->loanpur;
            $loan->loantype = $demLoan->loantype;
            $loan->isforce = $demLoan->isforce;
            $loan->isforceby = $demLoan->isforceby;
            $loan->guarantee = $demLoan->guarantee;
            $loan->employee = $demLoan->employee;
            $loan->institution = $demLoan->institution;
            $loan->branch = $demLoan->branch;
            $loan->save();

            if ($demLoan->guarantee === 'F') {
                $demcoMakers = DemComaker::getComakers($idloan);
                if ($demcoMakers->count() !== 0) {
                    foreach ($demcoMakers as $demcoMaker) {
                        $coMaker = new Comaker();
                        $coMaker->loan = $loan->idloan;
                        $coMaker->member = $demcoMaker->member;
                        $coMaker->account = $demcoMaker->account;
                        $coMaker->guaramt = $demcoMaker->guaramt;
                        $coMaker->save();

                        $demcoMaker->delete();
                    }
                }
            }
            if ($demLoan->guarantee === 'M') {
                $mortgno = 1;
                $demMortgages = DemMortgage::getMortgages($idloan);
                if ($demMortgages->count() !== 0) {
                    foreach ($demMortgages as $demMortgage) {
                        $last = Mortgage::getLast($loan->idloan);
                        $mortgage = new Mortgage();
                        if ($last !== null) {
                            $mortgno = $last->mortgno + 1;
                        }
                        $mortgage->mortgno = $mortgno;
                        $mortgage->name = $demMortgage->name;
                        $mortgage->nature = $demMortgage->nature;
                        $mortgage->member = $demMortgage->member;
                        $mortgage->loan = $loan->idloan;
                        $mortgage->amount = $demMortgage->amount;
                        $mortgage->save();

                        $demMortgage->delete();
                    }
                }
            }
            if ($demLoan->guarantee === 'F&M') {
                $demcoMakers = DemComaker::getComakers($idloan);
                if ($demcoMakers->count() !== 0) {
                    foreach ($demcoMakers as $demcoMaker) {
                        $coMaker = new Comaker();
                        $coMaker->loan = $loan->idloan;
                        $coMaker->member = $demcoMaker->member;
                        $coMaker->account = $demcoMaker->account;
                        $coMaker->guaramt = $demcoMaker->guaramt;
                        $coMaker->save();

                        $demcoMaker->delete();
                    }
                }
                $mortgno = 1;
                $demMortgages = DemMortgage::getMortgages($idloan);
                if ($demMortgages->count() !== 0) {
                    foreach ($demMortgages as $demMortgage) {
                        $last = Mortgage::getLast($loan->idloan);
                        $mortgage = new Mortgage();
                        if ($last !== null) {
                            $mortgno = $last->mortgno + 1;
                        }
                        $mortgage->mortgno = $mortgno;
                        $mortgage->name = $demMortgage->name;
                        $mortgage->nature = $demMortgage->nature;
                        $mortgage->member = $demMortgage->member;
                        $mortgage->loan = $loan->idloan;
                        $mortgage->amount = $demMortgage->amount;
                        $mortgage->save();

                        $demMortgage->delete();
                    }
                }
            }

            foreach ($nos as $key => $no) {
                if (!empty($no) || ($no !== '0')) {
                    $install = new Installment();
                    $install->loan = $loan->idloan;
                    $install->installno = $no;
                    $install->capital = $capitals[$key];
                    $install->amort = $amortAmts[$key];
                    $install->interest = $intAmts[$key];
                    $install->annuity = $annAmts[$key];
                    $install->tax = $taxAmts[$key];
                    $install->total = $totAmts[$key];
                    $install->instdate = getsDate(str_replace('/', '-', $dates[$key]));
                    $install->save();
                }
            }

            /**
             * Setting up Loan
             */
            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $loanType->loanacc;
            $writing->operation = $opera1->idoper;
            $writing->debitamt = $amount;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $loanType->transacc;
            $writing->aux = $demLoan->member;
            $writing->operation = $opera2->idoper;
            $writing->creditamt = $amount;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $memBal = Balance::getMemAcc($demLoan->member, $loanType->transacc);
            if ($memBal !== null) {
                $memBal->available += $amount;
                $memBal->update((array)$memBal);
            } else {
                $balance = new Balance();
                $balance->member = $demLoan->member;
                $balance->account = $loanType->transacc;
                $balance->operation = $opera2->idoper;
                $balance->available = $amount;
                $balance->save();
            }

            $demLoan->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.lappsave'));
        } catch (Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.lappsave'));
        }
    }

    public function index()
    {
        if (dateOpen()) {
            $loans = DemLoan::getDemLoans();
            $accounts = Account::getAccounts();

            return view('omega.pages.loan_approval', [
                'loans' => $loans,
                'accounts' => $accounts
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }
}
