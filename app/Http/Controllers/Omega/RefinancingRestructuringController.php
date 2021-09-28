<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\MemBalance;
use App\Models\Cash;
use App\Models\Comaker;
use App\Models\Employee;
use App\Models\Installment;
use App\Models\Loan;
use App\Models\LoanPur;
use App\Models\LoanType;
use App\Models\Member;
use App\Models\Mortgage;
use App\Models\Operation;
use App\Models\Priv_Menu;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class RefinancingRestructuringController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $members = Member::getMembers(['members.memstatus' => 'A']);
            $loans = Loan::getLoans(['loans.loanstat' => 'A']);
            $loan_types = LoanType::getLoanTypes();
            $loan_purs = LoanPur::getLoanPurs();
            $employees = Employee::getEmployees();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.refinancing_restructuring', compact('members', 'menu', 'loan_types', 'loan_purs', 'employees', 'loans'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        dd(Request::all());
        DB::beginTransaction();
        $emp = Session::get('employee');

        $idloan = Request::input('loan');
        $amount = trimOver(Request::input('amount'), ' ');
        $nbrinst = Request::input('numb_inst');
        $guarantee = Request::input('guarantee');

        $comakers = Request::input('coMakers');
        $comAccs = Request::input('coAccs');
        $comAmts = Request::input('coAmts');

        $mortNames = Request::input('mortNames');
        $mortNatures = Request::input('mortNatures');
        $mortAmts = Request::input('mortAmts');

        $nos = Request::input('nos');
        $capitals = Request::input('capitals');
        $amortAmts = Request::input('amortAmts');
        $intAmts = Request::input('intAmts');
        $annAmts = Request::input('annAmts');
        $taxAmts = Request::input('taxAmts');
        $totAmts = Request::input('totAmts');
        $dates = Request::input('dates');

        try {
            $loan = Loan::getLoan($idloan);
            $loanType = LoanType::getLoanType($loan->loantype);
            $cash = Cash::getMainCash();
            $accdate = AccDate::getOpenAccDate();
            $opera1 = Operation::getByCode(1);
            $opera2 = Operation::getByCode(54);
            $opera3 = Operation::getByCode(55);
            $opera4 = Operation::getByCode(56);
            $opera5 = Operation::getByCode(57);
            $opera6 = Operation::getByCode(59);
            $opera7 = Operation::getByCode(33);
            $opera8 = Operation::getByCode(58);
            $opera9 = Operation::getByCode(2);

            $loanAmt = (int)$loan->amount;
            if ((int)$loan->refamt > 0) {
                $loanAmt = (int)$loan->refamt;
            }
            $capital = $loanAmt - $loan->paidamt;

            $days = 0;
            $totPaid = 0;
            $diff = 0;

            $loanInstalls = Installment::getInstalls($idloan);
            foreach ($loanInstalls as $index => $loanInstall) {
                $date0 = new \DateTime($loan->instdate1);
                $date1 = new \DateTime($loan->lastdate);
                $date2 = new \DateTime($loanInstall->instdate);
                $date3 = new \DateTime("now");

                if (($date3 > $date0) && ($date2 <= $date3)) {
                    $totPaid += $loanInstall->amort;
                    $diff = $loan->paidamt - $totPaid;
                    if ($date1 <= $date2) {
                        if ($diff > 0) {
                            $days = $date2->diff($date3);
                        } else {
                            $days = $date3->diff($date2);
                        }
                    }

                }
            }

            $int = round(($capital * $loan->intrate) / 100);
            $pen = 0;

            if ($diff < 0) {
                $pen = round($capital * $days * ($loanType->pentax) / 1200);
            }

            $writnumb = getWritNumb();
            /**
             * Fake Cash In
             */
            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $cash->cashacc;
            $writing->operation = $opera1->idoper;
            $writing->debitamt = $capital + $pen + $loan->accramt + $int;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            /**
             * Penalty Payment
             */
            if ((int)$pen !== 0) {
                $writing = new Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $loanType->penacc;
                $writing->aux = $loan->member;
                $writing->operation = $opera4->idoper;
                $writing->creditamt = $pen;
                $writing->accdate = $accdate->idaccdate;
                $writing->employee = $emp->idemp;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->save();
            }

            /**
             * Accrued Payment
             */
            if ((int)$loan->accramt !== 0) {
                $writing = new Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $loanType->accracc;
                $writing->aux = $loan->member;
                $writing->operation = $opera5->idoper;
                $writing->creditamt = $loan->accramt;
                $writing->accdate = $accdate->idaccdate;
                $writing->employee = $emp->idemp;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->save();
            }

            /**
             * Interest Payment
             */
            if ((int)$int !== 0) {
                $writing = new Writing();
                $writing->writnumb = $writnumb;
                $writing->account = $loanType->intacc;
                $writing->aux = $loan->member;
                $writing->operation = $opera3->idoper;
                $writing->creditamt = $int;
                $writing->accdate = $accdate->idaccdate;
                $writing->employee = $emp->idemp;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->save();
            }

            /**
             * Reimbursement of Loan
             */
            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->aux = $loan->member;
            $writing->account = $loanType->loanacc;
            $writing->operation = $opera2->idoper;
            $writing->creditamt = $capital;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();


            $writnumb2 = getWritNumb();
            /**
             * Setting up Loan
             */
            $writing = new Writing();
            $writing->writnumb = $writnumb2;
            $writing->account = $loanType->loanacc;
            $writing->operation = $opera6->idoper;
            $writing->debitamt = $amount;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $writing = new Writing();
            $writing->writnumb = $writnumb2;
            $writing->account = $loanType->transacc;
            $writing->aux = $loan->member;
            $writing->operation = $opera7->idoper;
            $writing->creditamt = $amount;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $writnumb3 = getWritNumb();
            /**
             * Penalty Payment
             */
            if ((int)$pen !== 0) {
                $writing = new Writing();
                $writing->writnumb = $writnumb3;
                $writing->account = $loanType->penacc;
                $writing->aux = $loan->member;
                $writing->operation = $opera4->idoper;
                $writing->debitamt = $pen;
                $writing->accdate = $accdate->idaccdate;
                $writing->employee = $emp->idemp;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->save();
            }

            /**
             * Accrued Payment
             */
            if ((int)$loan->accramt !== 0) {
                $writing = new Writing();
                $writing->writnumb = $writnumb3;
                $writing->account = $loanType->accracc;
                $writing->aux = $loan->member;
                $writing->operation = $opera5->idoper;
                $writing->debitamt = $loan->accramt;
                $writing->accdate = $accdate->idaccdate;
                $writing->employee = $emp->idemp;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->save();
            }

            /**
             * Interest Payment
             */
            if ((int)$int !== 0) {
                $writing = new Writing();
                $writing->writnumb = $writnumb3;
                $writing->account = $loanType->intacc;
                $writing->aux = $loan->member;
                $writing->operation = $opera3->idoper;
                $writing->debitamt = $int;
                $writing->accdate = $accdate->idaccdate;
                $writing->employee = $emp->idemp;
                $writing->cash = $cash->idcash;
                $writing->network = $emp->network;
                $writing->zone = $emp->zone;
                $writing->institution = $emp->institution;
                $writing->branch = $emp->branch;
                $writing->save();
            }

            /**
             * Fixe Fake Loan Reimboursement
             */
            $writing = new Writing();
            $writing->writnumb = $writnumb3;
            $writing->aux = $loan->member;
            $writing->account = $loanType->transacc;
            $writing->operation = $opera8->idoper;
            $writing->debitamt = $capital;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            /**
             * Fixe Fake Loan Reimboursement
             */
            $writing = new Writing();
            $writing->writnumb = $writnumb3;
            $writing->account = $cash->cashacc;
            $writing->operation = $opera9->idoper;
            $writing->creditamt = $capital + $pen + $loan->accramt + $int;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $memBal = MemBalance::getMemAcc($loan->member, $loanType->transacc);
            $memBal->available += $amount - ($capital + $pen + $loan->accramt + $int);
            $memBal->update((array)$memBal);

            $loan->paidamt = 0;
            $loan->lastdate = Request::input('inst1');
            $loan->refamt = $amount;
            $loan->vat = Request::input('tax_rate');
            $loan->amortype = Request::input('amorti');
            $loan->periodicity = Request::input('period');
            $loan->grace = Request::input('grace');
            $loan->instdate1 = Request::input('inst1');
            $loan->guarantee = $guarantee;
            $loan->nbrinst = $nbrinst;
            $loan->intrate = Request::input('int_rate');
            ++$loan->isRef;

            if (($guarantee === 'F' || $guarantee === 'F&M') && isset($comakers)) {
                $loanComakers = Comaker::getComakers(['loan' => $idloan]);
                if ($loanComakers->count() < count($comakers)) {
                    foreach ($comakers as $key => $comaker) {
                        if (array_key_exists($key, (array)$loanComakers)) {
                            if (!empty($comAmts[$key]) && $comAmts[$key] !== null && $comAmts[$key] !== '0') {
                                $loanComakers[$key]->member = $comakers[$key];
                                $loanComakers[$key]->account = $comAccs[$key];
                                $loanComakers[$key]->guaramt = $comAmts[$key];
                                $loanComakers[$key]->paidguar = 0;
                                $loanComakers[$key]->update((array)$loanComakers[$key]);
                            }
                        } else if ($loanComakers->count() <= $key) {
                            if (!empty($comAmts[$key]) && $comAmts[$key] !== null && $comAmts[$key] !== '0') {
                                $comaker = new Comaker();
                                $comaker->loan = $idloan;
                                $comaker->member = $comakers[$key];
                                $comaker->account = $comAccs[$key];
                                $comaker->guaramt = $comAmts[$key];
                                $comaker->paidguar = 0;
                                $comaker->save();
                            }
                        }
                    }
                } else if ($loanComakers->count() > count($comakers)) {
                    foreach ($loanComakers as $key => $loanComaker) {
                        if (array_key_exists($key, $comakers)) {
                            if (!empty($comAmts[$key]) && $comAmts[$key] !== null && $comAmts[$key] !== '0') {
                                $loanComaker->member = $comakers[$key];
                                $loanComaker->account = $comAccs[$key];
                                $loanComaker->gauramt = $comAmts[$key];
                                $loanComaker->paidguar = 0;
                                $loanComaker->update((array)$loanComaker);
                            }
                        } else {
                            $loanComaker->delete();
                        }
                    }
                } else if ($loanComakers->count() === count($comakers)) {
                    foreach ($loanComakers as $key => $loanComaker) {
                        if (!empty($comAmts[$key]) && $comAmts[$key] !== null && $comAmts[$key] !== '0') {
                            $loanComaker->member = $comakers[$key];
                            $loanComaker->account = $comAccs[$key];
                            $loanComaker->guaramt = $comAmts[$key];
                            $loanComaker->paidguar = 0;
                            $loanComaker->update((array)$loanComaker);
                        }
                    }
                }
            }
            if (($guarantee === 'M' || $guarantee === 'F&M') && isset($mortNames)) {
                $loanMortgages = Mortgage::getMortgages($idloan);
                if ($loanMortgages->count() < count($mortNames)) {
                    $mortgno = 1;
                    foreach ($mortNames as $key => $mortName) {
                        if (array_key_exists($key, (array)$loanMortgages)) {
                            if (!empty($mortAmts[$key]) && $mortAmts[$key] !== null && $mortAmts[$key] !== '0') {
                                $loanMortgages[$key]->name = $mortName;
                                $loanMortgages[$key]->nature = $mortNatures[$key];
                                $loanMortgages[$key]->member = $loan->member;
                                $loanMortgages[$key]->amount = $mortAmts[$key];
                                $loanMortgages[$key]->update((array)$loanMortgages[$key]);
                            }
                        } else if ($loanMortgages->count() <= $key) {
                            if (!empty($mortAmts[$key]) && $mortAmts[$key] !== null && $mortAmts[$key] !== '0') {
                                $last = Mortgage::getLast($idloan);
                                $mortgage = new Mortgage();
                                if ($last !== null) {
                                    $mortgno = $last->mortgno + 1;
                                }
                                $mortgage->demmortgno = $mortgno;
                                $mortgage->name = $mortName;
                                $mortgage->nature = $mortNatures[$key];
                                $mortgage->member = $loan->member;
                                $mortgage->loan = $idloan;
                                $mortgage->amount = $mortAmts[$key];
                                $mortgage->save();
                            }
                        }
                    }
                } else if ($loanMortgages->count() > count($mortNames)) {
                    foreach ($loanMortgages as $key => $loanMortgage) {
                        if (array_key_exists($key, $mortNames)) {
                            if (!empty($mortAmts[$key]) && $mortAmts[$key] !== null && $mortAmts[$key] !== '0') {
                                $loanMortgage->name = $mortNames[$key];
                                $loanMortgage->nature = $mortNatures[$key];
                                $loanMortgage->member = $loan->member;
                                $loanMortgage->amount = $mortAmts[$key];
                                $loanMortgage->update((array)$loanMortgage);
                            }
                        } else {
                            $loanMortgage->delete();
                        }
                    }
                } else if ($loanMortgages->count() === count($mortNames)) {
                    foreach ($loanMortgages as $key => $loanMortgage) {
                        if (!empty($mortAmts[$key]) && $mortAmts[$key] !== null && $mortAmts[$key] !== '0') {
                            $loanMortgage->name = $mortNames[$key];
                            $loanMortgage->nature = $mortNatures[$key];
                            $loanMortgage->member = $loan->member;
                            $loanMortgage->amount = $mortAmts[$key];
                            $loanMortgage->update((array)$loanMortgage);
                        }
                    }
                }
            }
            
            $installs = Installment::getInstalls($idloan);
            if ($installs->count() < $nbrinst) {
                foreach ($nos as $key => $no) {
                    if (array_key_exists($key, (array)$installs)) {
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

            $loan->accramt = 0;
            $loan->update((array)$loan);

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.refsave'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.refsave'));
        }
    }
}
