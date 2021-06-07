<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plat_Param;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class PlatParamController extends Controller
{
    public function index()
    {
        $emp = Session::get('employee');

        $param = Plat_Param::getPlatParam();
        
        return view('admin.pages.plat_param', compact('param'));
    }

    public function store()
    {
        config(['app.timezone' => Session::get('timezone')]);
        DB::beginTransaction();
        try {
            //   dd(Request::all());
            $emp = Session::get('employee');

            $idparam = Request::input('idparam');
            $param = null;

            if ($idparam !== null) {
                $param = Plat_Param::getPlatParam();
            } else {
                $param = new Plat_Param();
            }

            $param->slogan = Request::input('slogan');
            $param->tax_rate = Request::input('tax_rate');
            $param->login_attempt = Request::input('login_attempt');
            $param->block_duration = Request::input('block_duration');
            $param->inactive_duration = Request::input('inactive_duration');

            if ($idparam !== null) {
                $param->update((array)$param);
            } else {
                $param->save();
            }

            DB::commit();
            if ($idparam !== null) {
                return Redirect::back()->with('success', trans('alertSuccess.plat_param_edit'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.plat_param_save'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idparam !== null) {
                return Redirect::back()->with('success', trans('alertDanger.plat_param_edit'));
            }
            return Redirect::back()->with('success', trans('alertDanger.plat_param_save'));
        }
    }
}
