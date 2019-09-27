<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class InstitutionController extends Controller
{
    public function index()
    {
        $institution = DB::table('institutions')->get();
        $zone = DB::table('zones')->get();

        return view('admin.pages.institution', ['institutions' => $institution, 'zones' => $zone]);
    }

    public function store()
    {
        $ins = new Institution();

        $ins->name = Request::input('name');
        $ins->phone1 = Request::input('phone1');
        $ins->phone2 = Request::input('phone2');
        $ins->email = Request::input('email');
        $ins->region = Request::input('region');
        $ins->town = Request::input('town');
        $ins->address = Request::input('address');
        $ins->postcode = Request::input('postcode');
        $ins->idzone = Request::input('zone');

        $ins->save();

        return Redirect::back();
    }

    public function delete(Request $request): \Illuminate\Http\RedirectResponse
    {
        DB::table('institutions')->where('idinst', '=', $request->id)->delete();

        return Redirect::back();
    }
}
