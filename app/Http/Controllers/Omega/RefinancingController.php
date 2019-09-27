<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Balance;
use App\Models\Cash;
use App\Models\Installment;
use App\Models\Loan;
use App\Models\LoanType;
use App\Models\Operation;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class RefinancingController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $loans = Loan::getLoans(['loanstat' => 'Ar']);

            return view('omega.pages.refinancing', [
                'loans' => $loans,
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public static function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        $emp = Session::get('employee');

        $idloan = Request::input('loan');
        $nbrinst = Request::input('numb_inst');
        $nos = Request::input('nos');
        $capitals = Request::input('capitals');
        $amortAmts = Request::input('amortAmts');
        $intAmts = Request::input('intAmts');
        $annAmts = Request::input('annAmts');
        $taxAmts = Request::input('taxAmts');
        $totAmts = Request::input('totAmts');
        $dates = Request::input('dates');
        $amount = trimOver(Request::input('newamt'), ' ');

        try {
            $loan = Loan::getloan($idloan);
            $loanacc = LoanType::getLoanType($loan->loantype);
            $accdate = AccDate::getOpenAccDate();
            $opera1 = Operation::getByCode(3);
            $opera2 = Operation::getByCode(19);
            $opera3 = Operation::getByCode(33);
            $cash = Cash::getMainCash();

            $writnumb1 = getWritNumb();
            /**
             * Repayment of Loan
             */
            $writing = new Writing();
            $writing->writnumb = $writnumb1;
            $writing->account = $cash->cashacc;
            $writing->operation = $opera1->idoper;
            $writing->debitamt = $loan->remamt;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $writing = new Writing();
            $writing->writnumb = $writnumb1;
            $writing->aux = $loan->member;
            $writing->account = $loanacc->loanacc;
            $writing->operation = $opera3->idoper;
            $writing->creditamt = $loan->remamt;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

//            $writnumb2 = getWritNumb();
            /**
             * Giving out Loan
             */
//            $writing = new Writing();
//            $writing->writnumb = $writnumb2;
//            $writing->account = $loanacc->loanaccart;
//            $writing->operation = $opera2->idoper;
//            $writing->debitamt = $amount;
//            $writing->accdate = $accdate->idaccdate;
//            $writing->employee = $emp->idemp;
//            $writing->network = $emp->network;
//            $writing->zone = $emp->zone;
//            $writing->institution = $emp->institution;
//            $writing->branch = $emp->branch;
//            $writing->save();
//
//            $writing = new Writing();
//            $writing->writnumb = $writnumb2;
//            $writing->account = $cash->cashacc;
//            $writing->operation = $opera2->idoper;
//            $writing->creditamt = $amount;
//            $writing->accdate = $accdate->idaccdate;
//            $writing->employee = $emp->idemp;
//            $writing->network = $emp->network;
//            $writing->zone = $emp->zone;
//            $writing->institution = $emp->institution;
//            $writing->branch = $emp->branch;
//            $writing->save();

            $writnumb3 = getWritNumb();
            /**
             * Setting Up Loan
             */
            $writing = new Writing();
            $writing->writnumb = $writnumb3;
            $writing->account = $loanacc->loanacc;
            $writing->operation = $opera2->idoper;
            $writing->debitamt = $amount;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $writing = new Writing();
            $writing->writnumb = $writnumb3;
            $writing->account = $loanacc->transacc;
            $writing->operation = $opera2->idoper;
            $writing->creditamt = $amount;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $writnumb4 = getWritNumb();
            /**
             * Disbursement of Loan
             */
            $writing = new Writing();
            $writing->writnumb = $writnumb4;
            $writing->account = $loanacc->transacc;
            $writing->operation = $opera3->idoper;
            $writing->debitamt = $amount;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $writing = new Writing();
            $writing->writnumb = $writnumb4;
            $writing->aux = $loan->member;
            $writing->account = $loanacc->memacc;
            $writing->operation = $opera3->idoper;
            $writing->creditamt = $amount;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $memBal = Balance::getMemAcc($loan->member, $loanacc->loanacc);
            if ($memBal !== null) {
                $memBal->initbal += $amount;
                $memBal->update((array)$memBal);
            }

            $loan->remamt = $amount;
            $loan->vat = Request::input('tax_rate');
            $loan->amortype = Request::input('amorti');
            $loan->periodicity = Request::input('period');
            $loan->grace = Request::input('grace');
            $loan->instdate1 = Request::input('inst1');
            $loan->nbrinst = $nbrinst;
            $loan->intrate = Request::input('int_rate');
            ++$loan->isRef;
            $loan->update((array)$loan);

            $installs = Installment::getInstalls($idloan);
            if ($installs->count() < $nbrinst) {
                foreach ($nos as $key => $no) {
                    if (array_key_exists($key, $installs)) {
                        $installs[$key]->capital = $capitals[$key];
                        $installs[$key]->amort = $amortAmts[$key];
                        $installs[$key]->interest = $intAmts[$key];
                        $installs[$key]->annuity = $annAmts[$key];
                        $installs[$key]->tax = $taxAmts[$key];
                        $installs[$key]->total = $totAmts[$key];
                        $installs[$key]->instdate = getsDate(str_replace('/', '-', $dates[$key]));
                        $installs[$key]->update((array)$installs[$key]);
                    } else if ($installs->count() <= $key) {
                        $newInst = new Installment();
                        $newInst->loan = $loan->idloan;
                        $newInst->installno = $nos[$key];
                        $newInst->capital = $capitals[$key];
                        $newInst->amort = $amortAmts[$key];
                        $newInst->interest = $intAmts[$key];
                        $newInst->annuity = $annAmts[$key];
                        $newInst->tax = $taxAmts[$key];
                        $newInst->total = $totAmts[$key];
                        $newInst->instdate = getsDate(str_replace('/', '-', $dates[$key]));
                        $newInst->save();
                    }
                }
            } else if ($installs->count() > $nbrinst) {
                foreach ($installs as $key => $install) {
                    if (array_key_exists($key, $nos)) {
                        $install->capital = $capitals[$key];
                        $install->amort = $amortAmts[$key];
                        $install->interest = $intAmts[$key];
                        $install->annuity = $annAmts[$key];
                        $install->tax = $taxAmts[$key];
                        $install->total = $totAmts[$key];
                        $install->instdate = getsDate(str_replace('/', '-', $dates[$key]));
                        $install->update((array)$install);
                    } else {
                        $install->delete();
                    }
                }
            } else if ($installs->count() === $nbrinst) {
                foreach ($installs as $key => $install) {
                    $install->capital = $capitals[$key];
                    $install->amort = $amortAmts[$key];
                    $install->interest = $intAmts[$key];
                    $install->annuity = $annAmts[$key];
                    $install->tax = $taxAmts[$key];
                    $install->total = $totAmts[$key];
                    $install->instdate = getsDate(str_replace('/', '-', $dates[$key]));
                    $install->update((array)$install);
                }
            }

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.refsave'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.refsave'));
        }
    }
}
