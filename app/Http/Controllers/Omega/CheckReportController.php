<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Check;
use App\Models\Member;
use App\Models\Operation;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CheckReportController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $emp = Session::get('employee');

            $checks = Check::getChecks();
            $banks = Bank::getBanks();
            $members = Member::getMembers(['members.memstatus' => 'A']);
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            $totalAmt = 0;

            foreach ($checks as $check) {
                $bank = $check->b_labeleng;
                $check->opera = $check->o_labeleng;
                if ($emp->lang === 'fr') {
                    $bank = $check->b_labelfr;
                    $check->opera = $check->o_labelfr;
                }
                $check->bank = pad($check->bankcode, 3) . ' : ' . $bank;

                if($check->member !== null) {
                    foreach ($members as $member) {
                        if ($member->idmember == $check->member) {
                            $check->carrier = pad($member->memnumb, 6) . ' : ' . $member->name . ' ' . $member->surname;
                        }
                    }
                }

                if ($check->status === 'D') {
                    $check->state = 'Dropped';
                } else if ($check->status === 'P') {
                    $check->state = 'Paid';
                } else if ($check->status === 'U') {
                    $check->state = 'Unpaid';
                }

                if ($emp->lang === 'fr') {
                    if ($check->status === 'D') {
                        $check->state = 'Déposés';
                    } else if ($check->status === 'P') {
                        $check->state = 'Payés';
                    } else if ($check->status === 'U') {
                        $check->state = 'Impayés';
                    }
                }

                $totalAmt += $check->amount;

            }

            return view('omega.pages.check_report', compact('checks', 'banks', 'members', 'menu', 'totalAmt'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

}
