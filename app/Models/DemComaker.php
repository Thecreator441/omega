<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemComaker extends Model
{
    protected $table = 'dem_comakers';

    protected $primaryKey = 'iddemcomaker';

    protected $fillable = ['dem_comakers'];

    /**
     * @param int $demloan
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getComakers(int $demloan)
    {
        return self::query()->where(['demloan' => $demloan, 'status' => 'Al'])->get();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getDemComakers(array $where = null)
    {
        return self::query()->where($where)->where('status', 'Al')->get();
    }
}
