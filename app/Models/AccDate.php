<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class AccDate extends Model
{
    protected $table = 'acc_dates';

    protected $primaryKey = 'idaccdate';

    protected $fillable = ['acc_dates'];

    /**
     * @param int $idaccdate
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getAccDate(int $idaccdate)
    {
        return self::query()->where('idaccdate', $idaccdate)->first();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getAccDateBy(array $where)
    {
        return self::query()->where($where)->first();
    }

    /**
     * @param int|null $branch
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getOpenAccDate(int $branch = null)
    {
        return self::query()->where([
            'status' => 'O',
            'branch' => $branch
        ])->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCloseAccDate(int $branch = null)
    {
        return self::query()->where([
            'status' => 'C',
            'branch' => $branch
        ])->first();
    }

}
