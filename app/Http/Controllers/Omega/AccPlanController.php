<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccPlan;
use App\Models\AccPlanCommis;
use App\Models\AccType;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AccPlanController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $acctypes = AccType::getAccTypes();
            $accounts = Account::getAccounts();
            $acc_plans = AccPlan::getAccPlans();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.acc_plan', compact('menu', 'acctypes', 'accounts', 'acc_plans'));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    public function store()
    {
        // dd(Request::all());
        DB::beginTransaction();
        $emp = Session::get('employee');

        try {
            $idacc_plan = Request::input('idaccplan');
            $commis_names = Request::input('comis_names');
            $commis_rates = Request::input('comis_rate');
            $commis_mins = Request::input('comis_min');
            $commis_accs = Request::input('comis_acc');

            $acc_plan = null;

            if ($idacc_plan === null) {
                $acc_plan = new AccPlan();
            } else {
                $acc_plan = AccPlan::getAccPlan($idacc_plan);
            }

            $acc_plan->class = substrWords(Request::input('plan_code'), 1);
            $acc_plan->plan_code = pad(substrWords(Request::input('plan_code'), 6), 6);
            $acc_plan->acc_type = Request::input('acc_type');
            $acc_plan->labeleng = Request::input('labeleng');
            $acc_plan->labelfr = Request::input('labelfr');
            $acc_plan->min_balance = trimOver(Request::input('min_balance'), ' ');

            $acc_plan->calc_int = Request::input('calc_int');
            $acc_plan->calc_comm = Request::input('calc_comm');
            $acc_plan->cont_debt = Request::input('cont_debt');
            $acc_plan->cont_fron_inpu = Request::input('cont_fron_inpu');
            $acc_plan->adm_amort_acc = Request::input('adm_amort_acc');
            $acc_plan->bila_group = Request::input('bila_group');
            $acc_plan->bala_group = Request::input('bala_group');

            $acc_plan->open_fee = trimOver(Request::input('open_fee'), ' ');
            $acc_plan->open_fee_acc = Request::input('open_fee_acc');
            $acc_plan->clos_fee = trimOver(Request::input('clos_fee'), ' ');
            $acc_plan->clos_fee_acc = Request::input('clos_fee_acc');

            $acc_plan->int_debt_rate = Request::input('int_debt_rate');
            $acc_plan->int_debt_min = trimOver(Request::input('int_debt_min'), ' ');
            $acc_plan->int_debt_acc = Request::input('int_debt_acc');
            $acc_plan->int_cred_rate = Request::input('int_cred_rate');
            $acc_plan->int_cred_min = trimOver(Request::input('int_cred_min'), ' ');
            $acc_plan->int_cred_acc = Request::input('int_cred_acc');

            $acc_plan->pen_with_rate = Request::input('pen_with_rate');
            $acc_plan->pen_with_acc = Request::input('pen_with_acc');

            $acc_plan->network = $emp->network;

            if ($idacc_plan === null) {
                $acc_plan->save();

                if (isset($commis_names) AND count($commis_names) > 0) {
                    foreach ($commis_names as $key => $commis_name) {
                        if ($commis_rates[$key] !== null AND $commis_mins[$key] !== null AND $commis_accs[$key] !== null) {
                            $acc_plan_commis = new AccPlanCommis();

                            $acc_plan_commis->acc_plan = $acc_plan->idaccplan;
                            $acc_plan_commis->label = $commis_name;
                            $acc_plan_commis->rate = $commis_rates[$key];
                            $acc_plan_commis->mins = trimOver($commis_mins[$key], ' ');
                            $acc_plan_commis->label_acc = $commis_accs[$key];
                            $acc_plan_commis->network = $emp->network;

                            $acc_plan_commis->save();
                        }
                    }
                }
            } else {
                $acc_plan->update((array)$acc_plan);

                $acc_plan_commiss = AccPlanCommis::getAccPlanCommiss(['acc_plan' => $idacc_plan]);

                if (isset($commis_names) AND count($commis_names) > 0) {
                    if ($acc_plan_commiss->count() < count($commis_names)) {
                        foreach ($commis_names as $index => $commis_name) {
                            if ($acc_plan_commiss->offsetExists($index)) {
                                $acc_plan_commiss[$index]->label = $commis_names[$index];
                                $acc_plan_commiss[$index]->rate = $commis_rates[$index];
                                $acc_plan_commiss[$index]->mins = trimOver($commis_mins[$index], ' ');
                                $acc_plan_commiss[$index]->label_acc = $commis_accs[$index];
                                $acc_plan_commiss[$index]->network = $emp->network;
    
                                $acc_plan_commiss[$index]->update((array)$acc_plan_commiss[$index]);
                            } else {
                                $acc_plan_comm = new AccPlanCommis();
    
                                $acc_plan_comm->acc_plan = $idacc_plan;
                                $acc_plan_comm->label = $commis_names[$index];
                                $acc_plan_comm->rate = $commis_rates[$index];
                                $acc_plan_comm->mins = trimOver($commis_mins[$index], ' ');
                                $acc_plan_comm->label_acc = $commis_accs[$index];
                                $acc_plan_comm->network = $emp->network;
    
                                $acc_plan_comm->save();
                            }
                        }
                    }
    
                    if ($acc_plan_commiss->count() === count($commis_names)) {
                        foreach ($acc_plan_commiss as $index => $acc_plan_commis) {
                            $acc_plan_commis->label = $commis_names[$index];
                            $acc_plan_commis->rate = $commis_rates[$index];
                            $acc_plan_commis->mins = trimOver($commis_mins[$index], ' ');
                            $acc_plan_commis->label_acc = $commis_accs[$index];
                            $acc_plan_commis->network = $emp->network;
    
                            $acc_plan_commis->update((array)$acc_plan_commis);
                        }
                    }
    
                    if ($acc_plan_commiss->count() > count($commis_names)) {
                        foreach ($acc_plan_commiss as $index => $acc_plan_commis) {
                            if (array_key_exists($index, $commis_names)) {
                                $acc_plan_commis->label = $commis_names[$index];
                                $acc_plan_commis->rate = $commis_rates[$index];
                                $acc_plan_commis->mins = trimOver($commis_mins[$index], ' ');
                                $acc_plan_commis->label_acc = $commis_accs[$index];
                                $acc_plan_commis->network = $emp->network;
    
                                $acc_plan_commis->update((array)$acc_plan_commis);
                            } else {
                                $acc_plan_commis->delete();
                            }
                        }
                    }
                }
            }

            DB::commit();
            if ($idacc_plan === null) {
                return Redirect::back()->with('success', trans('alertSuccess.acc_plan_save'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.acc_plan_edit'));
        } catch
        (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idacc_plan === null) {
                return Redirect::back()->with('danger', trans('alertDanger.acc_plan_save'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.acc_plan_edit'));
        }
    }

    public function delete()
    {
        // dd(Request::all());
        $idacc_plan = Request::input('acc_plan');

        DB::beginTransaction();
        try {
            $acc_plan_commiss = AccPlanCommis::getAccPlanCommiss(['acc_plan' => $idacc_plan]);

            if ($acc_plan_commiss->count() > 0) {
                foreach ($acc_plan_commiss as $acc_plan_commis) {
                    $acc_plan_commis->delete();
                }
                AccPlan::getAccPlan($idacc_plan)->delete();
            } else {
                AccPlan::getAccPlan($idacc_plan)->delete();
            }


            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.acc_plan_del'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.acc_plan_del'));
        }
    }
}
