<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Employee;
use App\Models\LoanType;
use App\Models\Operation;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class ProvisionReportController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $loanTypes = LoanType::getLoanTypes();
            $employees = Employee::getEmployees(['privilege' => 6]);

            return view('omega.pages.provision_report', [
                'loanTypes' => $loanTypes,
                'emprofs' => $employees
            ]);
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function store()
    {
        DB::beginTransaction();
        $emp = Session::get('employee');

        $provs = Request::input('provs');
        $amounts = Request::input('amounts');
        $totamt = 0;

        try {
            $writnumb = getWritNumb();
            $accdate = AccDate::getOpenAccDate();
            $opera1 = Operation::getByCode(61);
            $opera2 = Operation::getByCode(62);
            $acc1 = 414;
            $acc2 = 232;

            foreach ($provs as $prov) {
                $key = (int)$prov;
                if (!empty($amounts[$key]) && $amounts[$key] !== null && $amounts[$key] !== '0') {
                    $totamt += (int)trimOver($amounts[$key], ' ');
                }
            }

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $acc1;
            $writing->operation = $opera1->idoper;
            $writing->debitamt = $totamt;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

            $writing = new Writing();
            $writing->writnumb = $writnumb;
            $writing->account = $acc2;
            $writing->operation = $opera2->idoper;
            $writing->creditamt = $totamt;
            $writing->accdate = $accdate->idaccdate;
            $writing->employee = $emp->idemp;
            $writing->network = $emp->network;
            $writing->zone = $emp->zone;
            $writing->institution = $emp->institution;
            $writing->branch = $emp->branch;
            $writing->save();

//            foreach ($amounts as $key => $amount) {
//                if (!empty($amount) && $amount !== null && $amount !== '0') {
//                    if (array_key_exists($key, $provs)) {
//                        $writing = new Writing();
//                        $writing->writnumb = $writnumb;
//                        $writing->account = $acc2;
//                        $writing->operation = $opera2->idoper;
//                        $writing->creditamt = trimOver($amount, ' ');
//                        $writing->accdate = $accdate->idaccdate;
//                        $writing->employee = $emp->idemp;
//                        $writing->network = $emp->network;
//                        $writing->zone = $emp->zone;
//                        $writing->institution = $emp->institution;
//                        $writing->branch = $emp->branch;
//                        $writing->save();
//                    }
//                }
//            }

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.memsave'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->with('danger', trans('alertDanger.memsave'));
        }
    }

}
