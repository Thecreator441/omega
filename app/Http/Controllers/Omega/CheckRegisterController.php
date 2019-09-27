<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Check;
use App\Models\CheckAccAmt;
use App\Models\Member;
use App\Models\Operation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class CheckRegisterController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $checks = Check::getDroppedChecks();
            $banks = Bank::all();
            $members = Member::getActiveMembers();
            $operas = Operation::all();

            return view('omega.pages.check_register', [
                'checks' => $checks,
                'banks' => $banks,
                'members' => $members,
                'operas' => $operas
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        DB::beginTransaction();
        $provisions = Request::input('provisions');

        try {
            $checks = Check::getDroppedChecks();

            foreach ($provisions as $provision) {
                $idcheck = (int)filter_var($provision, FILTER_SANITIZE_NUMBER_INT);
                $status = preg_replace('!\d+!', '', $provision);

                $check_amts = CheckAccAmt::getChecksAcc($idcheck);
                foreach ($checks as $check) {
                    if ($check->idcheck === $idcheck) {
                        if ($status === 'P') {
                            $check->status = 'P';
                            $check->update((array)$check);

                            foreach ($check_amts as $check_amt) {
                                $check_amt->status = 'P';
                                $check_amt->update((array)$check_amt);
                            }
                        } else if ($status === 'U') {
                            $check->status = 'U';
                            $check->update((array)$check);

                            foreach ($check_amts as $check_amt) {
                                $check_amt->status = 'U';
                                $check_amt->update((array)$check_amt);
                            }
                        }
                    }
                }
            }

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.checkreg'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return Redirect::back()->with('danger', trans('alertDanger.checkreg'));
        }
    }
}
