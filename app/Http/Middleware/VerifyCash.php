<?php

namespace App\Http\Middleware;

use App\Models\Cash;
use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class VerifyCash
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
        $emp = Session::get('employee');

        if ($emp->level === 'B') {
            $cash = Cash::getCashBy(['cashes.employee' => $emp->iduser]);

            if ($cash === null) {
                return Redirect::back()->with('danger', trans('alertDanger.no_cash'));
            } else {
                if ($cash->status !== "O") {
                    return Redirect::back()->with('danger', trans('alertDanger.opencash'));
                }
            }
        }

        return $next($request);
    }
}
