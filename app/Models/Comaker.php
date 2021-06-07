<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comaker extends Model
{
    protected $table = 'comakers';

    protected $primaryKey = 'idcomaker';

    protected $fillable = ['comakers'];

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getComakers(array $where = null)
    {
        return self::query()->where($where)->where('status', 'Ar')->get();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getComakersDesc(array $where = null)
    {
        return self::query()->where($where)->where('status', 'Ar')->orderByDesc('idcomaker')->get();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getComakersSum(array $where = null)
    {
        return self::query()->where($where)->where('status', 'Ar')->sum('guaramt');
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getComakersPaidSum(array $where = null)
    {
        return self::query()->where($where)->where('status', 'Ar')->sum('paidguar');
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getBlockAcc()
    {
        return self::query()->orWhere('comakers.status', 'Ar')
            ->orWhere('comakers.status', 'C')
            ->join('loans AS L', 'comakers.loan', '=', 'L.idloan')
            ->join('loan_types AS Lt', 'L.loantype', '=', 'Lt.idltype')
            ->select('Lt.blockacc')->first();
    }
}
