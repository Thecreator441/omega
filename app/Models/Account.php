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

        return self::query()->select('accounts.*', 'Ac.plan_code', 'Ac.labelfr AS Acfr', 'Ac.labeleng AS Aceng', 'At.labelfr AS Atfr', 
        'At.labeleng AS Ateng', 'At.accabbr')
            ->join('acc_plans AS Ac', 'idplan', '=', 'Ac.idaccplan')
            ->join('acc_types AS At', 'accounts.acctype', '=', 'At.idacctype')
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
            return self::query()->select('accounts.*', 'Ac.plan_code', 'Ac.labelfr AS Acfr', 'Ac.labeleng AS Aceng', 'At.labelfr AS Atfr', 
            'At.labeleng AS Ateng', 'At.accabbr')
                ->join('acc_plans AS Ac', 'idplan', '=', 'Ac.idaccplan')
                ->join('acc_types AS At', 'accounts.acctype', '=', 'At.idacctype')
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

        return self::query()->select('accounts.*', 'Ac.plan_code', 'Ac.labelfr AS Acfr', 'Ac.labeleng AS Aceng', 'At.labelfr AS Atfr', 
        'At.labeleng AS Ateng', 'At.accabbr')
            ->join('acc_plans AS Ac', 'idplan', '=', 'Ac.idaccplan')
            ->join('acc_types AS At', 'accounts.acctype', '=', 'At.idacctype')
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
     * @param int $account
     * @return Builder|Model|object|null
     */
    public static function getAccBalance(int $account) 
    {
        $acc = self::getAccount($account);
        $totWritings = Writing::getWritings(['writings.account' => $account]);
        $totValWritings = ValWriting::getWritings(['val_writings.account' => $account]);
        
        foreach ($totValWritings as $totValWriting) {
            $totWritings->add($totValWriting);
        }
        
        $totCashIn = 0;
        $totCashOut = 0;
        foreach ($totWritings as $totWriting) {
            if ((int)$totWriting->creditamt !== 0) {
                $totCashIn += (int)$totWriting->creditamt;
            }
            if ((int)$totWriting->debitamt !== 0) {
                $totCashOut += (int)$totWriting->debitamt;
            }
        }
        
        $amount = abs($totCashIn - $totCashOut);
        if((int)$amount >= (int)$acc->available) {
            $amount = abs((int)$acc->available) + (int)$acc->initbal;
        } else {
            $amount += (int)$acc->initbal;
        }

        return $amount;
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAccountsFile(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->select('accounts.*', 'Ac.plan_code', 'Ac.labelfr AS Acfr', 'Ac.labeleng AS Aceng', 'At.labelfr AS Atfr', 
            'At.labeleng AS Ateng', 'At.accabbr')
                ->join('acc_plans AS Ac', 'idplan', '=', 'Ac.idaccplan')
                ->join('acc_types AS At', 'accounts.acctype', '=', 'At.idacctype')
                ->where($where)->where('accounts.network', $emp->network)
                ->orderBy('accnumb')->get();
        }
        return self::query()->select('accounts.*', 'Ac.plan_code', 'Ac.labelfr AS Acfr', 'Ac.labeleng AS Aceng', 'At.labelfr AS Atfr', 
        'At.labeleng AS Ateng', 'At.accabbr')
            ->join('acc_plans AS Ac', 'idplan', '=', 'Ac.idaccplan')
            ->join('acc_types AS At', 'accounts.acctype', '=', 'At.idacctype')
            ->where('accounts.network', $emp->network)->orderBy('accnumb')->get();
    }

    /**
     * @param int $network
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAccountsMob(int $network)
    {
        return self::query()->select('accounts.*', 'Ac.plan_code', 'Ac.labelfr AS Acfr', 'Ac.labeleng AS Aceng', 'At.labelfr AS Atfr', 
        'At.labeleng AS Ateng', 'At.accabbr')
            ->join('acc_plans AS Ac', 'idplan', '=', 'Ac.idaccplan')
            ->join('acc_types AS At', 'accounts.acctype', '=', 'At.idacctype')
            ->where('accounts.network', $network)->orderBy('accnumb')->get();
    }

    public static function getCharts(string $select = 'idplan')
    {
        $emp = Session::get('employee');

        return self::query()->select("{$select}")->distinct("{$select}")
            ->where('accounts.network', $emp->network)->orderBy($select)->get();
    }
}
