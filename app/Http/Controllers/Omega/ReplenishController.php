<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\Cash_ReplenClose_Init;
use App\Models\Money;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class ReplenishController extends Controller
{
    public function index()
    {
        if (dateOpen()) { 
            if (cashOpen()) {
                $cash = Cash::getEmpCashOpen();
                $cashes = Cash::getOpenCashes();
                $moneys = Money::getMoneys();
                $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

                return view('omega.pages.replenish', compact('menu', 'cash', 'cashes', 'moneys'));
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        // dd(Request::all());
        try {
            DB::beginTransaction();

            if (!dateOpen()) {
                return Redirect::back()->with('danger', trans('alertDanger.opdate'));
                if (!cashOpen()) {
                    return Redirect::back()->with('danger', trans('alertDanger.opencash'));   
                }
            }
            
            $emp = Session::get('employee');
            $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
            $cash_to = Cash::getCashBy(['cashes.status' => 'O', 'cashes.idcash' => Request::input('cashto')]);
            
            $cash_replen_init = Cash_ReplenClose_Init::getCashInit(Request::input('cashto'));
            if ($cash_replen_init === null) {
                $cash_replen_init = new Cash_ReplenClose_Init();
            } else {
                if ($cash_replen_init->cash !== $cash->idcash) {
                    return Redirect::back()->with('danger', trans('alertDanger.already_on_replenishment_by_another_till'));
                }
            }

            $cashSum = Cash::getSumBillet($cash->idcash)->total;
            $cash_toSum = Cash::getSumBillet(Request::input('cashto'))->total;

            if (($cashSum < $cash_toSum) || ($cashSum === $cash_toSum)) {
                return Redirect::back()->with('danger', trans('alertDanger.no_sufficient_funds'));
            }

            $compareCash = compareCash(
                [$cash_to->mon1, $cash_to->mon2, $cash_to->mon3, $cash_to->mon4, $cash_to->mon5, $cash_to->mon6, $cash_to->mon7,
                    $cash_to->mon8, $cash_to->mon9, $cash_to->mon10, $cash_to->mon11, $cash_to->mon12
                ],
                [trimOver(Request::input('B1'), ' '), trimOver(Request::input('B2'), ' '), trimOver(Request::input('B3'), ' '),
                    trimOver(Request::input('B4'), ' '), trimOver(Request::input('B5'), ' '), trimOver(Request::input('P1'), ' '),
                    trimOver(Request::input('P2'), ' '), trimOver(Request::input('P3'), ' '), trimOver(Request::input('P4'), ' '),
                    trimOver(Request::input('P5'), ' '), trimOver(Request::input('P6'), ' '), trimOver(Request::input('P7'), ' ')
                ]
            );
            
            if (!$compareCash) {
                return Redirect::back()->with('danger', trans('alertDanger.no_sufficient_funds_on_input'));
            }

            $cash_replen_init->cash = $cash->idcash;
            $cash_replen_init->mon1 += trimOver(Request::input('B1'), ' ');
            $cash_replen_init->mon2 += trimOver(Request::input('B2'), ' ');
            $cash_replen_init->mon3 += trimOver(Request::input('B3'), ' ');
            $cash_replen_init->mon4 += trimOver(Request::input('B4'), ' ');
            $cash_replen_init->mon5 += trimOver(Request::input('B5'), ' ');
            $cash_replen_init->mon6 += trimOver(Request::input('P1'), ' ');
            $cash_replen_init->mon7 += trimOver(Request::input('P2'), ' ');
            $cash_replen_init->mon8 += trimOver(Request::input('P3'), ' ');
            $cash_replen_init->mon9 += trimOver(Request::input('P4'), ' ');
            $cash_replen_init->mon10 += trimOver(Request::input('P5'), ' ');
            $cash_replen_init->mon11 += trimOver(Request::input('P6'), ' ');
            $cash_replen_init->mon12 += trimOver(Request::input('P7'), ' ');
            $cash_replen_init->init_type = 'R';
            $cash_replen_init->init_cash = Request::input('cashto');
            $cash_replen_init->init_file = null;
            $cash_replen_init->network = $emp->network;
            $cash_replen_init->zone = $emp->zone;
            $cash_replen_init->institution = $emp->institution;
            $cash_replen_init->branch = $emp->branch;

            if ($cash_replen_init === null) {
                $cash_replen_init->save();
            } else {
                $cash_replen_init->update((array)$cash_replen_init);
            }
            
            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.replenish'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.replenish'));
        }
    }
}
