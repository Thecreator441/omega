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
            'accounts' => $accounts,
        ]);
    }

    public function store()
    {
        DB::beginTransaction();
        $emp = Session::get('employee');

        $idltype = Request::input('idloantype');
        $paytax = Request::input('taxpay');
        $quod = Request::input('quod');
        $penreq = Request::input('penreg');

        try {
            $loanType = null;

            if ($idltype === null) {
                $loanType = new LoanType();
            } else {
                $loanType = LoanType::getLoanType($idltype);
            }

            $loanType->lcode = pad(Request::input('loancode'), 3);
            $loanType->labelfr = Request::input('loanfr');
            $loanType->labeleng = Request::input('loaneng');
            $loanType->period = Request::input('loanper');
            $loanType->maxdur = Request::input('maxdur');
            $loanType->maxamt = trimOver(Request::input('maxamt'), ' ');
            $loanType->datescapepen = Request::input('inst&pen');
            $loanType->loanacc = Request::input('intpayacc');
            $loanType->memacc = Request::input('loanacc');
            $loanType->getcomaker = Request::input('accCom');
            $loanType->blockacc = Request::input('accBlock');
            if ($paytax === 'Y') {
                $loanType->paytax = $paytax;
                $loanType->taxrate = Request::input('taxrate');
                $loanType->taxacc = Request::input('taxacc');
            }
            if ($quod === 'Y') {
                $loanType->usequod = $quod;
                $loanType->quoteaccplan = Request::input('accplanquod');
            }
            if ($penreq === 'Y') {
                $loanType->penreq = $penreq;
                $loanType->pentax = Request::input('taxpen');
                $loanType->penacc = Request::input('penacc');
            }
            $loanType->institution = $emp->institution;

            if ($idltype === null) {
                $loanType->save();
            } else {
                $loanType->update((array)$loanType);
            }

            DB::commit();
            if ($idltype === null) {
                return Redirect::route('omega')->with('success', trans('alertSuccess.ltypesave'));
            }
            return Redirect::route('omega')->with('success', trans('alertSuccess.ltypeedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            if ($idltype === null) {
                return Redirect::back()->with('danger', trans('alertDanger.ltypesave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.ltypeedit'));
        }
    }

    public function delete()
    {
        $idltype = Request::input('idloantype');

        DB::beginTransaction();
        try {
            LoanType::getLoanType($idltype)->delete();

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.ltypedel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.ltypedel'));
        }
    }
}
