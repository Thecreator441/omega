<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class PersonalisationController extends Controller
{
    public function index()
    {
        return view('omega.pages.personalisation');
    }
}
