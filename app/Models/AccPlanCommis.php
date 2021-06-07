<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class AccPlanCommis extends Model
{
    protected $primaryKey = 'idcommis';

    protected $table = 'acc_plan_commis';

    protected $fillable = ['acc_plan_commis'];

    /**
     * @param array $where
     * @return Builder|Model|object|null
     */
    public static function getAccPlanComis(int $idcommis)
    {
        return self::query()->where('idcommis', $idcommis)->first();
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAccPlanCommiss(array $where = null)
    {
        $emp = Session::get('employee');
            
        if ($where !== null) {
            return self::query()->select('acc_plan_commis.*', 'A.idaccount', 'A.accnumb')
            ->join('accounts AS A', 'label_acc', '=', 'A.idaccount')
            ->where($where)->get();
        }
        return self::query()->select('acc_plan_commis.*', 'A.idaccount', 'A.accnumb')
        ->join('accounts AS A', 'label_acc', '=', 'A.idaccount')
        ->where('acc_plan_commis.network', $emp->network)->get();
    }
}
