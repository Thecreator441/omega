<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Cash_Writing extends Model
{
    protected $table = 'cash_writings';

    protected $primaryKey = 'idwrit';

    protected $fillable = ['cash_writings'];

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCashWritings()
    {
        $emp = Session::get('employee');

        return self::query()->distinct('idwrit')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('institution', $emp->institution);
                }
            })->orderBy('idwrit')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCashJournal()
    {
        return self::query()->select('cash_writings.*')
            ->join('accounts AS A', 'cash_writings.account', '=', 'A.idaccount')
            ->where(static function ($query) {
                $emp = Session::get('employee');
                if ($emp->level === 'B') {
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('branches.institution', $emp->institution);
                }
            })->where(static function ($query) {
                $emp = Session::get('employee');
                if ($emp->privilege !== 5) {
                    $query->where('cash_writings.employee', $emp->iduser);
                }
            })
            ->distinct('idwrit')->orderBy('writnumb')->get();
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
            if ($emp->privilege !== 5) {
                $query->where('cash_writings.employee', $emp->iduser);
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
            if ($emp->privilege !== 5) {
                $query->where('cash_writings.employee', $emp->iduser);
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
        })->distinct('idwrit')->orderByDesc('writnumb')->first();
    }
}
