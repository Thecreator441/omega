<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Cash extends Model
{
    protected $table = 'cashes';

    protected $primaryKey = 'idcash';

    protected $fillable = ['cashes'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCash(int $id)
    {
        return self::query()->where('idcash', $id)->first();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getCashBy(array $where)
    {
        $emp = Session::get('employee');

        return self::query()->select('cashes.*', 'cA.accnumb AS casAcc_Numb', 'mA.accnumb AS misAcc_Numb', 'eA.accnumb AS excAcc_Numb', 'E.name', 'E.surname')
            ->join('accounts AS cA', 'cashes.cashacc', '=', 'cA.idaccount')
            ->join('accounts AS mA', 'cashes.misacc', '=', 'mA.idaccount')
            ->join('accounts AS eA', 'cashes.excacc', '=', 'eA.idaccount')
            ->join('users AS U', 'cashes.employee', '=', 'U.iduser')
            ->join('employees AS E', 'E.idemp', '=', 'U.employee')
            ->where(static function ($query) use ($emp) {
            if ($emp->level === 'N') {
                $query->where('cashes.network', $emp->network);
            }
            if ($emp->level === 'Z') {
                $query->where('cashes.zone', $emp->zone);
            }
            if ($emp->level === 'I') {
                $query->where('cashes.institution', $emp->institution);
            }
            if ($emp->level === 'B') {
                $query->where('cashes.branch', $emp->branch);
            }
        })->where($where)->orderBy('cashcode')->first();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getCashes(array $where = [])
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->select('cashes.*', 'cA.accnumb AS casAcc_Numb', 'mA.accnumb AS misAcc_Numb', 'eA.accnumb AS excAcc_Numb', 'E.name', 'E.surname')
                ->join('accounts AS cA', 'cashes.cashacc', '=', 'cA.idaccount')
                ->join('accounts AS mA', 'cashes.misacc', '=', 'mA.idaccount')
                ->join('accounts AS eA', 'cashes.excacc', '=', 'eA.idaccount')
                ->join('users AS U', 'cashes.employee', '=', 'U.iduser')
                ->join('employees AS E', 'E.idemp', '=', 'U.employee')
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'N') {
                        $query->where('cashes.network', $emp->network);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('cashes.zone', $emp->zone);
                    }
                    if ($emp->level === 'I') {
                        $query->where('cashes.institution', $emp->institution);
                    }
                    if ($emp->level === 'B') {
                        $query->where('cashes.branch', $emp->branch);
                    }
                })->where($where)->orderBy('cashcode')->get();
        }

        return self::query()->select('cashes.*', 'cA.accnumb AS casAcc_Numb', 'mA.accnumb AS misAcc_Numb', 'eA.accnumb AS excAcc_Numb', 'E.name', 'E.surname')
            ->join('accounts AS cA', 'cashes.cashacc', '=', 'cA.idaccount')
            ->join('accounts AS mA', 'cashes.misacc', '=', 'mA.idaccount')
            ->join('accounts AS eA', 'cashes.excacc', '=', 'eA.idaccount')
            ->join('users AS U', 'cashes.employee', '=', 'U.iduser')
            ->join('employees AS E', 'E.idemp', '=', 'U.employee')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'N') {
                    $query->where('cashes.network', $emp->network);
                }
                if ($emp->level === 'Z') {
                    $query->where('cashes.zone', $emp->zone);
                }
                if ($emp->level === 'I') {
                    $query->where('cashes.institution', $emp->institution);
                }
                if ($emp->level === 'B') {
                    $query->where('cashes.branch', $emp->branch);
                }
            })->orderBy('cashcode')->get();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getCashesPaginate(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->select('cashes.*', 'cA.accnumb AS casAcc_Numb', 'mA.accnumb AS misAcc_Numb', 'eA.accnumb AS excAcc_Numb', 'E.name', 'E.surname')
                ->join('accounts AS cA', 'cashes.cashacc', '=', 'cA.idaccount')
                ->join('accounts AS mA', 'cashes.misacc', '=', 'mA.idaccount')
                ->join('accounts AS eA', 'cashes.excacc', '=', 'eA.idaccount')
                ->join('users AS U', 'cashes.employee', '=', 'U.iduser')
                ->join('employees AS E', 'E.idemp', '=', 'U.employee')
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'N') {
                        $query->where('cashes.network', $emp->network);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('cashes.zone', $emp->zone);
                    }
                    if ($emp->level === 'I') {
                        $query->where('cashes.institution', $emp->institution);
                    }
                    if ($emp->level === 'B') {
                        $query->where('cashes.branch', $emp->branch);
                    }
                })->where($where)->orderBy('cashcode')->paginate(1);
        }

        return self::query()->select('cashes.*', 'cA.accnumb AS casAcc_Numb', 'mA.accnumb AS misAcc_Numb', 'eA.accnumb AS excAcc_Numb', 'E.name', 'E.surname')
            ->join('accounts AS cA', 'cashes.cashacc', '=', 'cA.idaccount')
            ->join('accounts AS mA', 'cashes.misacc', '=', 'mA.idaccount')
            ->join('accounts AS eA', 'cashes.excacc', '=', 'eA.idaccount')
            ->join('users AS U', 'cashes.employee', '=', 'U.iduser')
            ->join('employees AS E', 'E.idemp', '=', 'U.employee')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'N') {
                    $query->where('cashes.network', $emp->network);
                }
                if ($emp->level === 'Z') {
                    $query->where('cashes.zone', $emp->zone);
                }
                if ($emp->level === 'I') {
                    $query->where('cashes.institution', $emp->institution);
                }
                if ($emp->level === 'B') {
                    $query->where('cashes.branch', $emp->branch);
                }
            })->orderBy('cashcode')->paginate(1);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getCashesExcept(array $where = [])
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('cashes.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('cashes.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('cashes.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('cashes.network', $emp->network);
                }
            })->where('cashcode', '!=', '001')->where($where)->orderBy('cashcode')->get();
        }

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('cashes.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('cashes.institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('cashes.zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('cashes.network', $emp->network);
            }
        })->where('cashcode', '!=', '001')->orderBy('cashcode')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCashiers()
    {
        $emp = Session::get('employee');

        return self::query()->select('cashes.*', 'U.name', 'U.surname')
            ->join('users AS U', 'cashes.employee', '=', 'U.iduser')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('cashes.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('cashes.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('cashes.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('cashes.network', $emp->network);
                }
            })->orderBy('cashcode')->get();
    }

    /**
     * @param int|null $collector
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getEmpCashOpen(int $collector = null)
    {
        $emp = Session::get('employee');

        if ($collector === null) {
            return self::query()->where('employee', $emp->iduser)->where(static function ($query) {
                $query->orWhere(['status' => 'O', 'cashes.status' => 'R']);
            })->first();
        }

        return self::query()->where('employee', $collector)->where(static function ($query) {
            $query->orWhere(['status' => 'O', 'cashes.status' => 'R']);
        })->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getEmpCashReopen()
    {
        $emp = Session::get('employee');

        return self::query()->where('employee', $emp->idemp)
            ->where(['status' => 'C', 'closed_at' => getsDate(now())])->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getOpenCash()
    {
        $emp = Session::get('employee');

        return self::query()->where('status', 'O')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('cashes.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('cashes.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('cashes.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('cashes.network', $emp->network);
                }
            })->orderBy('cashcode')->get();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginate()
    {
        $emp = Session::get('employee');

        return self::query()->join('institutions AS I', 'cashes.institution', '=', 'I.idinst')
            ->join('branches AS B', 'cashes.branch', '=', 'B.idbranch')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('cashes.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('cashes.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('cashes.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('cashes.network', $emp->network);
                }
            })->paginate(1);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginateOpen()
    {
        $emp = Session::get('employee');

        return self::query()->orWhere(['status' => 'O', 'cashes.status' => 'R'])
            ->join('institutions AS I', 'cashes.institution', '=', 'I.idinst')
            ->join('branches AS B', 'cashes.branch', '=', 'B.idbranch')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('cashes.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('cashes.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('cashes.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('cashes.network', $emp->network);
                }
            })->distinct('idcash')->paginate(1);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginateAll()
    {
        $emp = Session::get('employee');

        return self::query()->join('institutions AS I', 'cashes.institution', '=', 'I.idinst')
            ->join('branches AS B', 'cashes.branch', '=', 'B.idbranch')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('cashes.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('cashes.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('cashes.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('cashes.network', $emp->network);
                }
            })->distinct('idcash')->orderBy('idcash', 'ASC')->paginate(1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMainCash()
    {
        $emp = Session::get('employee');

        return self::query()->where('status', 'O')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('institution ', $emp->institution);
                }
            })->orderBy('idcash')->first();
    }

    /**
     * @param int $idcash
     * @return mixed
     */
    public static function getSumBillet(int $idcash)
    {
        return self::query()->select(DB::raw('SUM((cashes.mon1*10000) + (cashes.mon2*5000) + (cashes.mon3*2000) + (cashes.mon4*1000) + (cashes.mon5*500) + (cashes.mon6*500) + (cashes.mon7*100) + (cashes.mon8*50) + (cashes.mon9*25) + (cashes.mon10*10) + (cashes.mon11*5) + (cashes.mon12*1)) AS total'))
            ->where('idcash', $idcash)->first();
    }
}
