<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Country extends Model
{
    protected $table = 'countries';

    protected $primaryKey = 'idcountry';

    protected $fillable = ['countries'];

    /**
     * @param int $idcountry
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCountry(int $idcountry)
    {
        return self::query()->where('idcountry', $idcountry)->first();
    }

    /**
     * @param string|null $lang
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCountries(string $lang = null, array $where = [])
    {
        if ($lang === null) {
            $emp = Session::get('employee');

            if ($where !== null) {
                if ($emp->lang === 'fr') {
                    return self::query()->where($where)->orderBy('labelfr')->get();
                }
                return self::query()->where($where)->orderBy('labeleng')->get();
            }
            if ($emp->lang === 'fr') {
                return self::query()->orderBy('labelfr')->get();
            }
            return self::query()->orderBy('labeleng')->get();
        }

        if ($where !== null) {
            if ($lang === 'fr') {
                return self::query()->where($where)->orderBy('labelfr')->get();
            }
            return self::query()->where($where)->orderBy('labeleng')->get();
        }
        if ($lang === 'fr') {
            return self::query()->orderBy('labelfr')->get();
        }
        return self::query()->orderBy('labeleng')->get();
    }
}
