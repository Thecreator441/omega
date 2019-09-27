<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class MemSetting extends Model
{
    private $idmemset;

    private $account;

    private $operation;

    private $amount;

    private $type;

    private $institution;

    private $branch;

    private $created_at;

    private $updated_at;

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMemSetting(int $id)
    {
        return self::query()->where('idmemset', $id)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMemSettings()
    {
        $emp = Session::get('employee');

        return self::query()->orWhere(['mem_settings.institution' => $emp->institution, 'mem_settings.branch' => $emp->branch])
            ->join('accounts AS A', 'mem_settings.account', '=', 'A.idaccount')
            ->join('acc_types AS At', 'A.acctype', '=', 'At.idacctype')
            ->join('operations AS O', 'mem_settings.operation', '=', 'O.idoper')
            ->select('mem_settings.*', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng',
                'O.labelfr AS operlabelfr', 'O.labeleng AS operlabeleng', 'O.debtfr', 'O.credtfr', 'O.credtfr', 'O.credteng', 'At.accabbr')
            ->orderBy('A.accnumb', 'ASC')->get();
    }

}
