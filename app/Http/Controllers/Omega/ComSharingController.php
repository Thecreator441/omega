<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Cash;
use App\Models\Collector;
use App\Models\Collector_Com;
use App\Models\Commis_Pay;
use App\Models\Inst_Param;
use App\Models\Operation;
use App\Models\ValWriting;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class ComSharingController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $emp = Session::get('employee');

                $branchs = null;
                $collectors = null;

                if ($emp->level === 'B') {
                    $collectors = Collector::getCollectorsCash();
                } else {
                    $branchs = Branch::getBranches(['branches.institution' => $emp->institution]);
                    $collectors = Collector::getCollectorsCash();
                }

                $accounts = Account::getAccounts();
                $param = Inst_Param::getInstParam($emp->institution);
                if ($param === null) {
                    return Redirect::route('omega')->with('danger', trans('alertDanger.noparam'));
                }

                $month = null;

                $pay = Commis_Pay::getCommisPay();

                if ($pay !== null && $pay->month !== 12) {
                    $month = $pay->month + 1;
                }

                $writings = Writing::getSharings($param->revenue_acc, $month);
                $val_writings = ValWriting::getSharings($param->revenue_acc, $month);

                foreach ($val_writings as $val_writing) {
                    $writings->add($val_writing);
                }

                return view('omega.pages.com_sharing', compact(
                    'param',
                    'accounts',
                    'branchs',
                    'writings',
                    'collectors',
                    'pay',
                    'month'
                ));
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        try {
            $emp = Session::get('employee');

            $col_codes = Request::input('col_codes');
            $col_amts = Request::input('col_amts');
            $cash = Cash::getEmpCashOpen();
            $total_inst = trimOver(Request::input('total_inst'), ' ');
            $total_amt = trimOver(Request::input('total_amt'), ' ');
            $iParam = Inst_Param::getInstParam($emp->institution);
            $writnumb = getWritNumb();
            $accdate = AccDate::getOpenAccDate();
            $opera1 = Operation::getByCode(16);
            $opera2 = Operation::getByCode(17);
            $opera3 = Operation::getByCode(18);

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $iParam->revenue_acc;
            $writing->operation = $opera1->idoper;
            $writing->debitamt = $total_amt;
            $writing->accdate = $accdate->accdate;
            $writing->employee = $emp->iduser;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $comBal = Account::getAccount($iParam->revenue_acc);
            $available = $comBal->available;
            if ((int)$available === 0) {
                $available = $comBal->evebal;
            }
            $comBal->available = $available - $total_amt;
            $comBal->update((array)$comBal);

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $iParam->inst_acc;
            $writing->operation = $opera2->idoper;
            $writing->creditamt = $total_inst;
            $writing->accdate = $accdate->accdate;
            $writing->employee = $emp->iduser;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $instBal = Account::getAccount($iParam->inst_acc);
            $instBal->available += $total_inst;
            $instBal->update((array)$instBal);

            foreach ($col_codes as $index => $col_code) {
                if (!empty($col_amts[$index]) && $col_amts[$index] !== null && $col_amts[$index] !== '0') {
                    $writing = new Writing();
                    $writing->writnumb = $writnumb;
                    $writing->account = $iParam->collect_acc;
                    $writing->coll_aux = $col_code;
                    $writing->operation = $opera3->idoper;
                    $writing->creditamt = trimOver($col_amts[$index], ' ');
                    $writing->accdate = $accdate->accdate;
                    $writing->employee = $emp->iduser;
                    $writing->cash = $cash->idcash;
                    $writing->network = $emp->network;
                    $writing->zone = $emp->zone;
                    $writing->institution = $emp->institution;
                    $writing->branch = $emp->branch;
                    $writing->save();

                    $colBal = Collector_Com::getCollectBal($col_code);
                    if ($colBal !== null) {
                        $colBal->available += trimOver($col_amts[$index], ' ');
                        $colBal->status = 'N';
                        $colBal->update((array)$colBal);
                    } else {
                        $colBal = new Collector_Com();

                        $colBal->collector = $col_code;
                        $colBal->account = $iParam->collect_acc;
                        $colBal->available = trimOver($col_amts[$index], ' ');
                        $colBal->status = 'N';
                        $colBal->save();
                    }
                }
            }

            $comBal = Account::getAccount($iParam->collect_acc);
            $comBal->available = $total_amt - $total_inst;
            $comBal->update((array)$comBal);

            $pay = Commis_Pay::getCommisPay();
            if ($pay === null) {
                $pay = new Commis_Pay();

                $pay->institution = $emp->institution;
                $pay->branch = $emp->branch;
                $pay->month = Request::input('month');
                $pay->save();
            } else {
                $pay->institution = $emp->institution;
                $pay->branch = $emp->branch;
                $pay->month = Request::input('month');
                $pay->update((array)$pay);
            }

            if ($emp->lang === 'fr') {
                Log::info($opera1->labelfr);
                Log::info($opera2->labelfr);
            } else {
                Log::info($opera1->labeleng);
                Log::info($opera2->labeleng);
            }

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.comssave'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('success', trans('alertDanger.comssave'));
        }
    }
}
