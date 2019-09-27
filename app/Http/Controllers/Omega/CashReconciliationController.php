<?php

namespace App\Http\Controllers\Omega;

use App\Models\AccDate;
use App\Models\Cash;
use App\Models\Employee;
use App\Models\Money;
use App\Models\Operation;
use App\Models\ValWriting;
use App\Models\Writing;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CashReconciliationController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            if (cashOpen()) {
                $writings = Writing::getWritings();
                $valwritings = ValWriting::getValWritings();
                $cashes = Cash::getPaginateOpen();
                $employees = Employee::getEmployees(['privilege' => 3]);
                $moneys = Money::getMoneys();
                $operas = Operation::all();

                return view('omega.pages.cash_reconciliation', [
                    'valwritings' => $valwritings,
                    'writings' => $writings,
                    'cashes' => $cashes,
                    'employees' => $employees,
                    'moneys' => $moneys,
                    'operas' => $operas,
                ]);
            }
            return Redirect::route('omega')->with('danger', trans('alertDanger.opencash'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        $emp = Session::get('employee');

        $writnumb = Request::input('writnumb');
        $opera = Request::input('opera');
        $amt = trimOver(Request::input('totbil'), ' ');

        DB::beginTransaction();
        try {
            $cash = Cash::getCash(Request::input('idcash'));

            if ($cash->cashcode === 'PC' || $cash->cashcode === 'CP') {
                return Redirect::back()->with('danger', trans('alertDanger.princashclosed'));
            }
//dd(Request::all());
            $cashto = Cash::getEmpCashOpen();
            $accdate = AccDate::getOpenAccDate();

            $cashto->mon1 += Request::input('B1');
            $cashto->mon2 += Request::input('B2');
            $cashto->mon3 += Request::input('B3');
            $cashto->mon4 += Request::input('B4');
            $cashto->mon5 += Request::input('B5');
            $cashto->mon6 += Request::input('P1');
            $cashto->mon7 += Request::input('P2');
            $cashto->mon8 += Request::input('P3');
            $cashto->mon9 += Request::input('P4');
            $cashto->mon10 += Request::input('P5');
            $cashto->mon11 += Request::input('P6');
            $cashto->mon12 += Request::input('P7');
            $cashto->save();

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $cashto->cashacc;
            $writing->operation = $opera;
            $writing->debitamt = $amt;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->cash = $cashto->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $cash->mon1 -= Request::input('B1');
            $cash->mon2 -= Request::input('B2');
            $cash->mon3 -= Request::input('B3');
            $cash->mon4 -= Request::input('B4');
            $cash->mon5 -= Request::input('B5');
            $cash->mon6 -= Request::input('P1');
            $cash->mon7 -= Request::input('P2');
            $cash->mon8 -= Request::input('P3');
            $cash->mon9 -= Request::input('P4');
            $cash->mon10 -= Request::input('P5');
            $cash->mon11 -= Request::input('P6');
            $cash->mon12 -= Request::input('P7');
            $cash->status = 'C';
            $cash->save();

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $cash->cashacc;
            $writing->operation = $opera;
            $writing->creditamt = $amt;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $cash->employee;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $cash->save();

            DB::commit();
            return Redirect::route('cash_reconciliation')->with('success', trans('alertSuccess.cashclosed'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::route('omega')->with('danger', trans('alertDanger.cashclosed'));
        }
    }
}
