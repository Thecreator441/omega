<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\AccDate;
use App\Models\Employee;
use App\Models\Institution;
use App\Models\Platform;
use App\Models\Priv_Menu;
use App\Models\Privilege;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    public function index()
    {
        if (Session::has('employee')) {
            return Redirect::back();
        }

        if (Session::has('backURI')) {
            $backURI = explode('/', Session::get('backURI'))[1];

            return view('omega.login', compact('backURI'));
        }

        return view('omega.login');
    }

    /**
     * @return array|RedirectResponse
     * @throws ValidationException
     * * @throws \Exception
     */
    public function login()
    {
        // dd(Request::all());
        $lang = Request::input('lang');

        if ($lang === 'fr') {
            App::setLocale('fr');
        }

        $validate = $this->validate(request(), [
            'name' => 'required',
            'password' => 'required'
        ]);

        if ($validate) {
            $users = User::getUsersByName(Request::input('name'));

            if ($users->count() > 0) {
                $user = null;

                foreach ($users as $pass_user) {
                    if (Hash::check(Request::input('password'), $pass_user->password)) {
                        $user = $pass_user;
                    }
                }

                if ($user !== null) {
                    if ($user->login_status === 'F') {
                        $priv = Privilege::getPrivilege($user->privilege);
                        $menus_1 = Priv_Menu::getPrivMenusAside(['privilege' => $priv->idpriv], 'menu_1');

                        foreach ($priv->getAttributes() as $index => $value) {
                            if ($user->created_at !== $user->$index || $user->upated_at !== $user->$index) {
                                $user->$index = $value;
                            }
                        }

                        $user->lang = $lang;
                        $user->edit = 'null';

                        $log_date = date($user->first_login, strtotime('+30 days'));
                        $today = date('yy-m-d');

                        $new_log_date = new \DateTime($log_date);
                        $new_today = new \DateTime($today);

                        $interval = $new_log_date->diff($new_today);

                        if ($user->login_no === null || $interval->days >= 30) {
                            $user->edit = 'Y';
                        }

                        $emp = null;
                        if ($user->platform !== null) {
                            $emp = Platform::getPlatform($user->platform);
                        } else {
                            $emp = Employee::getEmployee($user->employee);
                            // $params = Institution::getParams($emp->institution);

                            // $acc_date = AccDate::getOpenAccDate();
                            // if ($acc_date !== null) {
                            //     Session::put('accdate', $acc_date);
                            // }
                        }

                        foreach ($emp->getAttributes() as $index => $value) {
                            if ($user->created_at !== $user->$index || $user->upated_at !== $user->$index) {
                                $user->$index = $value;
                            }
                        }

                        Session::put('employee', $user);
                        Session::put('menus_1', $menus_1);

                        Log::info("{$user->username} " . trans('label.login') . " " . trans('label.at') . " " . getsDateTime(now()));

                        if (Request::input('backURL') !== null) {
                            $backURL = explode('?', Request::input('backURL'));
                            $params = explode('&', $backURL[1]);

                            return Redirect::route($backURL[0], [$params[0], $params[1]]);
                        }
                        return Redirect::route('omega');
                    }
                    return Redirect::back()->with('danger', trans('auth.blocked'))->withInput(\request(['name']));
                }
                return Redirect::back()->with('danger', trans('auth.failed'))->withInput(\request(['password']));
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
    public function changeLanguage(string $lang)
    {
        if (Session::has('employee')) {
            $emp = Session::get('employee');

            if ($lang === 'eng') {
                $emp->lang = 'eng';
                App::setLocale('en');
            } elseif ($lang === 'fr') {
                $emp->lang = 'fr';
                App::setLocale('fr');
            }
            return back()->with('lang', $lang);
        }

        return back()->with('lang', $lang);
    }

    /**
     * @return RedirectResponse
     */
    public function toHome()
    {
        $emp = Session::get('employee');

        if ($emp->employee === null && $emp->collector === null) {
            return Redirect::route('admin');
        }
        return Redirect::route('omega');
    }

    /**
     * @return RedirectResponse
     */
    public function logout()
    {
        $toke = Request::input('_token');

        if ($toke === null) {
            $empl = User::getUser(Request::input('user'));

            $empl->login_no = ++$empl->login_no;
            $empl->first_login = getsDate(now());

            $empl->update((array)$empl);

            Log::info("{$empl->username} " . trans('label.logout') . " " . trans('label.at') . " " . getsDateTime(now()));
            return ['success' => 'index.html'];
        }

        $emp = Session::get('employee');

        $empl = User::getUser($emp->iduser);

        $empl->login_no = ++$empl->login_no;
        $empl->first_login = getsDate(now());

        $empl->update((array)$empl);

        Session::flush();
        session_unset();
        \redirect(URL::previous());
        Log::info("{$empl->username} " . trans('label.logout') . " " . trans('label.at') . " " . getsDateTime(now()));
        return Redirect::route('/');
    }

    /**
     * @return RedirectResponse
     */
    public function editLogout()
    {
        $emp = Session::get('employee');

        $empl = User::getUser($emp->iduser);

        Session::flush();
        session_unset();
        \redirect(URL::previous());
        Log::info("{$empl->username} " . trans('label.logout') . " " . trans('label.at') . " " . getsDateTime(now()));
        return Redirect::route('/');
    }

    /**
     * @return RedirectResponse
     */
    public function changeLogout()
    {
        $empl = User::getUser(Request::input('user'));

        Session::flush();
        session_unset();
        \redirect(URL::previous());
        Log::info("{$empl->username} " . trans('label.logout') . " " . trans('label.at') . " " . getsDateTime(now()));
        return Redirect::route('/');
    }
}
