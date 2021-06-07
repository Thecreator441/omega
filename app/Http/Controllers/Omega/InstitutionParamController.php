<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Inst_Param;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class InstitutionParamController extends Controller
{
    public function index()
    {
        $emp = Session::get('employee');

        $accounts = Account::getAccounts();
        $param = Inst_Param::getInstParam($emp->institution);

        return view('omega.pages.institution', compact('param', 'accounts'));
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        try {
            $emp = Session::get('employee');

            $idparam = Request::input('idparam');
            $param = null;

            if (isset($idparam)) {
                $param = Inst_Param::getInstParam($idparam);
            } else {
                $param = new Inst_Param();
            }

            $param->institute = $emp->institution;
            $param->collect_acc = Request::input('collect_acc');
//            $param->pay_revenue_acc = Request::input('pay_revenue_acc');
            $param->revenue_acc = Request::input('revenue_acc');
            $param->client_acc = Request::input('client_acc');
            $param->inst_acc = Request::input('inst_acc');
            $param->tax_acc = Request::input('tax_acc');
            $param->inst_com = Request::input('inst_com');
            $param->col_com = Request::input('col_com');

            if (isset($idparam)) {
                $param->update((array)$param);
            } else {
                $param->save();
            }

            DB::commit();
            if (isset($idparam)) {
                return Redirect::back()->with('success', trans('alertSuccess.ipedit'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.ipsave'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if (isset($idparam)) {
                return Redirect::back()->with('success', trans('alertDanger.ipedit'));
            }
            return Redirect::back()->with('success', trans('alertDanger.ipsave'));
        }
    }
}
