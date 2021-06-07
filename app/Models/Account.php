<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Account extends Model
{
    protected $table = 'accounts';

    protected $primaryKey = 'idaccount';

    protected $fillable = ['accounts'];

    /**
     * @param int $idaccount
     * @return Builder|Model|object|null
     */
    public static function getAccount(int $idaccount)
    {
        return self::query()->where('idaccount', $idaccount)->first();
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAccountBy(array $where)
    {
        $emp = Session::get('employee');

        return self::query()->select('accounts.*', 'At.labelfr AS Atfr', 'At.labeleng AS Ateng', 'At.accabbr')
            ->join('acc_types AS At', 'acctype', '=', 'idacctype')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'N') {
                    $query->where('accounts.network', $emp->network);
                }
                if ($emp->level === 'Z') {
                    $query->where('accounts.zone', $emp->zone);
                }
                if ($emp->level === 'I') {
                    $query->where('accounts.institution', $emp->institution);
                }
                if ($emp->level === 'B') {
                    $query->where('accounts.branch', $emp->branch);
                }
            })->where($where)->orderBy('accnumb')->first();
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAccounts(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->select('accounts.*', 'At.labelfr AS Atfr', 'At.labeleng AS Ateng', 'At.accabbr')
                ->join('acc_types AS At', 'acctype', '=', 'idacctype')
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'N') {
                        $query->where('accounts.network', $emp->network);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('accounts.zone', $emp->zone);
                    }
                    if ($emp->level === 'I') {
                        $query->where('accounts.institution', $emp->institution);
                    }
                    if ($emp->level === 'B') {
                        $query->where('accounts.branch', $emp->branch);
                    }
                })->where($where)->orderBy('accnumb')->get();
        }

        return self::query()->select('accounts.*', 'At.labelfr AS Atfr', 'At.labeleng AS Ateng', 'At.accabbr')
            ->join('acc_types AS At', 'acctype', '=', 'idacctype')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'N') {
                    $query->where('accounts.network', $emp->network);
                }
                if ($emp->level === 'Z') {
                    $query->where('accounts.zone', $emp->zone);
                }
                if ($emp->level === 'I') {
                    $query->where('accounts.institution', $emp->institution);
                }
                if ($emp->level === 'B') {
                    $query->where('accounts.branch', $emp->branch);
                }
            })->orderBy('accnumb')->get();
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


    /**
     * @param int $network
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAccountsMob(int $network)
    {
        return self::query()->where('accounts.network', $network)
            ->join('acc_types AS At', 'acctype', '=', 'idacctype')
            ->select('accounts.*', 'At.labelfr AS Atfr', 'At.labeleng AS Ateng', 'At.accabbr')
            ->orderBy('accnumb')->get();
    }

    public static function getCharts(string $select = 'idplan')
    {
        $emp = Session::get('employee');

        return self::query()->select("{$select}")->distinct("{$select}")
            ->where('accounts.network', $emp->network)->orderBy($select)->get();
    }
}
