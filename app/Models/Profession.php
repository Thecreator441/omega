<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Profession extends Model
{
    protected $table = 'professions';

    protected $primaryKey = 'idprof';

    protected $fillable = ['professions'];

    /**
     * @param int $idprof
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getProfession(int $idprof)
    {
        return self::query()->where('idprof', $idprof)->first();
    }

    /**
     * @param string|null $lang
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getProfessions(string $lang = null, array $where = [])
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
