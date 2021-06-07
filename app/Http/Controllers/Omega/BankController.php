<?php

namespace App\Http\Controllers\Omega;

use App\Models\Account;
use App\Models\AccPlan;
use App\Models\Bank;
use App\Models\Country;
use App\Models\Division;
use App\Models\Priv_Menu;
use App\Models\Region;
use App\Models\SubDiv;
use App\Models\Town;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BankController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/');
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $banks = Bank::getBanks();
            $countries = Country::getCountries();
            $regions = Region::getRegions();
            $divisions = Division::getDivisions();
            $towns = Town::getTowns();
            $subdivs = SubDiv::getSubDivs();
            $accounts = Account::getAccounts();
            $accplans = AccPlan::getAccPlans();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.bank', compact(
                'menu',
                'banks',
                'countries',
                'regions',
                'divisions',
                'towns',
                'subdivs',
                'accounts',
                'accplans'
            ));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    public function store()
    {
        // dd(Request::input());
        DB::beginTransaction();
        $emp = Session::get('employee');

        $idbank = Request::input('idbank');
        try {
            $bank = null;

            if ($idbank === null) {
                $bank = new Bank();
            } else {
                $bank = Bank::getBank($idbank);
            }

            $bank->bankcode = pad(Request::input('bank_code'), 3);
            $bank->labelfr = Request::input('labelfr');
            $bank->labeleng = Request::input('labeleng');
            $bank->ouracc = Request::input('ouracc');
            $bank->phone1 = trimOver(Request::input('phone1'));
            $bank->phone2 = trimOver(Request::input('phone2'));
            $bank->email = Request::input('email');
            $bank->country = Request::input('country');
            $bank->region = Request::input('region');
            $bank->division = Request::input('division');
            $bank->subdivision = Request::input('subdiv');
            $bank->town = Request::input('town');
            $bank->address = Request::input('address');
            $bank->postcode = Request::input('postal');

            $theirAcc_Plan = AccPlan::getAccPlan(Request::input('theiracc'));
            $theirAcc_Numb = pad($theirAcc_Plan->plan_code, 6, 'right') . '' . pad(Request::input('bank_code'), 3, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);
            $theirAcc = Account::getAccountBy(['accnumb' => $theirAcc_Numb]);
            if ($theirAcc === null) {
                $theirAcc = new Account();

                $theirAcc->idplan = $theirAcc_Plan->idaccplan;
                $theirAcc->accnumb = $theirAcc_Numb;
                $theirAcc->labelfr = $theirAcc_Plan->labelfr;
                $theirAcc->labeleng = $theirAcc_Plan->labeleng;
                $theirAcc->class = $theirAcc_Plan->class;
                $theirAcc->acctype = $theirAcc_Plan->acc_type;
                $theirAcc->network = $emp->network;
                $theirAcc->zone = $emp->zone;
                $theirAcc->institution = $emp->institution;
                $theirAcc->branch = $emp->branch;

                $theirAcc->save();
            }
            $bank->theiracc = $theirAcc->idaccount;

            if (Request::input('cash_check_acc') !== null) {
                $cashCheckAcc_Plan = AccPlan::getAccPlan(Request::input('cash_check_acc'));
                $cashCheckAcc_Numb = pad($cashCheckAcc_Plan->plan_code, 6, 'right') . '' . pad(Request::input('bank_code'), 3, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);
                $cashCheckAcc = Account::getAccountBy(['accnumb' => $cashCheckAcc_Numb]);
                if ($cashCheckAcc === null) {
                    $cashCheckAcc = new Account();

                    $cashCheckAcc->idplan = $cashCheckAcc_Plan->idaccplan;
                    $cashCheckAcc->accnumb = $cashCheckAcc_Numb;
                    $cashCheckAcc->labelfr = $cashCheckAcc_Plan->labelfr;
                    $cashCheckAcc->labeleng = $cashCheckAcc_Plan->labeleng;
                    $cashCheckAcc->class = $cashCheckAcc_Plan->class;
                    $cashCheckAcc->acctype = $cashCheckAcc_Plan->acc_type;
                    $cashCheckAcc->network = $emp->network;
                    $cashCheckAcc->zone = $emp->zone;
                    $cashCheckAcc->institution = $emp->institution;
                    $cashCheckAcc->branch = $emp->branch;

                    $cashCheckAcc->save();
                }
                $bank->cash_check_acc = $cashCheckAcc->idaccount;
            }

            if (Request::input('credit_check_acc') !== null) {
                $creditCheckAcc_Plan = AccPlan::getAccPlan(Request::input('credit_check_acc'));
                $creditCheckAcc_Numb = pad($creditCheckAcc_Plan->plan_code, 6, 'right') . '' . pad(Request::input('bank_code'), 3, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);
                $creditCheckAcc = Account::getAccountBy(['accnumb' => $creditCheckAcc_Numb]);
                if ($creditCheckAcc === null) {
                    $creditCheckAcc = new Account();

                    $creditCheckAcc->idplan = $creditCheckAcc_Plan->idaccplan;
                    $creditCheckAcc->accnumb = $creditCheckAcc_Numb;
                    $creditCheckAcc->labelfr = $creditCheckAcc_Plan->labelfr;
                    $creditCheckAcc->labeleng = $creditCheckAcc_Plan->labeleng;
                    $creditCheckAcc->class = $creditCheckAcc_Plan->class;
                    $creditCheckAcc->acctype = $creditCheckAcc_Plan->acc_type;
                    $creditCheckAcc->network = $emp->network;
                    $creditCheckAcc->zone = $emp->zone;
                    $creditCheckAcc->institution = $emp->institution;
                    $creditCheckAcc->branch = $emp->branch;

                    $creditCheckAcc->save();
                }
                $bank->credit_check_acc = $creditCheckAcc->idaccount;
            }

            if (Request::input('cash_corresp_check_acc') !== null) {
                $cashCorrespCheckAcc_Plan = AccPlan::getAccPlan(Request::input('cash_corresp_check_acc'));
                $cashCorrespCheckAcc_Numb = pad($cashCorrespCheckAcc_Plan->plan_code, 6, 'right') . '' . pad(Request::input('bank_code'), 3, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);
                $cashCorrespCheckAcc = Account::getAccountBy(['accnumb' => $cashCorrespCheckAcc_Numb]);
                if ($cashCorrespCheckAcc === null) {
                    $cashCorrespCheckAcc = new Account();

                    $cashCorrespCheckAcc->idplan = $cashCorrespCheckAcc_Plan->idaccplan;
                    $cashCorrespCheckAcc->accnumb = $cashCorrespCheckAcc_Numb;
                    $cashCorrespCheckAcc->labelfr = $cashCorrespCheckAcc_Plan->labelfr;
                    $cashCorrespCheckAcc->labeleng = $cashCorrespCheckAcc_Plan->labeleng;
                    $cashCorrespCheckAcc->class = $cashCorrespCheckAcc_Plan->class;
                    $cashCorrespCheckAcc->acctype = $cashCorrespCheckAcc_Plan->acc_type;
                    $cashCorrespCheckAcc->network = $emp->network;
                    $cashCorrespCheckAcc->zone = $emp->zone;
                    $cashCorrespCheckAcc->institution = $emp->institution;
                    $cashCorrespCheckAcc->branch = $emp->branch;

                    $cashCorrespCheckAcc->save();
                }
                $bank->cash_corresp_check_acc = $cashCorrespCheckAcc->idaccount;
            }

            $bank->network = $emp->network;
            $bank->zone = $emp->zone;
            $bank->institution = $emp->institution;
            $bank->branch = $emp->branch;

            
            if ($idbank === null) {
                $bank->save();
            } else {
                $bank->update((array)$bank);
            }


            DB::commit();
            if ($idbank === null) {
                return Redirect::route('omega')->with('success', trans('alertSuccess.bank_save'));
            }
            return Redirect::route('omega')->with('success', trans('alertSuccess.bank_edit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idbank === null) {
                return Redirect::back()->with('danger', trans('alertDanger.bank_save'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.bank_edit'));
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $bank = Request::input('bank');

            Bank::getBank($bank)->delete();

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.bank_del'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.bank_del'));
        }
    }
}
