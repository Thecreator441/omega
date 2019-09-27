<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\DemComakers;
use App\Models\DemLoan;
use App\Models\DemMortgage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class LoanRejectController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $loans = DemLoan::getAllDemLoans();

            return view('omega.pages.loan_reject', [
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

        try {
            $demLoan = DemLoan::getloan($idloan);

            if ($demLoan->guarantee === 'F') {
                $demcoMakers = DemComakers::getComakers($demLoan->iddemloan);
                if ($demcoMakers->count() !== 0) {
                    foreach ($demcoMakers as $demcoMaker) {
                        $demcoMaker->delete();
                    }
                }
            }
            if ($demLoan->guarantee === 'M') {
                $demMortgages = DemMortgage::getMortgages($demLoan->iddemloan);
                if ($demMortgages->count() !== 0) {
                    foreach ($demMortgages as $demMortgage) {
                        $demMortgage->delete();
                    }
                }
            }
            if ($demLoan->guarantee === 'F&M') {
                $demcoMakers = DemComakers::getComakers($demLoan->iddemloan);
                if ($demcoMakers->count() !== 0) {
                    foreach ($demcoMakers as $demcoMaker) {
                        $demcoMaker->delete();
                    }
                }
                $demMortgages = DemMortgage::getMortgages($demLoan->iddemloan);
                if ($demMortgages->count() !== 0) {
                    foreach ($demMortgages as $demMortgage) {
                        $demMortgage->delete();
                    }
                }
            }
//            $demLoan->delete();
            $demLoan->status = 'R';
            $demLoan->update((array)$demLoan);

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.rejectsave'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.rejectsave'));
        }
    }
}
