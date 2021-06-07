<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Collector;
use App\Models\Commis_Pay;
use App\Models\Inst_Param;
use App\Models\ValWriting;
use App\Models\Writing;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CollectSitController extends Controller
{
    public function index()
    {
        //if (dateOpen()) {
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

        foreach ($collectors as $collector) {
            $amount = 0;
            $col_com = 0;
            foreach ($writings as $writing):
                if ($writing->employee === $collector->iduser):
                    $amount += (int)$writing->creditamt;
                endif;
            endforeach;
            $col_com = round(($param->col_com / 100) * $amount, 0);

            $collector->col_com = $col_com;
        }

        return view('omega.pages.collect_sit', compact(
            'collectors',
            'month'
        ));
        //}
        //return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }
}
