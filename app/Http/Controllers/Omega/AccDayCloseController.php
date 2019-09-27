<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\ValWriting;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AccDayCloseController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            return view('omega.pages.acc_day_close');
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {

        DB::beginTransaction();
        try {
            $date = AccDate::getOpenAccDate();
            $writings = Writing::getWritings();

            $date->status = 'C';
            $date->save();

            foreach ($writings as $writing) :
                $val_writing = new ValWriting();

                $val_writing->writnumb = $writing->writnumb;
                $val_writing->account = $writing->account;
                $val_writing->aux = $writing->aux;
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
                $val_writing->represent = $writing->represent ;
                $val_writing->created_at = $writing->created_at;
                $val_writing->save();

                $writing->delete();
            endforeach;

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.closedate'));
        } catch (\Exception $ex) {
            DB::rollback();
            return Redirect::back()->with('danger', trans('alertDanger.closedate'));
        }
    }
}
