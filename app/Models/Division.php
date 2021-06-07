<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Division extends Model
{
    protected $table = 'divisions';

    protected $primaryKey = 'iddiv';

    protected $fillable = ['divisions'];

    /**
     * @param int $iddivision
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getDivision(int $iddivision)
    {
        return self::query()->where('iddiv', $iddivision)->first();
    }

    /**
     * @param array $where
     * @return Branch[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getDivisions(array $where = [])
    {
        if ($where !== null) {
            return self::query()->where($where)->orderBy('label')->get();
        }
        return self::query()->orderBy('label')->get();
    }
}
