<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckAccAmt extends Model
{
    protected $table = 'check_acc_amts';

    protected $primaryKey = 'idcheckamt';

    protected $fillable = ['check_acc_amts'];


    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCheckAccAmts(array $where)
    {
        return self::query()->select('check_acc_amts.*', 'A.accnumb', 'A.labelfr AS a_labelfr', 'A.labeleng AS a_labeleng')
        ->join('accounts AS A', 'check_acc_amts.account', '=', 'A.idaccount')
        ->where($where)->orderBy('A.accnumb')->get();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getOtherCheckAccAmts(array $where = null)
    {
        if ($where !== null) {
            return self::query()->select('check_acc_amts.*', 'A.accnumb', 'A.labelfr AS a_labelfr', 'A.labeleng AS a_labeleng')
            ->join('accounts AS A', 'check_acc_amts.account', '=', 'A.idaccount')
            ->where($where)->orderBy('A.accnumb')->get();
        }
        return self::query()->select('check_acc_amts.*', 'A.accnumb', 'A.labelfr AS a_labelfr', 'A.labeleng AS a_labeleng')
        ->join('accounts AS A', 'check_acc_amts.account', '=', 'A.idaccount')
        ->orderBy('A.accnumb')->get();
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
