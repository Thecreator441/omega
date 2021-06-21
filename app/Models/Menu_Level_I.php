<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Menu_Level_I extends Model
{
    protected $table = 'menu_level_1';

    protected $primaryKey = 'idmenus_1';

    protected $fillable = ['menu_level_1'];

    /**
     * @param int $idmenu
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMenu(int $idmenu)
    {
        return self::query()->where('idmenus_1', $idmenu)->first();
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
                return self::query()->where($where)->orderBy('level')->get();
            }
            return self::query()->orderBy('level')->get();
        }

        if ($where !== null) {
            return self::query()->where($where)->orderBy('level')->get();
        }
        return self::query()->orderBy('level')->get();
    }
}
