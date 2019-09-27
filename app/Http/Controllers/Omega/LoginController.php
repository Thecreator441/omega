<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function login(): RedirectResponse
    {
        $lang = Request::input('lang');
        if ($lang === 'fr') {
            App::setLocale('fr');
        }

        $validate = $this->validate(request(), [
            'name' => 'required',
            'password' => 'required'
        ]);

        if ($validate) {
            $emp = Employee::getUser(Request::input('name'));

            if ($emp !== null) {
//                if (Crypt::decrypt($emp->password) === Request::input('password')) {
                if ($emp->password === Request::input('password')) {
                    $emp->lang = $lang;
                    Session::put('employee', $emp);

                    if ($emp->idpriv === 0) {
                        return Redirect::route('admin');
                    }
                    return Redirect::route('omega');
                }
                return Redirect::back()->with('danger', trans('auth.failed'))->withInput(\request(['name']));
            }
            return Redirect::back()->with('danger', trans('auth.failed'))->withInput(\request(['name']));
        }
        return Redirect::back()->withErrors([
            'name' => trans('validation.required'),
            'password' => trans('validation.required')
        ])->withInput(\request(['name', 'password']));
    }

    /**
     * @param string $lang
     * @return RedirectResponse
     */
    public function changeLanguage(string $lang): RedirectResponse
    {
        $emp = Session::get('employee');

        if ($lang === 'eng') {
            $emp->lang = 'eng';
            App::setLocale('en');
        } elseif ($lang === 'fr') {
            $emp->lang = 'fr';
            App::setLocale('fr');
        }
        return back();
    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        \session()->flush();
        session_unset();
        \redirect(URL::previous());
        return Redirect::to('/');
    }
}
