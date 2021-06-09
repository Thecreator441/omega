<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Billeting;
use App\Models\Currency;
use App\Models\Money;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class MoneyController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $currencies = Currency::getCurrencies();
            $moneys = Money::getMoneys();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));
            
            return view('omega.pages.money', compact('menu', 'currencies', 'moneys'));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    /**
    * @return \Illuminate\Http\RedirectResponse
    */
//    public function store(): \Illuminate\Http\RedirectResponse
//    {
//        DB::beginTransaction();
//        try {
//            $idcurrency = Request::input('id');
//            $currency = null;

//            if ($idcurrency === null) {
//                $currency = new Currency();
//            } else {
//                $currency = Currency::getCurrency($idcurrency);
//            }

//            $currency->label = Request::input('name');
//            $currency->symbol = Request::input('symbol');
//            $currency->format = Request::input('format');

//            if ($idcurrency === null) {
//                $currency->save();
//            } else {
//                $currency->update((array)$currency);
//            }

//            DB::commit();
//            if ($idcurrency === null) {
//                return Redirect::back()->with('success', trans('alertSuccess.cursave'));
//            }
//            return Redirect::back()->with('success', trans('alertSuccess.curedit'));
//        } catch (\Exception $ex) {
//            DB::rollBack();
//            dd($ex);
//            if ($idcurrency === null) {
//                return Redirect::back()->with('danger', trans('alertDanger.cursave'));
//            }
//            return Redirect::back()->with('danger', trans('alertDanger.curedit'));
//        }
//    }

   /**
    * @return \Illuminate\Http\RedirectResponse
    */
//    public function delete()
//    {
//        $idcurrency = Request::input('currency');

//        DB::beginTransaction();
//        try {
//            Currency::getCurrency($idcurrency)->delete();

//            DB::commit();
//            return Redirect::back()->with('success', trans('alertSuccess.curdel'));
//        } catch (\Exception $ex) {
//            DB::rollBack();
//            dd($ex);
//            return Redirect::back()->with('danger', trans('alertDanger.curdel'));
//        }
//    }

    public function store()
    {
        $billeting = [
            'value' => Request::input('value'),
            'format' => Request::input('format'),
            'labeleng' => Request::input('labeleng'),
            'labelfr' => Request::input('labelfr'),
            'idcurrency' => Request::input('currency')
        ];

        if (Billeting::insertData($billeting)) {
            return Redirect::back()->with('success', 'Billeting Successfully Saved');
        }
        return Redirect::back()->with('danger', 'Billeting not Saved');
    }

    public function delete()
    {
        if (Billeting::deleteData(Request::input('id'))) {
            return 'success';
        }
        return 'danger';
    }
}
