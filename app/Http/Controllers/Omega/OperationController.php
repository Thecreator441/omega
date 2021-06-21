<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class OperationController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $operations = Operation::getOperations();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.operation', compact('menu', 'operations'));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    public function store()
    {
        $emp = Session::get('employee');

        $idoper = Request::input('idoper');
        DB::beginTransaction();
        try {
            $oper = null;

            if ($idoper === null) {
                $oper = new Operation();
            } else {
                $oper = Operation::getOperation($idoper);
            }

            $opercode = Operation::all()->count() - 1;

            $oper->opercode = pad($opercode, 3);
            $oper->labelfr = Request::input('labelfr');
            $oper->labeleng = Request::input('labeleng');
            // $oper->debtfr = Request::input('debtfr');
            // $oper->debteng = Request::input('debteng');
            // $oper->credtfr = Request::input('credtfr');
            // $oper->credteng = Request::input('credteng');
            $oper->network = $emp->network;
            $oper->zone = $emp->zone;
            $oper->institution = $emp->institution;
            $oper->branch = $emp->branch;

            $oper->save();

            DB::commit();
            if ($idoper === null) {
                return Redirect::back()->with('success', trans('alertSuccess.opesave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.opeedit'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            if ($idoper === null) {
                return Redirect::back()->with('danger', trans('alertDanger.opesave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.opeedit'));
        }
    }

    public function delete()
    {
        $idoper = Request::input('idoper');

        DB::beginTransaction();
        try {
            Operation::getOperation($idoper)->delete();

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.opedel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.opedel'));
        }
    }
}
