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
        return self::query()->select('comakers.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS M_surname', 'A.accnumb', 'A.labelfr', 'A.labeleng')
            ->join('members AS M', 'comakers.member', '=', 'M.idmember')
            ->join('accounts AS A', 'comakers.account', '=', 'A.idaccount')
            ->where($where)->get();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getComakersDesc(array $where = null)
    {
        return self::query()->select('comakers.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS M_surname', 'A.accnumb', 'A.labelfr', 'A.labeleng')
            ->join('members AS M', 'comakers.member', '=', 'M.idmember')
            ->join('accounts AS A', 'comakers.account', '=', 'A.idaccount')
            ->where($where)->orderByDesc('idcomaker')->get();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getComakersSum(array $where = null)
    {
        return self::query()->select('comakers.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS M_surname', 'A.accnumb', 'A.labelfr', 'A.labeleng')
            ->join('members AS M', 'comakers.member', '=', 'M.idmember')
            ->join('accounts AS A', 'comakers.account', '=', 'A.idaccount')
            ->where($where)->sum('guaramt');
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getComakersPaidSum(array $where = null)
    {
        return self::query()->select('comakers.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS M_surname', 'A.accnumb', 'A.labelfr', 'A.labeleng')
            ->join('members AS M', 'comakers.member', '=', 'M.idmember')
            ->join('accounts AS A', 'comakers.account', '=', 'A.idaccount')
            ->where($where)->sum('paidguar');
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
