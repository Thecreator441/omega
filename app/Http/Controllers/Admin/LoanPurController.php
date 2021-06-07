<?php

namespace App\Http\Controllers\Admin;

use App\Models\LoanPur;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class LoanPurController extends Controller
{

    public function index()
    {
        $loanpurs = LoanPur::getPaginates();

        return view('admin.pages.loanpur', [
            'loanpurs' => $loanpurs
        ]);
    }

    public function store()
    {
        DB::beginTransaction();
        $emp = Session::get('employee');

        $loanPurno = 1;
        $idloanpur = Request::input('idloantype');

        try {
            $loanPur = null;

            if ($idloanpur === null) {
                $loanPur = new LoanPur();

                $last = LoanPur::getLast();

                if ($last !== null) {
                    $loanPurno = $last->purcode + 1;
                }
                $loanPur->purcode = $loanPurno;
            } else {
                $loanPur = LoanPur::getLoanPur($idloanpur);
            }

            $loanPur->labelfr = Request::input('loanfr');
            $loanPur->labeleng = Request::input('loaneng');
            $loanPur->institution = $emp->institution;

            if ($idloanpur === null) {
                $loanPur->save();
            } else {
                $loanPur->update((array)$loanPur);
            }

            DB::commit();
            if ($idloanpur === null) {
                return Redirect::route('o_collect')->with('success', trans('alertSuccess.lpursave'));
            }
            return Redirect::route('o_collect')->with('success', trans('alertSuccess.lpuredit'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            if ($idloanpur === null) {
                return Redirect::back()->with('danger', trans('alertDanger.lpursave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.lpuredit'));
        }
    }

    public function delete()
    {
        $idloanpur = Request::input('idloanpur');

        DB::beginTransaction();
        try {
            LoanPur::getLoanPur($idloanpur)->delete();

            DB::commit();
            return Redirect::route('o_collect')->with('success', trans('alertSuccess.lpurdel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.lpurdel'));
        }
    }
}
