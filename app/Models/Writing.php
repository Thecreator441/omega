<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Writing extends Model
{
    protected $table = 'writings';

    protected $primaryKey = 'idwrit';

    private $idwrit;

    private $writnumb;

    private $account;

    private $aux;

    private $operation;

    private $debitamt;

    private $creditamt;

    private $accdate;

    private $employee;

    private $cash;

    private $network;

    private $zone;

    private $institution;

    private $branch;

    private $represent;

    private $updated_at;

    private $created_at;

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getWritings()
    {
        $emp = Session::get('employee');

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('institution', $emp->institution);
            }
        })->distinct('idwrit')->orderBy('writnumb', 'ASC')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getJournal()
    {
        return self::query()->where(static function ($query) {
            $emp = Session::get('employee');
            if ($emp->level === 'B') {
                $query->where('writings.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('branches.institution', $emp->institution);
            }
        })->where(static function ($query) {
            $emp = Session::get('employee');
            if ($emp->privilege === 3) {
                $query->where('writings.employee', $emp->idemp);
            }
        })->join('accounts AS A', 'writings.account', '=', 'A.idaccount')
            ->join('cashes AS C', 'writings.cash', '=', 'C.idcash')
            ->join('acc_dates AS Ad', 'writings.accdate', '=', 'Ad.idaccdate')
            ->select('writings.*', 'C.cashcode', 'Ad.accdate AS date')
            ->distinct('idwrit')->orderBy('idwrit')->get();
    }

    /**
     * @return mixed
     */
    public static function getSumDebit()
    {
        return self::query()->where(static function ($query) {
            $emp = Session::get('employee');
            if ($emp->level === 'B') {
                $query->where('writings.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('branches.institution', $emp->institution);
            }
        })->where(static function ($query) {
            $emp = Session::get('employee');
            if ($emp->privilege === 3) {
                $query->where('writings.employee', $emp->idemp);
            }
        })->sum('debitamt');
    }

    /**
     * @return mixed
     */
    public static function getSumCredit()
    {
        return self::query()->where(static function ($query) {
            $emp = Session::get('employee');
            if ($emp->level === 'B') {
                $query->where('writings.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('branches.institution', $emp->institution);
            }
        })->where(static function ($query) {
            $emp = Session::get('employee');
            if ($emp->privilege === 3) {
                $query->where('writings.employee', $emp->idemp);
            }
        })->sum('creditamt');
    }

    /**
     * @param int $member
     * @param int $account
     * @return mixed
     */
    public static function getMemSumDebit(int $member, int $account)
    {
        return self::query()->where(['aux' => $member, 'account' => $account])->sum('debitamt');
    }

    /**
     * @param int $member
     * @param int $account
     * @return mixed
     */
    public static function getMemSumCredit(int $member, int $account)
    {
        return self::query()->where(['aux' => $member, 'account' => $account])->sum('creditamt');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast()
    {
        $emp = Session::get('employee');

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('institution', $emp->institution);
            }
        })->distinct('idwrit')->orderByDesc('writnumb')->first();
    }
}
