<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Menu_Level_II extends Model
{
    protected $table = 'menu_level_2';

    protected $primaryKey = 'idmenus_2';

    protected $fillable = ['menu_level_2'];

    /**
     * @param int $idmenu
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMenu(int $idmenu)
    {
        return self::query()->select('menu_level_2.*', 'ML1.idmenus_1 AS ML1_menu_1', 'ML1.labelfr AS ML1_fr', 'ML1.labeleng AS ML1_eng')
            ->join('menu_level_1 AS ML1', 'menu_level_2.menu_1', '=', 'ML1.idmenus_1')
            ->where('idmenus_2', $idmenu)->first();  
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
                return self::query()->where($where)->orderBy('menu_1')->get();
            }
            return self::query()->orderBy('menu_1')->get();
        }

        if ($where !== null) {
            return self::query()->where($where)->orderBy('menu_1')->get();
        }
        return self::query()->orderBy('menu_1')->get();
    }
}
