<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AccDayOpenController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            return Redirect::route('omega')->with('danger', trans('alertDanger.alrdate'));
        }

        $acc_date = AccDate::getCloseAccDate();

        return view('omega.pages.acc_day_open', compact('acc_date'));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        try {
            $emp = Session::get('employee');
            $iddate = Request::input('iddate');
            $date = null;

            if ($iddate !== null) {
                $date = AccDate::getAccDate($iddate);
            } else {
                $date = new AccDate();
            }

            $date->presentdate = getsDate(now());
            $date->accdate = Request::input('date');
            $date->status = 'O';
            if ($emp->level === 'B') {
                $date->branch = $emp->branch;
            }
            if ($emp->level === 'I') {
                $date->institution = $emp->institution;
            }
            if ($emp->level === 'Z') {
                $date->zone = $emp->zone;
            }
            if ($emp->level === 'N') {
                $date->network = $emp->network;
            }

            if ($iddate !== null) {
                $date->update((array)$date);
            } else {
                $date->save();
            }

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.opendate'));
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex->getMessage());
            return Redirect::back()->with('danger', trans('alertDanger.opendate'));
        }
    }
}
