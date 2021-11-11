<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Cash;
use App\Models\Collect_Mem;
use App\Models\Collector;
use App\Models\Member;
use App\Models\Operation;
use App\Models\Priv_Menu;
use App\Models\ValWriting;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use PDF;

class TransactionController extends Controller
{
    public function index()
    {
        $emp = Session::get('employee');

        $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
        $writings = ValWriting::getValJournal();
        $debit = ValWriting::getSumDebit();
        $credit = ValWriting::getSumCredit();
        if ($cash !== null) {
            if ($cash->view_other_tills === 'N') {
                $writings = ValWriting::getValJournal(['val_writings.employee' => $emp->iduser]);
                $debit = ValWriting::getSumDebit(['val_writings.employee' => $emp->iduser]);
                $credit = ValWriting::getSumCredit(['val_writings.employee' => $emp->iduser]);
            }
        }
        
        $employees = Cash::getCashes();
        $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

        foreach ($writings as $writing) {
            $aux = null;
            if ($writing->mem_aux !== null) {
                $member = Member::getMember($writing->mem_aux);
                $writing->code = pad($member->memnumb, 6);
                $writing->name = $member->name;
                $writing->surname = $member->surname;
            } elseif ($writing->emp_aux !== null) {
                $employee = Employee::getEmployee($writing->emp_aux);
                $writing->code = pad($employee->empmat, 6);
                $writing->name = $employee->name;
                $writing->surname = $employee->surname;
            }
            
            if (is_numeric($writing->operation)) {
                $opera = Operation::getOperation($writing->operation);
                $writing->operation = $opera->labeleng;
                if ($emp->lang === 'fr') {
                    $writing->operation = $opera->labelfr;
                }
            }
        }
        
        return view('omega.pages.transaction', compact('writings', 'debit', 'credit', 'cash', 'employees', 'menu'));
    }

    public function print() {
        // return Request::all();
        $user = null;
        if (Request::input('user') !== null) {
            $user = User::getUserInfos(Request::input('user'));
        } else {
            $user =  Session::get('employee');
        }
        
        $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));
        $result = ValWriting::getValidJournals(Request::input('network'), Request::input('zone'), Request::input('institution'), Request::input('branch'), Request::input('user'), Request::input('state'), Request::input('from'), Request::input('to'), Request::input('lang'));

        $writings = $result['data'];
        if ((int)count($writings) > 0) {
            $sumCredit = $result['sumCredit'];
            $sumDebit = $result['sumDebit'];
            $sumBal = $result['sumBal'];
            
            $date = date("d.m.Y");
            $time = date("H.i.s");
            
            $file_name = pad($user->network) . "" . pad($user->zone) . "" . pad($user->institution) . "" . pad($user->branch) . "-{$date}_{$time}.pdf";
            $file = "storage/files/printings/reports/" . $file_name;
            $pdf = PDF::loadView('omega.printings.transaction', compact('writings', 'sumCredit', 'sumDebit', 'sumBal', 'menu'));
        
            if($pdf->save($file)) {
                return $file;
            }
        }
    }
}
