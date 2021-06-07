<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    protected $table = 'networks';

    protected $primaryKey = 'idnetwork';

    protected $fillable = ['networks'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getNetwork(int $id)
    {
        return self::query()->where('idnetwork', $id)->first();
    }

    /**
     * @param array $where
     * @return Branch[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getNetworks(array $where = [])
    {
        if ($where !== null) {
            return self::query()->where($where)->orderBy('abbr')->get();
        }
        return self::query()->orderBy('abbr')->get();
    }

}
