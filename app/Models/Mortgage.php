<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Mortgage extends Model
{
    protected $table = 'mortgages';

    protected $primaryKey = 'idmortgage';

    protected $fillable = ['mortgages'];

    /**
     * @param int $demloan
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMortgages(array $where)
    {
        return self::query()->select('mortgages.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS M_surname')
        ->join('members AS M', 'mortgages.member', '=', 'M.idmember')
        ->where($where)->get();
    }
    
    /**
     * @param int $loan
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast(int $loan)
    {
        return self::query()->select('mortgages.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS M_surname')
        ->join('members AS M', 'mortgages.member', '=', 'M.idmember')
        ->where('loan', $loan)->orderByDesc('mortno')->first();
    }
}
