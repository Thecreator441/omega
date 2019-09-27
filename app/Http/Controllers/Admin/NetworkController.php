<?php

namespace App\Http\Controllers\Admin;

use App\Models\Network;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class NetworkController extends Controller
{
    public function index()
    {
        $network = DB::table('networks')->get();

        return view('admin.pages.network', ['networks' => $network,]);
    }
    public function store()
    {
        $network = new Network();

        $network->name = Request::input('name');
        $network->phone1 = Request::input('phone1');
        $network->phone2 = Request::input('phone2');
        $network->email = Request::input('email');
        $network->country = Request::input('country');
        $network->region = Request::input('region');
        $network->town = Request::input('town');
        $network->address = Request::input('address');
        $network->postcode = Request::input('postcode');

        $network->save();

        return Redirect::back();
    }

    public function delete(Request $request): \Illuminate\Http\RedirectResponse
    {
        DB::table('networks')->where('idnetwork', '=', $request->id)->delete();

        return Redirect::back();
    }
}
