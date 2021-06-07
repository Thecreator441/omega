<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'zones';

    protected $primaryKey = 'idzone';

    protected $fillable = ['zones'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getZone(int $id)
    {
        return self::query()->where('idzone', $id)->first();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getZones(array $where = null)
    {
        if ($where !== null) {
            return self::query()->where($where)->orderBy('name')->get();
        }
        return self::query()->orderBy('name')->get();
    }

}
