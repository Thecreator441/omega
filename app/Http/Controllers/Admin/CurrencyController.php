<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class CurrencyController extends Controller
{
    public function index()
    {
        return view('admin.pages.currency')->with('currencies', Currency::getData());
    }

    public function store(): \Illuminate\Http\RedirectResponse
    {
        $currency = [
            'label' => Request::input('label'),
            'format' => Request::input('format')
        ];
        if (Currency::insertData($currency)) {
            return Redirect::back()->with('success', 'Currency Successfully Saved');
        }
        return Redirect::back()->with('danger', 'Currency not Saved');
    }

    public function delete(): \Illuminate\Http\RedirectResponse
    {
        if (Currency::deleteData(Request::input('id'))) {
            return Redirect::back()->with('success', 'Currency Deleted');
        }
        return Redirect::back()->with('danger', 'Currency not Deleted');
    }

}
