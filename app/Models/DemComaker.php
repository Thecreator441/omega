<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemComaker extends Model
{
    protected $table = 'dem_comakers';

    protected $primaryKey = 'iddemcomaker';

    protected $fillable = ['dem_comakers'];

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getDemComakers(array $where = null)
    {   
        return self::query()->select('dem_comakers.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS M_surname', 'A.accnumb', 'A.labelfr', 'A.labeleng')
            ->join('members AS M', 'dem_comakers.member', '=', 'M.idmember')
            ->join('accounts AS A', 'dem_comakers.account', '=', 'A.idaccount')
            ->where($where)->get();
    }
}
