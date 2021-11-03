<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class VerifySessionPrivilege
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('employee')) {
            $emp = Session::get('employee');
            if (count(Request::all()) > 0) {
                if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
                    return $next($request);
                }
                return Redirect::back()->with('danger', trans('auth.unauthorised'));
            }
            return $next($request);
        }
        return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
    }
}
