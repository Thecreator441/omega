<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\Cash;
use App\Models\Comaker;
use App\Models\DemComaker;
use App\Models\DemLoan;
use App\Models\DemMortgage;
use App\Models\Employee;
use App\Models\Installment;
use App\Models\Loan;
use App\Models\LoanPur;
use App\Models\LoanType;
use App\Models\MemBalance;
use App\Models\Member;
use App\Models\Mortgage;
use App\Models\Operation;
use App\Models\Priv_Menu;
use App\Models\Writing;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class LoanApprovalController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $members = Member::getMembers(['members.memstatus' => 'A']);
            $dem_loans = DemLoan::getDemLoans(['dem_loans.status' => 'A']);
            $loan_types = LoanType::getLoanTypes();
            $loan_purs = LoanPur::getLoanPurs();
            $employees = Employee::getEmployees();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.loan_approval', compact('members', 'menu', 'loan_types', 'loan_purs', 'employees', 'dem_loans'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public static function store()
    {
        // dd(Request::all());
        try {
            DB::beginTransaction();

            if (!dateOpen()) {
                return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
            }

            $emp = Session::get('employee');

            $installs = Request::input('installs');
            $capitals = Request::input('capitals');
            $amo_amts = Request::input('amo_amts');
            $int_amts = Request::input('int_amts');
            $ann_amts = Request::input('ann_amts');
            $tax_amts = Request::input('tax_amts');
            $tot_amts = Request::input('tot_amts');
            $dates = Request::input('dates');

            $loan_no = 1;
            $last_loan = Loan::getLast();
            if ($last_loan !== null) {
                $loan_no = $last_loan->loanno + 1;
            }

            $dem_loan = DemLoan::getDemLoan(Request::input('dem_loan'));
            $loan_type = LoanType::getLoanType($dem_loan->loantype);
            $cash = null;
            $user_cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
            if ($user_cash !== null) {
                $cash = $user_cash->idcash;
            }
            
            $writnumb = getWritNumb();
            $accdate = AccDate::getOpenAccDate();

            $loan = new Loan();

            $loan->loanno = $loan_no;
            $loan->member = $dem_loan->member;
            $loan->memacc = $loan_type->trans_acc;
            $loan->employee = $dem_loan->employee;
            $loan->loantype = $dem_loan->loantype;
            $loan->loanpur = $dem_loan->loanpur;
            $loan->amount = (int)trimOver(Request::input('amount'), ' ');
            $loan->amortype = $dem_loan->amortype;
            $loan->grace = $dem_loan->grace;
            $loan->periodicity = $dem_loan->periodicity;
            $loan->intrate = $dem_loan->intrate;
            $loan->vat = $dem_loan->vat;
            $loan->nbrinst = $dem_loan->nbrinst;
            $loan->instdate1 = Request::input('inst1');
            $loan->guarantee = $dem_loan->guarantee;
            $loan->appdate = getsDate(now());
            $loan->demdate = getsDate($dem_loan->created_at);
            $loan->lastdate = $dem_loan->instdate1;
            if ($dem_loan->employee !== $emp->idemp) {
                $loan->isforce = 'Y';
                $loan->isforceby = $emp->idemp;
            }
            $loan->network = $emp->network;
            $loan->zone = $emp->zone;
            $loan->institution = $emp->institution;
            $loan->branch = $emp->branch;
            $loan->save();

            if ($dem_loan->guarantee === 'F' || $dem_loan->guarantee === 'F&M') {
                $dem_comakers = DemComaker::getDemComakers(['demloan' => Request::input('dem_loan')]);

                if ((int)$dem_comakers->count() > 0) {
                    foreach ($dem_comakers as $dem_comaker) {
                        $comaker = new Comaker();
                        $comaker->loan = $loan->idloan;
                        $comaker->member = $dem_comaker->member;
                        $comaker->account = $dem_comaker->account;
                        $comaker->guaramt = $dem_comaker->guaramt;
                        $comaker->save();

                        $dem_comaker->delete();
                    }
                }
            }

            if ($dem_loan->guarantee === 'M' || $dem_loan->guarantee === 'F&M') {
                $dem_mortgages = DemMortgage::getDemMortgages(['demloan' => Request::input('dem_loan')]);
                
                if ($dem_mortgages->count() !== 0) {
                    foreach ($dem_mortgages as $dem_mortgage) {
                        $mortg_no = 1;
                        $last_mortgage = Mortgage::getLast($loan->idloan);
                        $mortgage = new Mortgage();
                        if ($last_mortgage !== null) {
                            $mortg_no = $last_mortgage->mortgno + 1;
                        }

                        $mortgage->mortno = $mortg_no;
                        $mortgage->name = $dem_mortgage->name;
                        $mortgage->nature = $dem_mortgage->nature;
                        $mortgage->member = $dem_mortgage->member;
                        $mortgage->loan = $loan->idloan;
                        $mortgage->amount = $dem_mortgage->amount;
                        $mortgage->save();

                        $dem_mortgage->delete();
                    }
                }
            }

            if ((int)count($installs) > 0) {
                foreach ($installs as $key => $install) {
                    $installment = new Installment();

                    $installment->loan = $loan->idloan;
                    $installment->installno = $install;
                    $installment->capital = (int)trimOver($capitals[$key], ' ');
                    $installment->amort = (int)trimOver($amo_amts[$key], ' ');
                    $installment->interest = (int)trimOver($int_amts[$key], ' ');
                    $installment->annuity = (int)trimOver($ann_amts[$key], ' ');
                    $installment->tax = (int)trimOver($tax_amts[$key], ' ');
                    $installment->total = (int)trimOver($tot_amts[$key], ' ');
                    $installment->instdate = dbDate($dates[$key]);
                    // $installment->instdate = getsDate(str_replace('/', '-', $dates[$key]));
                    $installment->save();
                }
            }

            /**
             * Setting up Loan
             */
            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $loan_type->loanacc;
            $writing->operation = Request::input('menu_level_operation');
            $writing->debitamt = (int)trimOver(Request::input('amount'), ' ');
            $writing->accdate = $accdate->accdate;
            $writing->employee = $emp->iduser;
            $writing->cash = $cash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $loan_type->trans_acc;
            $writing->mem_aux = $dem_loan->member;
            $writing->operation = Request::input('menu_level_operation');
            $writing->creditamt = (int)trimOver(Request::input('amount'), ' ');
            $writing->accdate = $accdate->accdate;
            $writing->employee = $emp->iduser;
            $writing->cash = $cash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $memBal = MemBalance::getMemAcc($dem_loan->member, $loan_type->trans_acc);
            if ($memBal !== null) {
                $memBal->available += (int)trimOver(Request::input('amount'), ' ');
                $memBal->update((array)$memBal);
            } else {
                $balance = new MemBalance();
                $balance->member = $dem_loan->member;
                $balance->account = $loan_type->trans_acc;
                // $balance->operation = $opera2->idoper;
                $balance->available = (int)trimOver(Request::input('amount'), ' ');
                $balance->save();
            }

            $dem_loan->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.loan_approval_save'));
        } catch (Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.loan_approval_save'));
        }
    }
}
