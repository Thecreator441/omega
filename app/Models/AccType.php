<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AccType extends Model
{
    protected $primaryKey = 'idacctype';

    protected $table = 'acc_types';

    protected $fillable = ['acc_types'];

    /**
     * @param int $idacctype
     * @return Builder|Model|object|null
     */
    public static function getAccType(int $idacctype)
    {
        return self::query()->where('idacctype', $idacctype)->first();
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAccTypes(array $where = null)
    {
        if ($where !== null) {
            return self::query()->where($where)->orderBy('accabbr')->get();
        }
        return self::query()->orderBy('accabbr')->get();
    }
}
