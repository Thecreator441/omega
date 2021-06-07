<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Device extends Model
{
    protected $table = 'devices';

    protected $primaryKey = 'iddevice';

    protected $fillable = ['devices'];

    /**
     * @param int $iddevice
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getDevice(int $iddevice)
    {
        return self::query()->where('iddevice', $iddevice)->first();
    }

    /**
     * @param array $where
     * @return Branch[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getDevices(array $where = [])
    {
        if ($where !== null) {
            return self::query()->where($where)->orderBy('dev_name')->get();
        }
        return self::query()->orderBy('dev_name')->get();
    }
}
