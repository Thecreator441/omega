<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Bank extends Model
{
    protected $table = 'banks';

    protected $primaryKey = 'idbank';

    protected $fillable = ['banks'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getBank(int $id)
    {
        $emp = Session::get('employee');

        return self::query()->where(['idbank' => $id, 'branch' => $emp->branch])->first();
    }

    /**
     * @param array|null $where
    * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getBankBy(array $where)
    {
        $emp = Session::get('employee');

        return self::query()->select('banks.*', 'A.idaccount', 'A.accnumb')
            ->join('accounts AS A', 'theiracc', '=', 'A.idaccount')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'N') {
                    $query->where('banks.network', $emp->network);
                }
                if ($emp->level === 'Z') {
                    $query->where('banks.zone', $emp->zone);
                }
                if ($emp->level === 'I') {
                    $query->where('banks.institution', $emp->institution);
                }
                if ($emp->level === 'B') {
                    $query->where('banks.branch', $emp->branch);
                }
            })->where($where)->orderBy('bankcode')->first();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getBanks(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->select('banks.*', 'A.idaccount', 'A.accnumb')
            ->join('accounts AS A', 'theiracc', '=', 'A.idaccount')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'N') {
                    $query->where('banks.network', $emp->network);
                }
                if ($emp->level === 'Z') {
                    $query->where('banks.zone', $emp->zone);
                }
                if ($emp->level === 'I') {
                    $query->where('banks.institution', $emp->institution);
                }
                if ($emp->level === 'B') {
                    $query->where('banks.branch', $emp->branch);
                }
            })->where($where)
            ->orderBy('bankcode')->get();
        }
        return self::query()->select('banks.*', 'A.idaccount', 'A.accnumb')
            ->join('accounts AS A', 'theiracc', '=', 'A.idaccount')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'N') {
                    $query->where('banks.network', $emp->network);
                }
                if ($emp->level === 'Z') {
                    $query->where('banks.zone', $emp->zone);
                }
                if ($emp->level === 'I') {
                    $query->where('banks.institution', $emp->institution);
                }
                if ($emp->level === 'B') {
                    $query->where('banks.branch', $emp->branch);
                }
            })->orderBy('bankcode')->get();
    }
}
