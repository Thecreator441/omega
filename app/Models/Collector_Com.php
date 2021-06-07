<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Collector_Com extends Model
{
    protected $table = 'collector_coms';

    protected $primaryKey = 'idcollect_bal';

    protected $fillable = ['collector_coms'];

    /**
     * @param int $member
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCollectBal(int $member)
    {
        return self::query()->where('collector', $member)->first();
    }

    /**
     * @param array|null $where
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCollectBals(string $status, array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->select('collector_coms.*', 'C.code', 'C.name AS col_name', 'C.surname AS col_surname')
                ->join('collectors as C', 'collector_coms.collector', '=', 'C.idcoll')
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('C.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('C.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('C.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('C.network', $emp->network);
                    }
                })->where('collector_coms.status', $status)->where($where)->orderBy('C.code')->get();
        }

        return self::query()->select('collector_coms.*', 'C.code', 'C.name AS col_name', 'C.surname AS col_surname')
            ->join('collectors as C', 'collector_coms.collector', '=', 'C.idcoll')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('C.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('C.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('C.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('C.network', $emp->network);
                }
            })->where('collector_coms.status', $status)->orderBy('C.code')->get();
    }
}
