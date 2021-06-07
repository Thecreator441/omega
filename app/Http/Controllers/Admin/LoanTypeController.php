<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\LoanType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class LoanTypeController extends Controller
{

    public function index()
    {
        $loantypes = LoanType::getPaginates();
        $accounts = Account::getAccounts();

        return view('admin.pages.loantype', [
            'loantypes' => $loantypes,
            'accounts' => $accounts
        ]);
    }

    public function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        $emp = Session::get('employee');

        $loanTYno = 1;
        $idltype = Request::input('idloantype');
        $penreq = Request::input('penreg');

        try {
            $loanType = null;

            if ($idltype === null) {
                $loanType = new LoanType();

                $last = LoanType::getLast();

                if ($last !== null) {
                    $loanTYno = $last->lcode + 1;
                }
                $loanType->lcode = $loanTYno;
            } else {
                $loanType = LoanType::getLoanType($idltype);
            }

            $loanType->labelfr = Request::input('loanfr');
            $loanType->labeleng = Request::input('loaneng');
            $loanType->period = Request::input('period');
            $loanType->maxdur = Request::input('maxdur');
            $loanType->maxamt = trimOver(Request::input('maxamt'), ' ');
            $loanType->datescapepen = Request::input('inst&pen');
            $loanType->intacc = Request::input('intpayacc');
            $loanType->loanacc = Request::input('loanacc');
            if ($penreq === 'Y') {
                $loanType->penreq = $penreq;
                $loanType->pentax = Request::input('taxpen');
                $loanType->penacc = Request::input('penacc');
            }
            $loanType->institution = $emp->institution;
//dd($loanType);
            if ($idltype === null) {
                $loanType->save();
            } else {
                $loanType->update((array)$loanType);
            }

            DB::commit();
            if ($idltype === null) {
                return Redirect::route('o_collect')->with('success', trans('alertSuccess.ltypesave'));
            }
            return Redirect::route('o_collect')->with('success', trans('alertSuccess.ltypeedit'));
        } catch (\Exception $exception) {
            dd($exception);
            DB::rollBack();
            if ($idltype === null) {
                return Redirect::back()->with('danger', trans('alertDanger.ltypesave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.ltypeedit'));
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            LoanType::getLoanType(Request::input('idloantype'))->delete();

            DB::commit();
            return Redirect::route('o_collect')->with('success', trans('alertSuccess.ltypedel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.ltypedel'));
        }
    }
}
