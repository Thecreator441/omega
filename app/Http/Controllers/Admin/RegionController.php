<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class RegionController extends Controller
{
    public function index()
    {
        $countries = DB::table('countries')->get();
        $regions = DB::table('regions')->get();

        return view('admin.pages.region', ['regions' => $regions, 'countries' => $countries]);
    }

    public function store()
    {
        $region = new Region();

        $region->labelfr = Request::input('labelfr');
        $region->labeleng = Request::input('labeleng');
        $region->idcountry = Request::input('country');

        $region->save();

        return Redirect::back();
    }

    public function delete(Request $request): \Illuminate\Http\RedirectResponse
    {
        DB::table('regions')->where('idregi', '=', $request->id)->delete();

        return Redirect::back();
    }
}
