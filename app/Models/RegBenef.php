<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegBenef extends Model
{
    protected $table = 'reg_benefs';

    protected $primaryKey = 'idregbene';

    /**
     * @param int $register
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getRegBenefs(int $register)
    {
        return self::query()->where('register', $register)->get();
    }

}
