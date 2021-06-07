<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $table = 'privileges';

    protected $primaryKey = 'idpriv';

    protected $fillable = ['privileges'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getPrivilege(int $id)
    {
        return self::query()->where('idpriv', $id)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getPrivileges(array $where = null)
    {
        if ($where !== null) {
            return self::query()->where($where)->orderBy('code')->get();
        }
        return self::query()->orderBy('code')->get();
    }

}
