<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Check;
use App\Models\CheckAccAmt;
use App\Models\Member;
use App\Models\Operation;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CheckRegisterController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $emp = Session::get('employee');

            $checks = Check::getChecks(['checks.status' => 'D', 'checks.type' => 'I', 'checks.sorted' => 'N']);
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

            return view('omega.pages.check_register', compact('checks', 'banks', 'members', 'menu', 'totalAmt'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        // dd(Request::all());
        try {
            DB::beginTransaction();

            $provisions = Request::input('provisions');

            foreach ($provisions as $provision) {
                $idcheck = (int)filter_var($provision, FILTER_SANITIZE_NUMBER_INT);
                $status = preg_replace('!\d+!', '', $provision);

                $check = Check::getCheckOnly($idcheck);

                $check->status = $status;
                $check->update((array)$check);
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
