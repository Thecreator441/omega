<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Collector extends Model
{
    protected $table = 'collectors';

    protected $primaryKey = 'idcoll';

    protected $fillable = ['collectors'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCollector(int $id)
    {
        return self::query()->where('idcoll', $id)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast()
    {
        $emp = Session::get('employee');

        return self::query()->where('branch', $emp->branch)->orderByDesc('code')->first();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCollectorsBy(array $where)
    {
        return self::query()->where($where)->get();
    }

    /**
     * @param int|null $inst
     * @param int|null $branch
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|null
     */
    public static function getFilterCollectors(int $inst = null, int $branch = null)
    {
        $emp = Session::get('employee');

        $collectors = null;

        if ($inst === null && $branch === null) {
            $collectors = self::getCollectors();
        }
        if ($inst !== null && $branch === null) {
            $collectors = self::getCollectors(['collectors.institution' => $inst]);
        }
        if (($inst === null && $branch !== null) || ($inst !== null && $branch !== null)) {
            $collectors = self::getCollectors(['collectors.branch' => $branch]);
        }

        foreach ($collectors as $collector) {
            $user = User::getUserBy(['collector' => $collector->idcoll]);
            $cash = Cash::getEmpCash($user->iduser);
            $customers = Collect_Mem::getCollectMems($collector->idcoll);
            foreach ($user->getAttributes() as $index => $item) {
                $collector->$index = $item;
            }
            foreach ($cash->getAttributes() as $index => $item) {
                $collector->$index = $item;
            }
            $collector->customers = $customers->count();
        }

        return $collectors;

    }

    /**
     * @param array $where
     * @return Branch[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCollectors(array $where = [])
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('zone ', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('network ', $emp->network);
                    }
                })->where($where)->orderBy('code')->get();
        }
        return self::query()
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('zone ', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('network ', $emp->network);
                }
            })->orderBy('code')->get();
    }

    /**
     * @param int|null $inst
     * @param int|null $branch
     * @param int|null $month
     * @return Branch[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|null
     */
    public static function getFilterCollectBals(int $inst = null, int $branch = null, int $month = null)
    {
        $emp = Session::get('employee');

        $collectors = null;

        if ($inst === null && $branch === null) {
            $collectors = self::getCollectorsCash();
        }
        if ($inst !== null && $branch === null) {
            $collectors = self::getCollectorsCash(['collectors.institution' => $inst]);
        }
        if (($inst === null && $branch !== null) || ($inst !== null && $branch !== null)) {
            $collectors = self::getCollectorsCash(['collectors.branch' => $branch]);
        }

        $param = Inst_Param::getInstParam($emp->institution);

        $writings = Writing::getSharings($param->revenue_acc, $month);
        $val_writings = ValWriting::getSharings($param->revenue_acc, $month);

        foreach ($val_writings as $val_writing) {
            $writings->add($val_writing);
        }

        foreach ($collectors as $collector) {
            $amount = 0;
            $col_com = 0;
            foreach ($writings as $writing):
                if ($writing->employee === $collector->iduser):
                    $amount += (int)$writing->creditamt;
                endif;
            endforeach;
            $col_com = round(($param->col_com / 100) * $amount, 0);
//            $inst_com = $amount - $col_com;
            $collector->col_com = $col_com;
        }

        return $collectors;
    }

    /**
     * @param array $where
     * @return Branch[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCollectorsCash(array $where = [])
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->select('collectors.*', 'U.iduser')
                ->join('users AS U', 'collectors.idcoll', '=', 'U.collector')
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('collectors.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('collectors.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('collectors.zone ', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('collectors.network ', $emp->network);
                    }
                })->where($where)->orderBy('code')->get();
        }

        return self::query()->select('collectors.*', 'U.iduser')
            ->join('users AS U', 'collectors.idcoll', '=', 'U.collector')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('collectors.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('collectors.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('collectors.zone ', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('collectors.network ', $emp->network);
                }
            })->orderBy('code')->get();
    }

    /**
     * @param int|null $branch
     * @param int|null $month
     * @return Branch[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getFilterSharings(int $branch = null, int $month = null)
    {
        $emp = Session::get('employee');

        $collectors = self::getCollectorsCash();

        $param = Inst_Param::getInstParam($emp->institution);
        $pay = Commis_Pay::getCommisPay();

        $writings = Writing::getFilterSharings($branch, $month);
        $val_writings = ValWriting::getFilterSharings($branch, $month);

        foreach ($val_writings as $val_writing) {
            $writings->add($val_writing);
        }

        foreach ($collectors as $collector) {
            $amount = 0;
            foreach ($writings as $writing):
                if ($writing->employee === $collector->iduser):
                    $amount += (int)$writing->creditamt;
                endif;
            endforeach;
            $col_com = round(($param->col_com / 100) * $amount, 0);
            $inst_com = $amount - $col_com;

            $collector->amount = $amount;
            $collector->col_com = $col_com;
            $collector->inst_com = $inst_com;
            $collector->month = $pay->month;
        }

        return $collectors;

    }


    /**
     * @param int $institution
     * @param int $iduser
     * @return array
     */
    public static function getCollectBalsByColl(int $institution, int $iduser)
    {
        $collectors = self::query()->select('collectors.*', 'U.iduser')
            ->join('users AS U', 'collectors.idcoll', '=', 'U.collector')
            ->where('U.iduser', $iduser)->get();

        $param = Inst_Param::getInstParam($institution);

        $month = null;

        $pay = Commis_Pay::getCommisPayMob();

        if ($pay !== null && $pay->month !== 12) {
            $month = $pay->month + 1;
        }

        $writings = Writing::getSharingsMob($param->revenue_acc, $month);
        $val_writings = ValWriting::getSharingsMob($param->revenue_acc, $month);

        foreach ($val_writings as $val_writing) {
            $writings->add($val_writing);
        }

        $amount = 0;

        foreach ($writings as $writing):
            if ($writing->employee === $iduser):
                $amount += (int)$writing->creditamt;
            endif;
        endforeach;

        foreach ($collectors as $collector) {
            $collector->code = pad($collector->code, 6);
            $collector->name .= ' ' . $collector->surname;
            $collector->col_com = money(round(($param->col_com / 100) * $amount, 0));
        }

        return ['data' => $collectors];
    }

    /**
     * @param int $institution
     * @param int $iduser
     * @param int|null $month
     * @return array
     */
    public static function getFilterCollectBalsByColl(int $institution, int $iduser, int $month = null)
    {
        $collectors = self::query()->select('collectors.*', 'U.iduser')
            ->join('users AS U', 'collectors.idcoll', '=', 'U.collector')
            ->where('U.iduser', $iduser)->get();

        $param = Inst_Param::getInstParam($institution);

        $writings = Writing::getSharingsMob($param->revenue_acc, $month);
        $val_writings = ValWriting::getSharingsMob($param->revenue_acc, $month);

        foreach ($val_writings as $val_writing) {
            $writings->add($val_writing);
        }

        $amount = 0;

        foreach ($writings as $writing):
            if ($writing->employee === $iduser):
                $amount += (int)$writing->creditamt;
            endif;
        endforeach;

        foreach ($collectors as $collector) {
            $collector->code = pad($collector->code, 6);
            $collector->name .= ' ' . $collector->surname;
            $collector->col_com = money(round(($param->col_com / 100) * $amount, 0));
        }

        return ['data' => $collectors];
    }
}
