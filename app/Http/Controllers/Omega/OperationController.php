<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class OperationController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $operations = Operation::getPaginate();

            return view('omega.pages.operation', [
                'operations' => $operations
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
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

            $oper->opercode = pad(Request::input('opercode'), 3);
            $oper->labelfr = Request::input('labelfr');
            $oper->labeleng = Request::input('labeleng');
            $oper->debtfr = Request::input('debtfr');
            $oper->debteng = Request::input('debteng');
            $oper->credtfr = Request::input('credtfr');
            $oper->credteng = Request::input('credteng');
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
