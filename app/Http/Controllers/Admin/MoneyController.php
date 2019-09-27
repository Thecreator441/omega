<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Billeting;
use App\Models\Currency;
use App\Models\Money;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class MoneyController extends Controller
{
    public function index()
    {
        $moneys = Money::all();
        $currencies = Currency::all();

        return view('admin.pages.money', [
            'moneys' => $moneys,
            'currencies' => $currencies
        ]);
    }

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
