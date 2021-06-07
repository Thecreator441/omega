<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckAccAmt extends Model
{
    protected $table = 'check_acc_amts';

    protected $primaryKey = 'idcheckamt';

    protected $fillable = ['check_acc_amts'];


    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCheckAccAmts(array $where = null)
    {
        if ($where !== null) {
            return self::query()->where($where)
                ->join('operations AS O', 'operation', '=', 'O.idoper')
                ->join('accounts AS A', 'account', '=', 'A.idaccount')
                ->select('check_acc_amts.*', 'A.accnumb', 'A.labelfr', 'A.labeleng', 'O.labelfr AS operfr',
                    'O.labeleng AS opereng', 'O.debtfr', 'O.debteng', 'O.credtfr', 'O.credteng', 'A.accplan')
                ->distinct('checkno')->orderBy('A.accnumb')->get();
        }
        return self::query()->join('operations AS O', 'operation', '=', 'O.idoper')
            ->join('accounts AS A', 'account', '=', 'A.idaccount')
            ->select('check_acc_amts.*', 'A.accnumb', 'A.labelfr', 'A.labeleng', 'O.labelfr AS operfr',
                'O.labeleng AS opereng', 'O.debtfr', 'O.debteng', 'O.credtfr', 'O.credteng', 'A.accplan')
            ->distinct('checkno')->orderBy('A.accnumb')->get();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getOtherCheckAccAmts(array $where = null)
    {
        if ($where !== null) {
            return self::query()->where($where)
                ->join('accounts AS A', 'account', '=', 'A.idaccount')
                ->select('check_acc_amts.*', 'A.accnumb', 'A.labelfr')
                ->distinct('checkno')->orderBy('A.accnumb')->get();
        }
        return self::query()->join('accounts AS A', 'account', '=', 'A.idaccount')
            ->select('check_acc_amts.*', 'A.accnumb', 'A.labelfr', 'A.labeleng')
            ->distinct('checkno')->orderBy('A.accnumb')->get();
    }

    /**
     * @param int $checkno
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getChecksAcc(int $checkno)
    {
        return self::query()->where('checkno', $checkno)->get();
    }
}
