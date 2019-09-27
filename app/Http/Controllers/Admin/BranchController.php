<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class BranchController extends Controller
{
    public function index()
    {
        $institution = DB::table('institutions')->get();
        $branchs = DB::table('branches')->get();

        return view('admin.pages.branch', ['branches' => $branchs, 'institutions' => $institution]);
    }

    public function store()
    {
        $branchs = new Branch();

        $branchs->name = Request::input('name');
        $branchs->phone1 = Request::input('phone1');
        $branchs->phone2 = Request::input('phone2');
        $branchs->email = Request::input('email');
        $branchs->region = Request::input('region');
        $branchs->town = Request::input('town');
        $branchs->address = Request::input('address');
        $branchs->postcode = Request::input('postcode');
        $branchs->idinst = Request::input('idinst');

        $branchs->save();

        return Redirect::back();
    }

    public function delete(Request $request): \Illuminate\Http\RedirectResponse
    {
        DB::table('branches')->where('idbranch', $request->id)->delete();

        return Redirect::back();
    }
}
