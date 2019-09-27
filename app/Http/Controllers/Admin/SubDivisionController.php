<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubDiv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class SubDivisionController extends Controller
{
    public function index()
    {
        $countries = DB::table('countries')->get();
        $regions = DB::table('regions')->get();
        $divisions = DB::table('divisions')->get();
        $subdivisions = DB::table('sub_divs')->get();

        return view('admin.pages.subdivision', [
            'subdivisions' => $subdivisions,
            'divisions' => $divisions,
            'regions' => $regions,
            'countries' => $countries]);
    }

    public function store()
    {
        $subDiv = new SubDiv();

        $subDiv->labelfr = Request::input('labelfr');
        $subDiv->labeleng = Request::input('labeleng');
        $subDiv->iddiv = Request::input('division');

        $subDiv->save();

        return Redirect::back();
    }

    public function delete(Request $request): \Illuminate\Http\RedirectResponse
    {
        DB::table('sub_divs')->where('idsub', '=', $request->id)->delete();

        return Redirect::back();
    }
}
