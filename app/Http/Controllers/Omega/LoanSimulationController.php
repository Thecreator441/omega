<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Support\Facades\Redirect;

class LoanSimulationController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $members = Member::getActiveMembers();

            return view('omega.pages.loan_simulation', [
                'members' => $members
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }
}
