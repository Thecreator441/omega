<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubDiv extends Model
{
    protected $table = 'sub_divs';

    protected $primaryKey = 'idsub';

    protected $fillable = ['sub_divs'];

    /**
     * @param int $idsub
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getSubDiv(int $idsub)
    {
        return self::query()->where('idsub', $idsub)->first();
    }

    /**
     * @param array $where
     * @return Branch[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getSubDivs(array $where = [])
    {
        if ($where !== null) {
            return self::query()->where($where)->orderBy('label')->get();
        }
        return self::query()->orderBy('label')->get();
    }
}
