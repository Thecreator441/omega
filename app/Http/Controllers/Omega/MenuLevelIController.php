<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Menu_Level_I;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class MenuLevelIController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/');
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $main_menus_1 = Menu_Level_I::getMenus();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.menu_level_1', compact('menu', 'main_menus_1'));
        }
        return Redirect::route('omega')->with('danger', trans('auth.unauthorised'));
    }

    public function store()
    {
        // dd(Request::all());
        DB::beginTransaction();
        try {
            $idmain_menu = Request::input('idmain_menu');
            $main_menu = null;

            if ($idmain_menu === null) {
                $main_menu = new Menu_Level_I();
            } else {
                $main_menu = Menu_Level_I::getMenu($idmain_menu);
            }

            $main_menu->labelfr = Request::input('labelfr');
            $main_menu->labeleng = Request::input('labeleng');
            $main_menu->level = Request::input('level');
            $main_menu->view_icon = strtolower(Request::input('view_icon'));
            $main_menu->view_path = strtolower(Request::input('view_path'));

            if ($idmain_menu === null) {
                $main_menu->save();
            } else {
                $main_menu->update((array)$main_menu);
            }

            DB::commit();
            if ($idmain_menu === null) {
                return Redirect::back()->with('success', trans('alertSuccess.main_menu_save'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.main_menu_edit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idmain_menu === null) {
                return Redirect::back()->with('danger', trans('alertDanger.main_menu_save'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.main_menu_edit'));
        }
    }

    public function delete(): \Illuminate\Http\RedirectResponse
    {
        $idmain_menu = Request::input('main_menu');

        DB::beginTransaction();
        try {
            Menu_Level_I::getMenu($idmain_menu)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.menu_level_1_del'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.menu_level_1_del'));
        }
    }
}
