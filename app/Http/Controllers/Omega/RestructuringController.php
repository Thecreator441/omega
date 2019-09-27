<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Installment;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class RestructuringController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $loans = Loan::getLoans(['loanstat' => 'Ar']);

            return view('omega.pages.restructuring', [
                'loans' => $loans,
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public static function store()
    {
//        dd(Request::all());
        DB::beginTransaction();
        $idloan = Request::input('loan');
        $resBy = Request::input('resby');
        $nbrinst = Request::input('numb_inst');
        $nos = Request::input('nos');
        $capitals = Request::input('capitals');
        $amortAmts = Request::input('amortAmts');
        $intAmts = Request::input('intAmts');
        $annAmts = Request::input('annAmts');
        $taxAmts = Request::input('taxAmts');
        $totAmts = Request::input('totAmts');
        $dates = Request::input('dates');
        try {
            $loan = Loan::getloan($idloan);
            $installs = Installment::getInstalls($idloan);

            if ($resBy === 'intrate') {
                $loan->intrate = Request::input('int_rate');
            } else if ($resBy === 'install') {
                $loan->nbrinst = $nbrinst;
            } else if ($resBy === 'grace') {
                $loan->grace = Request::input('grace');
            } else if ($resBy === 'all') {
                $loan->intrate = Request::input('int_rate');
                $loan->nbrinst = $nbrinst;
                $loan->grace = Request::input('grace');
            }
            $loan->annuity = trimOver(Request::input('annAmt'), ' ');
            $loan->intamt = trimOver(Request::input('intAmt'), ' ');
            ++$loan->isRes;
            $loan->update((array)$loan);

            if ($installs->count() < $nbrinst) {
                foreach ($nos as $key => $no) {
                    if (array_key_exists($key, $installs)) {
                        $installs[$key]->capital = $capitals[$key];
                        $installs[$key]->amort = $amortAmts[$key];
                        $installs[$key]->interest = $intAmts[$key];
                        $installs[$key]->annuity = $annAmts[$key];
                        $installs[$key]->tax = $taxAmts[$key];
                        $installs[$key]->total = $totAmts[$key];
                        $installs[$key]->instdate = getsDate(str_replace('/', '-', $dates[$key]));
                        $installs[$key]->update((array)$installs[$key]);
                    } else if ($installs->count() <= $key) {
                        $newInst = new Installment();
                        $newInst->loan = $loan->idloan;
                        $newInst->installno = $nos[$key];
                        $newInst->capital = $capitals[$key];
                        $newInst->amort = $amortAmts[$key];
                        $newInst->interest = $intAmts[$key];
                        $newInst->annuity = $annAmts[$key];
                        $newInst->tax = $taxAmts[$key];
                        $newInst->total = $totAmts[$key];
                        $newInst->instdate = getsDate(str_replace('/', '-', $dates[$key]));
                        $newInst->save();
                    }
                }
            } else if ($installs->count() > $nbrinst) {
                foreach ($installs as $key => $install) {
                    if (array_key_exists($key, $nos)) {
                        $install->capital = $capitals[$key];
                        $install->amort = $amortAmts[$key];
                        $install->interest = $intAmts[$key];
                        $install->annuity = $annAmts[$key];
                        $install->tax = $taxAmts[$key];
                        $install->total = $totAmts[$key];
                        $install->instdate = getsDate(str_replace('/', '-', $dates[$key]));
                        $install->update((array)$install);
                    } else {
                        $install->delete();
                    }
                }
            } else if (($installs->count() === $nbrinst)) {
                foreach ($installs as $key => $install) {
                    $install->capital = $capitals[$key];
                    $install->amort = $amortAmts[$key];
                    $install->interest = $intAmts[$key];
                    $install->annuity = $annAmts[$key];
                    $install->tax = $taxAmts[$key];
                    $install->total = $totAmts[$key];
                    $install->instdate = getsDate(str_replace('/', '-', $dates[$key]));
                    $install->update((array)$install);
                }
            }

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.ressave'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.ressave'));
        }
    }
}
