<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class CurrencyController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $currencies = Currency::getCurrencies();
        $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

        return view('omega.pages.currency', compact('menu', 'currencies'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(): \Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();
        try {
            $idcurrency = Request::input('idcurrency');
            $currency = null;

            if ($idcurrency === null) {
                $currency = new Currency();
            } else {
                $currency = Currency::getCurrency($idcurrency);
            }

            $currency->label = Request::input('name');
            $currency->symbol = Request::input('symbol');
            $currency->format = Request::input('format');

            if ($idcurrency === null) {
                $currency->save();
            } else {
                $currency->update((array)$currency);
            }

            DB::commit();
            if ($idcurrency === null) {
                return Redirect::back()->with('success', trans('alertSuccess.cursave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.curedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idcurrency === null) {
                return Redirect::back()->with('danger', trans('alertDanger.cursave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.curedit'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete()
    {
        $idcurrency = Request::input('currency');

        DB::beginTransaction();
        try {
            Currency::getCurrency($idcurrency)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.curdel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.curdel'));
        }
    }
}
