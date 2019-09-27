<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Check;
use App\Models\Member;
use App\Models\Operation;
use Illuminate\Support\Facades\Redirect;

class CheckReportController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $checks = Check::getChecks();
            $banks = Bank::all();
            $members = Member::getActiveMembers();
            $operas = Operation::all();

            return view('omega.pages.check_report', [
                'checks' => $checks,
                'banks' => $banks,
                'members' => $members,
                'operas' => $operas
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

}
