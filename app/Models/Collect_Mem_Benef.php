<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collect_Mem_Benef extends Model
{
    protected $table = 'collect_mem_benefs';

    protected $primaryKey = 'idmem_collect_bene';

    protected $fillable = ['collect_mem_benefs'];

    /**
     * @param int $idcolmemben
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCollectMemBenef(int $idcolmemben)
    {
        return self::query()->where('idmem_collect_bee', $idcolmemben)->first();
    }

    /**
     * @param int $collect_mem
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCollectMemBenefs(int $collect_mem)
    {
        return self::query()->where('collect_mem', $collect_mem)->get();
    }

}
