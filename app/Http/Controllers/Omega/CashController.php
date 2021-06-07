<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccPlan;
use App\Models\Cash;
use App\Models\Employee;
use App\Models\Institution;
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
            return Redirect::route('/');
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $cashes = Cash::getPaginate();
            $accounts = AccPlan::getAccPlans();
            $employees = Employee::getEmpUsers();
            $moneys = Money::getMoneys();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.cash', compact(
                'menu',
                'cashes',
                'accounts',
                'employees',
                'moneys'
            ));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised')); 
    }

    public function store()
    {
        dd(Request::all());
        DB::beginTransaction();
        try {
          $emp = Session::get('employee');

          $idcash = Request::input('idcash');
          $cashes = Cash::getCashes();
          $cashacc = Request::input('cashacc');
          $institution = Institution::getInstitution($emp->institution);
          $cash = null;

            if ($idcash === null) {
                $cash = new Cash();
    
                if ($cashes->count() === 0) {
                  $main = Account::getAccount($cashacc);
                  
                  $cash_acc = Account::getAccountBy(['accnumb' => $main->accnumb, 'accounts.institution' => $emp->institution]);
                  if($emp->level === 'B') {
                      $cash_acc = Account::getAccountBy(['accnumb' => $main->accnumb, 'accounts.branch' => $emp->branch]);
                  }
                  
                  if($cash_acc === null) {
                    $cash_acc = new Account();
                    $cash_acc->class = $main->class;
                    $cash_acc->idplan = $main->idplan;
                    $cash_acc->accnumb = $main->accnumb;
                    $cash_acc->acctype = $main->acctype;
                    $cash_acc->labeleng = Request::input('casheng');
                    $cash_acc->labelfr = Request::input('cashfr');
                    $cash_acc->network = $emp->network;
                    $cash_acc->zone = $emp->zone;
                    $cash_acc->institution = $emp->institution;
                    $cash_acc->branch = $emp->branch;
                    $cash_acc->save();
                  } else {
                    $cash_acc->class = $main->class;
                    $cash_acc->idplan = $main->idplan;
                    $cash_acc->accnumb = $main->accnumb;
                    $cash_acc->acctype = $main->acctype;
                    $cash_acc->update((array)$cash_acc);
                  }
    
                    $cashacc = $cash_acc->idaccount;
    
                    $mon1 = Request::input('B1');
                    $mon2 = Request::input('B2');
                    $mon3 = Request::input('B3');
                    $mon4 = Request::input('B4');
                    $mon5 = Request::input('B5');
                    $mon6 = Request::input('P1');
                    $mon7 = Request::input('P2');
                    $mon8 = Request::input('P3');
                    $mon9 = Request::input('P4');
                    $mon10 = Request::input('P5');
                    $mon11 = Request::input('P6');
                    $mon12 = Request::input('P7');
    
                    if ($mon1 !== null) {
                        $cash->mon1 += trimOver($mon1, ' ');
                    }
                    if ($mon2 !== null) {
                        $cash->mon2 += trimOver($mon2, ' ');
                    }
                    if ($mon3 !== null) {
                        $cash->mon3 += trimOver($mon3, ' ');
                    }
                    if ($mon4 !== null) {
                        $cash->mon4 += trimOver($mon4, ' ');
                    }
                    if ($mon5 !== null) {
                        $cash->mon5 += trimOver($mon5, ' ');
                    }
                    if ($mon6 !== null) {
                        $cash->mon6 += trimOver($mon6, ' ');
                    }
                    if ($mon7 !== null) {
                        $cash->mon7 += trimOver($mon7, ' ');
                    }
                    if ($mon8 !== null) {
                        $cash->mon8 += trimOver($mon8, ' ');
                    }
                    if ($mon9 !== null) {
                        $cash->mon9 += trimOver($mon9, ' ');
                    }
                    if ($mon10 !== null) {
                        $cash->mon10 += trimOver($mon10, ' ');
                    }
                    if ($mon11 !== null) {
                        $cash->mon11 += trimOver($mon11, ' ');
                    }
                    if ($mon12 !== null) {
                        $cash->mon12 += trimOver($mon12, ' ');
                    }
                } else {
                  $main = Account::getAccount($cashacc);
                  
                  $new_cash_acc = pad(substr($main->accnumb, 0, 6) . '' . pad($cashes->count()), 12, 'right');
                  
                  $cash_acc = Account::getAccountBy(['accnumb' => $new_cash_acc, 'accounts.institution' => $emp->institution]);
                  if($emp->level === 'B') {
                      $cash_acc = Account::getAccountBy(['accnumb' => $new_cash_acc, 'accounts.branch' => $emp->branch]);
                  }
                //   dd($new_cash_acc);
                  if($cash_acc === null) {
                    $cash_acc = new Account();
                    $cash_acc->class = $main->class;
                    $cash_acc->idplan = $main->idplan;
                    $cash_acc->accnumb = $new_cash_acc;
                    $cash_acc->acctype = $main->acctype;
                    $cash_acc->labeleng = Request::input('casheng');
                    $cash_acc->labelfr = Request::input('cashfr');
                    $cash_acc->network = $emp->network;
                    $cash_acc->zone = $emp->zone;
                    $cash_acc->institution = $emp->institution;
                    $cash_acc->branch = $emp->branch;
                    $cash_acc->save();
                  } else {
                    $cash_acc->class = $main->class;
                    $cash_acc->idplan = $main->idplan;
                    $cash_acc->accnumb = $new_cash_acc;
                    $cash_acc->acctype = $main->acctype;
                    $cash_acc->update((array)$cash_acc);
                  }
                  $cashacc = $cash_acc->idaccount;
                }
            } else {
                $cash = Cash::getCash($idcash);
            }
    
            $cash->cashcode = Request::input('cashcode');
            $cash->labelfr = Request::input('cashfr');
            $cash->labeleng = Request::input('casheng');
            $cash->cashacc = $cashacc;
            $cash->employee = Request::input('employee');
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
                Log::info(trans('alertSuccess.cashsave'));
                return Redirect::back()->with('success', trans('alertSuccess.cashsave'));
            }
            Log::info(trans('alertSuccess.cashedit'));
            return Redirect::back()->with('success', trans('alertSuccess.cashedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            if ($idcash === null) {
                Log::error(trans('alertDanger.cashsave'));
                return Redirect::back()->with('danger', trans('alertDanger.cashsave'));
            }
            Log::error(trans('alertDanger.cashedit'));
            return Redirect::back()->with('danger', trans('alertDanger.cashedit'));
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            Cash::getCash(Request::input('idcash'))->delete();

            DB::commit();
            Log::info(trans('alertSuccess.cashdel'));
            return Redirect::route('o-collect')->with('success', trans('alertSuccess.cashdel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Log::error(trans('alertDanger.cashdel'));
            return Redirect::back()->with('danger', trans('alertDanger.cashdel'));
        }
    }
}
