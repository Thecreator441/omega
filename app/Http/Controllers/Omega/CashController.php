<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccPlan;
use App\Models\Cash;
use App\Models\Employee;
use App\Models\Money;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CashController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $cashes = Cash::getCashes();
            $accplans = AccPlan::getAccPlans();
            $employees = Employee::getEmployees();
            $moneys = Money::getMoneys();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            foreach ($cashes as $cash) {
                $cash->totalCash = Cash::getSumBillet($cash->idcash)->total;
            }

            return view('omega.pages.cash', compact(
                'menu',
                'cashes',
                'accplans',
                'employees',
                'moneys'
            ));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    public function store()
    {
        // dd(Request::all());
        DB::beginTransaction();
        try {
          $emp = Session::get('employee');

          $idcash = Request::input('idcash');
          $cash = null;

            if ($idcash === null) {
                $cash = new Cash();
            } else {
                $cash = Cash::getCash($idcash);
            }

            $cash->cashcode = pad(Request::input('cash_code'), 3);
            $cash->labelfr = Request::input('labelfr');
            $cash->labeleng = Request::input('labeleng');
            $cash->employee = Request::input('employee');

            $cashAcc_Plan = AccPlan::getAccPlan(Request::input('cashacc'));
            $cashAcc_Numb = pad($cashAcc_Plan->plan_code, 6, 'right') . '' . pad(Request::input('cash_code'), 3, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);
            $cashAcc = Account::getAccountBy(['accnumb' => $cashAcc_Numb]);
            if ($cashAcc === null) {
                $cashAcc = new Account();

                $cashAcc->idplan = $cashAcc_Plan->idaccplan;
                $cashAcc->accnumb = $cashAcc_Numb;
                $cashAcc->labelfr = Request::input('labelfr');
                $cashAcc->labeleng = Request::input('labeleng');
                $cashAcc->class = $cashAcc_Plan->class;
                $cashAcc->acctype = $cashAcc_Plan->acc_type;
                $cashAcc->network = $emp->network;
                $cashAcc->zone = $emp->zone;
                $cashAcc->institution = $emp->institution;
                $cashAcc->branch = $emp->branch;

                $cashAcc->save();
            }
            $cash->cashacc = $cashAcc->idaccount;

            $misAcc_Plan = AccPlan::getAccPlan(Request::input('misacc'));
            $misAcc_Numb = pad($misAcc_Plan->plan_code, 6, 'right') . '' . pad(Request::input('cash_code'), 3, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);
            $misAcc = Account::getAccountBy(['accnumb' => $misAcc_Numb]);
            if ($misAcc === null) {
                $misAcc = new Account();

                $misAcc->idplan = $misAcc_Plan->idaccplan;
                $misAcc->accnumb = $misAcc_Numb;
                $misAcc->labelfr = Request::input('labelfr') . ' ' . $misAcc_Plan->labelfr;
                $misAcc->labeleng = Request::input('labeleng') . ' ' . $misAcc_Plan->labeleng;
                $misAcc->class = $misAcc_Plan->class;
                $misAcc->acctype = $misAcc_Plan->acc_type;
                $misAcc->network = $emp->network;
                $misAcc->zone = $emp->zone;
                $misAcc->institution = $emp->institution;
                $misAcc->branch = $emp->branch;

                $misAcc->save();
            }
            $cash->misacc = $misAcc->idaccount;

            $excAcc_Plan = AccPlan::getAccPlan(Request::input('excacc'));
            $excAcc_Numb = pad($excAcc_Plan->plan_code, 6, 'right') . '' . pad(Request::input('cash_code'), 3, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);
            $excAcc = Account::getAccountBy(['accnumb' => $excAcc_Numb]);
            if ($excAcc === null) {
                $excAcc = new Account();

                $excAcc->idplan = $excAcc_Plan->idaccplan;
                $excAcc->accnumb = $excAcc_Numb;
                $excAcc->labelfr = Request::input('labelfr') . ' ' . $excAcc_Plan->labelfr;
                $excAcc->labeleng = Request::input('labeleng') . ' ' . $excAcc_Plan->labeleng;
                $excAcc->class = $excAcc_Plan->class;
                $excAcc->acctype = $excAcc_Plan->acc_type;
                $excAcc->network = $emp->network;
                $excAcc->zone = $emp->zone;
                $excAcc->institution = $emp->institution;
                $excAcc->branch = $emp->branch;

                $excAcc->save();
            }
            $cash->excacc = $excAcc->idaccount;

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

            $cash->view_other_tills = Request::input('view_other_tills');
            $cash->network = $emp->network;
            $cash->zone = $emp->zone;
            $cash->institution = $emp->institution;
            $cash->branch = $emp->branch;
    
            if ($idcash === null) {
                $cash->save();
            } else {
                $cash->update((array)$cash);
            }
            
            DB::commit();
            if ($idcash === null) {
                Log::info(trans('alertSuccess.cash_save'));
                return Redirect::back()->with('success', trans('alertSuccess.cash_save'));
            }
            Log::info(trans('alertSuccess.cashedit'));
            return Redirect::back()->with('success', trans('alertSuccess.cash_edit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            dd($ex);
            if ($idcash === null) {
                Log::error(trans('alertDanger.cash_save'));
                return Redirect::back()->with('danger', trans('alertDanger.cash_save'));
            }
            Log::error(trans('alertDanger.cash_edit'));
            return Redirect::back()->with('danger', trans('alertDanger.cash_edit'));
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            Cash::getCash(Request::input('idcash'))->delete();

            DB::commit();
            Log::info(trans('alertSuccess.cash_delete'));
            return Redirect::route('o-collect')->with('success', trans('alertSuccess.cash_delete'));
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Log::error(trans('alertDanger.cash_delete'));
            return Redirect::back()->with('danger', trans('alertDanger.cash_delete'));
        }
    }
}
