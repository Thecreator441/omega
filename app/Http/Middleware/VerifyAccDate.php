<?php

namespace App\Http\Middleware;

use App\Models\AccDate;
use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class VerifyAccDate
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
            $acc_date = AccDate::getAccDateBy(['acc_dates.branch' => $emp->branch]);

            if ($acc_date === null) {
                return Redirect::back()->with('danger', trans('alertDanger.no_acc_date'));
            } else {
                if ($acc_date->status !== "O") {
                    return Redirect::back()->with('danger', trans('alertDanger.opdate'));
                }
            }
        }

        return $next($request);
    }
}
