<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccType;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class AccTypeController extends Controller
{
    public function index()
    {
        return view('admin.pages.acctype')->with('acctypes', AccType::all());
    }

    public function store()
    {
        $acctype = [
            'labelfr' => Request::input('labelfr'),
            'labeleng' => Request::input('labeleng')
        ];
        if (AccType::insertData($acctype)) {
            return Redirect::back()->with('success', 'Account Type Successfully Saved');
        }
        return Redirect::back()->with('danger', 'Account Type not Saved');
    }

    public function delete(): \Illuminate\Http\RedirectResponse
    {
        if (AccType::deleteData(Request::input('id'))) {
            return Redirect::back()->with('success', 'Account Type Successfully Deleted');
        }
        return Redirect::back()->with('danger', 'Account Type not Deleted');
    }
}
