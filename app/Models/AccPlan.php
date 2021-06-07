<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class AccPlan extends Model
{
    protected $primaryKey = 'idaccplan';

    protected $table = 'acc_plans';

    protected $fillable = ['acc_plans'];


    /**
     * @param array $where
     * @return Builder|Model|object|null
     */
    public static function getAccPlan(int $idaccplan = null)
    {
        return self::query()->where('idaccplan', $idaccplan)->first();
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAccPlanBy(array $where)
    {

        $emp = Session::get('employee');

        return self::query()->select('acc_plans.*', 'At.labelfr AS Atfr', 'At.labeleng AS Ateng', 'At.accabbr')
            ->join('acc_types AS At', 'acc_type', '=', 'At.idacctype')
            ->where('acc_plans.network', $emp->network)
            ->orWhere($where)
            ->orderBy('plan_code')->first();
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAccPlans(array $where = null)
    {

        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->select('acc_plans.*', 'At.labelfr AS Atfr', 'At.labeleng AS Ateng', 'At.accabbr')
                ->join('acc_types AS At', 'acc_type', '=', 'At.idacctype')
                ->where('acc_plans.network', $emp->network)
                ->orWhere($where)
                ->orderBy('plan_code')->get();
        }
        return self::query()->select('acc_plans.*', 'At.labelfr AS Atfr', 'At.labeleng AS Ateng', 'At.accabbr')
            ->join('acc_types AS At', 'acc_type', '=', 'At.idacctype')
            ->where('acc_plans.network', $emp->network)
            ->orderBy('plan_code')->get();
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAccPlansFile(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where($where)->where('network', $emp->network)
                ->orderBy('code')->get();
        }
        return self::query()->where('network', $emp->network)
            ->orderBy('code')->get();
    }
}
