<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\MemSetting;
use App\Models\Operation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class MemSettingController extends Controller
{
    public function index()
    {
        $accounts = Account::getAccounts();
        $operas = Operation::getOperations();
        $mem_sets = MemSetting::getMemSettings();

        return view('omega.pages.mem_setting')->with([
            'accounts' => $accounts,
            'operas' => $operas,
            'mem_sets' => $mem_sets
        ]);
    }

    public function store()
    {
        dd(Request::all());
        DB::beginTransaction();
        $emp = Session::get('employee');

        $classes = Request::input('classes');
        $accounts = Request::input('accounts');
        $operations = Request::input('operations');
        $amounts = Request::input('amounts');
        $classes2 = Request::input('classes2');
        $accounts2 = Request::input('accounts2');
        $operations2 = Request::input('operations2');
        $amounts2 = Request::input('amounts2');

        try {
            $mem_setting = new MemSetting();

            if (isset($accounts)) {
                foreach ($accounts as $key => $account) {
                    if (!empty($amounts[$key]) || $amounts[$key] !== null) {
                        $mem_setting->accplan = $account;
                        $mem_setting->operation = $operations[$key];
                        $mem_setting->type = 'C';
                        $mem_setting->amount = $amounts[$key];
                        $mem_setting->institution = $emp->institution;
                        $mem_setting->branch = $emp->branch;
                    }
                }
            }

            if (isset($accounts2)) {
                foreach ($accounts2 as $key => $account) {
                    if (!empty($amounts2[$key]) || $amounts2[$key] !== null) {
                        $mem_setting->accplan = $account;
                        $mem_setting->operation = $operations2[$key];
                        $mem_setting->type = 'G';
                        $mem_setting->amount = $amounts2[$key];
                        $mem_setting->institution = $emp->institution;
                        $mem_setting->branch = $emp->branch;
                    }
                }
            }

            if (isset($classes)) {
                foreach ($classes as $class) {
                    MemSetting::getMemSetting($class)->delete();
                }
            }

            if (isset($classes2)) {
                foreach ($classes2 as $class) {
                    MemSetting::getMemSetting($class)->delete();
                }
            }

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.memset'));
        } catch (\Exception  $ex) {
            dd($ex);
            DB::rollback();
            return Redirect::back()->with('danger', trans('alertDanger.memset'));
        }
    }
}
