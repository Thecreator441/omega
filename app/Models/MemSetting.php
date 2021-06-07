<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class MemSetting extends Model
{
    protected $table = 'mem_settings';

    protected $primaryKey = 'idmemset';

    protected $fillable = ['mem_settings'];

    /**
     * @param int $idmemset
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMemSetting(int $idmemset)
    {
        return self::query()->where('idmemset', $idmemset)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMemSettings()
    {
        $emp = Session::get('employee');

        return self::query()->select('mem_settings.*', 'A.idaccount', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'At.accabbr')
            ->join('accounts AS A', 'mem_settings.account', '=', 'A.idaccount')
            ->join('acc_types AS At', 'A.acctype', '=', 'At.idacctype')
            ->orWhere('mem_settings.branch', $emp->branch)
            ->orderBy('A.accnumb', 'ASC')->get();
    }

}
