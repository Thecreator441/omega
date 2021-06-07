<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Branch_Param;
use App\Models\Commis_Tab;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class BranchParamController extends Controller
{
    public function index()
    {
        $emp = Session::get('employee');

        $param = Branch_Param::getBranchParam($emp->branch);
        $param_tab = null;
        if ($param->commis === 'T') {
            $param_tab = Commis_Tab::getCommisTab($param->idbranch_param);
        }

        return view('omega.pages.branch', compact('param', 'param_tab'));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        try {
            $emp = Session::get('employee');

            $idparam = Request::input('idparam');
            $commis = Request::input('commis');
            $param = null;

            if (isset($idparam)) {
                $param = Branch_Param::getBranchParam($emp->branch);
            } else {
                $param = new Branch_Param();
            }

            $param->commis = $commis;
            $param->branch = $emp->branch;
            if ($commis === 'P') {
                $param->com_perc = Request::input('per_rate');
                if (isset($idparam)) {
                    $param->update((array)$param);
                } else {
                    $param->save();
                }
            }
            if ($commis === 'T') {
                $param_tab = null;
                if (isset($idparam)) {
                    $param->update((array)$param);
                } else {
                    $param->save();
                }

                if (isset($idparam)) {
                    $param_tab = Commis_Tab::getCommisTab($param->idbranch_param);
                } else {
                    $param_tab = new Commis_Tab();
                }

                $param_tab->branch_param = $param->idbranch_param;
                $param_tab->t50 = trimOver(Request::input('t50'), ' ');
                $param_tab->t200 = trimOver(Request::input('t200'), ' ');
                $param_tab->t400 = trimOver(Request::input('t400'), ' ');
                $param_tab->t500 = trimOver(Request::input('t500'), ' ');
                $param_tab->t = trimOver(Request::input('t'), ' ');

                if (isset($idparam)) {
                    $param_tab->update((array)$param_tab);
                } else {
                    $param_tab->save();
                }
            }

            DB::commit();
            if (isset($idparam)) {
                return Redirect::route('omega')->with('success', trans('alertSuccess.bpedit'));
            }
            return Redirect::route('omega')->with('success', trans('alertSuccess.bpsave'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if (isset($idparam)) {
                return Redirect::back()->with('success', trans('alertDanger.bpedit'));
            }
            return Redirect::back()->with('success', trans('alertDanger.bpsave'));
        }
    }
}
