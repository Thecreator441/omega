<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccType;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AccTypeController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $acctypes = AccType::getAccTypes();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.acctype', compact('menu', 'acctypes'));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    public function store()
    {
        // dd(Request::input());
        DB::beginTransaction();
        $emp = $emp = Session::get('employee');
        try {
            $idacctype = Request::input('idacctype');
            $acctype = null;

            if ($idacctype === null) {
                $acctype = new AccType();
            } else {
                $acctype = AccType::getAccType($idacctype);
            }

            $code = ucfirst(strtolower(substr(Request::input('labeleng'), 0, 2)));

            $acctype->accabbr = $code;
            $acctype->labelfr = Request::input('labelfr');
            $acctype->labeleng = Request::input('labeleng');
            $acctype->network = $emp->network;
            $acctype->zone = $emp->zone;
            $acctype->institution = $emp->institution;
            $acctype->branch = $emp->branch;
            // dd($acctype);
            if ($idacctype === null) {
                $acctype->save();
            } else {
                $acctype->update((array)$acctype);
            }

            DB::commit();
            if ($idacctype === null) {
                return Redirect::back()->with('success', trans('alertSuccess.acctype_save'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.acctype_edit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idacctype === null) {
                return Redirect::back()->with('danger', trans('alertDanger.acctype_save'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.acctype_edit'));
        }
    }

    public function delete()
    {
//        dd(Request::all());
        $idacctype = Request::input('acctype');

        DB::beginTransaction();
        try {
            Acctype::getAccType($idacctype)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.brandel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.brandel'));
        }
    }
}
