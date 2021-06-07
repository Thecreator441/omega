<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Money extends Model
{
    protected $table = 'moneys';

    protected $primaryKey = 'idmoney';

    protected $fillable = ['moneys'];

    /**
     * @param int $idcountry
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMoney(int $idmoney)
    {
        return self::query()->where('idmoney', $idmoney)->first();
    }

    /**
     * @param array $where
     * @return Branch[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMoneys(array $where = [])
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where($where)->where('C.idcountry', $emp->country)
                ->join('countries AS C', 'C.currency', '=', 'moneys.currency')
                ->select('moneys.*', 'C.labelfr AS coulabelfr', 'C.labeleng AS coulabeleng')
                ->orderByDesc('value')->get();
        }
        return self::query()->where('C.idcountry', $emp->country)
            ->join('countries AS C', 'C.currency', '=', 'moneys.currency')
            ->select('moneys.*', 'C.labelfr AS coulabelfr', 'C.labeleng AS coulabeleng')
            ->orderByDesc('value')->get();
    }


    /**
     * @param int $country
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMoneysMob(int $country)
    {
        return self::query()->where('C.idcountry', $country)
            ->join('countries AS C', 'C.currency', '=', 'moneys.currency')
            ->select('moneys.*', 'C.labelfr AS coulabelfr', 'C.labeleng AS coulabeleng')
            ->orderByDesc('value')->get();
    }
}
