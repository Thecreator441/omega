<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Account;
use App\Models\MemBalance;
use App\Models\Cash;
use App\Models\Member;
use App\Models\Money;
use App\Models\Operation;
use App\Models\Priv_Menu;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PDF;
use SnappyPDF;

class CashOutController extends Controller
{
    public function index()
    {
        $members = Member::getMembers(['members.memstatus' => 'A']);
        $cash = Cash::getEmpCashOpen();
        $moneys = Money::getMoneys();
        $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

        return view('omega.pages.cash_out', compact('menu', 'members', 'cash', 'moneys'));
    }

    public function store()
    {
        // dd(Request::all());
        try {
            DB::beginTransaction();
            
            $emp = Session::get('employee');

            $writnumb = getWritNumb();
            $accdate = AccDate::getOpenAccDate();
            $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
            $operation = Operation::getOperation(Request::input('menu_level_operation'));
            
            $accounts = Request::input('accounts');
            $operations = Request::input('operations');
            $amounts = Request::input('amounts');
            $fees = Request::input('fees');

            $cash->mon1 -= (int)trimOver(Request::input('B1'), ' ');
            $cash->mon2 -= (int)trimOver(Request::input('B2'), ' ');
            $cash->mon3 -= (int)trimOver(Request::input('B3'), ' ');
            $cash->mon4 -= (int)trimOver(Request::input('B4'), ' ');
            $cash->mon5 -= (int)trimOver(Request::input('B5'), ' ');
            $cash->mon6 -= (int)trimOver(Request::input('P1'), ' ');
            $cash->mon7 -= (int)trimOver(Request::input('P2'), ' ');
            $cash->mon8 -= (int)trimOver(Request::input('P3'), ' ');
            $cash->mon9 -= (int)trimOver(Request::input('P4'), ' ');
            $cash->mon10 -= (int)trimOver(Request::input('P5'), ' ');
            $cash->mon11 -= (int)trimOver(Request::input('P6'), ' ');
            $cash->mon12 -= (int)trimOver(Request::input('P7'), ' ');
            $cash->update((array)$cash);

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $cash->cashacc;
            $writing->creditamt = (int)trimOver(Request::input('totrans'), ' ');
            $writing->operation = Request::input('menu_level_operation');
            $writing->accdate = $accdate->accdate;
            $writing->employee = $emp->iduser;
            $writing->cash = $cash->idcash;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->writ_type = 'O';
            $writing->represent = Request::input('represent');
            $writing->save();

            $cashBal = Account::getAccount($cash->cashacc);
            $cashBal->available -= (int)trimOver(Request::input('totrans'), ' ');
            $cashBal->update((array)$cashBal);
            
            foreach ($accounts as $key => $account) {
                $amount = (int)trimOver($amounts[$key], ' ') + (int)trimOver($fees[$key], ' ');

                if ($amount !== 0) {
                    $writing = new Writing();
                    $writing->writnumb = $writnumb;
                    $writing->account = $account;
                    $writing->mem_aux = Request::input('member');
                    $writing->operation = $operations[$key];
                    $writing->debitamt = $amount;
                    $writing->accdate = $accdate->accdate;
                    $writing->employee = $emp->iduser;
                    $writing->cash = $cash->idcash;
                    $writing->network = $emp->network;
                    $writing->zone = $emp->zone;
                    $writing->institution = $emp->institution;
                    $writing->branch = $emp->branch;
                    $writing->writ_type = 'O';
                    $writing->represent = Request::input('represent');
                    $writing->save();

                    $memBal = MemBalance::getMemAcc(Request::input('member'), $account);
                    $memBal->available -= $amount;
                    $memBal->update((array)$memBal);
                }
            }

            $date = date("d.m.Y");
            $time = date("H.i.s");
            $file = "storage/files/printings/{$emp->name}_{$date}_{$time}.pdf";
            $pdf = PDF::loadView('printings.cash_out', compact('accounts', 'operations', 'amounts', 'fees'));
            
            $pdf->save($file);

            if ($emp->lang === 'fr') {
                Log::info($operation->labelfr);
            } else {
                Log::info($operation->labeleng);
            }

            DB::commit();
            Session::flash('cash_out', $file);
            return Redirect::back()->with('success', trans('alertSuccess.cash_out'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.cash_out'));
        }
    }
}
