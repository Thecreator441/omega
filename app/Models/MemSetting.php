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
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMemSettingBy(array $where = null )
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->select('mem_settings.*', 'A.idaccount', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'At.accabbr', 'O.idoper', 'O.labelfr AS olabelfr', 'O.labeleng AS olabeleng')
                ->join('accounts AS A', 'mem_settings.account', '=', 'A.idaccount')
                ->join('acc_types AS At', 'A.acctype', '=', 'At.idacctype')
                ->join('operations AS O', 'mem_settings.operation', '=', 'O.idoper')
                ->where('mem_settings.branch', $emp->branch)->where($where)
                ->orderBy('A.accnumb', 'ASC')->first();
        }
        return self::query()->select('mem_settings.*', 'A.idaccount', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'At.accabbr', 'O.idoper', 'O.labelfr AS olabelfr', 'O.labeleng AS olabeleng')
            ->join('accounts AS A', 'mem_settings.account', '=', 'A.idaccount')
            ->join('acc_types AS At', 'A.acctype', '=', 'At.idacctype')
            ->join('operations AS O', 'mem_settings.operation', '=', 'O.idoper')
            ->where('mem_settings.branch', $emp->branch)
            ->orderBy('A.accnumb', 'ASC')->first();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMemSettings(array $where = null )
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->select('mem_settings.*', 'A.idaccount', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'At.accabbr', 'O.idoper', 'O.labelfr AS olabelfr', 'O.labeleng AS olabeleng')
                ->join('accounts AS A', 'mem_settings.account', '=', 'A.idaccount')
                ->join('acc_types AS At', 'A.acctype', '=', 'At.idacctype')
                ->join('operations AS O', 'mem_settings.operation', '=', 'O.idoper')
                ->where('mem_settings.branch', $emp->branch)->where($where)
                ->orderBy('A.accnumb', 'ASC')->get();
        }
        return self::query()->select('mem_settings.*', 'A.idaccount', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'At.accabbr', 'O.idoper', 'O.labelfr AS olabelfr', 'O.labeleng AS olabeleng')
            ->join('accounts AS A', 'mem_settings.account', '=', 'A.idaccount')
            ->join('acc_types AS At', 'A.acctype', '=', 'At.idacctype')
            ->join('operations AS O', 'mem_settings.operation', '=', 'O.idoper')
            ->where('mem_settings.branch', $emp->branch)
            ->orderBy('A.accnumb', 'ASC')->get();
    }

}
