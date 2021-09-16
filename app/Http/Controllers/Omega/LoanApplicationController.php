<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\DemComaker;
use App\Models\DemLoan;
use App\Models\DemMortgage;
use App\Models\Employee;
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
            $employees = Employee::getEmployees();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.loan_application', compact('members', 'menu', 'loan_types', 'loan_purs', 'employees'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public static function store()
    {
        // dd(Request::all());
        try {
            DB::beginTransaction();

            if(!dateOpen()) {
                return Redirect::back()->with('danger', trans('alertDanger.opdate'));
            }

            $emp = Session::get('employee');
            $guarantee = Request::input('guarantee');

            $dem_loan_no = 1;
            $last_dem_loan = DemLoan::getLast();
            if ($last_dem_loan !== null) {
                $dem_loan_no = $last_dem_loan->demloanno + 1;
            }

            $dem_loan = new DemLoan();

            $dem_loan->demloanno = $dem_loan_no;
            $dem_loan->member = Request::input('member');
            $dem_loan->employee = Request::input('employee');
            $dem_loan->loantype = Request::input('loan_type');
            $dem_loan->loanpur = Request::input('loan_pur');
            $dem_loan->amount = trimOver(Request::input('totrans'), ' ');
            $dem_loan->amortype = Request::input('amorti');
            $dem_loan->grace = Request::input('grace');
            $dem_loan->periodicity = Request::input('period');
            $dem_loan->intrate = Request::input('int_rate');
            $dem_loan->vat = Request::input('tax_rate');
            $dem_loan->nbrinst = Request::input('numb_inst');
            $dem_loan->instdate1 = Request::input('inst1');
            $dem_loan->guarantee = $guarantee;
            $dem_loan->network = $emp->network;
            $dem_loan->zone = $emp->zone;
            $dem_loan->institution = $emp->institution;
            $dem_loan->branch = $emp->branch;
            $dem_loan->save();

            if ($guarantee === 'F' || $guarantee === 'F&M') {
                $comakers = Request::input('comakers');
                $comake_accs = Request::input('comake_accs');
                $comake_amounts = Request::input('comake_amounts');

                if (isset($comakers) && (int)count($comakers) > 0) {
                    foreach ($comakers as $key => $dem_comaker) {
                        $comake_amount = (int)$comake_amounts[$key];
                        
                        if ($comake_amount > 0) {
                            $dem_comaker = new DemComaker();
                            $dem_comaker->demloan = $dem_loan->iddemloan;
                            $dem_comaker->member = $comakers[$key];
                            $dem_comaker->account = $comake_accs[$key];
                            $dem_comaker->guaramt = $comake_amount;
                            $dem_comaker->network = $emp->network;
                            $dem_comaker->zone = $emp->zone;
                            $dem_comaker->institution = $emp->institution;
                            $dem_comaker->branch = $emp->branch;

                            $dem_comaker->save();
                        }
                    }
                }
            }

            if ($guarantee === 'M' || $guarantee === 'F&M') {
                $mort_names = Request::input('mort_names');
                $mort_natures = Request::input('mort_natures');
                $mort_amounts = Request::input('mort_amounts');

                if (isset($mort_names) && (int)count($mort_names) > 0) {
                    $dem_mortgage_no = 1;

                    foreach ($mort_names as $key => $mort_name) {
                        $mort_amount = (int)$mort_amounts[$key];

                        if ($mort_amount > 0) {
                            $last_dem_mortgage = DemMortgage::getLast($dem_loan->iddemloan);
                            $dem_mortgage = new DemMortgage();
                            if ($last_dem_mortgage !== null) {
                                $dem_mortgage_no = $last_dem_mortgage->demmortgno + 1;
                            }

                            $dem_mortgage->demmortgno = $dem_mortgage_no;
                            $dem_mortgage->name = $mort_name;
                            $dem_mortgage->nature = $mort_natures[$key];
                            $dem_mortgage->member = Request::input('member');
                            $dem_mortgage->loan = $dem_loan->iddemloan;
                            $dem_mortgage->amount = $mort_amount;
                            $dem_mortgage->network = $emp->network;
                            $dem_mortgage->zone = $emp->zone;
                            $dem_mortgage->institution = $emp->institution;
                            $dem_mortgage->branch = $emp->branch;

                            $dem_mortgage->save();
                        }
                    }
                }
            }

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.loan_application_save'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.loan_application_save'));
        }
    }
}
