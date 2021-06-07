<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\LoanType;
use Illuminate\Support\Facades\Redirect;

class DelinquencyReportController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $loanTypes = LoanType::getLoanTypes();

            return view('omega.pages.delinquency_report', [
                'loanTypes' => $loanTypes
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }
}
