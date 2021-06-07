<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Town extends Model
{
    protected $table = 'towns';

    protected $primaryKey = 'idtown';

    protected $fillable = ['towns'];

    /**
     * @param int $idtown
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getTown(int $idtown)
    {
        return self::query()->where('idtown', $idtown)->first();
    }

    /**
     * @param array $where
     * @return Branch[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getTowns(array $where = [])
    {
        if ($where !== null) {
            return self::query()->where($where)->orderBy('label')->get();
        }
        return self::query()->orderBy('label')->get();
    }
}
