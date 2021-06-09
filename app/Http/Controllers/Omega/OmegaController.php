<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class OmegaController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/');
        }

        return view('omega.index');
    }
}
