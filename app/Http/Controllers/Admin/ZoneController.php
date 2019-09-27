<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class ZoneController extends Controller
{
    public function index()
    {

        $zone = DB::table('zones')->orderBy('idzone', 'desc')->get();
        $network = DB::table('networks')->get();

        return view('admin.pages.zone', ['zones' => $zone, 'networks' => $network]);

    }

    public function store()
    {
        $zone = new Zone();

        $zone->name = Request::input('name');
        $zone->phone1 = Request::input('phone1');
        $zone->phone2 = Request::input('phone2');
        $zone->email = Request::input('email');
        $zone->country = Request::input('country');
        $zone->idnetwork = Request::input('network');
        $zone->region = Request::input('region');
        $zone->town = Request::input('town');
        $zone->address = Request::input('address');
        $zone->postcode = Request::input('postcode');

        $zone->save();

        return Redirect::back();
    }

    public function delete(Request $request): \Illuminate\Http\RedirectResponse
    {
        DB::table('zones')->where('idzone', $request->id)->delete();

        return Redirect::back();
    }
}
