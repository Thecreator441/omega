<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';

    protected $primaryKey = 'idcurrency';

    protected $fillable = ['currencies'];

    /**
     * @param int $idcurrency
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCurrency(int $idcurrency)
    {
        return self::query()->where('idcurrency', $idcurrency)->first();
    }

    /**
     * @param array $where
     * @return Branch[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCurrencies(array $where = [])
    {
        if ($where !== null) {
            return self::query()->where($where)->orderBy('label')->get();
        }
        return self::query()->orderBy('label')->get();
    }
}
