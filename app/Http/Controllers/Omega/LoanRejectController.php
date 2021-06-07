<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\DemComaker;
use App\Models\DemLoan;
use App\Models\DemMortgage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class LoanRejectController extends Controller
{
    public static function store()
    {
//        dd(Request::all());
        DB::beginTransaction();

        $idloan = Request::input('loan');

        try {
            $demLoan = DemLoan::getLoan($idloan);

            if ($demLoan->guarantee === 'F') {
                $demcoMakers = DemComaker::getComakers($demLoan->iddemloan);
                foreach ($demcoMakers as $demcoMaker) {
                    $demcoMaker->status = 'R';
                    $demcoMaker->update((array)$demcoMaker);
                }
            }
            if ($demLoan->guarantee === 'M') {
                $demMortgages = DemMortgage::getMortgages($demLoan->iddemloan);
                foreach ($demMortgages as $demMortgage) {
                    $demMortgage->status = 'R';
                    $demMortgage->update((array)$demMortgage);
                }
            }
            if ($demLoan->guarantee === 'F&M') {
                $demcoMakers = DemComaker::getComakers($demLoan->iddemloan);
                if ($demcoMakers->count() !== 0) {
                    foreach ($demcoMakers as $demcoMaker) {
                        $demcoMaker->status = 'R';
                        $demcoMaker->update((array)$demcoMaker);
                    }
                }
                $demMortgages = DemMortgage::getMortgages($demLoan->iddemloan);
                if ($demMortgages->count() !== 0) {
                    foreach ($demMortgages as $demMortgage) {
                        $demMortgage->status = 'R';
                        $demMortgage->update((array)$demMortgage);
                    }
                }
            }
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
}
