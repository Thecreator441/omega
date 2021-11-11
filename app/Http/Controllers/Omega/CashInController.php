<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\MemBalance;
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
use App\Models\Priv_Menu;
use App\Models\ReceiptPrint;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use PDF;

class CashInController extends Controller
{
    public function index()
    {
        $emp = Session::get('employee');
        $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
        $members = Member::getMembers(['members.memstatus' => 'A']);
        $moneys = Money::getMoneys();
        $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

        return view('omega.pages.cash_in', compact('menu', 'members', 'cash', 'moneys'));
    }

    public function store()
    {
        // dd(Request::all());
        try {
            DB::beginTransaction();

            $emp = Session::get('employee');
            
            $writnumb = getWritNumb();
            $accdate = AccDate::getOpenAccDate();
            $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
            $operation = Operation::getOperation(Request::input('menu_level_operation'));
            $member = Member::getMember(Request::input('member'));

            $opera1 = Operation::getByCode(48);
            $opera2 = Operation::getByCode(49);
            $opera3 = Operation::getByCode(50);
            $opera4 = Operation::getByCode(51);

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

            $cash->mon1 += (int)trimOver(Request::input('B1'), ' ');
            $cash->mon2 += (int)trimOver(Request::input('B2'), ' ');
            $cash->mon3 += (int)trimOver(Request::input('B3'), ' ');
            $cash->mon4 += (int)trimOver(Request::input('B4'), ' ');
            $cash->mon5 += (int)trimOver(Request::input('B5'), ' ');
            $cash->mon6 += (int)trimOver(Request::input('P1'), ' ');
            $cash->mon7 += (int)trimOver(Request::input('P2'), ' ');
            $cash->mon8 += (int)trimOver(Request::input('P3'), ' ');
            $cash->mon9 += (int)trimOver(Request::input('P4'), ' ');
            $cash->mon10 += (int)trimOver(Request::input('P5'), ' ');
            $cash->mon11 += (int)trimOver(Request::input('P6'), ' ');
            $cash->mon12 += (int)trimOver(Request::input('P7'), ' ');
            $cash->update((array)$cash);

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $cash->cashacc;
            $writing->operation = Request::input('menu_level_operation');
            $writing->debitamt = (int)trimOver(Request::input('totrans'), ' ');
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
            $cashBal->available += (int)trimOver(Request::input('totrans'), ' ');
            $cashBal->update((array)$cashBal);

            $accs = [];
            foreach ($accounts as $key => $account) {
                $amount = (int)trimOver($amounts[$key], ' ');

                if ($amount > 0) {
                    $writing = new Writing();
                    $writing->writnumb = $writnumb;
                    $writing->account = $account;
                    $writing->mem_aux = Request::input('member');
                    $writing->operation = $operations[$key];
                    $writing->creditamt = $amount;
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

                    $memBal = MemBalance::getMemAcc(Request::input('member'), $account);
                    $memBal->available += $amount;
                    $memBal->update((array)$memBal);

                    $oper = Operation::getOperation($operations[$key]);
                    if ($emp->lang === 'fr') {
                        Log::info($oper->labelfr);
                    } else {
                        Log::info($oper->labeleng);
                    }

                    $acc = [];

                    $acc['amount'] = (int)trimOver($amounts[$key], ' ');
                    $accBal = MemBalance::getMemAcc(Request::input('member'), $account);
                    $acc['balance'] = (int)$accBal->available;

                    $accInfo = Account::getAccount($account);
                    $acc['accnumb'] = $accInfo->accnumb;
                    $acc['entitle'] = $operation->labeleng . ' ' . $accInfo->labeleng;
                    if ($emp->lang === 'fr') {
                        $acc['entitle'] = $operation->labelfr . ' ' . $accInfo->labelfr;
                    }

                    $accs[] = $acc;
                }
            }

            if (isset($loans)) {
                foreach ($loans as $key => $loan) {
                    $memLoan = Loan::getCashInLoan($loan);
                    $loanType = LoanType::getLoanType($memLoan->loantype);
                    
                    $memLoanAmt = (int)$memLoan->amount;
                    if ((int)$memLoan->refamt > 0) {
                        $memLoanAmt = (int)$memLoan->refamt;
                    }

                    $totints = (int)trimOver($totints[$key], ' ');
                    $intAmt = (int)trimOver($intamts[$key], ' ');
                    if ($intAmt > 0) {
                        /**
                         * Penalty Payment
                         */
                        $pen = (int)trimOver($pens[$key], ' ');
                        if ((int)$pen > 0) {
                            if ($pen > $intAmt) {
                                $pen = $intAmt;
                            }

                            $writing = new Writing();
                            $writing->writnumb = $writnumb;
                            $writing->account = $loanType->pen_req_acc;
                            $writing->mem_aux = Request::input('member');
                            $writing->operation = $opera3->idoper;
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

                            $penBal = Account::getAccount($loanType->pen_req_acc);
                            $penBal->available += $pen;
                            $penBal->update((array)$penBal);

                            if ($emp->lang === 'fr') {
                                Log::info($opera3->labelfr);
                            } else {
                                Log::info($opera3->labeleng);
                            }

                            $acc = [];

                            $acc['amount'] = (int)$pen;
                            $accInfo = Account::getAccount($loanType->pen_req_acc);
                            $acc['balance'] = 0;
                            $acc['accnumb'] = $accInfo->accnumb;
                            $acc['entitle'] = $operation->labeleng . ' ' . $opera3->labeleng;
                            if ($emp->lang === 'fr') {
                                $acc['entitle'] = $operation->labelfr . ' ' . $opera3->labelfr;
                            }

                            $accs[] = $acc;
                        }

                        $reste = $intAmt - $pen;

                        if ($reste > 0) {
                            /**
                             * Accrued Payment
                             */
                            $accr = (int)trimOver($accrs[$key], ' ');
                            if ((int)$accr > 0) {
                                if ($accr > $reste) {
                                    $accr = $reste;
                                }

                                $writing = new Writing();
                                $writing->writnumb = $writnumb;
                                $writing->account = $loanType->accr_paid_acc;
                                $writing->mem_aux = Request::input('member');
                                $writing->operation = $opera4->idoper;
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

                                $accrBal = Account::getAccount($loanType->accr_paid_acc);
                                $accrBal->available += $accr;
                                $accrBal->update((array)$accrBal);

                                if ($emp->lang === 'fr') {
                                    Log::info($opera4->labelfr);
                                } else {
                                    Log::info($opera4->labeleng);
                                }

                                $acc = [];

                                $acc['amount'] = (int)$accr;
                                $accInfo = Account::getAccount($loanType->accr_paid_acc);
                                $acc['balance'] = 0;
                                $acc['accnumb'] = $accInfo->accnumb;
                                $acc['entitle'] = $operation->labeleng . ' ' . $opera4->labeleng;
                                if ($emp->lang === 'fr') {
                                    $acc['entitle'] = $operation->labelfr . ' ' . $opera4->labelfr;
                                }

                                $accs[] = $acc;
                            }

                            $reste2 = $reste - $accr;

                            if ($reste2 > 0) {
                                /**
                                 * Interest Payment
                                 */
                                $int = (int)trimOver($ints[$key], ' ');
                                if ((int)$int > 0) {
                                    if ($int > $reste2) {
                                        $int = $reste2;
                                    }

                                    $writing = new Writing();
                                    $writing->writnumb = $writnumb;
                                    $writing->account = $loanType->int_paid_acc;
                                    $writing->mem_aux = Request::input('member');
                                    $writing->operation = $opera2->idoper;
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

                                    $intBal = Account::getAccount($loanType->int_paid_acc);
                                    $intBal->available += $int;
                                    $intBal->update((array)$intBal);

                                    if ($emp->lang === 'fr') {
                                        Log::info($opera2->labelfr);
                                    } else {
                                        Log::info($opera2->labeleng);
                                    }

                                    $acc = [];

                                    $acc['amount'] = (int)$int;
                                    $accInfo = Account::getAccount($loanType->int_paid_acc);
                                    $acc['balance'] = 0;
                                    $acc['accnumb'] = $accInfo->accnumb;
                                    $acc['entitle'] = $operation->labeleng . ' ' . $opera2->labeleng;
                                    if ($emp->lang === 'fr') {
                                        $acc['entitle'] = $operation->labelfr . ' ' . $opera2->labelfr;
                                    }

                                    $accs[] = $acc;
                                }
                            }
                        }
                        if ($totints >= $intAmt) {
                            $memLoan->accramt = $totints - $intAmt;
                        }
                    } else {
                        $memLoan->accramt = $totints;
                    }

                    $loanAmt = (int)trimOver($loanamts[$key], ' ');
                    if ($loanAmt > 0) {
                        /**
                         * Reimbursement of Loan
                         */
                        $writing = new Writing();
                        $writing->writnumb = $writnumb;
                        $writing->mem_aux = Request::input('member');
                        $writing->account = $loanType->loan_acc;
                        $writing->operation = $opera1->idoper;
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

                        if ($memLoan->guarantee === 'F' || $memLoan->guarantee === 'F&M') {
                            $comakers = Comaker::getComakers(['loan' => $memLoan->idloan]);

                            if ((int)$comakers->count() > 0) {
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
                        }
                        
                        if ($memLoan->guarantee === 'M' || $memLoan->guarantee === 'F&M') {
                            $mortgages = Mortgage::getMortgages(['loan' => $memLoan->idloan]);

                            if ((int)$mortgages->count() > 0) {
                                /*
                                    $mortgagesSum = Mortgage::getMortgagesSum(['loan' => $memLoan->idloan]);
                                    $mortgagesPaidSum = Mortgage::getMortgagesPaidSum(['loan' => $memLoan->idloan]);
                                    if ((int)$mortgagesPaidSum !== 0) {
                                        $mortgagesSum -= $mortgagesPaidSum;
                                    }

                                    if ($mortgagesSum <= $loanAmt) {
                                        foreach ($mortgages as $mortgage) {
                                            $mortgage->paidmort = $mortgage->amount;
                                            $mortgage->status = 'C';
                                            $mortgage->update((array)$mortgage);
                                        }
                                    } else {
                                        foreach ($comakers as $mortgage) {
                                            $comAmt = (int)$mortgage->guaramt;
                                            if ((int)$mortgage->paidguar !== 0) {
                                                $comAmt = (int)$mortgage->paidguar;
                                            }

                                            $reste = $comAmt;
                                            if ($comAmt < $loanAmt) {
                                                $mortgage->paidguar = $comAmt;
                                                $mortgage->status = 'C';
                                                $loanAmt -= $comAmt;
                                            } else {
                                                $mortgage->paidguar += $loanAmt;
                                            }
                                            $mortgage->update((array)$mortgage);
                                        }
                                    }
                                */

                                $memPaidLoan = $memLoan->paidamt + $loanAmt;
                                if ($memLoanAmt === (int)$memPaidLoan) {
                                    foreach ($mortgages as $mortgage) {
                                        $mortgage->status = 'C';
                                        $mortgage->update((array)$mortgage);
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

                        $loanBal = Account::getAccount($loanType->loan_acc);
                        $loanBal->available += $loanAmt;
                        $loanBal->update((array)$loanBal);

                        if ($emp->lang === 'fr') {
                            Log::info($opera1->labelfr);
                        } else {
                            Log::info($opera1->labeleng);
                        }

                        $acc = [];

                        $acc['amount'] = (int)$loanAmt;
                        $accInfo = Account::getAccount($loanType->loan_acc);
                        $acc['balance'] = 0;
                        $acc['accnumb'] = $accInfo->accnumb;
                        $acc['entitle'] = $operation->labeleng . ' ' . $opera1->labeleng;
                        if ($emp->lang === 'fr') {
                            $acc['entitle'] = $operation->labelfr . ' ' . $opera1->labelfr;
                        }

                        $accs[] = $acc;
                    }
                }
            }

            /***************************
             ******** PRINTING ********
            ***************************/
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));
            $moneys = Money::getMoneys();

            $userCash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
            $userCash->mon1 = (int)trimOver(Request::input('B1'), ' ');
            $userCash->mon2 = (int)trimOver(Request::input('B2'), ' ');
            $userCash->mon3 = (int)trimOver(Request::input('B3'), ' ');
            $userCash->mon4 = (int)trimOver(Request::input('B4'), ' ');
            $userCash->mon5 = (int)trimOver(Request::input('B5'), ' ');
            $userCash->mon6 = (int)trimOver(Request::input('P1'), ' ');
            $userCash->mon7 = (int)trimOver(Request::input('P2'), ' ');
            $userCash->mon8 = (int)trimOver(Request::input('P3'), ' ');
            $userCash->mon9 = (int)trimOver(Request::input('P4'), ' ');
            $userCash->mon10 = (int)trimOver(Request::input('P5'), ' ');
            $userCash->mon11 = (int)trimOver(Request::input('P6'), ' ');
            $userCash->mon12 = (int)trimOver(Request::input('P7'), ' ');
            $userCash->total = (int)trimOver(Request::input('totrans'), ' ');
            $userCash->totalWord = Request::input('totalWord');
            $userCash->writnumb = formWriting($accdate->accdate, $emp->network, $emp->zone, $emp->institution, $emp->branch, $writnumb);

            $date = date("d.m.Y");
            $time = date("H.i.s");
            
            $file_name = formWriting($accdate->accdate, $emp->network, $emp->zone, $emp->institution, $emp->branch, $writnumb) . "_{$date}_{$time}.pdf";

            $file = "storage/files/printings/" . $file_name;
            $pdf = PDF::loadView('omega.printings.cash_in', compact('accs', 'menu', 'moneys', 'userCash', 'member'))->setPaper([0, 0, 595.276, 420.94488], 'portrait');

            if($pdf->save($file)) {
                $print = new ReceiptPrint();

                $print->print_no = 1;
                $print->path = $file;
                $print->file_name = $file_name;
                $print->user = $emp->iduser;
                $print->network = $emp->network;
                $print->zone = $emp->zone;
                $print->institution = $emp->institution;
                $print->branch = $emp->branch;
                $print->operation = Request::input('menu_level_operation');
                $print->member = Request::input('member');

                $print->save();
            }

            $opera = null;
            if ($emp->lang === 'fr') {
                $opera = $operation->labelfr;
            } else {
                $opera = $operation->labeleng;
            }
            Log::info($opera);

            Session::flash('cash_in', $file);
            Session::put('operation', $opera);

            DB::commit();

            return Redirect::back()->with('success', trans('alertSuccess.cash_in'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.cash_in'));
        }
    }
}
