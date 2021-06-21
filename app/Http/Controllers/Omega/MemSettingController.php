<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccPlan;
use App\Models\MemSetting;
use App\Models\Operation;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class MemSettingController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $acc_plans = AccPlan::getAccPlans();
            $mem_sets = MemSetting::getMemSettings();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.mem_setting', compact('menu', 'acc_plans', 'mem_sets'));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    public function store()
    {
        dd(Request::all());
        DB::beginTransaction();

        try {
            $emp = Session::get('employee');

            $idmem_set = Request::input('idmem_set');

            $accplans = Request::input('accplans');
            $amounts = Request::input('amounts');

            if ($idmem_set === null) {
                if (isset($accplans) AND count($accplans) > 0) {
                    foreach ($accplans as $index => $accplan) {
                        $mem_setting = new MemSetting();
                        $operation = new Operation();

                        $amount = (int)trimOver($amounts[$index], ' ');

                        $memAcc_Plan = AccPlan::getAccPlan($accplan);
                        $memAcc_Numb = pad($memAcc_Plan->plan_code, 9, 'right') . '' .  pad($emp->institution, 3) . '' . pad($emp->branch, 3);
                        $memAcc = Account::getAccountBy(['accnumb' => $memAcc_Numb]);
                        if ($memAcc === null) {
                            $memAcc = new Account();

                            $memAcc->idplan = $memAcc_Plan->idaccplan;
                            $memAcc->accnumb = $memAcc_Numb;
                            $memAcc->labelfr = Request::input('labelfr');
                            $memAcc->labeleng = Request::input('labeleng');
                            $memAcc->class = $memAcc_Plan->class;
                            $memAcc->acctype = $memAcc_Plan->acc_type;
                            $memAcc->network = $emp->network;
                            $memAcc->zone = $emp->zone;
                            $memAcc->institution = $emp->institution;
                            $memAcc->branch = $emp->branch;

                            $memAcc->save();
                        }

                        $opercode = Operation::all()->count() - 1;

                        $operation->opercode = pad($opercode, 3);
                        $operation->labelfr = "VERSEMENT ESPECES " . Request::input('labelfr');
                        $operation->labeleng = "CASH IN " . Request::input('labeleng');

                        $operation->save();

                        if ($amount > 0) {
                            $mem_setting->account = $memAcc->idaccount;
                            $mem_setting->amount = $amount;
                            $mem_setting->operation = $operation->idoper;
                            $mem_setting->network = $emp->network;
                            $mem_setting->zone = $emp->zone;
                            $mem_setting->institution = $emp->institution;
                            $mem_setting->branch = $emp->branch;

                            $mem_setting->save();
                        }
                    }
                }
            } else {
                $accounts = Request::input('accounts');
                $mem_settings = MemSetting::getMemSettings();

                if (isset($accplans) AND count($accplans) > 0) {
                    if ($mem_settings->count() < count($accplans)) {
                        foreach ($accplans as $index => $accplan) {
                            $amount = (int)trimOver($amounts[$index], ' ');
                            $acc_plan = AccPlan::getAccPlan($accplan);

                            if ($mem_settings->offsetExists($index)) {
                                $account = Account::getAccount($accounts[$index]);
                                $accnumb = pad($acc_plan->plan_code, 9, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);

                                if ($amount > 0 AND $account->acccnumb !== $accnumb) {
                                    $account = new Account();
                                    $accnumb = pad($acc_plan->plan_code, 9, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);

                                    $account->idplan = $acc_plan->idaccplan;
                                    $account->accnumb = $accnumb;
                                    $account->labelfr = $acc_plan->labelfr;
                                    $account->labeleng = $acc_plan->labeleng;
                                    $account->class = $acc_plan->class;
                                    $account->acctype = $acc_plan->acc_type;
                                    $account->network = $emp->network;
                                    $account->zone = $emp->zone;
                                    $account->institution = $emp->institution;
                                    $account->branch = $emp->branch;

                                    $account->save();
                                }

                                if ($amount > 0) {
                                    $mem_settings[$index]->account = $account->idaccount;
                                    $mem_settings[$index]->amount = $amount;
                                    $mem_settings[$index]->network = $emp->network;
                                    $mem_settings[$index]->zone = $emp->zone;
                                    $mem_settings[$index]->institution = $emp->institution;
                                    $mem_settings[$index]->branch = $emp->branch;

                                    $mem_settings[$index]->update((array)$mem_settings[$index]);
                                }
                            } else {
                                $account = Account::getAccount($accounts[$index]);
                                $accnumb = pad($acc_plan->plan_code, 9, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);

                                if ($amount > 0 AND $account->acccnumb !== $accnumb) {
                                    $account = new Account();
                                    $accnumb = pad($acc_plan->plan_code, 9, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);

                                    $account->idplan = $acc_plan->idaccplan;
                                    $account->accnumb = $accnumb;
                                    $account->labelfr = $acc_plan->labelfr;
                                    $account->labeleng = $acc_plan->labeleng;
                                    $account->class = $acc_plan->class;
                                    $account->acctype = $acc_plan->acc_type;
                                    $account->network = $emp->network;
                                    $account->zone = $emp->zone;
                                    $account->institution = $emp->institution;
                                    $account->branch = $emp->branch;

                                    $account->save();
                                }

                                $mem_setting = new MemSetting();
                                if ($amount > 0) {
                                    $mem_setting->account = $account->idaccount;
                                    $mem_setting->amount = $amount;
                                    $mem_setting->network = $emp->network;
                                    $mem_setting->zone = $emp->zone;
                                    $mem_setting->institution = $emp->institution;
                                    $mem_setting->branch = $emp->branch;

                                    $mem_setting->save();
                                }
                            }
                        }
                    }

                    if ($mem_settings->count() === count($accplans)) {
                        foreach ($mem_settings as $index => $mem_setting) {
                            $amount = (int)trimOver($amounts[$index], ' ');
                            $acc_plan = AccPlan::getAccPlan($accplan);
                            $account = Account::getAccount($accounts[$index]);
                            $accnumb = pad($acc_plan->plan_code, 9, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);

                            if ($amount > 0 AND $account->acccnumb !== $accnumb) {
                                $account = new Account();
                                $accnumb = pad($acc_plan->plan_code, 9, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);

                                $account->idplan = $acc_plan->idaccplan;
                                $account->accnumb = $accnumb;
                                $account->labelfr = $acc_plan->labelfr;
                                $account->labeleng = $acc_plan->labeleng;
                                $account->class = $acc_plan->class;
                                $account->acctype = $acc_plan->acc_type;
                                $account->network = $emp->network;
                                $account->zone = $emp->zone;
                                $account->institution = $emp->institution;
                                $account->branch = $emp->branch;

                                $account->save();
                            }

                            if ($amount > 0) {
                                $mem_setting->account = $account->idaccount;
                                $mem_setting->amount = $amount;
                                $mem_setting->network = $emp->network;
                                $mem_setting->zone = $emp->zone;
                                $mem_setting->institution = $emp->institution;
                                $mem_setting->branch = $emp->branch;

                                $mem_setting->update((array)$mem_setting);
                            }
                        }
                    }

                    if ($mem_settings->count() > count($accplans)) {
                        foreach ($mem_settings as $index => $mem_setting) {
                            if (array_key_exists($index, $accplans)) {
                                $amount = (int)trimOver($amounts[$index], ' ');
                                $acc_plan = AccPlan::getAccPlan($accplan);
                                $account = Account::getAccount($accounts[$index]);
                                $accnumb = pad($acc_plan->plan_code, 9, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);

                                if ($amount > 0 AND $account->acccnumb !== $accnumb) {
                                    $account = new Account();
                                    $accnumb = pad($acc_plan->plan_code, 9, 'right') . '' . pad($emp->institution, 3) . '' . pad($emp->branch, 3);

                                    $account->idplan = $acc_plan->idaccplan;
                                    $account->accnumb = $accnumb;
                                    $account->labelfr = $acc_plan->labelfr;
                                    $account->labeleng = $acc_plan->labeleng;
                                    $account->class = $acc_plan->class;
                                    $account->acctype = $acc_plan->acc_type;
                                    $account->network = $emp->network;
                                    $account->zone = $emp->zone;
                                    $account->institution = $emp->institution;
                                    $account->branch = $emp->branch;

                                    $account->save();
                                }

                                if ($amount > 0) {
                                    $mem_setting->account = $account->idaccount;
                                    $mem_setting->amount = $amount;
                                    $mem_setting->network = $emp->network;
                                    $mem_setting->zone = $emp->zone;
                                    $mem_setting->institution = $emp->institution;
                                    $mem_setting->branch = $emp->branch;

                                    $mem_setting->update((array)$mem_setting);
                                }
                            } else {
                                $mem_setting->delete();
                            }
                        }
                    }
                } else {
                    self::delete();
                }
            }

            DB::commit();
            if ($idmem_set === null) {
                return Redirect::back()->with('success', trans('alertSuccess.mem_setting_save'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.mem_setting_edit'));
        } catch
        (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idmem_set === null) {
                return Redirect::back()->with('danger', trans('alertDanger.mem_setting_save'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.mem_setting_edit'));
        }
    }

    public static function delete(): \Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();
        try {
            $mem_settings = MemSetting::getMemSettings();

            if ($mem_settings->count() > 0) {
                foreach ($mem_settings as $mem_setting) {
                    $mem_setting->delete();
                }
            }

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.mem_setting_delete'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.mem_setting_delete'));
        }
    }
}
