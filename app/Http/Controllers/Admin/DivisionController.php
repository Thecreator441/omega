<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class DivisionController extends Controller
{
    public function index()
    {
        $countries = DB::table('countries')->get();
        $regions = DB::table('regions')->get();
        $divisions = DB::table('divisions')->get();

        return view('admin.pages.division', ['divisions' => $divisions, 'regions' => $regions, 'countries' => $countries]);
    }

    public function store()
    {
        $division = new Division();

        $division->labelfr = Request::input('labelfr');
        $division->labeleng = Request::input('labeleng');
        $division->idregi = Request::input('region');

        $division->save();

        return Redirect::back();
    }

    public function delete(Request $request): \Illuminate\Http\RedirectResponse
    {
        DB::table('divisions')->where('iddiv', '=', $request->id)->delete();

        return Redirect::back();
    }
}
