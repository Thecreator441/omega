<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Menu_Level_IV extends Model
{
    protected $table = 'menu_level_4';

    protected $primaryKey = 'idmenus_4';

    protected $fillable = ['menu_level_4'];

    /**
     * @param int $idmenu
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMenu(int $idmenu)
    {
        return self::query()->select('menu_level_4.*', 'ML3.idmenus_3 AS ML3_menu_3', 'ML3.labelfr AS ML3_fr', 'ML3.labeleng AS ML3_eng', 'ML2.idmenus_2 AS ML2_menu_2', 'ML2.labelfr AS ML2_fr', 'ML2.labeleng AS ML2_eng', 'ML1.idmenus_1 AS ML1_menu_1', 'ML1.labelfr AS ML1_fr', 'ML1.labeleng AS ML1_eng')
            ->join('menu_level_3 AS ML3', 'menu_level_4.menu_3', '=', 'ML3.idmenus_3')
            ->join('menu_level_2 AS ML2', 'ML3.menu_2', '=', 'ML2.idmenus_2')
            ->join('menu_level_1 AS ML1', 'ML2.menu_1', '=', 'ML1.idmenus_1')
            ->where('idmenus_4', $idmenu)->first();      
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
                return self::query()->select('menu_level_4.*', 'ML3.idmenus_3 AS ML3_menu_3', 'ML3.labelfr AS ML3_fr', 'ML3.labeleng AS ML3_eng', 'ML2.idmenus_2 AS ML2_menu_2', 'ML2.labelfr AS ML2_fr', 'ML2.labeleng AS ML2_eng', 'ML1.idmenus_1 AS ML1_menu_1', 'ML1.labelfr AS ML1_fr', 'ML1.labeleng AS ML1_eng')
                ->join('menu_level_3 AS ML3', 'menu_level_4.menu_3', '=', 'ML3.idmenus_3')
                ->join('menu_level_2 AS ML2', 'ML3.menu_2', '=', 'ML2.idmenus_2')
                ->join('menu_level_1 AS ML1', 'ML2.menu_1', '=', 'ML1.idmenus_1')
                ->where($where)->orderBy('menu_3')->get();
            }
            return self::query()->select('menu_level_4.*', 'ML3.idmenus_3 AS ML3_menu_3', 'ML3.labelfr AS ML3_fr', 'ML3.labeleng AS ML3_eng', 'ML2.idmenus_2 AS ML2_menu_2', 'ML2.labelfr AS ML2_fr', 'ML2.labeleng AS ML2_eng', 'ML1.idmenus_1 AS ML1_menu_1', 'ML1.labelfr AS ML1_fr', 'ML1.labeleng AS ML1_eng')
            ->join('menu_level_3 AS ML3', 'menu_level_4.menu_3', '=', 'ML3.idmenus_3')
            ->join('menu_level_2 AS ML2', 'ML3.menu_2', '=', 'ML2.idmenus_2')
            ->join('menu_level_1 AS ML1', 'ML2.menu_1', '=', 'ML1.idmenus_1')
            ->orderBy('menu_3')->get();
        }

        if ($where !== null) {
            return self::query()->select('menu_level_4.*', 'ML3.idmenus_3 AS ML3_menu_3', 'ML3.labelfr AS ML3_fr', 'ML3.labeleng AS ML3_eng', 'ML2.idmenus_2 AS ML2_menu_2', 'ML2.labelfr AS ML2_fr', 'ML2.labeleng AS ML2_eng', 'ML1.idmenus_1 AS ML1_menu_1', 'ML1.labelfr AS ML1_fr', 'ML1.labeleng AS ML1_eng')
            ->join('menu_level_3 AS ML3', 'menu_level_4.menu_3', '=', 'ML3.idmenus_3')
            ->join('menu_level_2 AS ML2', 'ML3.menu_2', '=', 'ML2.idmenus_2')
            ->join('menu_level_1 AS ML1', 'ML2.menu_1', '=', 'ML1.idmenus_1')
            ->where($where)->orderBy('menu_3')->get();
        }
        return self::query()->select('menu_level_4.*', 'ML3.idmenus_3 AS ML3_menu_3', 'ML3.labelfr AS ML3_fr', 'ML3.labeleng AS ML3_eng', 'ML2.idmenus_2 AS ML2_menu_2', 'ML2.labelfr AS ML2_fr', 'ML2.labeleng AS ML2_eng', 'ML1.idmenus_1 AS ML1_menu_1', 'ML1.labelfr AS ML1_fr', 'ML1.labeleng AS ML1_eng')
        ->join('menu_level_3 AS ML3', 'menu_level_4.menu_3', '=', 'ML3.idmenus_3')
        ->join('menu_level_2 AS ML2', 'ML3.menu_2', '=', 'ML2.idmenus_2')
        ->join('menu_level_1 AS ML1', 'ML2.menu_1', '=', 'ML1.idmenus_1')
        ->orderBy('menu_3')->get();
    }
}
