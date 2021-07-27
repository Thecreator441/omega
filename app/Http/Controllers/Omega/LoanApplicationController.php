<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\DemComaker;
use App\Models\DemLoan;
use App\Models\DemMortgage;
use App\Models\Employee;
use App\Models\LoanMan;
use App\Models\LoanPur;
use App\Models\LoanType;
use App\Models\Member;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class LoanApplicationController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $members = Member::getMembers(['members.memstatus' => 'A']);
            $loan_types = LoanType::getLoanTypes();
            $loan_purs = LoanPur::getLoanPurs();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.loan_application', compact('members', 'menu', 'loan_types', 'loan_purs'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public static function store()
    {
        // dd(Request::all());
        try {
            DB::beginTransaction();
            $emp = Session::get('employee');

            $loanno = 1;
            $guarantee = Request::input('guarantee');
            $member = Request::input('member');
            $comakers = Request::input('coMakers');
            $accounts = Request::input('coAccs');
            $amounts = Request::input('coAmts');
            $mortNames = Request::input('mortNames');
            $mortNatures = Request::input('mortNatures');
            $mortAmts = Request::input('mortAmts');

            $loan = DemLoan::getLast();
            if ($loan !== null) {
                $loanno = $loan->demloanno + 1;
            }
            $loanMan = LoanMan::getLoanMan((int)$member);

            $demLoan = new DemLoan();
            $demLoan->demloanno = $loanno;
            $demLoan->member = $member;
            $demLoan->amount = trimOver(Request::input('totrans'), ' ');
            $demLoan->loantype = Request::input('loanty');
            $demLoan->loanpur = Request::input('loanpur');
            $demLoan->vat = Request::input('tax_rate');
            $demLoan->amortype = Request::input('amorti');
            $demLoan->periodicity = Request::input('period');
            $demLoan->grace = Request::input('grace');
            $demLoan->instdate1 = Request::input('inst1');
            $demLoan->nbrinst = Request::input('numb_inst');
            $demLoan->intrate = Request::input('int_rate');
            $demLoan->guarantee = $guarantee;
            if ($loanMan->employee === $emp->idemp) {
                $demLoan->employee = $emp->idemp;
            } else {
                $demLoan->employee = $loanMan->employee;
                $demLoan->isforce = 'Y';
                $demLoan->isforceby = $emp->idemp;
            }
            $demLoan->institution = $emp->institution;
            $demLoan->branch = $emp->branch;
            $demLoan->save();

            if (($guarantee === 'F') && isset($comakers)) {
                foreach ($comakers as $key => $demComaker) {
                    if (!empty($amounts[$key]) || $amounts[$key] !== null) {
                        $demComaker = new DemComaker();
                        $demComaker->demloan = $demLoan->iddemloan;
                        $demComaker->member = $comakers[$key];
                        $demComaker->account = $accounts[$key];
                        $demComaker->guaramt = $amounts[$key];
                        $demComaker->save();
                    }
                }
            }
            if (($guarantee === 'M') && isset($mortNames)) {
                $demmortgno = 1;
                foreach ($mortNames as $key => $morgName) {
                    if (!empty($mortAmts[$key]) || $mortAmts[$key] !== null) {
                        $last = DemMortgage::getLast($demLoan->iddemloan);
                        $demMorg = new DemMortgage();
                        if ($last !== null) {
                            $demmortgno = $last->demmortgno + 1;
                        }
                        $demMorg->demmortgno = $demmortgno;
                        $demMorg->name = $morgName;
                        $demMorg->nature = $mortNatures[$key];
                        $demMorg->member = $member;
                        $demMorg->loan = $demLoan->iddemloan;
                        $demMorg->amount = $mortAmts[$key];
                        $demMorg->save();
                    }
                }
            }
            if ($guarantee === 'F&M') {
                if (isset($comakers)) {
                    foreach ($comakers as $key => $demComaker) {
                        if (!empty($amounts[$key]) || $amounts[$key] !== null) {
                            $demComaker = new DemComaker();
                            $demComaker->demloan = $demLoan->iddemloan;
                            $demComaker->member = $comakers[$key];
                            $demComaker->account = $accounts[$key];
                            $demComaker->guaramt = $amounts[$key];
                            $demComaker->save();
                        }
                    }
                }
                if (isset($mortNames)) {
                    $demmortgno = 1;
                    foreach ($mortNames as $key => $morgName) {
                        if (!empty($mortAmts[$key]) || $mortAmts[$key] !== null) {
                            $last = DemMortgage::getLast($demLoan->iddemloan);
                            $demMorg = new DemMortgage();
                            if ($last !== null) {
                                $demmortgno = $last->demmortgno + 1;
                            }
                            $demMorg->demmortgno = $demmortgno;
                            $demMorg->name = $morgName;
                            $demMorg->nature = $mortNatures[$key];
                            $demMorg->member = $member;
                            $demMorg->loan = $demLoan->iddemloan;
                            $demMorg->amount = $mortAmts[$key];
                            $demMorg->save();
                        }
                    }
                }
            }

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.lappsave'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.lappsave'));
        }
    }
}
