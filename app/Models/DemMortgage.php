<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemMortgage extends Model
{
    protected $table = 'dem_mortgages';

    protected $primaryKey = 'iddemmortgage';

    protected $fillable = ['dem_mortgages'];

    
    /**
     * @param int $demloan
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getDemMortgages(array $where)
    {
        return self::query()->select('dem_mortgages.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS M_surname')
        ->join('members AS M', 'dem_mortgages.member', '=', 'M.idmember')
        ->where($where)->get();
    }
    
    /**
     * @param int $loan
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast(int $loan)
    {
        return self::query()->select('dem_mortgages.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS M_surname')
        ->join('members AS M', 'dem_mortgages.member', '=', 'M.idmember')
        ->where('demloan', $loan)->orderByDesc('demmortgno')->first();
    }
}
