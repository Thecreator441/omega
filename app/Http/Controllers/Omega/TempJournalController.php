<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\Employee;
use App\Models\Member;
use App\Models\Operation;
use App\Models\Priv_Menu;
use App\Models\Writing;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use PDF;

class TempJournalController extends Controller
{
    public function index()
    {
        $emp = Session::get('employee');

        $cash = Cash::getCashBy(['cashes.status' => 'O', 'cashes.employee' => $emp->iduser]);
        $writings = Writing::getWritings();
        $debit = Writing::getSumDebit();
        $credit = Writing::getSumCredit();
        if ($cash !== null) {
            if ($cash->view_other_tills === 'N') {
                $writings = Writing::getWritings(['writings.employee' => $emp->iduser]);
                $debit = Writing::getSumDebit(['writings.employee' => $emp->iduser]);
                $credit = Writing::getSumCredit(['writings.employee' => $emp->iduser]);
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
        
        return view('omega.pages.temp_journal', compact('menu', 'writings', 'debit', 'credit', 'employees'));
    }

    public function print() {
        // return Request::all();
        $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));
        $result = Writing::getJournals(Request::input('network'), Request::input('zone'), Request::input('institution'), Request::input('branch'), Request::input('user'), Request::input('state'), Request::input('lang'));

        $writings = $result['data'];
        if ((int)count($writings) > 0) {
            $sumCredit = $result['sumCredit'];
            $sumDebit = $result['sumDebit'];
            $sumBal = $result['sumBal'];
            
            $date = date("d.m.Y");
            $time = date("H.i.s");
            
            $file_name = "{$date}_{$time}.pdf";

            $pdf = PDF::loadView('omega.printings.temp_journal', compact('writings', 'sumCredit', 'sumDebit', 'sumBal', 'menu'));
        
            return $pdf->stream($file_name);
        }
    }
}
