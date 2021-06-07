<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Menu_Level_III extends Model
{
    protected $table = 'menu_level_3';

    protected $primaryKey = 'idmenus_3';

    protected $fillable = ['menu_level_3'];

    /**
     * @param int $idmenu
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMenu(int $idmenu)
    {
        return self::query()->select('menu_level_3.*', 'ML2.idmenus_2 AS ML2_menu_2', 'ML2.labelfr AS ML2_fr', 'ML2.labeleng AS ML2_eng', 'ML1.idmenus_1 AS ML1_menu_1', 'ML1.labelfr AS ML1_fr', 'ML1.labeleng AS ML1_eng')
            ->join('menu_level_2 AS ML2', 'menu_level_3.menu_2', '=', 'ML2.idmenus_2')
            ->join('menu_level_1 AS ML1', 'ML2.menu_1', '=', 'ML1.idmenus_1')
            ->where('idmenus_3', $idmenu)->first();      
    }

    /**
     * @param string|null $lang
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMenus(string $lang = null, array $where = [])
    {
        if ($lang === null) {
            $emp = Session::get('employee');

            if ($where !== null) {
                return self::query()->where($where)->orderBy('menu_2')->get();
            }
            return self::query()->orderBy('menu_2')->get();
        }

        if ($where !== null) {
            return self::query()->where($where)->orderBy('menu_2')->get();
        }
        return self::query()->orderBy('menu_2')->get();
    }
}
