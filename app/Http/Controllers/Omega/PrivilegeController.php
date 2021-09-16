<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Menu_Level_I;
use App\Models\Menu_Level_II;
use App\Models\Menu_Level_III;
use App\Models\Menu_Level_IV;
use App\Models\Priv_Menu;
use App\Models\Privilege;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class PrivilegeController extends Controller
{
    public function index()
    {
        $emp = verifSession('employee');
        if($emp === null) {
            return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
        }

        $privileges = Privilege::getPrivileges();
        $menus_1 = Menu_Level_I::getMenus();
        $menuss_2 = Menu_Level_II::getMenus();
        $menuss_3 = Menu_Level_III::getMenus();
        $menuss_4 = Menu_Level_IV::getMenus();
        if ($emp->level !== 'P') {
            $privileges = Privilege::getPrivileges(['level' => $emp->level]);
            $menus_1 = Priv_Menu::getMenus(1, ['privilege' => $emp->privilege]);
            $menuss_2 = Priv_Menu::getMenus(2, ['privilege' => $emp->privilege]);
            $menuss_3 = Priv_Menu::getMenus(3, ['privilege' => $emp->privilege]);
            $menuss_4 = Priv_Menu::getMenus(4, ['privilege' => $emp->privilege]);
        }
        $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

        return view('omega.pages.privilege', compact('menu', 'privileges', 'menus_1', 'menuss_2', 'menuss_3', 'menuss_4'));
    }

    public function store()
    {
        // dd(Request::all());
        DB::beginTransaction();
        try {
            $emp = verifSession('employee');
            if($emp === null) {
                return Redirect::route('/')->with('backURI', $_SERVER["REQUEST_URI"]);
            }

            $idprivilege = Request::input('idmain_menu');
            $menus_1 = Request::input('menu_1');
            $menus_2 = Request::input('menu_2');
            $menus_3 = Request::input('menu_3');
            $menus_4 = Request::input('menu_4');

            $privilege = null;

            if ($idprivilege === null) {
                $privilege = new Privilege();
            } else {
                $privilege = Privilege::getPrivilege($idprivilege);
            }

            $privilege->labelfr = ucwords(strtolower(Request::input('labelfr')));
            $privilege->labeleng = ucwords(strtolower(Request::input('labeleng')));
            $privilege->level = Request::input('priv_level');

            if ($idprivilege === null) {
                $privilege->save();

                foreach ($menus_1 as $menu_1) {
                    $priv_menu = new Priv_Menu();

                    $priv_menu->privilege = $privilege->idpriv;
                    $priv_menu->menu_1 = $menu_1;

                    $priv_menu->save();

                    foreach ($menus_2 as $menu_2) {
                        $menu2 = explode("_", $menu_2);

                        if ($menu_1 === $menu2[0]) {
                            $priv_menu = new Priv_Menu();

                            $priv_menu->privilege = $privilege->idpriv;
                            $priv_menu->menu_1 = $menu_1;
                            $priv_menu->menu_2 = $menu2[1];

                            $priv_menu->save();
                        }

                        foreach ($menus_3 as $menu_3) {
                            $menu3 = explode("_", $menu_3);

                            if ($menu_1 === $menu3[0] AND $menu2[1] === $menu3[1]) {
                                $priv_menu = new Priv_Menu();

                                $priv_menu->privilege = $privilege->idpriv;
                                $priv_menu->menu_1 = $menu_1;
                                $priv_menu->menu_2 = $menu2[1];
                                $priv_menu->menu_3 = $menu3[2];

                                $priv_menu->save();
                            }

                            foreach ($menus_4 as $menu_4) {
                                $menu4 = explode("_", $menu_4);

                                if ($menu_1 === $menu4[0] && $menu2[1] === $menu4[1] && $menu3[2] === $menu4[2]) {
                                    $priv_menu = new Priv_Menu();

                                    $priv_menu->privilege = $privilege->idpriv;
                                    $priv_menu->menu_1 = $menu_1;
                                    $priv_menu->menu_2 = $menu2[1];
                                    $priv_menu->menu_3 = $menu3[2];
                                    $priv_menu->menu_4 = $menu4[3];

                                    $priv_menu->save();
                                }
                            }
                        }
                    }
                }
            } else {
                $privilege->update((array)$privilege);

                // $line = count($menus_1) + count($menus_2) + count($menus_3) + count($menus_4);

                $priv_menus = Priv_Menu::getPrivMenus(['privilege' => $privilege->idpriv]);

                /*
                    $menus1 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_1');
                    if ($priv_menus->count() < $line) {
                        foreach ($menus_1 as $key => $menu_1) {
                            if (array_key_exists($key, $menus1)) {
                                $menus1[$key]->privilege = $privilege->idpriv;
                                $menus1[$key]->menu_1 = $menus_1[$key];

                                $menus1[$key]->update((array)$menus1[$key]);
                            } else {
                                $priv_menu = new Priv_Menu();

                                $priv_menu->privilege = $privilege->idpriv;
                                $priv_menu->menu_1 = $menus_1[$key];

                                $priv_menu->save();
                            }

                            $menus2 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_2');
                            if ($menu2->count() < count($menus_2)) {
                                foreach ($menus_2 as $index => $menu_2) {
                                    if (array_key_exists($index, $menus2)) {
                                        $menu2_ = explode("_", $menus_2[$index]);

                                        if ($menus_1[$key] === $menu2_[0]) {
                                            $menu2[$index]->privilege = $privilege->idpriv;
                                            $menu2[$index]->menu_1 = $menus_1[$key];
                                            $menu2[$index]->menu_2 = $menu2_[1];

                                            $menu2[$index]->update((array)$menu2[$index]);
                                        }
                                    } else {
                                        if ($menus_1[$key] === $menu2_[0]) {
                                            $priv_menu = new Priv_Menu();

                                            $priv_menu->privilege = $privilege->idpriv;
                                            $priv_menu->menu_1 = $menu_1;
                                            $priv_menu->menu_2 = $menu2_[1];

                                            $priv_menu->save();
                                        }
                                    }

                                    $menus3 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_3');
                                    if ($menus3->count() < count($menus_2)) {
                                        foreach ($menus_3 as $key_index => $menu_3) {
                                            $menu3_ = explode("_", $menus_3[$key_index]);

                                            if (array_key_exists($key_index, $menus3)) {
                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $menu3[$key_index]->privilege = $privilege->idpriv;
                                                    $menu3[$key_index]->menu_1 = $menus_1[$key];
                                                    $menu3[$key_index]->menu_2 = $menu2_[1];
                                                    $menu3[$key_index]->menu_3 = $menu3_[2];

                                                    $menu3[$key_index]->update((array)$menu3[$key_index]);
                                                }
                                            } else {
                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $priv_menu = new Priv_Menu();

                                                    $priv_menu->privilege = $privilege->idpriv;
                                                    $priv_menu->menu_1 = $menu_1;
                                                    $priv_menu->menu_2 = $menu2_[1];
                                                    $priv_menu->menu_3 = $menu3_[2];

                                                    $priv_menu->save();
                                                }
                                            }

                                            $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                            if ($menus4->count() < count($menus4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                            $menu4[$keyIndex]->menu_1 = $menu_1;
                                                            $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                            $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                            $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                            $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                        }
                                                    } else {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $priv_menu = new Priv_Menu();

                                                            $priv_menu->privilege = $privilege->idpriv;
                                                            $priv_menu->menu_1 = $menu_1;
                                                            $priv_menu->menu_2 = $menu2_[1];
                                                            $priv_menu->menu_3 = $menu3_[2];
                                                            $priv_menu->menu_4 = $menu4_[3];

                                                            $priv_menu->save();
                                                        }
                                                    }
                                                }
                                            }

                                            if ($menus4->count() === count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                        $menu4->privilege = $privilege->idpriv;
                                                        $menu4->menu_1 = $menu_1;
                                                        $menu4->menu_2 = $menu2_[1];
                                                        $menu4->menu_3 = $menu3_[2];
                                                        $menu4->menu_4 = $menu4_[3];

                                                        $menu4->update((array)$menu4);
                                                    }
                                                }
                                            }

                                            if ($menus4->count() > count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    } else {
                                                        $menu4->delete();
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if ($menus3->count() === count($menus_3)) {
                                        foreach ($menus3 as $key_index => $menu3) {
                                            $menu3_ = explode("_", $menus_3[$key_index]);

                                            if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                $priv_menu = new Priv_Menu();

                                                $menu3->privilege = $privilege->idpriv;
                                                $menu3->menu_1 = $menus_1[$key];
                                                $menu3->menu_2 = $menu2_[1];
                                                $menu3->menu_3 = $menu3_[2];

                                                $menu3->update((array)$menu3);
                                            }

                                            $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                            if ($menus4->count() < count($menus4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                            $menu4[$keyIndex]->menu_1 = $menu_1;
                                                            $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                            $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                            $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                            $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                        }
                                                    } else {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $priv_menu = new Priv_Menu();

                                                            $priv_menu->privilege = $privilege->idpriv;
                                                            $priv_menu->menu_1 = $menu_1;
                                                            $priv_menu->menu_2 = $menu2_[1];
                                                            $priv_menu->menu_3 = $menu3_[2];
                                                            $priv_menu->menu_4 = $menu4_[3];

                                                            $priv_menu->save();
                                                        }
                                                    }
                                                }
                                            }

                                            if ($menus4->count() === count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                        $menu4->privilege = $privilege->idpriv;
                                                        $menu4->menu_1 = $menu_1;
                                                        $menu4->menu_2 = $menu2_[1];
                                                        $menu4->menu_3 = $menu3_[2];
                                                        $menu4->menu_4 = $menu4_[3];

                                                        $menu4->update((array)$menu4);
                                                    }
                                                }
                                            }

                                            if ($menus4->count() > count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    } else {
                                                        $menu4->delete();
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if ($menus3->count() > count($menus_3)) {
                                        foreach ($menus3 as $key_index => $menu3) {
                                            if (array_key_exists($key_index, $menus3)) {
                                                $menu3_ = explode("_", $menus_3[$key_index]);

                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $menu3->privilege = $privilege->idpriv;
                                                    $menu3->menu_1 = $menus_1[$key];
                                                    $menu3->menu_2 = $menu2_[1];
                                                    $menu3->menu_3 = $menu3_[2];

                                                    $menu3->update((array)$menu3);
                                                }

                                                $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                if ($menus4->count() < count($menus4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                            }
                                                        } else {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $priv_menu = new Priv_Menu();

                                                                $priv_menu->privilege = $privilege->idpriv;
                                                                $priv_menu->menu_1 = $menu_1;
                                                                $priv_menu->menu_2 = $menu2_[1];
                                                                $priv_menu->menu_3 = $menu3_[2];
                                                                $priv_menu->menu_4 = $menu4_[3];

                                                                $priv_menu->save();
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() === count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() > count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        } else {
                                                            $menu4->delete();
                                                        }
                                                    }
                                                }
                                            } else {
                                                $menu3->delete();
                                            }
                                        }
                                    }
                                }
                            }

                            if ($menus2->count() === count($menus_2)) {
                                $menu2_ = explode("_", $menus_2[$index]);

                                foreach ($menus2 as $index => $menu2) {
                                    if ($menus_1[$key] === $menu2_[0]) {
                                        $menu2->privilege = $privilege->idpriv;
                                        $menu2->menu_1 = $menus_1[$key];
                                        $menu2->menu_2 = $menu2_[1];

                                        $menu2->update((array)$menu2);
                                    }

                                    $menus3 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_3');
                                    if ($menus3->count() < count($menus_2)) {
                                        foreach ($menus_3 as $key_index => $menu_3) {
                                            $menu3_ = explode("_", $menus_3[$key_index]);

                                            if (array_key_exists($key_index, $menus3)) {
                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $menu3[$key_index]->privilege = $privilege->idpriv;
                                                    $menu3[$key_index]->menu_1 = $menus_1[$key];
                                                    $menu3[$key_index]->menu_2 = $menu2_[1];
                                                    $menu3[$key_index]->menu_3 = $menu3_[2];

                                                    $menu3[$key_index]->update((array)$menu3[$key_index]);
                                                }
                                            } else {
                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $priv_menu = new Priv_Menu();

                                                    $priv_menu->privilege = $privilege->idpriv;
                                                    $priv_menu->menu_1 = $menu_1;
                                                    $priv_menu->menu_2 = $menu2_[1];
                                                    $priv_menu->menu_3 = $menu3_[2];

                                                    $priv_menu->save();
                                                }
                                            }

                                            $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                            if ($menus4->count() < count($menus4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                            $menu4[$keyIndex]->menu_1 = $menu_1;
                                                            $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                            $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                            $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                            $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                        }
                                                    } else {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $priv_menu = new Priv_Menu();

                                                            $priv_menu->privilege = $privilege->idpriv;
                                                            $priv_menu->menu_1 = $menu_1;
                                                            $priv_menu->menu_2 = $menu2_[1];
                                                            $priv_menu->menu_3 = $menu3_[2];
                                                            $priv_menu->menu_4 = $menu4_[3];

                                                            $priv_menu->save();
                                                        }
                                                    }
                                                }
                                            }

                                            if ($menus4->count() === count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                        $menu4->privilege = $privilege->idpriv;
                                                        $menu4->menu_1 = $menu_1;
                                                        $menu4->menu_2 = $menu2_[1];
                                                        $menu4->menu_3 = $menu3_[2];
                                                        $menu4->menu_4 = $menu4_[3];

                                                        $menu4->update((array)$menu4);
                                                    }
                                                }
                                            }

                                            if ($menus4->count() > count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    } else {
                                                        $menu4->delete();
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if ($menus3->count() === count($menus_3)) {
                                        foreach ($menus3 as $key_index => $menu3) {
                                            $menu3_ = explode("_", $menus_3[$key_index]);

                                            if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                $priv_menu = new Priv_Menu();

                                                $menu3->privilege = $privilege->idpriv;
                                                $menu3->menu_1 = $menus_1[$key];
                                                $menu3->menu_2 = $menu2_[1];
                                                $menu3->menu_3 = $menu3_[2];

                                                $menu3->update((array)$menu3);
                                            }

                                            $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                            if ($menus4->count() < count($menus4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                            $menu4[$keyIndex]->menu_1 = $menu_1;
                                                            $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                            $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                            $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                            $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                        }
                                                    } else {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $priv_menu = new Priv_Menu();

                                                            $priv_menu->privilege = $privilege->idpriv;
                                                            $priv_menu->menu_1 = $menu_1;
                                                            $priv_menu->menu_2 = $menu2_[1];
                                                            $priv_menu->menu_3 = $menu3_[2];
                                                            $priv_menu->menu_4 = $menu4_[3];

                                                            $priv_menu->save();
                                                        }
                                                    }
                                                }
                                            }

                                            if ($menus4->count() === count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                        $menu4->privilege = $privilege->idpriv;
                                                        $menu4->menu_1 = $menu_1;
                                                        $menu4->menu_2 = $menu2_[1];
                                                        $menu4->menu_3 = $menu3_[2];
                                                        $menu4->menu_4 = $menu4_[3];

                                                        $menu4->update((array)$menu4);
                                                    }
                                                }
                                            }

                                            if ($menus4->count() > count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    } else {
                                                        $menu4->delete();
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if ($menus3->count() > count($menus_3)) {
                                        foreach ($menus3 as $key_index => $menu3) {
                                            if (array_key_exists($key_index, $menus3)) {
                                                $menu3_ = explode("_", $menus_3[$key_index]);

                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $menu3->privilege = $privilege->idpriv;
                                                    $menu3->menu_1 = $menus_1[$key];
                                                    $menu3->menu_2 = $menu2_[1];
                                                    $menu3->menu_3 = $menu3_[2];

                                                    $menu3->update((array)$menu3);
                                                }

                                                $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                if ($menus4->count() < count($menus4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                            }
                                                        } else {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $priv_menu = new Priv_Menu();

                                                                $priv_menu->privilege = $privilege->idpriv;
                                                                $priv_menu->menu_1 = $menu_1;
                                                                $priv_menu->menu_2 = $menu2_[1];
                                                                $priv_menu->menu_3 = $menu3_[2];
                                                                $priv_menu->menu_4 = $menu4_[3];

                                                                $priv_menu->save();
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() === count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() > count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        } else {
                                                            $menu4->delete();
                                                        }
                                                    }
                                                }
                                            } else {
                                                $menu3->delete();
                                            }
                                        }
                                    }
                                }
                            }

                            if ($menus2->count() > count($menus_2)) {
                                foreach ($menus2 as $index => $menu2) {
                                    if (array_key_exists($index, $menus2)) {
                                        $menu2_ = explode("_", $menus_2[$index]);

                                        if ($menus_1[$key] === $menu2_[0]) {
                                            $menu2->privilege = $privilege->idpriv;
                                            $menu2->menu_1 = $menus_1[$key];
                                            $menu2->menu_2 = $menu2_[1];

                                            $menu2->update((array)$menu2);
                                        }

                                        $menus3 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_3');
                                        if ($menus3->count() < count($menus_2)) {
                                            foreach ($menus_3 as $key_index => $menu_3) {
                                                $menu3_ = explode("_", $menus_3[$key_index]);

                                                if (array_key_exists($key_index, $menus3)) {
                                                    if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                        $menu3[$key_index]->privilege = $privilege->idpriv;
                                                        $menu3[$key_index]->menu_1 = $menus_1[$key];
                                                        $menu3[$key_index]->menu_2 = $menu2_[1];
                                                        $menu3[$key_index]->menu_3 = $menu3_[2];

                                                        $menu3[$key_index]->update((array)$menu3[$key_index]);
                                                    }
                                                } else {
                                                    if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                        $priv_menu = new Priv_Menu();

                                                        $priv_menu->privilege = $privilege->idpriv;
                                                        $priv_menu->menu_1 = $menu_1;
                                                        $priv_menu->menu_2 = $menu2_[1];
                                                        $priv_menu->menu_3 = $menu3_[2];

                                                        $priv_menu->save();
                                                    }
                                                }

                                                $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                if ($menus4->count() < count($menus4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                            }
                                                        } else {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $priv_menu = new Priv_Menu();

                                                                $priv_menu->privilege = $privilege->idpriv;
                                                                $priv_menu->menu_1 = $menu_1;
                                                                $priv_menu->menu_2 = $menu2_[1];
                                                                $priv_menu->menu_3 = $menu3_[2];
                                                                $priv_menu->menu_4 = $menu4_[3];

                                                                $priv_menu->save();
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() === count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() > count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        } else {
                                                            $menu4->delete();
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        if ($menus3->count() === count($menus_3)) {
                                            foreach ($menus3 as $key_index => $menu3) {
                                                $menu3_ = explode("_", $menus_3[$key_index]);

                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $priv_menu = new Priv_Menu();

                                                    $menu3->privilege = $privilege->idpriv;
                                                    $menu3->menu_1 = $menus_1[$key];
                                                    $menu3->menu_2 = $menu2_[1];
                                                    $menu3->menu_3 = $menu3_[2];

                                                    $menu3->update((array)$menu3);
                                                }

                                                $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                if ($menus4->count() < count($menus4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                            }
                                                        } else {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $priv_menu = new Priv_Menu();

                                                                $priv_menu->privilege = $privilege->idpriv;
                                                                $priv_menu->menu_1 = $menu_1;
                                                                $priv_menu->menu_2 = $menu2_[1];
                                                                $priv_menu->menu_3 = $menu3_[2];
                                                                $priv_menu->menu_4 = $menu4_[3];

                                                                $priv_menu->save();
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() === count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() > count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        } else {
                                                            $menu4->delete();
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        if ($menus3->count() > count($menus_3)) {
                                            foreach ($menus3 as $key_index => $menu3) {
                                                if (array_key_exists($key_index, $menus3)) {
                                                    $menu3_ = explode("_", $menus_3[$key_index]);

                                                    if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                        $menu3->privilege = $privilege->idpriv;
                                                        $menu3->menu_1 = $menus_1[$key];
                                                        $menu3->menu_2 = $menu2_[1];
                                                        $menu3->menu_3 = $menu3_[2];

                                                        $menu3->update((array)$menu3);
                                                    }

                                                    $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                    if ($menus4->count() < count($menus4)) {
                                                        foreach ($menus4 as $keyIndex => $menu4) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if (array_key_exists($keyIndex, $menus4)) {
                                                                if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                    $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                    $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                    $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                    $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                    $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                    $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                                }
                                                            } else {
                                                                if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                    $priv_menu = new Priv_Menu();

                                                                    $priv_menu->privilege = $privilege->idpriv;
                                                                    $priv_menu->menu_1 = $menu_1;
                                                                    $priv_menu->menu_2 = $menu2_[1];
                                                                    $priv_menu->menu_3 = $menu3_[2];
                                                                    $priv_menu->menu_4 = $menu4_[3];

                                                                    $priv_menu->save();
                                                                }
                                                            }
                                                        }
                                                    }

                                                    if ($menus4->count() === count($menus_4)) {
                                                        foreach ($menus4 as $keyIndex => $menu4) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        }
                                                    }

                                                    if ($menus4->count() > count($menus_4)) {
                                                        foreach ($menus4 as $keyIndex => $menu4) {
                                                            if (array_key_exists($keyIndex, $menus4)) {
                                                                $menu4_= explode("_", $menus_4[$key_index]);

                                                                if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                    $menu4->privilege = $privilege->idpriv;
                                                                    $menu4->menu_1 = $menu_1;
                                                                    $menu4->menu_2 = $menu2_[1];
                                                                    $menu4->menu_3 = $menu3_[2];
                                                                    $menu4->menu_4 = $menu4_[3];

                                                                    $menu4->update((array)$menu4);
                                                                }
                                                            } else {
                                                                $menu4->delete();
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    $menu3->delete();
                                                }
                                            }
                                        }
                                    } else {
                                        $menu2->delete();
                                    }
                                }
                            }
                        }
                    }

                    if ($priv_menus->count() === $line) {
                        foreach ($menus1 as $key => $menu1) {
                            $menu1->privilege = $privilege->idpriv;
                            $menu1->menu_1 = $menus_1[$key];

                            $menu1->update((array)$menu1);

                            $menus2 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_2');
                            if ($menu2->count() < count($menus_2)) {
                                foreach ($menus_2 as $index => $menu_2) {
                                    if (array_key_exists($index, $menus2)) {
                                        $menu2_ = explode("_", $menus_2[$index]);

                                        if ($menus_1[$key] === $menu2_[0]) {
                                            $menu2[$index]->privilege = $privilege->idpriv;
                                            $menu2[$index]->menu_1 = $menus_1[$key];
                                            $menu2[$index]->menu_2 = $menu2_[1];

                                            $menu2[$index]->update((array)$menu2[$index]);
                                        }
                                    } else {
                                        if ($menus_1[$key] === $menu2_[0]) {
                                            $priv_menu = new Priv_Menu();

                                            $priv_menu->privilege = $privilege->idpriv;
                                            $priv_menu->menu_1 = $menu_1;
                                            $priv_menu->menu_2 = $menu2_[1];

                                            $priv_menu->save();
                                        }
                                    }

                                    $menus3 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_3');
                                    if ($menus3->count() < count($menus_2)) {
                                        foreach ($menus_3 as $key_index => $menu_3) {
                                            $menu3_ = explode("_", $menus_3[$key_index]);

                                            if (array_key_exists($key_index, $menus3)) {
                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $menu3[$key_index]->privilege = $privilege->idpriv;
                                                    $menu3[$key_index]->menu_1 = $menus_1[$key];
                                                    $menu3[$key_index]->menu_2 = $menu2_[1];
                                                    $menu3[$key_index]->menu_3 = $menu3_[2];

                                                    $menu3[$key_index]->update((array)$menu3[$key_index]);
                                                }
                                            } else {
                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $priv_menu = new Priv_Menu();

                                                    $priv_menu->privilege = $privilege->idpriv;
                                                    $priv_menu->menu_1 = $menu_1;
                                                    $priv_menu->menu_2 = $menu2_[1];
                                                    $priv_menu->menu_3 = $menu3_[2];

                                                    $priv_menu->save();
                                                }
                                            }

                                            $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                            if ($menus4->count() < count($menus4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                            $menu4[$keyIndex]->menu_1 = $menu_1;
                                                            $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                            $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                            $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                            $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                        }
                                                    } else {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $priv_menu = new Priv_Menu();

                                                            $priv_menu->privilege = $privilege->idpriv;
                                                            $priv_menu->menu_1 = $menu_1;
                                                            $priv_menu->menu_2 = $menu2_[1];
                                                            $priv_menu->menu_3 = $menu3_[2];
                                                            $priv_menu->menu_4 = $menu4_[3];

                                                            $priv_menu->save();
                                                        }
                                                    }
                                                }
                                            }

                                            if ($menus4->count() === count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                        $menu4->privilege = $privilege->idpriv;
                                                        $menu4->menu_1 = $menu_1;
                                                        $menu4->menu_2 = $menu2_[1];
                                                        $menu4->menu_3 = $menu3_[2];
                                                        $menu4->menu_4 = $menu4_[3];

                                                        $menu4->update((array)$menu4);
                                                    }
                                                }
                                            }

                                            if ($menus4->count() > count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    } else {
                                                        $menu4->delete();
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if ($menus3->count() === count($menus_3)) {
                                        foreach ($menus3 as $key_index => $menu3) {
                                            $menu3_ = explode("_", $menus_3[$key_index]);

                                            if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                $priv_menu = new Priv_Menu();

                                                $menu3->privilege = $privilege->idpriv;
                                                $menu3->menu_1 = $menus_1[$key];
                                                $menu3->menu_2 = $menu2_[1];
                                                $menu3->menu_3 = $menu3_[2];

                                                $menu3->update((array)$menu3);
                                            }

                                            $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                            if ($menus4->count() < count($menus4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                            $menu4[$keyIndex]->menu_1 = $menu_1;
                                                            $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                            $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                            $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                            $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                        }
                                                    } else {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $priv_menu = new Priv_Menu();

                                                            $priv_menu->privilege = $privilege->idpriv;
                                                            $priv_menu->menu_1 = $menu_1;
                                                            $priv_menu->menu_2 = $menu2_[1];
                                                            $priv_menu->menu_3 = $menu3_[2];
                                                            $priv_menu->menu_4 = $menu4_[3];

                                                            $priv_menu->save();
                                                        }
                                                    }
                                                }
                                            }

                                            if ($menus4->count() === count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                        $menu4->privilege = $privilege->idpriv;
                                                        $menu4->menu_1 = $menu_1;
                                                        $menu4->menu_2 = $menu2_[1];
                                                        $menu4->menu_3 = $menu3_[2];
                                                        $menu4->menu_4 = $menu4_[3];

                                                        $menu4->update((array)$menu4);
                                                    }
                                                }
                                            }

                                            if ($menus4->count() > count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    } else {
                                                        $menu4->delete();
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if ($menus3->count() > count($menus_3)) {
                                        foreach ($menus3 as $key_index => $menu3) {
                                            if (array_key_exists($key_index, $menus3)) {
                                                $menu3_ = explode("_", $menus_3[$key_index]);

                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $menu3->privilege = $privilege->idpriv;
                                                    $menu3->menu_1 = $menus_1[$key];
                                                    $menu3->menu_2 = $menu2_[1];
                                                    $menu3->menu_3 = $menu3_[2];

                                                    $menu3->update((array)$menu3);
                                                }

                                                $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                if ($menus4->count() < count($menus4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                            }
                                                        } else {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $priv_menu = new Priv_Menu();

                                                                $priv_menu->privilege = $privilege->idpriv;
                                                                $priv_menu->menu_1 = $menu_1;
                                                                $priv_menu->menu_2 = $menu2_[1];
                                                                $priv_menu->menu_3 = $menu3_[2];
                                                                $priv_menu->menu_4 = $menu4_[3];

                                                                $priv_menu->save();
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() === count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() > count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        } else {
                                                            $menu4->delete();
                                                        }
                                                    }
                                                }
                                            } else {
                                                $menu3->delete();
                                            }
                                        }
                                    }
                                }
                            }

                            if ($menus2->count() === count($menus_2)) {
                                $menu2_ = explode("_", $menus_2[$index]);

                                foreach ($menus2 as $index => $menu2) {
                                    if ($menus_1[$key] === $menu2_[0]) {
                                        $menu2->privilege = $privilege->idpriv;
                                        $menu2->menu_1 = $menus_1[$key];
                                        $menu2->menu_2 = $menu2_[1];

                                        $menu2->update((array)$menu2);
                                    }

                                    $menus3 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_3');
                                    if ($menus3->count() < count($menus_2)) {
                                        foreach ($menus_3 as $key_index => $menu_3) {
                                            $menu3_ = explode("_", $menus_3[$key_index]);

                                            if (array_key_exists($key_index, $menus3)) {
                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $menu3[$key_index]->privilege = $privilege->idpriv;
                                                    $menu3[$key_index]->menu_1 = $menus_1[$key];
                                                    $menu3[$key_index]->menu_2 = $menu2_[1];
                                                    $menu3[$key_index]->menu_3 = $menu3_[2];

                                                    $menu3[$key_index]->update((array)$menu3[$key_index]);
                                                }
                                            } else {
                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $priv_menu = new Priv_Menu();

                                                    $priv_menu->privilege = $privilege->idpriv;
                                                    $priv_menu->menu_1 = $menu_1;
                                                    $priv_menu->menu_2 = $menu2_[1];
                                                    $priv_menu->menu_3 = $menu3_[2];

                                                    $priv_menu->save();
                                                }
                                            }

                                            $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                            if ($menus4->count() < count($menus4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                            $menu4[$keyIndex]->menu_1 = $menu_1;
                                                            $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                            $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                            $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                            $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                        }
                                                    } else {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $priv_menu = new Priv_Menu();

                                                            $priv_menu->privilege = $privilege->idpriv;
                                                            $priv_menu->menu_1 = $menu_1;
                                                            $priv_menu->menu_2 = $menu2_[1];
                                                            $priv_menu->menu_3 = $menu3_[2];
                                                            $priv_menu->menu_4 = $menu4_[3];

                                                            $priv_menu->save();
                                                        }
                                                    }
                                                }
                                            }

                                            if ($menus4->count() === count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                        $menu4->privilege = $privilege->idpriv;
                                                        $menu4->menu_1 = $menu_1;
                                                        $menu4->menu_2 = $menu2_[1];
                                                        $menu4->menu_3 = $menu3_[2];
                                                        $menu4->menu_4 = $menu4_[3];

                                                        $menu4->update((array)$menu4);
                                                    }
                                                }
                                            }

                                            if ($menus4->count() > count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    } else {
                                                        $menu4->delete();
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if ($menus3->count() === count($menus_3)) {
                                        foreach ($menus3 as $key_index => $menu3) {
                                            $menu3_ = explode("_", $menus_3[$key_index]);

                                            if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                $priv_menu = new Priv_Menu();

                                                $menu3->privilege = $privilege->idpriv;
                                                $menu3->menu_1 = $menus_1[$key];
                                                $menu3->menu_2 = $menu2_[1];
                                                $menu3->menu_3 = $menu3_[2];

                                                $menu3->update((array)$menu3);
                                            }

                                            $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                            if ($menus4->count() < count($menus4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                            $menu4[$keyIndex]->menu_1 = $menu_1;
                                                            $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                            $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                            $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                            $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                        }
                                                    } else {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $priv_menu = new Priv_Menu();

                                                            $priv_menu->privilege = $privilege->idpriv;
                                                            $priv_menu->menu_1 = $menu_1;
                                                            $priv_menu->menu_2 = $menu2_[1];
                                                            $priv_menu->menu_3 = $menu3_[2];
                                                            $priv_menu->menu_4 = $menu4_[3];

                                                            $priv_menu->save();
                                                        }
                                                    }
                                                }
                                            }

                                            if ($menus4->count() === count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                        $menu4->privilege = $privilege->idpriv;
                                                        $menu4->menu_1 = $menu_1;
                                                        $menu4->menu_2 = $menu2_[1];
                                                        $menu4->menu_3 = $menu3_[2];
                                                        $menu4->menu_4 = $menu4_[3];

                                                        $menu4->update((array)$menu4);
                                                    }
                                                }
                                            }

                                            if ($menus4->count() > count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    } else {
                                                        $menu4->delete();
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if ($menus3->count() > count($menus_3)) {
                                        foreach ($menus3 as $key_index => $menu3) {
                                            if (array_key_exists($key_index, $menus3)) {
                                                $menu3_ = explode("_", $menus_3[$key_index]);

                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $menu3->privilege = $privilege->idpriv;
                                                    $menu3->menu_1 = $menus_1[$key];
                                                    $menu3->menu_2 = $menu2_[1];
                                                    $menu3->menu_3 = $menu3_[2];

                                                    $menu3->update((array)$menu3);
                                                }

                                                $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                if ($menus4->count() < count($menus4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                            }
                                                        } else {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $priv_menu = new Priv_Menu();

                                                                $priv_menu->privilege = $privilege->idpriv;
                                                                $priv_menu->menu_1 = $menu_1;
                                                                $priv_menu->menu_2 = $menu2_[1];
                                                                $priv_menu->menu_3 = $menu3_[2];
                                                                $priv_menu->menu_4 = $menu4_[3];

                                                                $priv_menu->save();
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() === count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() > count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        } else {
                                                            $menu4->delete();
                                                        }
                                                    }
                                                }
                                            } else {
                                                $menu3->delete();
                                            }
                                        }
                                    }
                                }
                            }

                            if ($menus2->count() > count($menus_2)) {
                                foreach ($menus2 as $index => $menu2) {
                                    if (array_key_exists($index, $menus2)) {
                                        $menu2_ = explode("_", $menus_2[$index]);

                                        if ($menus_1[$key] === $menu2_[0]) {
                                            $menu2->privilege = $privilege->idpriv;
                                            $menu2->menu_1 = $menus_1[$key];
                                            $menu2->menu_2 = $menu2_[1];

                                            $menu2->update((array)$menu2);
                                        }

                                        $menus3 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_3');
                                        if ($menus3->count() < count($menus_2)) {
                                            foreach ($menus_3 as $key_index => $menu_3) {
                                                $menu3_ = explode("_", $menus_3[$key_index]);

                                                if (array_key_exists($key_index, $menus3)) {
                                                    if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                        $menu3[$key_index]->privilege = $privilege->idpriv;
                                                        $menu3[$key_index]->menu_1 = $menus_1[$key];
                                                        $menu3[$key_index]->menu_2 = $menu2_[1];
                                                        $menu3[$key_index]->menu_3 = $menu3_[2];

                                                        $menu3[$key_index]->update((array)$menu3[$key_index]);
                                                    }
                                                } else {
                                                    if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                        $priv_menu = new Priv_Menu();

                                                        $priv_menu->privilege = $privilege->idpriv;
                                                        $priv_menu->menu_1 = $menu_1;
                                                        $priv_menu->menu_2 = $menu2_[1];
                                                        $priv_menu->menu_3 = $menu3_[2];

                                                        $priv_menu->save();
                                                    }
                                                }

                                                $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                if ($menus4->count() < count($menus4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                            }
                                                        } else {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $priv_menu = new Priv_Menu();

                                                                $priv_menu->privilege = $privilege->idpriv;
                                                                $priv_menu->menu_1 = $menu_1;
                                                                $priv_menu->menu_2 = $menu2_[1];
                                                                $priv_menu->menu_3 = $menu3_[2];
                                                                $priv_menu->menu_4 = $menu4_[3];

                                                                $priv_menu->save();
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() === count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() > count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        } else {
                                                            $menu4->delete();
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        if ($menus3->count() === count($menus_3)) {
                                            foreach ($menus3 as $key_index => $menu3) {
                                                $menu3_ = explode("_", $menus_3[$key_index]);

                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $priv_menu = new Priv_Menu();

                                                    $menu3->privilege = $privilege->idpriv;
                                                    $menu3->menu_1 = $menus_1[$key];
                                                    $menu3->menu_2 = $menu2_[1];
                                                    $menu3->menu_3 = $menu3_[2];

                                                    $menu3->update((array)$menu3);
                                                }

                                                $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                if ($menus4->count() < count($menus4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                            }
                                                        } else {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $priv_menu = new Priv_Menu();

                                                                $priv_menu->privilege = $privilege->idpriv;
                                                                $priv_menu->menu_1 = $menu_1;
                                                                $priv_menu->menu_2 = $menu2_[1];
                                                                $priv_menu->menu_3 = $menu3_[2];
                                                                $priv_menu->menu_4 = $menu4_[3];

                                                                $priv_menu->save();
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() === count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() > count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        } else {
                                                            $menu4->delete();
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        if ($menus3->count() > count($menus_3)) {
                                            foreach ($menus3 as $key_index => $menu3) {
                                                if (array_key_exists($key_index, $menus3)) {
                                                    $menu3_ = explode("_", $menus_3[$key_index]);

                                                    if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                        $menu3->privilege = $privilege->idpriv;
                                                        $menu3->menu_1 = $menus_1[$key];
                                                        $menu3->menu_2 = $menu2_[1];
                                                        $menu3->menu_3 = $menu3_[2];

                                                        $menu3->update((array)$menu3);
                                                    }

                                                    $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                    if ($menus4->count() < count($menus4)) {
                                                        foreach ($menus4 as $keyIndex => $menu4) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if (array_key_exists($keyIndex, $menus4)) {
                                                                if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                    $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                    $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                    $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                    $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                    $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                    $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                                }
                                                            } else {
                                                                if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                    $priv_menu = new Priv_Menu();

                                                                    $priv_menu->privilege = $privilege->idpriv;
                                                                    $priv_menu->menu_1 = $menu_1;
                                                                    $priv_menu->menu_2 = $menu2_[1];
                                                                    $priv_menu->menu_3 = $menu3_[2];
                                                                    $priv_menu->menu_4 = $menu4_[3];

                                                                    $priv_menu->save();
                                                                }
                                                            }
                                                        }
                                                    }

                                                    if ($menus4->count() === count($menus_4)) {
                                                        foreach ($menus4 as $keyIndex => $menu4) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        }
                                                    }

                                                    if ($menus4->count() > count($menus_4)) {
                                                        foreach ($menus4 as $keyIndex => $menu4) {
                                                            if (array_key_exists($keyIndex, $menus4)) {
                                                                $menu4_= explode("_", $menus_4[$key_index]);

                                                                if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                    $menu4->privilege = $privilege->idpriv;
                                                                    $menu4->menu_1 = $menu_1;
                                                                    $menu4->menu_2 = $menu2_[1];
                                                                    $menu4->menu_3 = $menu3_[2];
                                                                    $menu4->menu_4 = $menu4_[3];

                                                                    $menu4->update((array)$menu4);
                                                                }
                                                            } else {
                                                                $menu4->delete();
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    $menu3->delete();
                                                }
                                            }
                                        }
                                    } else {
                                        $menu2->delete();
                                    }
                                }
                            }
                        }
                    }

                    if ($priv_menus->count() > $line) {
                    foreach ($menus1 as $key => $menu1) {
                        if (array_key_exists($key, $menus1)) {
                            $menu1->privilege = $privilege->idpriv;
                            $menu1->menu_1 = $menus_1[$key];

                            $menu1->update((array)$menu1);

                            $menus2 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_2');
                            if ($menu2->count() < count($menus_2)) {
                                foreach ($menus_2 as $index => $menu_2) {
                                    if (array_key_exists($index, $menus2)) {
                                        $menu2_ = explode("_", $menus_2[$index]);

                                        if ($menus_1[$key] === $menu2_[0]) {
                                            $menu2[$index]->privilege = $privilege->idpriv;
                                            $menu2[$index]->menu_1 = $menus_1[$key];
                                            $menu2[$index]->menu_2 = $menu2_[1];

                                            $menu2[$index]->update((array)$menu2[$index]);
                                        }
                                    } else {
                                        if ($menus_1[$key] === $menu2_[0]) {
                                            $priv_menu = new Priv_Menu();

                                            $priv_menu->privilege = $privilege->idpriv;
                                            $priv_menu->menu_1 = $menu_1;
                                            $priv_menu->menu_2 = $menu2_[1];

                                            $priv_menu->save();
                                        }
                                    }

                                    $menus3 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_3');
                                    if ($menus3->count() < count($menus_2)) {
                                        foreach ($menus_3 as $key_index => $menu_3) {
                                            $menu3_ = explode("_", $menus_3[$key_index]);

                                            if (array_key_exists($key_index, $menus3)) {
                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $menu3[$key_index]->privilege = $privilege->idpriv;
                                                    $menu3[$key_index]->menu_1 = $menus_1[$key];
                                                    $menu3[$key_index]->menu_2 = $menu2_[1];
                                                    $menu3[$key_index]->menu_3 = $menu3_[2];

                                                    $menu3[$key_index]->update((array)$menu3[$key_index]);
                                                }
                                            } else {
                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $priv_menu = new Priv_Menu();

                                                    $priv_menu->privilege = $privilege->idpriv;
                                                    $priv_menu->menu_1 = $menu_1;
                                                    $priv_menu->menu_2 = $menu2_[1];
                                                    $priv_menu->menu_3 = $menu3_[2];

                                                    $priv_menu->save();
                                                }
                                            }

                                            $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                            if ($menus4->count() < count($menus4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                            $menu4[$keyIndex]->menu_1 = $menu_1;
                                                            $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                            $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                            $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                            $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                        }
                                                    } else {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $priv_menu = new Priv_Menu();

                                                            $priv_menu->privilege = $privilege->idpriv;
                                                            $priv_menu->menu_1 = $menu_1;
                                                            $priv_menu->menu_2 = $menu2_[1];
                                                            $priv_menu->menu_3 = $menu3_[2];
                                                            $priv_menu->menu_4 = $menu4_[3];

                                                            $priv_menu->save();
                                                        }
                                                    }
                                                }
                                            }

                                            if ($menus4->count() === count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                        $menu4->privilege = $privilege->idpriv;
                                                        $menu4->menu_1 = $menu_1;
                                                        $menu4->menu_2 = $menu2_[1];
                                                        $menu4->menu_3 = $menu3_[2];
                                                        $menu4->menu_4 = $menu4_[3];

                                                        $menu4->update((array)$menu4);
                                                    }
                                                }
                                            }

                                            if ($menus4->count() > count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    } else {
                                                        $menu4->delete();
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if ($menus3->count() === count($menus_3)) {
                                        foreach ($menus3 as $key_index => $menu3) {
                                            $menu3_ = explode("_", $menus_3[$key_index]);

                                            if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                $priv_menu = new Priv_Menu();

                                                $menu3->privilege = $privilege->idpriv;
                                                $menu3->menu_1 = $menus_1[$key];
                                                $menu3->menu_2 = $menu2_[1];
                                                $menu3->menu_3 = $menu3_[2];

                                                $menu3->update((array)$menu3);
                                            }

                                            $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                            if ($menus4->count() < count($menus4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                            $menu4[$keyIndex]->menu_1 = $menu_1;
                                                            $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                            $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                            $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                            $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                        }
                                                    } else {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $priv_menu = new Priv_Menu();

                                                            $priv_menu->privilege = $privilege->idpriv;
                                                            $priv_menu->menu_1 = $menu_1;
                                                            $priv_menu->menu_2 = $menu2_[1];
                                                            $priv_menu->menu_3 = $menu3_[2];
                                                            $priv_menu->menu_4 = $menu4_[3];

                                                            $priv_menu->save();
                                                        }
                                                    }
                                                }
                                            }

                                            if ($menus4->count() === count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                        $menu4->privilege = $privilege->idpriv;
                                                        $menu4->menu_1 = $menu_1;
                                                        $menu4->menu_2 = $menu2_[1];
                                                        $menu4->menu_3 = $menu3_[2];
                                                        $menu4->menu_4 = $menu4_[3];

                                                        $menu4->update((array)$menu4);
                                                    }
                                                }
                                            }

                                            if ($menus4->count() > count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    } else {
                                                        $menu4->delete();
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if ($menus3->count() > count($menus_3)) {
                                        foreach ($menus3 as $key_index => $menu3) {
                                            if (array_key_exists($key_index, $menus3)) {
                                                $menu3_ = explode("_", $menus_3[$key_index]);

                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $menu3->privilege = $privilege->idpriv;
                                                    $menu3->menu_1 = $menus_1[$key];
                                                    $menu3->menu_2 = $menu2_[1];
                                                    $menu3->menu_3 = $menu3_[2];

                                                    $menu3->update((array)$menu3);
                                                }

                                                $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                if ($menus4->count() < count($menus4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                            }
                                                        } else {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $priv_menu = new Priv_Menu();

                                                                $priv_menu->privilege = $privilege->idpriv;
                                                                $priv_menu->menu_1 = $menu_1;
                                                                $priv_menu->menu_2 = $menu2_[1];
                                                                $priv_menu->menu_3 = $menu3_[2];
                                                                $priv_menu->menu_4 = $menu4_[3];

                                                                $priv_menu->save();
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() === count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() > count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        } else {
                                                            $menu4->delete();
                                                        }
                                                    }
                                                }
                                            } else {
                                                $menu3->delete();
                                            }
                                        }
                                    }
                                }
                            }

                            if ($menus2->count() === count($menus_2)) {
                                $menu2_ = explode("_", $menus_2[$index]);

                                foreach ($menus2 as $index => $menu2) {
                                    if ($menus_1[$key] === $menu2_[0]) {
                                        $menu2->privilege = $privilege->idpriv;
                                        $menu2->menu_1 = $menus_1[$key];
                                        $menu2->menu_2 = $menu2_[1];

                                        $menu2->update((array)$menu2);
                                    }

                                    $menus3 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_3');
                                    if ($menus3->count() < count($menus_2)) {
                                        foreach ($menus_3 as $key_index => $menu_3) {
                                            $menu3_ = explode("_", $menus_3[$key_index]);

                                            if (array_key_exists($key_index, $menus3)) {
                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $menu3[$key_index]->privilege = $privilege->idpriv;
                                                    $menu3[$key_index]->menu_1 = $menus_1[$key];
                                                    $menu3[$key_index]->menu_2 = $menu2_[1];
                                                    $menu3[$key_index]->menu_3 = $menu3_[2];

                                                    $menu3[$key_index]->update((array)$menu3[$key_index]);
                                                }
                                            } else {
                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $priv_menu = new Priv_Menu();

                                                    $priv_menu->privilege = $privilege->idpriv;
                                                    $priv_menu->menu_1 = $menu_1;
                                                    $priv_menu->menu_2 = $menu2_[1];
                                                    $priv_menu->menu_3 = $menu3_[2];

                                                    $priv_menu->save();
                                                }
                                            }

                                            $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                            if ($menus4->count() < count($menus4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                            $menu4[$keyIndex]->menu_1 = $menu_1;
                                                            $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                            $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                            $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                            $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                        }
                                                    } else {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $priv_menu = new Priv_Menu();

                                                            $priv_menu->privilege = $privilege->idpriv;
                                                            $priv_menu->menu_1 = $menu_1;
                                                            $priv_menu->menu_2 = $menu2_[1];
                                                            $priv_menu->menu_3 = $menu3_[2];
                                                            $priv_menu->menu_4 = $menu4_[3];

                                                            $priv_menu->save();
                                                        }
                                                    }
                                                }
                                            }

                                            if ($menus4->count() === count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                        $menu4->privilege = $privilege->idpriv;
                                                        $menu4->menu_1 = $menu_1;
                                                        $menu4->menu_2 = $menu2_[1];
                                                        $menu4->menu_3 = $menu3_[2];
                                                        $menu4->menu_4 = $menu4_[3];

                                                        $menu4->update((array)$menu4);
                                                    }
                                                }
                                            }

                                            if ($menus4->count() > count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    } else {
                                                        $menu4->delete();
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if ($menus3->count() === count($menus_3)) {
                                        foreach ($menus3 as $key_index => $menu3) {
                                            $menu3_ = explode("_", $menus_3[$key_index]);

                                            if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                $priv_menu = new Priv_Menu();

                                                $menu3->privilege = $privilege->idpriv;
                                                $menu3->menu_1 = $menus_1[$key];
                                                $menu3->menu_2 = $menu2_[1];
                                                $menu3->menu_3 = $menu3_[2];

                                                $menu3->update((array)$menu3);
                                            }

                                            $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                            if ($menus4->count() < count($menus4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                            $menu4[$keyIndex]->menu_1 = $menu_1;
                                                            $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                            $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                            $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                            $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                        }
                                                    } else {
                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $priv_menu = new Priv_Menu();

                                                            $priv_menu->privilege = $privilege->idpriv;
                                                            $priv_menu->menu_1 = $menu_1;
                                                            $priv_menu->menu_2 = $menu2_[1];
                                                            $priv_menu->menu_3 = $menu3_[2];
                                                            $priv_menu->menu_4 = $menu4_[3];

                                                            $priv_menu->save();
                                                        }
                                                    }
                                                }
                                            }

                                            if ($menus4->count() === count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    $menu4_= explode("_", $menus_4[$key_index]);

                                                    if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                        $menu4->privilege = $privilege->idpriv;
                                                        $menu4->menu_1 = $menu_1;
                                                        $menu4->menu_2 = $menu2_[1];
                                                        $menu4->menu_3 = $menu3_[2];
                                                        $menu4->menu_4 = $menu4_[3];

                                                        $menu4->update((array)$menu4);
                                                    }
                                                }
                                            }

                                            if ($menus4->count() > count($menus_4)) {
                                                foreach ($menus4 as $keyIndex => $menu4) {
                                                    if (array_key_exists($keyIndex, $menus4)) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    } else {
                                                        $menu4->delete();
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if ($menus3->count() > count($menus_3)) {
                                        foreach ($menus3 as $key_index => $menu3) {
                                            if (array_key_exists($key_index, $menus3)) {
                                                $menu3_ = explode("_", $menus_3[$key_index]);

                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $menu3->privilege = $privilege->idpriv;
                                                    $menu3->menu_1 = $menus_1[$key];
                                                    $menu3->menu_2 = $menu2_[1];
                                                    $menu3->menu_3 = $menu3_[2];

                                                    $menu3->update((array)$menu3);
                                                }

                                                $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                if ($menus4->count() < count($menus4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                            }
                                                        } else {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $priv_menu = new Priv_Menu();

                                                                $priv_menu->privilege = $privilege->idpriv;
                                                                $priv_menu->menu_1 = $menu_1;
                                                                $priv_menu->menu_2 = $menu2_[1];
                                                                $priv_menu->menu_3 = $menu3_[2];
                                                                $priv_menu->menu_4 = $menu4_[3];

                                                                $priv_menu->save();
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() === count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() > count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        } else {
                                                            $menu4->delete();
                                                        }
                                                    }
                                                }
                                            } else {
                                                $menu3->delete();
                                            }
                                        }
                                    }
                                }
                            }

                            if ($menus2->count() > count($menus_2)) {
                                foreach ($menus2 as $index => $menu2) {
                                    if (array_key_exists($index, $menus2)) {
                                        $menu2_ = explode("_", $menus_2[$index]);

                                        if ($menus_1[$key] === $menu2_[0]) {
                                            $menu2->privilege = $privilege->idpriv;
                                            $menu2->menu_1 = $menus_1[$key];
                                            $menu2->menu_2 = $menu2_[1];

                                            $menu2->update((array)$menu2);
                                        }

                                        $menus3 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_3');
                                        if ($menus3->count() < count($menus_2)) {
                                            foreach ($menus_3 as $key_index => $menu_3) {
                                                $menu3_ = explode("_", $menus_3[$key_index]);

                                                if (array_key_exists($key_index, $menus3)) {
                                                    if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                        $menu3[$key_index]->privilege = $privilege->idpriv;
                                                        $menu3[$key_index]->menu_1 = $menus_1[$key];
                                                        $menu3[$key_index]->menu_2 = $menu2_[1];
                                                        $menu3[$key_index]->menu_3 = $menu3_[2];

                                                        $menu3[$key_index]->update((array)$menu3[$key_index]);
                                                    }
                                                } else {
                                                    if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                        $priv_menu = new Priv_Menu();

                                                        $priv_menu->privilege = $privilege->idpriv;
                                                        $priv_menu->menu_1 = $menu_1;
                                                        $priv_menu->menu_2 = $menu2_[1];
                                                        $priv_menu->menu_3 = $menu3_[2];

                                                        $priv_menu->save();
                                                    }
                                                }

                                                $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                if ($menus4->count() < count($menus4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                            }
                                                        } else {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $priv_menu = new Priv_Menu();

                                                                $priv_menu->privilege = $privilege->idpriv;
                                                                $priv_menu->menu_1 = $menu_1;
                                                                $priv_menu->menu_2 = $menu2_[1];
                                                                $priv_menu->menu_3 = $menu3_[2];
                                                                $priv_menu->menu_4 = $menu4_[3];

                                                                $priv_menu->save();
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() === count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() > count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        } else {
                                                            $menu4->delete();
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        if ($menus3->count() === count($menus_3)) {
                                            foreach ($menus3 as $key_index => $menu3) {
                                                $menu3_ = explode("_", $menus_3[$key_index]);

                                                if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                    $priv_menu = new Priv_Menu();

                                                    $menu3->privilege = $privilege->idpriv;
                                                    $menu3->menu_1 = $menus_1[$key];
                                                    $menu3->menu_2 = $menu2_[1];
                                                    $menu3->menu_3 = $menu3_[2];

                                                    $menu3->update((array)$menu3);
                                                }

                                                $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                if ($menus4->count() < count($menus4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                            }
                                                        } else {
                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $priv_menu = new Priv_Menu();

                                                                $priv_menu->privilege = $privilege->idpriv;
                                                                $priv_menu->menu_1 = $menu_1;
                                                                $priv_menu->menu_2 = $menu2_[1];
                                                                $priv_menu->menu_3 = $menu3_[2];
                                                                $priv_menu->menu_4 = $menu4_[3];

                                                                $priv_menu->save();
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() === count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        $menu4_= explode("_", $menus_4[$key_index]);

                                                        if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                            $menu4->privilege = $privilege->idpriv;
                                                            $menu4->menu_1 = $menu_1;
                                                            $menu4->menu_2 = $menu2_[1];
                                                            $menu4->menu_3 = $menu3_[2];
                                                            $menu4->menu_4 = $menu4_[3];

                                                            $menu4->update((array)$menu4);
                                                        }
                                                    }
                                                }

                                                if ($menus4->count() > count($menus_4)) {
                                                    foreach ($menus4 as $keyIndex => $menu4) {
                                                        if (array_key_exists($keyIndex, $menus4)) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        } else {
                                                            $menu4->delete();
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        if ($menus3->count() > count($menus_3)) {
                                            foreach ($menus3 as $key_index => $menu3) {
                                                if (array_key_exists($key_index, $menus3)) {
                                                    $menu3_ = explode("_", $menus_3[$key_index]);

                                                    if ($menus_1[$key] === $menu3_[0] AND $menu2_[1] === $menu3_[1]) {
                                                        $menu3->privilege = $privilege->idpriv;
                                                        $menu3->menu_1 = $menus_1[$key];
                                                        $menu3->menu_2 = $menu2_[1];
                                                        $menu3->menu_3 = $menu3_[2];

                                                        $menu3->update((array)$menu3);
                                                    }

                                                    $menus4 = Priv_Menu::getPrivMenusAside(['privilege' => $privilege->idpriv], 'menu_4');
                                                    if ($menus4->count() < count($menus4)) {
                                                        foreach ($menus4 as $keyIndex => $menu4) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if (array_key_exists($keyIndex, $menus4)) {
                                                                if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                    $menu4[$keyIndex]->privilege = $privilege->idpriv;
                                                                    $menu4[$keyIndex]->menu_1 = $menu_1;
                                                                    $menu4[$keyIndex]->menu_2 = $menu2_[1];
                                                                    $menu4[$keyIndex]->menu_3 = $menu3_[2];
                                                                    $menu4[$keyIndex]->menu_4 = $menu4_[3];

                                                                    $menu4[$keyIndex]->update((array)$menu4[$keyIndex]);
                                                                }
                                                            } else {
                                                                if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                    $priv_menu = new Priv_Menu();

                                                                    $priv_menu->privilege = $privilege->idpriv;
                                                                    $priv_menu->menu_1 = $menu_1;
                                                                    $priv_menu->menu_2 = $menu2_[1];
                                                                    $priv_menu->menu_3 = $menu3_[2];
                                                                    $priv_menu->menu_4 = $menu4_[3];

                                                                    $priv_menu->save();
                                                                }
                                                            }
                                                        }
                                                    }

                                                    if ($menus4->count() === count($menus_4)) {
                                                        foreach ($menus4 as $keyIndex => $menu4) {
                                                            $menu4_= explode("_", $menus_4[$key_index]);

                                                            if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                $menu4->privilege = $privilege->idpriv;
                                                                $menu4->menu_1 = $menu_1;
                                                                $menu4->menu_2 = $menu2_[1];
                                                                $menu4->menu_3 = $menu3_[2];
                                                                $menu4->menu_4 = $menu4_[3];

                                                                $menu4->update((array)$menu4);
                                                            }
                                                        }
                                                    }

                                                    if ($menus4->count() > count($menus_4)) {
                                                        foreach ($menus4 as $keyIndex => $menu4) {
                                                            if (array_key_exists($keyIndex, $menus4)) {
                                                                $menu4_= explode("_", $menus_4[$key_index]);

                                                                if ($menus_1[$key] === $menu4_[0] && $menu2_[1] === $menu4_[1] && $menu3_[2] === $menu4_[2]) {
                                                                    $menu4->privilege = $privilege->idpriv;
                                                                    $menu4->menu_1 = $menu_1;
                                                                    $menu4->menu_2 = $menu2_[1];
                                                                    $menu4->menu_3 = $menu3_[2];
                                                                    $menu4->menu_4 = $menu4_[3];

                                                                    $menu4->update((array)$menu4);
                                                                }
                                                            } else {
                                                                $menu4->delete();
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    $menu3->delete();
                                                }
                                            }
                                        }
                                    } else {
                                        $menu2->delete();
                                    }
                                }
                            }
                        } else {
                            $menu1->delete();
                        }
                    }
                }
                */

                foreach ($priv_menus as $priv_menu) {
                    $priv_menu->delete();
                }

                foreach ($menus_1 as $menu_1) {
                    $priv_menu = new Priv_Menu();

                    $priv_menu->privilege = $privilege->idpriv;
                    $priv_menu->menu_1 = $menu_1;

                    $priv_menu->save();

                    foreach ($menus_2 as $menu_2) {
                        $menu2 = explode("_", $menu_2);

                        if ($menu_1 === $menu2[0]) {
                            $priv_menu = new Priv_Menu();

                            $priv_menu->privilege = $privilege->idpriv;
                            $priv_menu->menu_1 = $menu_1;
                            $priv_menu->menu_2 = $menu2[1];

                            $priv_menu->save();
                        }

                        foreach ($menus_3 as $menu_3) {
                            $menu3 = explode("_", $menu_3);

                            if ($menu_1 === $menu3[0] AND $menu2[1] === $menu3[1]) {
                                $priv_menu = new Priv_Menu();

                                $priv_menu->privilege = $privilege->idpriv;
                                $priv_menu->menu_1 = $menu_1;
                                $priv_menu->menu_2 = $menu2[1];
                                $priv_menu->menu_3 = $menu3[2];

                                $priv_menu->save();
                            }

                            foreach ($menus_4 as $menu_4) {
                                $menu4 = explode("_", $menu_4);

                                if ($menu_1 === $menu4[0] && $menu2[1] === $menu4[1] && $menu3[2] === $menu4[2]) {
                                    $priv_menu = new Priv_Menu();

                                    $priv_menu->privilege = $privilege->idpriv;
                                    $priv_menu->menu_1 = $menu_1;
                                    $priv_menu->menu_2 = $menu2[1];
                                    $priv_menu->menu_3 = $menu3[2];
                                    $priv_menu->menu_4 = $menu4[3];

                                    $priv_menu->save();
                                }
                            }
                        }
                    }
                }
            }

            DB::commit();
            if ($idprivilege === null) {
                return Redirect::back()->with('success', trans('alertSuccess.privilege_save'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.privilege_edit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idprivilege === null) {
                return Redirect::back()->with('danger', trans('alertDanger.privilege_save'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.privilege_edit'));
        }
    }

    public function delete(): \Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();
        try {
            // dd(Request::input('privilege'));
            $priv_menus = Priv_Menu::getPrivMenus(['privilege' => Request::input('privilege')]);
            if ($priv_menus->count() > 0) {
                foreach ($priv_menus as $priv_menu) {
                    $priv_menu->delete();
                }
            }

            Privilege::getPrivilege(Request::input('privilege'))->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.privilege_del'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.privilege_del'));
        }
    }


}
