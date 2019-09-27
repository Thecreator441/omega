<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AccDayOpenController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            return Redirect::route('omega')->with('danger', trans('alertDanger.alrdate'));
        }
        return view('omega.pages.acc_day_open');
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $date = AccDate::getCloseAccDate();

            $date->presentdate = getsDate(now());
            $date->status = 'O';
            $date->save();

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.opendate'));
        } catch (\Exception $ex) {
            DB::rollback();
            return Redirect::back()->with('danger', trans('alertDanger.opendate'));
        }
    }
}
