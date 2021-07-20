<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Cash;
use App\Models\Cash_ReplenClose_Init;
use App\Models\Cash_Writing;
use App\Models\Money;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class ReceptionController extends Controller
{
    public function index()
    {
        if (dateOpen()) { 
            if (cashOpen()) {
                $cash = Cash::getEmpCashOpen();
                $cash_replen_init = Cash_ReplenClose_Init::getCashInitBy(['init_cash' => $cash->idcash]);
                if ($cash_replen_init === null) {
                    return Redirect::route('omega')->with('danger', trans('alertDanger.no_funds_reception'));
                }
                $cashes = Cash::getOpenCashes();
                $moneys = Money::getMoneys();
                $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

                return view('omega.pages.reception', compact('menu', 'cashes', 'moneys', 'cash_replen_init'));
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

            $cash_writnumb = getCashWritNumb();
            $accdate = AccDate::getOpenAccDate();
            
            $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
            $cash_fr = Cash::getCashBy(['cashes.status' => 'O', 'cashes.idcash' => Request::input('cashfr')]);
            if (!cashOpen($cash_fr->employee)) {
                return Redirect::back()->with('danger', trans('alertDanger.open_cash_from'));
            }

            $cashSum = Cash::getSumBillet($cash->idcash)->total;
            $cash_frSum = Cash::getSumBillet(Request::input('cashfr'))->total;

            if (($cashSum > $cash_frSum) || ($cashSum === $cash_frSum)) {
                return Redirect::back()->with('danger', trans('alertDanger.no_sufficient_funds'));
            }

            $compareCash = compareCash(
                [$cash_fr->mon1, $cash_fr->mon2, $cash_fr->mon3, $cash_fr->mon4, $cash_fr->mon5, $cash_fr->mon6, $cash_fr->mon7,
                    $cash_fr->mon8, $cash_fr->mon9, $cash_fr->mon10, $cash_fr->mon11, $cash_fr->mon12
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

            $cash->mon1 += trimOver(Request::input('B1'), ' ');
            $cash->mon2 += trimOver(Request::input('B2'), ' ');
            $cash->mon3 += trimOver(Request::input('B3'), ' ');
            $cash->mon4 += trimOver(Request::input('B4'), ' ');
            $cash->mon5 += trimOver(Request::input('B5'), ' ');
            $cash->mon6 += trimOver(Request::input('P1'), ' ');
            $cash->mon7 += trimOver(Request::input('P2'), ' ');
            $cash->mon8 += trimOver(Request::input('P3'), ' ');
            $cash->mon9 += trimOver(Request::input('P4'), ' ');
            $cash->mon10 += trimOver(Request::input('P5'), ' ');
            $cash->mon11 += trimOver(Request::input('P6'), ' ');
            $cash->mon12 += trimOver(Request::input('P7'), ' ');
            $cash->update((array)$cash);

            $cash_writing = new Cash_Writing();
            $cash_writing->writnumb = $cash_writnumb;
            $cash_writing->account = $cash->cashacc;
            $cash_writing->operation = Request::input('menu_level_operation');
            $cash_writing->debitamt = Request::input('totamt');
            $cash_writing->accdate = $accdate->accdate;
            $cash_writing->employee = $emp->iduser;
            $cash_writing->cash = $cash->idcash;
            $cash_writing->network = $emp->network;
            $cash_writing->zone = $emp->zone;
            $cash_writing->institution = $emp->institution;
            $cash_writing->branch = $emp->branch;
            $cash_writing->save();

            $cash_fr->mon1 -= trimOver(Request::input('B1'), ' ');
            $cash_fr->mon2 -= trimOver(Request::input('B2'), ' ');
            $cash_fr->mon3 -= trimOver(Request::input('B3'), ' ');
            $cash_fr->mon4 -= trimOver(Request::input('B4'), ' ');
            $cash_fr->mon5 -= trimOver(Request::input('B5'), ' ');
            $cash_fr->mon6 -= trimOver(Request::input('P1'), ' ');
            $cash_fr->mon7 -= trimOver(Request::input('P2'), ' ');
            $cash_fr->mon8 -= trimOver(Request::input('P3'), ' ');
            $cash_fr->mon9 -= trimOver(Request::input('P4'), ' ');
            $cash_fr->mon10 -= trimOver(Request::input('P5'), ' ');
            $cash_fr->mon11 -= trimOver(Request::input('P6'), ' ');
            $cash_fr->mon12 -= trimOver(Request::input('P7'), ' ');
            $cash_fr->update((array)$cash_fr);

            $cash_writing = new Cash_Writing();
            $cash_writing->writnumb = $cash_writnumb;
            $cash_writing->account = $cash_fr->cashacc;
            $cash_writing->operation = Request::input('menu_level_operation');
            $cash_writing->creditamt = Request::input('totamt');
            $cash_writing->accdate = $accdate->accdate;
            $cash_writing->employee = $emp->iduser;
            $cash_writing->cash = $cash_fr->idcash;
            $cash_writing->network = $emp->network;
            $cash_writing->zone = $emp->zone;
            $cash_writing->institution = $emp->institution;
            $cash_writing->branch = $emp->branch;
            $cash_writing->save();

            $cash_replen_init = Cash_ReplenClose_Init::getCashInitBy(['init_cash' => $cash->idcash]);
            if ($cash_replen_init === null) {
                return Redirect::back()->with('danger', trans('alertDanger.no_funds_reception'));
            } else {
                $cash_replen_init->delete();
            }

            DB::commit();
            return Redirect::route('omega')->with('success', trans('alertSuccess.reception'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.reception'));
        }
    }
}
