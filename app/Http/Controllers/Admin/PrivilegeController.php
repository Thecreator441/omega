<?php

namespace App\Http\Controllers\Admin;

use App\Models\Privilege;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class PrivilegeController extends Controller
{
    public function index()
    {
        $pri = DB::table('privileges')->get();

        return view('admin.pages.privilege', ['privileges'=> $pri]);

    }
    public function store()
    {
        $pri = new Privilege();

        $pri->labeleng = Request::input('englishlabel');
        $pri->labelfr = Request::input('frenchlabel');
        $pri->level = Request::input('level');

        $pri->save();

        return Redirect::back();
    }

    public function delete(Request $request): \Illuminate\Http\RedirectResponse
    {
        DB::table('privileges')->where('idpriv', $request->id)->delete();

        return Redirect::back();
    }
}
