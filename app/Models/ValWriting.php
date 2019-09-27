<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ValWriting extends Model
{
    protected $table = 'val_writings';

    protected $primaryKey = 'idvalwrit';

    private $idvalwrit;

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
    public static function getValWritings()
    {
        return self::query()->where(static function ($query) {
            $emp = Session::get('employee');
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('institution', $emp->institution);
            }
        })->distinct('idvalwrit')->get();
    }

    public static function getValJournal()
    {
        return self::query()->where(static function ($query) {
            $emp = Session::get('employee');
            if ($emp->level === 'B') {
                $query->where('val_writings.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('branches.institution', $emp->institution);
            }
        })->join('accounts AS A', 'val_writings.account', '=', 'A.idaccount')
            ->join('cashes AS C', 'val_writings.cash', '=', 'C.idcash')
            ->join('acc_dates AS Ad', 'val_writings.accdate', '=', 'Ad.idaccdate')
            ->select('val_writings.*', 'C.cashcode', 'Ad.accdate AS date')
            ->distinct('idvalwrit')->orderBy('writnumb', 'ASC')->get();
    }

    /**
     * @return mixed
     */
    public static function getSumDebit()
    {
        $emp = Session::get('employee');

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('val_writings.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('branches.institution', $emp->institution);
            }
        })->sum('debitamt');
    }

    /**
     * @return mixed
     */
    public static function getSumCredit()
    {
        $emp = Session::get('employee');

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('val_writings.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('branches.institution', $emp->institution);
            }
        })->sum('creditamt');
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
        })->distinct('idvalwrit')->orderByDesc('writnumb')->first();
    }

}
