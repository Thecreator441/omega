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
}
