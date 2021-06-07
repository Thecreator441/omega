<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $primaryKey = 'idgroup';

    protected $fillable = ['groups'];

    /**
     * @param int $idgroup
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getGroup(int $idgroup)
    {
        return self::query()->where('idgroup', $idgroup)->first();
    }

    /**
     * @param string|null $lang
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getGroups(array $where = [])
    {

        if ($where !== null) {
            return self::query()->where($where)->orderBy('code')->get();
        }

        return self::query()->orderBy('code')->get();
    }

}
