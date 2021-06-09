<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Menu_Level_I;
use App\Models\Menu_Level_II;
use App\Models\Menu_Level_III;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class MenuLevelIIIController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        if (verifPriv(Request::input("level"), Request::input("menu"), $emp->privilege)) {
            $main_menus_1 = Menu_Level_I::getMenus();
            $main_menus_2 = Menu_Level_II::getMenus();
            $main_menus_3 = Menu_Level_III::getMenus();
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            foreach ($main_menus_3 as $main_menu_3) {
                $main_menu_2 = Menu_Level_II::getMenu($main_menu_3->menu_2);
                $main_menu_1 = Menu_Level_I::getMenu($main_menu_2->menu_1);
                
                $main_menu_3->main_menu_1 = ($emp->lang === 'fr') ? $main_menu_1->labelfr : $main_menu_1->labeleng;
                $main_menu_3->main_menu_2 = ($emp->lang === 'fr') ? $main_menu_2->labelfr : $main_menu_2->labeleng;
            }

            return view('omega.pages.menu_level_3', compact('menu', 'main_menus_1', 'main_menus_2', 'main_menus_3'));
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
                $main_menu = new Menu_Level_III();
            } else {
                $main_menu = Menu_Level_III::getMenu($idmain_menu);
            }

            $main_menu->labelfr = ucwords(strtolower(Request::input('labelfr')));
            $main_menu->labeleng = ucwords(strtolower(Request::input('labeleng')));
            $main_menu->menu_2 = Request::input('menu_level_2');
            $main_menu->level = Request::input('level');
            $main_menu->view_icon = strtolower(Request::input('view_icon'));
            $main_menu->view_path = strtolower(Request::input('view_path'));
// dd($main_menu);
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
            Menu_Level_III::getMenu($idmain_menu)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.main_menu__del'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.main_menu__del'));
        }
    }
}
