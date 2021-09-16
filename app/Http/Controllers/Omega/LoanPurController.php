<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\LoanPur;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class loanpurController extends Controller
{
    public function index()
    {
        $loanpurs = LoanPur::getLoanPurs();
        $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

        return view('omega.pages.loanpur', compact('menu', 'loanpurs'));
    }

    public function store()
    {
        // dd(Request::input());
        try {
            DB::beginTransaction();
            $emp = $emp = Session::get('employee');
            $idloanpur = Request::input('idloanpur');
            $loanpur = null;

            if ($idloanpur === null) {
                $loanpur = new loanpur();
            } else {
                $loanpur = loanpur::getloanpur($idloanpur);
            }

            $loanpur->labelfr = Request::input('labelfr');
            $loanpur->labeleng = Request::input('labeleng');
            $loanpur->network = $emp->network;
            $loanpur->zone = $emp->zone;
            $loanpur->institution = $emp->institution;
            $loanpur->branch = $emp->branch;
            
            if ($idloanpur === null) {
                $loanpur->save();
            } else {
                $loanpur->update((array)$loanpur);
            }

            DB::commit();
            if ($idloanpur === null) {
                return Redirect::back()->with('success', trans('alertSuccess.loanpur_save'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.loanpur_edit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idloanpur === null) {
                return Redirect::back()->with('danger', trans('alertDanger.loanpur_save'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.loanpur_edit'));
        }
    }

    public function delete()
    {
        //  dd(Request::all());
        $idloanpur = Request::input('loanpur');

        DB::beginTransaction();
        try {
            Loanpur::getLoanPur($idloanpur)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.loanpur_del'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.loanpur_del'));
        }
    }
}
