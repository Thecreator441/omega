<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\Balance;
use App\Models\Branch_Param;
use App\Models\Cash;
use App\Models\Collect_Bal;
use App\Models\Collect_Mem;
use App\Models\Comaker;
use App\Models\Commis_Tab;
use App\Models\Inst_Param;
use App\Models\Loan;
use App\Models\LoanType;
use App\Models\Member;
use App\Models\Money;
use App\Models\Mortgage;
use App\Models\Operation;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CashInController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $emp = Session::get('employee');

                $members = Member::getActiveMembers();
                if ($emp->collector !== null) {
                    $members = Collect_Mem::getMembers(['collector' => $emp->idcoll]);
                }

                $cash = Cash::getEmpCashOpen();
                $accounts = Account::getAccounts();
                $moneys = Money::getMoneys();

                return view('omega.pages.cash_in', [
                    'members' => $members,
                    'cash' => $cash,
                    'moneys' => $moneys,
                    'accounts' => $accounts,
                ]);
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        try {
            $emp = Session::get('employee');

            if ($emp->collector !== null) {
                $writnumb = getWritNumb();
                $accdate = AccDate::getOpenAccDate();
                $cash = Cash::getEmpCashOpen();
                $bParam = Branch_Param::getBranchParam($emp->branch);
                $iParam = Inst_Param::getInstParam($cash->institution);
                $opera1 = Operation::getByCode(1);
                $opera2 = Operation::getByCode(14);
                $opera3 = Operation::getByCode(15);
                $opera4 = Operation::getByCode(23);
                $commis = null;

                $member = Request::input('member');
                $totbil = trimOver(Request::input('totbil'), ' ');
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

                $writing = new Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $cash->cashacc;
                $writing->operation = $opera1->idoper;
                $writing->debitamt = $totbil;
                $writing->accdate = $accdate->accdate;
                $writing->employee = $cash->employee;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->represent = $represent;
                $writing->writ_type = 'I';
                $writing->save();

                $cashBal = Account::getAccount($cash->cashacc);
                $cashBal->available += $totbil;
                $cashBal->update((array)$cashBal);

                if ($bParam->commis === 'P') {
                    $commis = round(($bParam->com_perc / 100) * $totbil, 0);
                } else {
                    $param_tab = Commis_Tab::getCommisTab($bParam->idbranch_param);

                    if ($totbil >= 500 && $totbil <= 5000) {
                        $commis = $param_tab->t50;
                    } elseif ($totbil >= 50001 && $totbil <= 20000) {
                        $commis = $param_tab->t200;
                    } elseif ($totbil >= 20001 && $totbil <= 40000) {
                        $commis = $param_tab->t400;
                    } elseif ($totbil >= 40001 && $totbil <= 50000) {
                        $commis = $param_tab->t500;
                    } elseif ($totbil >= 50001) {
                        $commis = $param_tab->t;
                    }
                }

                $client = $totbil - $commis;
                $tax = round((19.25 / 100) * $commis, 0);
                $revenu = $commis - $tax;

                $writing = new Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $iParam->client_acc;
                $writing->cust_aux = $member;
                $writing->operation = $opera4->idoper;
                $writing->creditamt = $client;
                $writing->accdate = $accdate->accdate;
                $writing->employee = $cash->employee;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->represent = $represent;
                $writing->writ_type = 'I';
                $writing->save();

                $memBal = Collect_Bal::getMemBal($member);
                $memBal->available += $client;
                $memBal->update((array)$memBal);

                $writing = new Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $iParam->tax_acc;
                $writing->operation = $opera3->idoper;
                $writing->creditamt = $tax;
                $writing->accdate = $accdate->accdate;
                $writing->employee = $cash->employee;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->writ_type = 'I';
                $writing->save();

                $taxBal = Account::getAccount($iParam->tax_acc);
                $taxBal->available += $tax;
                $taxBal->update((array)$taxBal);

                $writing = new Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $iParam->revenue_acc;
                $writing->operation = $opera2->idoper;
                $writing->creditamt = $revenu;
                $writing->accdate = $accdate->accdate;
                $writing->employee = $cash->employee;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->writ_type = 'I';
                $writing->save();

                $revBal = Account::getAccount($iParam->revenue_acc);
                $revBal->available += $revenu;
                $revBal->update((array)$revBal);

                if ($emp->lang === 'fr') {
                    Log::info($opera1->labelfr);
                    Log::info($opera3->labelfr);
                    Log::info($opera2->labelfr);
                } else {
                    Log::info($opera1->labeleng);
                    Log::info($opera3->labeleng);
                    Log::info($opera2->labeleng);
                }
            } else {
                $member = Request::input('member');
                $accounts = Request::input('accounts');
                $operations = Request::input('operations');
                $amounts = Request::input('amounts');
                $represent = Request::input('represent');

                $loans = Request::input('loans');
                $ints = Request::input('ints');
                $pens = Request::input('pens');
                $accrs = Request::input('accrs');
                $totints = Request::input('totints');
                $intamts = Request::input('intamts');
                $loanamts = Request::input('loanamts');

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

                $writnumb = getWritNumb();
                $accdate = AccDate::getOpenAccDate();
                $cash = Cash::getEmpCashOpen();
                $opera1 = Operation::getByCode(1);
                $opera2 = Operation::getByCode(54);
                $opera3 = Operation::getByCode(55);
                $opera4 = Operation::getByCode(56);
                $opera5 = Operation::getByCode(57);

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
                $cash->update((array) $cash);

                $writing = new Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $cash->cashacc;
                $writing->operation = $opera1->idoper;
                $writing->debitamt = trimOver(Request::input('totrans'), ' ');
                $writing->accdate = $accdate->accdate;
                $writing->employee = $emp->iduser;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->represent = $represent;
                $writing->writ_type = 'I';
                $writing->save();

                $cashBal = Account::getAccount($cash->cashacc);
                $cashBal->available += trimOver(Request::input('totrans'), ' ');
                $cashBal->update((array)$cashBal);

                foreach ($accounts as $key => $account) {
                    if (!empty($amounts[$key]) && $amounts[$key] !== null && $amounts[$key] !== '0') {
                        $writing = new Writing();
                        $writing->writnumb = $writnumb;
                        $writing->account = $account;
                        $writing->aux = $member;
                        $writing->operation = $operations[$key];
                        $writing->creditamt = trimOver($amounts[$key], ' ');
                        $writing->accdate = $accdate->accdate;
                        $writing->employee = $emp->iduser;
                        $writing->cash = $cash->idcash;
                        $writing->network = $emp->network;
                        $writing->zone = $emp->zone;
                        $writing->institution = $emp->institution;
                        $writing->branch = $emp->branch;
                        $writing->represent = $represent;
                        $writing->writ_type = 'I';
                        $writing->save();

                        $memBal = Balance::getMemAcc($member, $account);
                        $memBal->available += trimOver($amounts[$key], ' ');
                        $memBal->update((array)$memBal);

                        $oper = Operation::getOperation($operations[$key]);
                        if ($emp->lang === 'fr') {
                            Log::info($oper->labelfr);
                        } else {
                            Log::info($oper->labeleng);
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
                                $writing->aux = $member;
                                $writing->operation = $opera4->idoper;
                                $writing->creditamt = $pen;
                                $writing->accdate = $accdate->accdate;
                                $writing->employee = $emp->iduser;
                                $writing->cash = $cash->idcash;
                                $writing->network = $emp->network;
                                $writing->zone = $emp->zone;
                                $writing->institution = $emp->institution;
                                $writing->branch = $emp->branch;
                                $writing->represent = $represent;
                                $writing->writ_type = 'I';
                                $writing->save();

                                $penBal = Account::getAccount($loanType->penacc);
                                $penBal->available += $pen;
                                $penBal->update((array)$penBal);

                                if ($emp->lang === 'fr') {
                                    Log::info($opera4->labelfr);
                                } else {
                                    Log::info($opera4->labeleng);
                                }
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
                                    $writing->aux = $member;
                                    $writing->operation = $opera5->idoper;
                                    $writing->creditamt = $accr;
                                    $writing->accdate = $accdate->accdate;
                                    $writing->employee = $emp->iduser;
                                    $writing->cash = $cash->idcash;
                                    $writing->network = $emp->network;
                                    $writing->zone = $emp->zone;
                                    $writing->institution = $emp->institution;
                                    $writing->branch = $emp->branch;
                                    $writing->represent = $represent;
                                    $writing->writ_type = 'I';
                                    $writing->save();

                                    $accrBal = Account::getAccount($loanType->accracc);
                                    $accrBal->available += $accr;
                                    $accrBal->update((array)$accrBal);

                                    if ($emp->lang === 'fr') {
                                        Log::info($opera5->labelfr);
                                    } else {
                                        Log::info($opera5->labeleng);
                                    }
                                }

                                $reste2 = $reste - $accr;

                                if ($reste2 > 0) {
                                    /**
                                     * Interest Payment
                                     */
                                    $int = trimOver($ints[$key], ' ');
                                    if ((int)$int !== 0) {
                                        if ($int > $reste2) {
                                            $int = $reste2;
                                        }

                                        $writing = new Writing();
                                        $writing->writnumb = $writnumb;
                                        $writing->account = $loanType->intacc;
                                        $writing->aux = $member;
                                        $writing->operation = $opera3->idoper;
                                        $writing->creditamt = $int;
                                        $writing->accdate = $accdate->accdate;
                                        $writing->employee = $emp->iduser;
                                        $writing->cash = $cash->idcash;
                                        $writing->network = $emp->network;
                                        $writing->zone = $emp->zone;
                                        $writing->institution = $emp->institution;
                                        $writing->branch = $emp->branch;
                                        $writing->represent = $represent;
                                        $writing->writ_type = 'I';
                                        $writing->save();

                                        $intBal = Account::getAccount($loanType->intacc);
                                        $intBal->available += $int;
                                        $intBal->update((array)$intBal);

                                        if ($emp->lang === 'fr') {
                                            Log::info($opera3->labelfr);
                                        } else {
                                            Log::info($opera3->labeleng);
                                        }
                                    }
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
                            $writing->aux = $member;
                            $writing->account = $loanType->loanacc;
                            $writing->operation = $opera2->idoper;
                            $writing->creditamt = $loanAmt;
                            $writing->accdate = $accdate->accdate;
                            $writing->employee = $emp->iduser;
                            $writing->cash = $cash->idcash;
                            $writing->network = $emp->network;
                            $writing->zone = $emp->zone;
                            $writing->institution = $emp->institution;
                            $writing->branch = $emp->branch;
                            $writing->represent = $represent;
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
                            if ($memLoanAmt === (int)$memLoan->paidamt && (int)$memLoan->accramt === 0) {
                                $memLoan->loanstat = 'C';
                            }
                            $memLoan->update((array)$memLoan);

                            $loanBal = Account::getAccount($loanType->loanacc);
                            $loanBal->available += $loanAmt;
                            $loanBal->update((array)$loanBal);

                            if ($emp->lang === 'fr') {
                                Log::info($opera2->labelfr);
                            } else {
                                Log::info($opera2->labeleng);
                            }
                        }
                    }
                }

                if ($emp->lang === 'fr') {
                    Log::info($opera1->labelfr);
                } else {
                    Log::info($opera1->labeleng);
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
