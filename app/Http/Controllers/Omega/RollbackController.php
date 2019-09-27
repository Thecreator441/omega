<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;

class RollbackController extends Controller
{
    public function index()
    {
        return view('omega.pages.rollback');
    }
}
