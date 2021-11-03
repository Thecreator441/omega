<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class LoanType extends Model
{
    protected $table = 'loan_types';

    protected $primaryKey = 'idltype';

    protected $fillable = ['loan_types'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLoanType(int $id)
    {
        return self::query()->select('loan_types.*', 'iA.accnumb AS iaccnumb', 'lA.accnumb AS laccnumb', 'tA.accnumb AS taccnumb', 'aA.accnumb AS aaccnumb')
        ->join('accounts AS iA', 'int_paid_acc', '=', 'iA.idaccount')
        ->join('accounts AS lA', 'loan_acc', '=', 'lA.idaccount')
        ->join('accounts AS tA', 'trans_acc', '=', 'tA.idaccount')
        ->join('accounts AS aA', 'accr_paid_acc', '=', 'aA.idaccount')
        ->where('idltype', $id)->first();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLoanTypeBy(array $where)
    {
        return self::query()->select('loan_types.*', 'iA.accnumb AS iaccnumb', 'lA.accnumb AS laccnumb', 'tA.accnumb AS taccnumb', 'aA.accnumb AS aaccnumb')
        ->join('accounts AS iA', 'int_paid_acc', '=', 'iA.idaccount')
        ->join('accounts AS lA', 'loan_acc', '=', 'lA.idaccount')
        ->join('accounts AS tA', 'trans_acc', '=', 'tA.idaccount')
        ->join('accounts AS aA', 'accr_paid_acc', '=', 'aA.idaccount')
        ->where($where)->orderBy('loan_type_code')->first();
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getLoanTypes(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->select('loan_types.*', 'iA.accnumb AS iaccnumb', 'lA.accnumb AS laccnumb', 'tA.accnumb AS taccnumb', 'aA.accnumb AS aaccnumb')
            ->join('accounts AS iA', 'int_paid_acc', '=', 'iA.idaccount')
            ->join('accounts AS lA', 'loan_acc', '=', 'lA.idaccount')
            ->join('accounts AS tA', 'trans_acc', '=', 'tA.idaccount')
            ->join('accounts AS aA', 'accr_paid_acc', '=', 'aA.idaccount')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'N') {
                    $query->where('loan_types.network', $emp->network);
                }
                if ($emp->level === 'Z') {
                    $query->where('loan_types.zone', $emp->zone);
                }
                if ($emp->level === 'I') {
                    $query->where('loan_types.institution', $emp->institution);
                }
                if ($emp->level === 'B') {
                    $query->where('loan_types.branch', $emp->branch);
                }
            })->where($where)->orderBy('loan_type_code')->get();
        }
        
        return self::query()->select('loan_types.*', 'iA.accnumb AS iaccnumb', 'lA.accnumb AS laccnumb', 'tA.accnumb AS taccnumb', 'aA.accnumb AS aaccnumb')
        ->join('accounts AS iA', 'int_paid_acc', '=', 'iA.idaccount')
        ->join('accounts AS lA', 'loan_acc', '=', 'lA.idaccount')
        ->join('accounts AS tA', 'trans_acc', '=', 'tA.idaccount')
        ->join('accounts AS aA', 'accr_paid_acc', '=', 'aA.idaccount')
        ->where(static function ($query) use ($emp) {
            if ($emp->level === 'N') {
                $query->where('loan_types.network', $emp->network);
            }
            if ($emp->level === 'Z') {
                $query->where('loan_types.zone', $emp->zone);
            }
            if ($emp->level === 'I') {
                $query->where('loan_types.institution', $emp->institution);
            }
            if ($emp->level === 'B') {
                $query->where('loan_types.branch', $emp->branch);
            }
        })->orderBy('loan_type_code')->get();
    }
}
