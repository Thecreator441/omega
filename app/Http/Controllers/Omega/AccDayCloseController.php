<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\Cash;
use App\Models\Collect_Bal;
use App\Models\Collect_Mem;
use App\Models\Collector;
use App\Models\Collector_Com;
use App\Models\ValWriting;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class AccDayCloseController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $acc_date = AccDate::getOpenAccDate();

            return view('omega.pages.acc_day_close', compact('acc_date'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
//dd(Request::all());
        DB::beginTransaction();
        try {
            $writings = Writing::getWritings();
            $cashes = Cash::getCashes();

            foreach ($cashes as $cash) {
                if ($cash->status === 'O') {
                    return Redirect::back()->with('danger', trans('alertDanger.allcashclose'));
                }
            }

            $debit = Writing::getSumDebit();
            $credit = Writing::getSumCredit();

            if ((int)$debit - (int)$credit !== 0) {
                return Redirect::back()->with('danger', trans('alertDanger.debt_credt'));
            }

            if ($writings !== null) {
                foreach ($writings as $writing) :
                    $val_writing = new ValWriting();

                    $val_writing->writnumb = $writing->writnumb;
                    $val_writing->account = $writing->account;
                    $val_writing->aux = $writing->aux;
                    $val_writing->coll_aux = $writing->coll_aux;
                    $val_writing->operation = $writing->operation;
                    $val_writing->debitamt = $writing->debitamt;
                    $val_writing->creditamt = $writing->creditamt;
                    $val_writing->accdate = $writing->accdate;
                    $val_writing->employee = $writing->employee;
                    $val_writing->cash = $writing->cash;
                    $val_writing->network = $writing->network;
                    $val_writing->zone = $writing->zone;
                    $val_writing->institution = $writing->institution;
                    $val_writing->branch = $writing->branch;
                    $val_writing->represent = $writing->represent;
                    $val_writing->created_at = $writing->created_at;

                    $val_writing->save();

                    $writing->delete();
                endforeach;
            }


            $accounts = Account::getAccounts();
            foreach ($accounts as $account) {
                $account->eveamt = $account->available;

                $account->update((array)$account);
            }

            $customers = Collect_Mem::getMembers();
            foreach ($customers as $customer) {
                $cust_bal = Collect_Bal::getMemBal($customer->idcollect_mem);
                $cust_bal->evebal = $cust_bal->available;
                $cust_bal->available = 0;

                $cust_bal->update((array)$cust_bal);
            }

            $collectors = Collector::getCollectors();
            foreach ($collectors as $collector) {
                $coll_bal = Collector_Com::getCollectBal($collector->idcoll);
                $coll_bal->evebal = $coll_bal->available;
                $coll_bal->available = 0;

                $coll_bal->update((array)$coll_bal);
            }

            $date = AccDate::getAccDate(Request::input('iddate'));
            $date->evedate = $date->accdate;
            $date->accdate = null;
            $date->status = 'C';

            $date->update((array)$date);

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.closedate'));
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.closedate'));
        }
    }
}
