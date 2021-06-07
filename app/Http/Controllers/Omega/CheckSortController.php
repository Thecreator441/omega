<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Balance;
use App\Models\Bank;
use App\Models\Check;
use App\Models\CheckAccAmt;
use App\Models\Comaker;
use App\Models\Loan;
use App\Models\LoanType;
use App\Models\Mortgage;
use App\Models\Operation;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CheckSortController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $checks = Check::getNotSortChecks();

            return view('omega.pages.check_sort', [
                'checks' => $checks
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $emp = Session::get('employee');

            $writnumb = getWritNumb();
            $accounts = Request::input('accounts');
            $operations = Request::input('operations');
            $amounts = Request::input('amounts');
            $loans = Request::input('loans');
            $ints = Request::input('ints');
            $pens = Request::input('pens');
            $accrs = Request::input('accrs');
            $totints = Request::input('totints');
            $intamts = Request::input('intamts');
            $loanamts = Request::input('loanamts');

            $check = Check::getCheck(Request::input('check'));
            $accdate = AccDate::getOpenAccDate();
            $bank = Bank::getBank($check->bank);

            $opera2 = Operation::getByCode(54);
            $opera3 = Operation::getByCode(55);
            $opera4 = Operation::getByCode(56);
            $opera5 = Operation::getByCode(57);

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $bank->theiracc;
            $writing->operation = $check->operation;
            $writing->debitamt = trimOver(Request::input('totrans'), ' ');
            $writing->accdate = $accdate->accdate;
            $writing->employee = $emp->iduser;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->represent = $check->carrier;
            $writing->writ_type = 'I';
            $writing->save();

            if (isset($accounts)) {
                foreach ($accounts as $key => $account) {
                    if ($amounts[$key] !== '0' && $amounts[$key] !== null && !empty($amounts[$key])) {
                        $writing = new Writing();
                        $writing->writnumb = $writnumb;
                        $writing->account = $account;
                        $writing->aux = $check->member;
                        $writing->operation = $operations[$key];
                        $writing->creditamt = trimOver($amounts[$key], ' ');
                        $writing->accdate = $accdate->accdate;
                        $writing->employee = $emp->iduser;
                        $writing->network = $emp->network;
                        $writing->zone = $emp->zone;
                        $writing->institution = $emp->institution;
                        $writing->branch = $emp->branch;
                        $writing->represent = $check->carrier;
                        $writing->writ_type = 'I';
                        $writing->save();

                        $memBal = Balance::getMemAcc($check->member, $account);
                        $memBal->available += trimOver($amounts[$key], ' ');
                        $memBal->update((array)$memBal);
                    }
                }
            }

            if (isset($loans)) {
                foreach ($loans as $key => $loan) {
                    $memLoan = Loan::getLoan($loan);
                    $loanType = LoanType::getLoanType($memLoan->loantype);
                    $memLoanAmt = (int)$memLoan->amount;
                    if ((int)$memLoan->refamt > 0) {
                        $memLoanAmt = (int)$memLoan->refamt;
                    }

                    $totints = trimOver($totints[$key], ' ');

                    if (!empty($intamts[$key]) && $intamts[$key] !== null && $intamts[$key] !== '0') {
                        $intAmt = trimOver($intamts[$key], ' ');

                        /**
                         * Penalty Payment
                         */
                        $pen = trimOver($pens[$key], ' ');
                        if ((int)$pen !== 0) {
                            if ($pen > $intAmt) {
                                $pen = $intAmt;
                            }

                            $writing = new Writing();
                            $writing->writnumb = $writnumb;
                            $writing->account = $loanType->penacc;
                            $writing->aux = $memLoan->member;
                            $writing->operation = $opera4->idoper;
                            $writing->creditamt = $pen;
                            $writing->accdate = $accdate->accdate;
                            $writing->employee = $emp->iduser;
                            $writing->network = $emp->network;
                            $writing->zone = $emp->zone;
                            $writing->institution = $emp->institution;
                            $writing->branch = $emp->branch;
                            $writing->represent = $check->carrier;
                            $writing->writ_type = 'I';
                            $writing->save();
                        }

                        $reste = $intAmt - $pen;

                        if ($reste > 0) {
                            /**
                             * Accrued Payment
                             */
                            $accr = trimOver($accrs[$key], ' ');
                            if ((int)$accr !== 0) {
                                if ($accr > $reste) {
                                    $accr = $reste;
                                }

                                $writing = new Writing();
                                $writing->writnumb = $writnumb;
                                $writing->account = $loanType->accracc;
                                $writing->aux = $memLoan->member;
                                $writing->operation = $opera5->idoper;
                                $writing->creditamt = $accr;
                                $writing->accdate = $accdate->accdate;
                                $writing->employee = $emp->iduser;
                                $writing->network = $emp->network;
                                $writing->zone = $emp->zone;
                                $writing->institution = $emp->institution;
                                $writing->branch = $emp->branch;
                                $writing->represent = $check->carrier;
                                $writing->writ_type = 'I';
                                $writing->save();
                            }

                            $reste2 = $reste - $accr;

                            if ($reste2 > 0) {
                                /**
                                 * Interest Payment
                                 */
                                $int = trimOver($ints[$key], ' ');
                                if ($int > $reste2) {
                                    $int = $reste2;
                                }

                                $writing = new Writing();
                                $writing->writnumb = $writnumb;
                                $writing->account = $loanType->intacc;
                                $writing->aux = $memLoan->member;
                                $writing->operation = $opera3->idoper;
                                $writing->creditamt = $int;
                                $writing->accdate = $accdate->accdate;
                                $writing->employee = $emp->iduser;
                                $writing->network = $emp->network;
                                $writing->zone = $emp->zone;
                                $writing->institution = $emp->institution;
                                $writing->branch = $emp->branch;
                                $writing->represent = $check->carrier;
                                $writing->writ_type = 'I';
                                $writing->save();
                            }
                        }
                        if ($totints >= $intAmt) {
                            $memLoan->accramt = $totints - $intAmt;
                        }
                    } else {
                        $memLoan->accramt = $totints;
                    }

                    if (!empty($loanamts[$key]) && $loanamts[$key] !== null && $loanamts[$key] !== '0') {
                        $loanAmt = trimOver($loanamts[$key], ' ');

                        /**
                         * Reimbursement of Loan
                         */
                        $writing = new Writing();
                        $writing->writnumb = $writnumb;
                        $writing->aux = $memLoan->member;
                        $writing->account = $loanType->loanacc;
                        $writing->operation = $opera2->idoper;
                        $writing->creditamt = $loanAmt;
                        $writing->accdate = $accdate->accdate;
                        $writing->employee = $emp->iduser;
                        $writing->network = $emp->network;
                        $writing->zone = $emp->zone;
                        $writing->institution = $emp->institution;
                        $writing->branch = $emp->branch;
                        $writing->represent = $check->carrier;
                        $writing->writ_type = 'I';
                        $writing->save();

                        if ($memLoan->guarantee === 'F') {
                            $comakers = Comaker::getComakersDesc(['loan' => $memLoan->idloan]);
                            $comakersSum = Comaker::getComakersSum(['loan' => $memLoan->idloan]);
                            $comakersPaidSum = Comaker::getComakersPaidSum(['loan' => $memLoan->idloan]);
                            if ((int)$comakersPaidSum !== 0) {
                                $comakersSum -= $comakersPaidSum;
                            }

                            if ($comakersSum <= $loanAmt) {
                                foreach ($comakers as $comaker) {
                                    $comaker->paidguar = $comaker->guaramt;
                                    $comaker->status = 'C';
                                    $comaker->update((array)$comaker);
                                }
                            } else {
                                foreach ($comakers as $comaker) {
                                    $comAmt = (int)$comaker->guaramt;
                                    if ((int)$comaker->paidguar !== 0) {
                                        $comAmt = (int)$comaker->paidguar;
                                    }

                                    $reste = $comAmt;
                                    if ($comAmt < $loanAmt) {
                                        $comaker->paidguar = $comAmt;
                                        $comaker->status = 'C';
                                        $loanAmt -= $comAmt;
                                    } else {
                                        $comaker->paidguar += $loanAmt;
                                    }
                                    $comaker->update((array)$comaker);
                                }
                            }
                        }
                        if ($memLoan->guarantee === 'M') {
                            $loanMortgages = Mortgage::getMortgages($memLoan->idloan);
                            $memPaidLoan = $memLoan->paidamt + $loanAmt;
                            if ($memLoanAmt === (int)$memPaidLoan) {
                                foreach ($loanMortgages as $loanMortgage) {
                                    $loanMortgage->status = 'C';
                                    $loanMortgage->update((array)$loanMortgage);
                                }
                            }
                        }
                        if ($memLoan->guarantee === 'F&M') {
                            $comakers = Comaker::getComakersDesc(['loan' => $memLoan->idloan]);
                            if ($comakers !== null) {
                                $comakersSum = Comaker::getComakersSum(['loan' => $memLoan->idloan]);
                                $comakersPaidSum = Comaker::getComakersPaidSum(['loan' => $memLoan->idloan]);
                                if ((int)$comakersPaidSum !== 0) {
                                    $comakersSum -= $comakersPaidSum;
                                }

                                if ($comakersSum <= $loanAmt) {
                                    foreach ($comakers as $comaker) {
                                        $comaker->paidguar = $comaker->guaramt;
                                        $comaker->status = 'C';
                                        $comaker->update((array)$comaker);
                                    }
                                } else {
                                    foreach ($comakers as $comaker) {
                                        $comAmt = (int)$comaker->guaramt;
                                        if ((int)$comaker->paidguar !== 0) {
                                            $comAmt = (int)$comaker->paidguar;
                                        }

                                        if ($comAmt < $loanAmt) {
                                            $comaker->paidguar = $comAmt;
                                            $comaker->status = 'C';
                                            $loanAmt -= $comAmt;
                                        } else {
                                            $comaker->paidguar += $loanAmt;
                                        }
                                        $comaker->update((array)$comaker);
                                    }
                                }
                            }

                            $loanMortgages = Mortgage::getMortgages($memLoan->idloan);
                            if ($loanMortgages !== null) {
                                $memPaidLoan = $memLoan->paidamt + $loanAmt;
                                if ($memLoanAmt === (int)$memPaidLoan) {
                                    foreach ($loanMortgages as $loanMortgage) {
                                        $loanMortgage->status = 'C';
                                        $loanMortgage->update((array)$loanMortgage);
                                    }
                                }
                            }
                        }

                        $memLoan->paidamt += $loanAmt;
                        $memLoan->lastdate = getsDate(now());
                        if ($memLoanAmt === (int)$memLoan->paidamt && (int)$memLoanAmt->accramt === 0) {
                            $memLoan->loanstat = 'C';
                        }
                        $memLoan->update((array)$memLoan);
                    }
                }
            }

            $check->sorted = 'Y';
            $check->update((array)$check);

            $checAccs = CheckAccAmt::getChecksAcc($check->idcheck);
            foreach ($checAccs as $checAcc) {
                $checAcc->delete();
            }

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.checksort'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return Redirect::back()->with('danger', trans('alertDanger.checksort'));
        }
    }
}
