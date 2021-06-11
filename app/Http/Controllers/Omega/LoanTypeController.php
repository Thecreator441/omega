<?php

namespace App\Http\Controllers\Omega;

use App\Models\Account;
use App\Models\AccPlan;
use App\Models\LoanType;
use App\Models\Priv_Menu;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class LoanTypeController extends Controller
{

    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $loan_types = LoanType::getLoanTypes();
            $accplans = AccPlan::getAccPlans();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.loantype', compact('menu', 'loan_types', 'accplans'));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    public function store()
    {
        // dd(Request::all());
        DB::beginTransaction();
        $emp = Session::get('employee');

        $idloan_type = Request::input('idloan_type');

        try {
            $loan_type = null;

            if ($idloan_type === null) {
                $loan_type = new LoanType();
            } else {
                $loan_type = LoanType::getLoanType($idloan_type);
            }

            $loan_type->loan_type_code = Request::input('loan_type_code');
            $loan_type->labelfr = Request::input('labelfr');
            $loan_type->labeleng = Request::input('labeleng');
            $loan_type->loan_per = Request::input('loan_per');
            $loan_type->max_dur = Request::input('max_dur');
            $loan_type->max_amt = trimOver(Request::input('max_amt'), ' ');
            $loan_type->inst_pen_day_space = trimOver(Request::input('inst_pen_day_space'), ' ');

            $intPaidAcc_Plan = AccPlan::getAccPlan(Request::input('int_paid_acc'));
            $intPaidAcc_Numb = pad($intPaidAcc_Plan->plan_code, 9, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);
            $intPaidAcc = Account::getAccountBy(['accnumb' => $intPaidAcc_Numb]);
            if ($intPaidAcc === null) {
                $intPaidAcc = new Account();

                $intPaidAcc->idplan = $intPaidAcc_Plan->idaccplan;
                $intPaidAcc->accnumb = $intPaidAcc_Numb;
                $intPaidAcc->labelfr = $intPaidAcc_Plan->labelfr;
                $intPaidAcc->labeleng = $intPaidAcc_Plan->labeleng;
                $intPaidAcc->class = $intPaidAcc_Plan->class;
                $intPaidAcc->acctype = $intPaidAcc_Plan->acc_type;
                $intPaidAcc->network = $emp->network;
                $intPaidAcc->zone = $emp->zone;
                $intPaidAcc->institution = $emp->institution;
                $intPaidAcc->branch = $emp->branch;

                $intPaidAcc->save();
            }
            $loan_type->int_paid_acc = $intPaidAcc->idaccount;

            $loanAcc_Plan = AccPlan::getAccPlan(Request::input('loan_acc'));
            $loanAcc_Numb = pad($loanAcc_Plan->plan_code, 6, 'right') . '' . pad(Request::input('loan_type_code'), 3, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);
            $loanAcc = Account::getAccountBy(['accnumb' => $loanAcc_Numb]);
            if ($loanAcc === null) {
                $loanAcc = new Account();

                $loanAcc->idplan = $loanAcc_Plan->idaccplan;
                $loanAcc->accnumb = $loanAcc_Numb;
                $loanAcc->labelfr = Request::input('labelfr');
                $loanAcc->labeleng = Request::input('labeleng');
                $loanAcc->class = $loanAcc_Plan->class;
                $loanAcc->acctype = $loanAcc_Plan->acc_type;
                $loanAcc->network = $emp->network;
                $loanAcc->zone = $emp->zone;
                $loanAcc->institution = $emp->institution;
                $loanAcc->branch = $emp->branch;

                $loanAcc->save();
            }
            $loan_type->loan_acc = $loanAcc->idaccount;

            $loan_type->seicomaker = Request::input('seicomaker');
            $loan_type->block_acc = Request::input('block_acc');

            if ((int)Request::input('pay_tax_rate') > 0 AND Request::input('pay_tax_acc') !== null) {
                $loan_type->pay_tax_rate = trimOver(Request::input('pay_tax_rate'), ' ');

                $pay_taxAcc_Plan = AccPlan::getAccPlan(Request::input('pay_tax_acc'));
                $pay_taxAcc_Numb = pad($pay_taxAcc_Plan->plan_code, 9, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);
                $pay_taxAcc = Account::getAccountBy(['accnumb' => $pay_taxAcc_Numb]);
                if ($pay_taxAcc === null) {
                    $pay_taxAcc = new Account();

                    $pay_taxAcc->idplan = $pay_taxAcc_Plan->idaccplan;
                    $pay_taxAcc->accnumb = $pay_taxAcc_Numb;
                    $pay_taxAcc->labelfr = $pay_taxAcc_Plan->labelfr;
                    $pay_taxAcc->labeleng = $pay_taxAcc_Plan->labeleng;
                    $pay_taxAcc->class = $pay_taxAcc_Plan->class;
                    $pay_taxAcc->acctype = $pay_taxAcc_Plan->acc_type;
                    $pay_taxAcc->network = $emp->network;
                    $pay_taxAcc->zone = $emp->zone;
                    $pay_taxAcc->institution = $emp->institution;
                    $pay_taxAcc->branch = $emp->branch;

                    $pay_taxAcc->save();
                }
                $loan_type->pay_tax_acc = $pay_taxAcc->idaccount;
            }

            if ((int)Request::input('use_quod_rate') > 0 AND Request::input('use_quod_acc') !== null) {
                $loan_type->use_quod_rate = trimOver(Request::input('use_quod_rate'), ' ');

                $use_quotAcc_Plan = AccPlan::getAccPlan(Request::input('use_quot_acc'));
                $use_quotAcc_Numb = pad($use_quotAcc_Plan->plan_code, 6, 'right') . '' . pad(Request::input('loan_code'), 3, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);
                $use_quotAcc = Account::getAccountBy(['accnumb' => $use_quotAcc_Numb]);
                if ($use_quotAcc === null) {
                    $use_quotAcc = new Account();

                    $use_quotAcc->idplan = $use_quotAcc_Plan->idaccplan;
                    $use_quotAcc->accnumb = $use_quotAcc_Numb;
                    $use_quotAcc->labelfr = $use_quotAcc_Plan->labelfr;
                    $use_quotAcc->labeleng = $use_quotAcc_Plan->labeleng;
                    $use_quotAcc->class = $use_quotAcc_Plan->class;
                    $use_quotAcc->acctype = $use_quotAcc_Plan->acc_type;
                    $use_quotAcc->network = $emp->network;
                    $use_quotAcc->zone = $emp->zone;
                    $use_quotAcc->institution = $emp->institution;
                    $use_quotAcc->branch = $emp->branch;

                    $use_quotAcc->save();
                }
                $loan_type->use_quot_acc = $use_quotAcc->idaccount;
            }

            if ((int)Request::input('pen_req_tax') > 0 AND Request::input('pen_req_acc') !== null) {
                $loan_type->pen_req_tax = trimOver(Request::input('pen_req_tax'), ' ');

                $pen_reqAcc_Plan = AccPlan::getAccPlan(Request::input('pen_req_acc'));
                $pen_reqAcc_Numb = pad($pen_reqAcc_Plan->plan_code, 9, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);
                $pen_reqAcc = Account::getAccountBy(['accnumb' => $pen_reqAcc_Numb]);
                if ($pen_reqAcc === null) {
                    $pen_reqAcc = new Account();

                    $pen_reqAcc->idplan = $pen_reqAcc_Plan->idaccplan;
                    $pen_reqAcc->accnumb = $pen_reqAcc_Numb;
                    $pen_reqAcc->labelfr = $pen_reqAcc_Plan->labelfr;
                    $pen_reqAcc->labeleng = $pen_reqAcc_Plan->labeleng;
                    $pen_reqAcc->class = $pen_reqAcc_Plan->class;
                    $pen_reqAcc->acctype = $pen_reqAcc_Plan->acc_type;
                    $pen_reqAcc->network = $emp->network;
                    $pen_reqAcc->zone = $emp->zone;
                    $pen_reqAcc->institution = $emp->institution;
                    $pen_reqAcc->branch = $emp->branch;

                    $pen_reqAcc->save();
                }
                $loan_type->pen_req_acc = $pen_reqAcc->idaccount;
            }

            $loan_type->network = $emp->network;
            $loan_type->zone = $emp->zone;
            $loan_type->institution = $emp->institution;
            $loan_type->branch = $emp->branch;

            if ($idloan_type === null) {
                $loan_type->save();
            } else {
                $loan_type->update((array)$loan_type);
            }

            DB::commit();
            if ($idloan_type === null) {
                return Redirect::route('omega')->with('success', trans('alertSuccess.loan_type_save'));
            }
            return Redirect::route('omega')->with('success', trans('alertSuccess.loan_type_edit'));
        } catch (\Exception $exception) {
            dd($exception);
            DB::rollBack();
            if ($idloan_type === null) {
                return Redirect::back()->with('danger', trans('alertDanger.loan_type_save'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.loan_type_edit'));
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            LoanType::getLoanType(Request::input('idloan_type'))->delete();

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.loan_type_delete'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.loan_type_delete'));
        }
    }
}
