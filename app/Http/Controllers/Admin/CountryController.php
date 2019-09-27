<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::getData();
        $currencies = Currency::getData();

        return view('admin.pages.country')->with(['countries' => $countries, 'currencies' => $currencies]);
    }

    public function store()
    {
        $country = [
            'labelfr' => Request::input('labelfr'),
            'labeleng' => Request::input('labeleng'),
            'isocode' => Request::input('isocode'),
            'phonecode' => Request::input('phonecode'),
            'idcurrency' => Request::input('currency')
        ];

        if (Currency::insertData($country)) {
            return Redirect::back()->with('success', 'Country Successfully Saved');
        }
        return Redirect::back()->with('danger', 'Country not Saved');
    }

    public function delete(Request $request): \Illuminate\Http\RedirectResponse
    {
        if (Country::deleteData($request->id)) {
            return Redirect::back()->with('success', 'Country successfully Deleted');
        }
        return Redirect::back()->with('danger', 'Country not Delete');
    }
}
