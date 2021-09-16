<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Priv_Menu extends Model
{
    protected $table = 'priv_menus';

    protected $primaryKey = 'idpriv_menu';

    protected $fillable = ['priv_menus'];

    /**
     * @param int $idpriv_menu
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getPrivMenu(int $idpriv_menu)
    {
        return self::query()->where('idpriv_menu', $idpriv_menu)->first();
    }

    /**
     * @param array $where
     * @param string|null $lang
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getPrivMenus(array $where = [])
    {
        if ($where !== null) {
            return self::query()->where($where)->get();
        }

        return self::query()->get();
    }

    public static function getPrivMenusAside(array $where = [], string $select)
    {
        if ($where !== null) {
            return self::query()->distinct($select)->select($select)->where($where)->get();
        }

        return self::query()->distinct($select)->select($select)->get();
    }

    /**
     * @param array $where
     * @param string|null $lang
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getPrivMenus_1(array $where = [], string $select = null)
    {
        if ($where !== null) {
            if ($select !== null) {
                return self::query()->distinct("menu_1")->where($where)->get();
            }
            return self::query()->select("menu_1")->where($where)->get();


            // return self::query()->where($where)->get();
        }

        if ($select !== null) {
            return self::query()->distinct("menu_1")->get();
        }

        return self::query()->get();
    }

    /**
     * @param array $where
     * @param string|null $lang
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getPrivMenus_2(array $where = [], string $select = null)
    {
        if ($where !== null) {
            return self::query()->select("menu_2")->where($where)->get();

            if ($select !== null) {
                return self::query()->distinct("menu_2")->where($where)->get();
            }

            return self::query()->where($where)->get();
        }

        if ($select !== null) {
            return self::query()->distinct("menu_2")->get();
        }

        return self::query()->get();
    }

    /**
     * @param array $where
     * @param string|null $lang
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getPrivMenus_3(array $where = [], string $select = null)
    {
        if ($where !== null) {
            return self::query()->select("menu_3")->where($where)->get();

            if ($select !== null) {
                return self::query()->distinct("menu_3")->where($where)->get();
            }

            return self::query()->where($where)->get();
        }

        if ($select !== null) {
            return self::query()->distinct("menu_3")->get();
        }

        return self::query()->get();
    }

    /**
     * @param array $where
     * @param string|null $lang
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getPrivMenus_4(array $where = [], string $select = null)
    {
        if ($where !== null) {
            return self::query()->select("menu_4")->where($where)->get();

            if ($select !== null) {
                return self::query()->distinct("menu_4")->where($where)->get();
            }

            return self::query()->where($where)->get();
        }

        if ($select !== null) {
            return self::query()->distinct("menu_4")->get();
        }

        return self::query()->get();
    }

    /**
     * @param string $level
     * @param int $menu
     * @param int $privilege
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getVerifPrivMenu(string $level, int $menu, int $privilege)
    {
        return self::query()->where([
            'privilege' => $privilege,
            $level => $menu
        ])->first();
    }

    /**
     * @param string $level
     * @param int $menu
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMenu(string $level, int $menu)
    {
        switch ($level) {
            case 1:
                return Menu_Level_I::getMenu($menu);
                break;
            case 2:
                return Menu_Level_II::getMenu($menu);
                break;
            case 3:
                return Menu_Level_III::getMenu($menu);
                break;
            default:
                return Menu_Level_IV::getMenu($menu);
                break;
        }
    }

    /**
     * @param int $menu
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMenus(int $menu, array $where = [])
    {
        if ($where !== null) {
            if ($menu === 1) {
                return self::query()->distinct('menu_1')->select('menu_1', 'ML1.idmenus_1', 'ML1.labelfr', 'ML1.labeleng', 'ML1.level', 'ML1.view_icon', 'ML1.view_path')
                    ->join('menu_level_1 AS ML1', 'priv_menus.menu_1', '=', 'ML1.idmenus_1')->where($where)->get();
            } else if ($menu === 2) {
                return self::query()->distinct('menu_2')->select('menu_2', 'ML2.idmenus_2', 'ML2.labelfr', 'ML2.labeleng', 'ML2.level', 'ML2.view_icon', 'ML2.view_path')
                    ->join('menu_level_2 AS ML2', 'priv_menus.menu_2', '=', 'ML2.idmenus_2')->where($where)->get();
            } else if ($menu === 3) {
                return self::query()->distinct('menu_3')->select('menu_3', 'ML3.idmenus_3', 'ML3.labelfr', 'ML3.labeleng', 'ML3.level', 'ML3.view_icon', 'ML3.view_path')
                    ->join('menu_level_3 AS ML3', 'priv_menus.menu_3', '=', 'ML3.idmenus_3')->where($where)->get();
            } else if ($menu === 4) {
                return self::query()->distinct('menu_4')->select('menu_4', 'ML4.idmenus_4', 'ML4.labelfr', 'ML4.labeleng', 'ML4.level', 'ML4.view_icon', 'ML4.view_path')
                    ->join('menu_level_4 AS ML4', 'priv_menus.menu_4', '=', 'ML4.idmenus_4')->where($where)->get();
            }
            
        }

        if ($menu === 1) {
            return self::query()->distinct('menu_1')->select('menu_1', 'ML1.idmenus_1', 'ML1.labelfr', 'ML1.labeleng', 'ML1.level', 'ML1.view_icon', 'ML1.view_path')
                ->join('menu_level_1 AS ML1', 'priv_menus.menu_1', '=', 'ML1.idmenus_1')->get();
        } else if ($menu === 2) {
            return self::query()->distinct('menu_2')->select('menu_2', 'ML2.idmenus_2', 'ML2.labelfr', 'ML2.labeleng', 'ML2.level', 'ML2.view_icon', 'ML2.view_path')
                ->join('menu_level_2 AS ML2', 'priv_menus.menu_2', '=', 'ML2.idmenus_2')->get();
        } else if ($menu === 3) {
            return self::query()->distinct('menu_3')->select('menu_3', 'ML3.idmenus_3', 'ML3.labelfr', 'ML3.labeleng', 'ML3.level', 'ML3.view_icon', 'ML3.view_path')
                ->join('menu_level_3 AS ML3', 'priv_menus.menu_3', '=', 'ML3.idmenus_3')->get();
        } else if ($menu === 4) {
            return self::query()->distinct('menu_4')->select('menu_4', 'ML4.idmenus_4', 'ML4.labelfr', 'ML4.labeleng', 'ML4.level', 'ML4.view_icon', 'ML4.view_path')
                ->join('menu_level_4 AS ML4', 'priv_menus.menu_4', '=', 'ML4.idmenus_4')->get();
        }
    }
}
