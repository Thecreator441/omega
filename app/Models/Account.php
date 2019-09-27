<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Account extends Model
{
    private $idaccount;

    private $accnumb;

    private $labelfr;

    private $labeleng;

    private $accplan;

    private $acctype;

    private $initamt;

    private $country;

    private $network;

    private $institution;

    private $branch;

    private $updated_at;

    private $created_at;

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAccounts(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where($where)->where('network', $emp->network)
                ->join('acc_types AS At', 'acctype', '=', 'idacctype')
                ->select('accounts.*', 'At.labelfr AS Atfr', 'At.labeleng AS Ateng', 'At.accabbr')
                ->orderBy('accnumb')->get();
        }
        return self::query()->where('network', $emp->network)
            ->join('acc_types AS At', 'acctype', '=', 'idacctype')
            ->select('accounts.*', 'At.labelfr AS Atfr', 'At.labeleng AS Ateng', 'At.accabbr')
            ->orderBy('accnumb')->get();
    }

    /**
     * @param int $type
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getOrdAccs(int $type)
    {
        $emp = Session::get('employee');

        return self::query()->where(['network' => $emp->network, 'acctype' => $type])
            ->orderBy('accnumb')->get();
    }

    /**
     * @param array $where
     * @return Builder|Model|object|null
     */
    public static function getAccount(array $where)
    {
        $emp = Session::get('employee');

        return self::query()->where($where)->where('network', $emp->network)
            ->orderBy('accnumb')->first();
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAccountsFile(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where($where)->where('network', $emp->network)
                ->join('acc_types AS At', 'acctype', '=', 'idacctype')
                ->select('accounts.*', 'At.labelfr AS Atfr', 'At.labeleng AS Ateng', 'At.accabbr')
                ->orderBy('accnumb')->get();
        }
        return self::query()->where('network', $emp->network)
            ->join('acc_types AS At', 'acctype', '=', 'idacctype')
            ->select('accounts.*', 'At.labelfr AS Atfr', 'At.labeleng AS Ateng', 'At.accabbr')
            ->orderBy('accnumb')->get();
    }
}
