<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Collect_Bal;
use App\Models\Collector;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ClientSitController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $emp = Session::get('employee');

            $members = Collect_Bal::getCustBals();
            $collectors = Collector::getCollectors();

            if ($emp->collector !== null) {
                $members = Collect_Bal::getCustBals(['Cm.collector' => $emp->idcoll]);
            }

            return view('omega.pages.client_sit', compact('members', 'collectors'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }
}
