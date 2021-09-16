<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class ValWriting extends Model
{
    protected $table = 'val_writings';

    protected $primaryKey = 'idvalwrit';

    protected $fillable = ['val_writings'];

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

    /**
     * @return mixed
     */
    public static function getSumDebit(array $where = [])
    {
        $emp = Session::get('employee');

        if ($where === null) {
            return self::query()->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('val_writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('val_writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('val_writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('val_writings.network', $emp->network);
                }
            })->sum('debitamt');
        }

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('val_writings.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('val_writings.institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('val_writings.zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('val_writings.network', $emp->network);
            }
        })->where($where)->sum('debitamt');
    }

    /**
     * @return mixed
     */
    public static function getSumCredit(array $where = [])
    {
        $emp = Session::get('employee');

        if ($where === null) {
            return self::query()->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('val_writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('val_writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('val_writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('val_writings.network', $emp->network);
                }
            })->sum('creditamt');
        }

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('val_writings.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('val_writings.institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('val_writings.zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('val_writings.network', $emp->network);
            }
        })->where($where)->sum('creditamt');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getValJournal(array $where = [])
    {
        $emp = Session::get('employee');

        if ($where === null) {
            return self::query()->select('val_writings.*')
                ->join('accounts AS A', 'val_writings.account', '=', 'A.idaccount')
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('val_writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('val_writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('val_writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('val_writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
        }

        return self::query()->select('val_writings.*')
            ->join('accounts AS A', 'val_writings.account', '=', 'A.idaccount')
            ->where($where)->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('val_writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('val_writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('val_writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('val_writings.network', $emp->network);
                }
            })->orderBy('writnumb')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getEmployees()
    {
        $emp = Session::get('employee');

        return self::query()->distinct('U.iduser')->select('U.*', 'val_writings.employee')
            ->join('users AS U', 'val_writings.employee', '=', 'U.iduser')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('val_writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('val_writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('val_writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('val_writings.network', $emp->network);
                }
            })->orderBy('U.username')->get();
    }

    /**
     * @param int|null $branch
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast(int $branch = null)
    {
        $emp = Session::get('employee');

        if ($branch !== null) {
            return self::query()->where('branch', $branch)->distinct('idvalwrit')->orderByDesc('writnumb')->first();
        }

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('institution', $emp->institution);
            }
        })->distinct('idvalwrit')->orderByDesc('writnumb')->first();
    }

    /**
     * @param int $rev_acc
     * @param int $tax_acc
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getSharings(int $rev_acc, int $month = null)
    {
        $emp = Session::get('employee');

        if ($month === null) {
            return self::query()->distinct('val_writings.employee')
                ->select('val_writings.*', 'C.code', 'C.name', 'C.surname')
                ->join('users AS U', 'val_writings.employee', '=', 'U.iduser')
                ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
                ->where('account', $rev_acc)
                ->whereRaw('YEAR(date(val_writings.created_at)) = ' . date('Y'))
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('val_writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('val_writings.institution', $emp->institution);
                    }
                })->orderBy('writnumb')->get();
        }

        return self::query()->distinct('val_writings.employee')
            ->select('val_writings.*', 'C.code', 'C.name', 'C.surname')
            ->join('users AS U', 'val_writings.employee', '=', 'U.iduser')
            ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
            ->where('account', $rev_acc)
            ->whereRaw('YEAR(date(val_writings.created_at)) = ' . date('Y') . ' AND MONTH(date(val_writings.created_at)) = ' . $month)
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('val_writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('val_writings.institution', $emp->institution);
                }
            })->orderBy('writnumb')->get();
    }

    /**
     * @param int|null $branch
     * @param int|null $month
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getFilterSharings(int $branch = null, int $month = null)
    {
        $emp = Session::get('employee');
        $param = Inst_Param::getInstParam($emp->institution);

        if ($branch === null && $month === null) {
            return self::query()->select('val_writings.*', 'C.code', 'C.name', 'C.surname')->distinct('idwrit')
                ->join('users AS U', 'val_writings.employee', '=', 'U.iduser')
                ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
                ->where('account', $param->revenue_acc)
                ->whereRaw('YEAR(date(val_writings.created_at)) = ' . date('Y'))
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('val_writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('val_writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('val_writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('val_writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
        }

        if ($branch !== null && $month === null) {
            return self::query()->select('val_writings.*', 'C.code', 'C.name', 'C.surname')->distinct('idwrit')
                ->join('users AS U', 'val_writings.employee', '=', 'U.iduser')
                ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
                ->where('account', $param->revenue_acc)
                ->whereRaw('YEAR(date(val_writings.created_at)) = ' . date('Y') . ' AND val_writings.branch = ' . $branch)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('val_writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('val_writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('val_writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('val_writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
        }

        if ($branch === null && $month !== null) {
            return self::query()->select('val_writings.*', 'C.code', 'C.name', 'C.surname')->distinct('idwrit')
                ->join('users AS U', 'val_writings.employee', '=', 'U.iduser')
                ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
                ->where('account', $param->revenue_acc)
                ->whereRaw('YEAR(date(val_writings.created_at)) = ' . date('Y') . ' AND MONTH(date(val_writings.created_at)) = ' . $month)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('val_writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('val_writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('val_writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('val_writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
        }

        return self::query()->select('val_writings.*', 'C.code', 'C.name', 'C.surname')->distinct('idwrit')
            ->join('users AS U', 'val_writings.employee', '=', 'U.iduser')
            ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
            ->where('account', $param->revenue_acc)
            ->whereRaw('val_writings.branch = ' . $branch . ' AND YEAR(date(val_writings.created_at)) = ' . date('Y') . ' AND MONTH(date(val_writings.created_at)) = ' . $month)
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('val_writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('val_writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('val_writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('val_writings.network', $emp->network);
                }
            })->orderBy('writnumb')->get();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getReports()
    {
        $emp = Session::get('employee');
        $iParam = Inst_Param::getInstParam($emp->institution);

        $val_writings = self::query()->select('val_writings.creditamt AS amount', 'val_writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
            ->join('collect_mems AS Cm', 'val_writings.aux', '=', 'Cm.idcollect_mem')
            ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
            ->where(['val_writings.account' => $iParam->client_acc, 'val_writings.debitamt' => null])
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('val_writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('val_writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('val_writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('val_writings.network', $emp->network);
                }
                if ($emp->collector !== null) {
                    $query->where('val_writings.employee', $emp->iduser);
                }
            })->orderBy('writnumb')->get();
        $revenue_vals = self::query()->where(['val_writings.account' => $iParam->revenue_acc, 'val_writings.debitamt' => null])
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('val_writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('val_writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('val_writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('val_writings.network', $emp->network);
                }
                if ($emp->collector !== null) {
                    $query->where('val_writings.employee', $emp->iduser);
                }
            })->orderBy('writnumb')->get();
        $tax_vals = self::query()->where(['val_writings.account' => $iParam->tax_acc, 'val_writings.debitamt' => null])
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('val_writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('val_writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('val_writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('val_writings.network', $emp->network);
                }
                if ($emp->collector !== null) {
                    $query->where('val_writings.employee', $emp->iduser);
                }
            })->orderBy('writnumb')->get();

        foreach ($val_writings as $index => $val_writing) {
            $val_writing->total = $val_writing->amount + $revenue_vals[$index]->creditamt + $tax_vals[$index]->creditamt;
            $val_writing->client = $val_writing->amount;
            $val_writing->revenue = $revenue_vals[$index]->creditamt;
            $val_writing->tax = $tax_vals[$index]->creditamt;

            $col_com = round(($iParam->col_com / 100) * $revenue_vals[$index]->creditamt, 0);
            $inst_com = round(($iParam->inst_com / 100) * $revenue_vals[$index]->creditamt, 0);

            $val_writing->col_com = $col_com;
            $val_writing->inst_com = $inst_com;
        }

        return $val_writings;
    }

    /**
     * @param int|null $zone
     * @param int|null $institution
     * @param int|null $branch
     * @param int|null $collector
     * @param string|null $from
     * @param string|null $to
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|null
     */
    public static function getFilterReports(int $zone = null, int $institution = null, int $branch = null, int $collector = null, string $from = null, string $to = null)
    {
        $emp = Session::get('employee');
        $param = Inst_Param::getInstParam($emp->institution);
        $val_writings = null;
        $revenue_vals = null;
        $tax_vals = null;
        $date1 = dbDate($from);
        $date2 = dbDate($to);

        if ($emp->level === 'B') {
            $val_writings = self::query()->select('val_writings.creditamt AS amount', 'val_writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
                ->join('collect_mems AS Cm', 'val_writings.aux', '=', 'Cm.idcollect_mem')
                ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
                ->where([
                    'val_writings.account' => $param->client_acc,
                    'val_writings.debitamt' => null,
                    'val_writings.branch' => $emp->branch
                ])->where(static function ($query) use ($collector, $date1, $date2) {
                    if ($collector !== null && $date1 === null && $date2 === null) {
                        $query->where('val_writings.employee', $collector);
                    }
                    if ($collector !== null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($collector !== null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($collector !== null && $date1 !== null && $date2 !== null) {
                        $query->where('val_writings.employee', $collector)
                            ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                    if ($collector === null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($collector === null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($collector === null && $date1 !== null && $date2 !== null) {
                        $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                })->orderBy('writnumb')->get();
            $revenue_vals = self::query()->where([
                'val_writings.account' => $param->revenue_acc,
                'val_writings.debitamt' => null,
                'val_writings.branch' => $emp->branch
            ])->where(static function ($query) use ($collector, $date1, $date2) {
                if ($collector !== null && $date1 === null && $date2 === null) {
                    $query->where('val_writings.employee', $collector);
                }
                if ($collector !== null && $date1 !== null && $date2 === null) {
                    $query->where('val_writings.employee', $collector)
                        ->where('val_writings.accdate', '>=', $date1);
                }
                if ($collector !== null && $date1 === null && $date2 !== null) {
                    $query->where('val_writings.employee', $collector)
                        ->where('val_writings.accdate', '<=', $date2);
                }
                if ($collector !== null && $date1 !== null && $date2 !== null) {
                    $query->where('val_writings.employee', $collector)
                        ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                }
                if ($collector === null && $date1 !== null && $date2 === null) {
                    $query->where('val_writings.accdate', '>=', $date1);
                }
                if ($collector === null && $date1 === null && $date2 !== null) {
                    $query->where('val_writings.accdate', '<=', $date2);
                }
                if ($collector === null && $date1 !== null && $date2 !== null) {
                    $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();
            $tax_vals = self::query()->where([
                'val_writings.account' => $param->tax_acc,
                'val_writings.debitamt' => null,
                'val_writings.branch' => $emp->branch
            ])->where(static function ($query) use ($collector, $date1, $date2) {
                if ($collector !== null && $date1 === null && $date2 === null) {
                    $query->where('val_writings.employee', $collector);
                }
                if ($collector !== null && $date1 !== null && $date2 === null) {
                    $query->where('val_writings.employee', $collector)
                        ->where('val_writings.accdate', '>=', $date1);
                }
                if ($collector !== null && $date1 === null && $date2 !== null) {
                    $query->where('val_writings.employee', $collector)
                        ->where('val_writings.accdate', '<=', $date2);
                }
                if ($collector !== null && $date1 !== null && $date2 !== null) {
                    $query->where('val_writings.employee', $collector)
                        ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                }
                if ($collector === null && $date1 !== null && $date2 === null) {
                    $query->where('val_writings.accdate', '>=', $date1);
                }
                if ($collector === null && $date1 === null && $date2 !== null) {
                    $query->where('val_writings.accdate', '<=', $date2);
                }
                if ($collector === null && $date1 !== null && $date2 !== null) {
                    $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();

        }

        if ($emp->level === 'I') {
            $val_writings = self::query()->select('val_writings.creditamt AS amount', 'val_writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
                ->join('collect_mems AS Cm', 'val_writings.aux', '=', 'Cm.idcollect_mem')
                ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
                ->where([
                    'val_writings.account' => $param->client_acc,
                    'val_writings.debitamt' => null,
                    'val_writings.institution' => $emp->institution
                ])
                ->where(static function ($query) use ($branch, $collector, $date1, $date2) {
                    if ($branch !== null && $collector === null && $date1 === null && $date2 === null) {
                        $query->where('val_writings.branch', $branch);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.branch', $branch)
                            ->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($branch !== null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.branch', $branch)
                            ->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->where('val_writings.branch', $branch)
                            ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($branch === null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 === null) || ($branch === null && $collector !== null && $date1 === null && $date2 === null)) {
                        $query->where('val_writings.employee', $collector);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 === null) || ($branch === null && $collector !== null && $date1 !== null && $date2 === null)) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '>=', $date1);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 !== null) || ($branch === null && $collector !== null && $date1 === null && $date2 !== null)) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '<=', $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 !== null) || ($branch === null && $collector !== null && $date1 !== null && $date2 !== null)) {
                        $query->where('val_writings.employee', $collector)
                            ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                })
                ->orderBy('writnumb')->get();
            $revenue_vals = self::query()
                ->where([
                    'val_writings.account' => $param->revenue_acc,
                    'val_writings.debitamt' => null,
                    'val_writings.institution' => $emp->institution
                ])
                ->where(static function ($query) use ($branch, $collector, $date1, $date2) {
                    if ($branch !== null && $collector === null && $date1 === null && $date2 === null) {
                        $query->where('val_writings.branch', $branch);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.branch', $branch)
                            ->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($branch !== null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.branch', $branch)
                            ->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->where('val_writings.branch', $branch)
                            ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($branch === null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 === null) || ($branch === null && $collector !== null && $date1 === null && $date2 === null)) {
                        $query->where('val_writings.employee', $collector);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 === null) || ($branch === null && $collector !== null && $date1 !== null && $date2 === null)) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '>=', $date1);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 !== null) || ($branch === null && $collector !== null && $date1 === null && $date2 !== null)) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '<=', $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 !== null) || ($branch === null && $collector !== null && $date1 !== null && $date2 !== null)) {
                        $query->where('val_writings.employee', $collector)
                            ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                })
                ->orderBy('writnumb')->get();
            $tax_vals = self::query()
                ->where([
                    'val_writings.account' => $param->tax_acc,
                    'val_writings.debitamt' => null,
                    'val_writings.institution' => $emp->institution
                ])
                ->where(static function ($query) use ($branch, $collector, $date1, $date2) {
                    if ($branch !== null && $collector === null && $date1 === null && $date2 === null) {
                        $query->where('val_writings.branch', $branch);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.branch', $branch)
                            ->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($branch !== null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.branch', $branch)
                            ->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->where('val_writings.branch', $branch)
                            ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($branch === null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 === null) || ($branch === null && $collector !== null && $date1 === null && $date2 === null)) {
                        $query->where('val_writings.employee', $collector);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 === null) || ($branch === null && $collector !== null && $date1 !== null && $date2 === null)) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '>=', $date1);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 !== null) || ($branch === null && $collector !== null && $date1 === null && $date2 !== null)) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '<=', $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 !== null) || ($branch === null && $collector !== null && $date1 !== null && $date2 !== null)) {
                        $query->where('val_writings.employee', $collector)
                            ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                })
                ->orderBy('writnumb')->get();
        }

        if ($zone === null && $institution === null && $branch === null && $collector === null && $date1 === null && $date2 === null) {
            $val_writings = self::query()->select('val_writings.creditamt AS amount', 'val_writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
                ->join('collect_mems AS Cm', 'val_writings.aux', '=', 'Cm.idcollect_mem')
                ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
                ->where(['val_writings.account' => $param->client_acc, 'val_writings.debitamt' => null])
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('val_writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('val_writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('val_writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('val_writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
            $revenue_vals = self::query()->where(['val_writings.account' => $param->revenue_acc, 'val_writings.debitamt' => null])
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('val_writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('val_writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('val_writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('val_writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
            $tax_vals = self::query()->where(['val_writings.account' => $param->tax_acc, 'val_writings.debitamt' => null])
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('val_writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('val_writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('val_writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('val_writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
        }

        foreach ($val_writings as $index => $val_writing) {
            $val_writing->total = money($val_writing->amount + $revenue_vals[$index]->creditamt + $tax_vals[$index]->creditamt);
            $val_writing->client = money((int)$val_writing->amount);
            $val_writing->revenue = money((int)$revenue_vals[$index]->creditamt);
            $val_writing->tax = money((int)$tax_vals[$index]->creditamt);

            $col_com = round(($param->col_com / 100) * $revenue_vals[$index]->creditamt, 0);
            $inst_com = round(($param->inst_com / 100) * $revenue_vals[$index]->creditamt, 0);

            $val_writing->accdate = changeFormat($val_writing->accdate);
            $val_writing->code = pad($val_writing->code, 6);
            $val_writing->name .= ' ' . $val_writing->surname;
            $val_writing->col_name .= ' ' . $val_writing->col_surname;
            $val_writing->col_com = money((int)$col_com);
            $val_writing->inst_com = money((int)$inst_com);
        }

        return $val_writings;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getStatements()
    {
        $emp = Session::get('employee');
        $iParam = Inst_Param::getInstParam($emp->institution);

        $val_writings = self::query()->where('account', $iParam->client_acc)
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('val_writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('val_writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('val_writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('val_writings.network', $emp->network);
                }
            })->orderBy('writnumb')->get();

        return $val_writings;
    }

    /**
     * @param int|null $zone
     * @param int|null $institution
     * @param int|null $branch
     * @param int|null $collector
     * @param string|null $from
     * @param string|null $to
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|null
     */
    public static function getFilterStatements(int $zone = null, int $institution = null, int $branch = null, int $collector = null, string $from = null, string $to = null)
    {
        $emp = Session::get('employee');
        $param = Inst_Param::getInstParam($emp->institution);
        $val_writings = null;
        $revenue_vals = null;
        $tax_vals = null;
        $date1 = dbDate($from);
        $date2 = dbDate($to);

        if ($emp->level === 'B') {
            $val_writings = self::query()->select('val_writings.debitamt AS amount', 'val_writings.creditamt AS amount', 'val_writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
                ->join('collect_mems AS Cm', 'val_writings.aux', '=', 'Cm.idcollect_mem')
                ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
                ->where([
                    'account' => $param->client_acc,
                    'val_writings.branch' => $emp->branch
                ])->where(static function ($query) use ($collector, $date1, $date2) {
                    if ($collector !== null && $date1 === null && $date2 === null) {
                        $query->where('val_writings.employee', $collector);
                    }
                    if ($collector !== null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($collector !== null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($collector !== null && $date1 !== null && $date2 !== null) {
                        $query->where('val_writings.employee', $collector)
                            ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                    if ($collector === null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($collector === null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($collector === null && $date1 !== null && $date2 !== null) {
                        $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                })->orderBy('writnumb')->get();
            $revenue_vals = self::query()->where([
                'account' => $param->revenue_acc,
                'val_writings.branch' => $emp->branch
            ])->where(static function ($query) use ($collector, $date1, $date2) {
                if ($collector !== null && $date1 === null && $date2 === null) {
                    $query->where('val_writings.employee', $collector);
                }
                if ($collector !== null && $date1 !== null && $date2 === null) {
                    $query->where('val_writings.employee', $collector)
                        ->where('val_writings.accdate', '>=', $date1);
                }
                if ($collector !== null && $date1 === null && $date2 !== null) {
                    $query->where('val_writings.employee', $collector)
                        ->where('val_writings.accdate', '<=', $date2);
                }
                if ($collector !== null && $date1 !== null && $date2 !== null) {
                    $query->where('val_writings.employee', $collector)
                        ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                }
                if ($collector === null && $date1 !== null && $date2 === null) {
                    $query->where('val_writings.accdate', '>=', $date1);
                }
                if ($collector === null && $date1 === null && $date2 !== null) {
                    $query->where('val_writings.accdate', '<=', $date2);
                }
                if ($collector === null && $date1 !== null && $date2 !== null) {
                    $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();
            $tax_vals = self::query()->where([
                'account' => $param->tax_acc,
                'val_writings.branch' => $emp->branch
            ])->where(static function ($query) use ($collector, $date1, $date2) {
                if ($collector !== null && $date1 === null && $date2 === null) {
                    $query->where('val_writings.employee', $collector);
                }
                if ($collector !== null && $date1 !== null && $date2 === null) {
                    $query->where('val_writings.employee', $collector)
                        ->where('val_writings.accdate', '>=', $date1);
                }
                if ($collector !== null && $date1 === null && $date2 !== null) {
                    $query->where('val_writings.employee', $collector)
                        ->where('val_writings.accdate', '<=', $date2);
                }
                if ($collector !== null && $date1 !== null && $date2 !== null) {
                    $query->where('val_writings.employee', $collector)
                        ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                }
                if ($collector === null && $date1 !== null && $date2 === null) {
                    $query->where('val_writings.accdate', '>=', $date1);
                }
                if ($collector === null && $date1 === null && $date2 !== null) {
                    $query->where('val_writings.accdate', '<=', $date2);
                }
                if ($collector === null && $date1 !== null && $date2 !== null) {
                    $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();

        }

        if ($emp->level === 'I') {
            $val_writings = self::query()->select('val_writings.creditamt AS amount', 'val_writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
                ->join('collect_mems AS Cm', 'val_writings.aux', '=', 'Cm.idcollect_mem')
                ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
                ->where([
                    'account' => $param->client_acc,
                    'val_writings.institution' => $emp->institution
                ])
                ->where(static function ($query) use ($branch, $collector, $date1, $date2) {
                    if ($branch !== null && $collector === null && $date1 === null && $date2 === null) {
                        $query->where('val_writings.branch', $branch);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.branch', $branch)
                            ->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($branch !== null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.branch', $branch)
                            ->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->where('val_writings.branch', $branch)
                            ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($branch === null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 === null) || ($branch === null && $collector !== null && $date1 === null && $date2 === null)) {
                        $query->where('val_writings.employee', $collector);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 === null) || ($branch === null && $collector !== null && $date1 !== null && $date2 === null)) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '>=', $date1);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 !== null) || ($branch === null && $collector !== null && $date1 === null && $date2 !== null)) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '<=', $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 !== null) || ($branch === null && $collector !== null && $date1 !== null && $date2 !== null)) {
                        $query->where('val_writings.employee', $collector)
                            ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                })
                ->orderBy('writnumb')->get();
            $revenue_vals = self::query()
                ->where([
                    'account' => $param->revenue_acc,
                    'val_writings.institution' => $emp->institution
                ])
                ->where(static function ($query) use ($branch, $collector, $date1, $date2) {
                    if ($branch !== null && $collector === null && $date1 === null && $date2 === null) {
                        $query->where('val_writings.branch', $branch);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.branch', $branch)
                            ->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($branch !== null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.branch', $branch)
                            ->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->where('val_writings.branch', $branch)
                            ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($branch === null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 === null) || ($branch === null && $collector !== null && $date1 === null && $date2 === null)) {
                        $query->where('val_writings.employee', $collector);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 === null) || ($branch === null && $collector !== null && $date1 !== null && $date2 === null)) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '>=', $date1);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 !== null) || ($branch === null && $collector !== null && $date1 === null && $date2 !== null)) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '<=', $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 !== null) || ($branch === null && $collector !== null && $date1 !== null && $date2 !== null)) {
                        $query->where('val_writings.employee', $collector)
                            ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                })
                ->orderBy('writnumb')->get();
            $tax_vals = self::query()
                ->where([
                    'account' => $param->tax_acc,
                    'val_writings.institution' => $emp->institution
                ])
                ->where(static function ($query) use ($branch, $collector, $date1, $date2) {
                    if ($branch !== null && $collector === null && $date1 === null && $date2 === null) {
                        $query->where('val_writings.branch', $branch);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.branch', $branch)
                            ->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($branch !== null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.branch', $branch)
                            ->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->where('val_writings.branch', $branch)
                            ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('val_writings.accdate', '>=', $date1);
                    }
                    if ($branch === null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('val_writings.accdate', '<=', $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 === null) || ($branch === null && $collector !== null && $date1 === null && $date2 === null)) {
                        $query->where('val_writings.employee', $collector);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 === null) || ($branch === null && $collector !== null && $date1 !== null && $date2 === null)) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '>=', $date1);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 !== null) || ($branch === null && $collector !== null && $date1 === null && $date2 !== null)) {
                        $query->where('val_writings.employee', $collector)
                            ->where('val_writings.accdate', '<=', $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 !== null) || ($branch === null && $collector !== null && $date1 !== null && $date2 !== null)) {
                        $query->where('val_writings.employee', $collector)
                            ->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                    }
                })
                ->orderBy('writnumb')->get();
        }

        if ($zone === null && $institution === null && $branch === null && $collector === null && $date1 === null && $date2 === null) {
            $val_writings = self::query()->select('val_writings.creditamt AS amount', 'val_writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
                ->join('collect_mems AS Cm', 'val_writings.aux', '=', 'Cm.idcollect_mem')
                ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
                ->where('account', $param->client_acc)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('val_writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('val_writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('val_writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('val_writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
            $revenue_vals = self::query()
                ->where('account', $param->revenue_acc)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('val_writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('val_writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('val_writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('val_writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
            $tax_vals = self::query()
                ->where('account', $param->tax_acc)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('val_writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('val_writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('val_writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('val_writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
        }

        foreach ($val_writings as $index => $val_writing) {
            $val_writing->total = $val_writing->amount + $revenue_vals[$index]->creditamt + $tax_vals[$index]->creditamt;
            $val_writing->client = $val_writing->amount;
            $val_writing->revenue = $revenue_vals[$index]->creditamt;
            $val_writing->tax = $tax_vals[$index]->creditamt;

            $col_com = round(($param->col_com / 100) * $revenue_vals[$index]->creditamt, 0);
            $inst_com = round(($param->inst_com / 100) * $revenue_vals[$index]->creditamt, 0);

            $val_writing->col_com = $col_com;
            $val_writing->inst_com = $inst_com;
        }

        return $val_writings;
    }

    public static function getValidJournals(int $network = null, int $zone = null, int $institution = null, int $branch = null, int $user = null, string $state = null, string $from = null, string $to = null, string $lang = 'eng')
    {
        $date1 = dbDate($from);
        $date2 = dbDate($to);
        $val_writings = '';
        $sumDebit = '';
        $sumCredit = '';

        $val_writings = self::query()->select('val_writings.*', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'C.cashcode')
        ->join('accounts AS A', 'val_writings.account', '=', 'A.idaccount')
        ->join('cashes AS C', 'val_writings.cash', '=', 'C.idcash')
        ->where(static function ($query) use ($user, $state) {
            if ($user !== null && $state === null) {
                $query->where('val_writings.employee', $user);
            }
            if ($user === null && $state !== null) {
                $query->where('val_writings.writ_type', $state);
            }
            if ($user !== null && $state !== null) {
                $query->where([
                    'val_writings.employee' => $user,
                    'val_writings.writ_type' => $state,
                ]);
            }
        })->where(static function ($query) use ($date1, $date2) {
            if ($date1 !== null && $date2 === null) {
                $query->where('val_writings.accdate', '>=', $date1);
            }
            if ($date1 === null && $date2 !== null) {
                $query->where('val_writings.accdate', '<=', $date2);
            }
            if ($date1 !== null && $date2 !== null) {
                $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
            }
        })->where(static function ($query) use ($network, $zone, $institution, $branch) {
            $query->orWhere([
                'val_writings.branch' => $branch,
                'val_writings.institution' => $institution,
                'val_writings.zone' => $zone,
                'val_writings.network' => $network
            ]);
        })->orderBy('writnumb')->get();

        $sumDebit = self::query()->where(static function ($query) use ($user, $state) {
            if ($user !== null && $state === null) {
                $query->where('val_writings.employee', $user);
            }
            if ($user === null && $state !== null) {
                $query->where('val_writings.writ_type', $state);
            }
            if ($user !== null && $state !== null) {
                $query->where([
                    'val_writings.employee' => $user,
                    'val_writings.writ_type' => $state,
                ]);
            }
        })->where(static function ($query) use ($date1, $date2) {
            if ($date1 !== null && $date2 === null) {
                $query->where('val_writings.accdate', '>=', $date1);
            }
            if ($date1 === null && $date2 !== null) {
                $query->where('val_writings.accdate', '<=', $date2);
            }
            if ($date1 !== null && $date2 !== null) {
                $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
            }
        })->where(static function ($query) use ($network, $zone, $institution, $branch) {
            $query->orWhere([
                'val_writings.branch' => $branch,
                'val_writings.institution' => $institution,
                'val_writings.zone' => $zone,
                'val_writings.network' => $network
            ]);
        })->sum('debitamt');

        $sumCredit = self::query()->where(static function ($query) use ($user, $state) {
            if ($user !== null && $state === null) {
                $query->where('val_writings.employee', $user);
            }
            if ($user === null && $state !== null) {
                $query->where('val_writings.writ_type', $state);
            }
            if ($user !== null && $state !== null) {
                $query->where([
                    'val_writings.employee' => $user,
                    'val_writings.writ_type' => $state,
                ]);
            }
        })->where(static function ($query) use ($date1, $date2) {
            if ($date1 !== null && $date2 === null) {
                $query->where('val_writings.accdate', '>=', $date1);
            }
            if ($date1 === null && $date2 !== null) {
                $query->where('val_writings.accdate', '<=', $date2);
            }
            if ($date1 !== null && $date2 !== null) {
                $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
            }
        })->where(static function ($query) use ($network, $zone, $institution, $branch) {
            $query->orWhere([
                'val_writings.branch' => $branch,
                'val_writings.institution' => $institution,
                'val_writings.zone' => $zone,
                'val_writings.network' => $network
            ]);
        })->sum('creditamt');

        foreach ($val_writings as $val_writing) {
            $val_writing->refs = formWriting($val_writing->accdate, $val_writing->network, $val_writing->zone, $val_writing->institution, $val_writing->branch, $val_writing->writnumb);

            $aux = null;
            if ($val_writing->mem_aux !== null) {
                $member = Member::getMember($val_writing->mem_aux);
                $val_writing->code = pad($member->memnumb, 6);
                $val_writing->name = $member->name;
                $val_writing->surname = $member->surname;
            } elseif ($val_writing->emp_aux !== null) {
                $employee = Employee::getEmployee($val_writing->emp_aux);
                $val_writing->code = pad($employee->empmat, 6);
                $val_writing->name = $employee->name;
                $val_writing->surname = $employee->surname;
            }

            if (is_numeric($val_writing->operation)) {
                $opera = Operation::getOperation($val_writing->operation);
                $val_writing->operation = $opera->labeleng;
                if ($lang === 'fr') {
                    $val_writing->operation = $opera->labelfr;
                }
            }

            $val_writing->account = $val_writing->accnumb;
            $val_writing->aux = $val_writing->code . ' - ' . $val_writing->name . ' ' . $val_writing->surname;
            // $val_writing->aux = $val_writing->code . ' - ' . explode(' ', $val_writing->name)[0] . ' ' . explode(' ', $val_writing->surname)[0];
            $val_writing->debit = money((int)$val_writing->debitamt);
            $val_writing->credit = money((int)$val_writing->creditamt);
            $val_writing->accdate = changeFormat($val_writing->accdate);
            $val_writing->operdate = changeFormat($val_writing->created_at);
            $val_writing->time = getsTime($val_writing->created_at);
        }

        return [
            'data' => $val_writings,
            'sumDebit' => money((int)$sumDebit),
            'sumCredit' => money((int)$sumCredit),
            'sumBal' => money((int)$sumDebit - (int)$sumCredit)
        ];
    }

    /**
     * @param int $network
     * @param int $collector
     * @param int $idcollect
     * @param string $lang
     * @return array
     */
    public static function getTransactionsByColl(int $network, int $collector, int $idcollect, string $lang)
    {
        $val_writings = self::query()->select('val_writings.*')
            ->join('accounts AS A', 'val_writings.account', '=', 'A.idaccount')
            ->where('val_writings.employee', $collector)
            ->orderBy('writnumb')->get();
        $accounts = Account::getAccountsMob($network);
        $operas = Operation::getOperations();
        $members = Collect_Mem::getCollectMems($idcollect);
        $collector = Collector::getCollector($idcollect);

        $sumDebit = self::query()->where('val_writings.employee', $collector)->sum('debitamt');
        $sumCredit = self::query()->where('val_writings.employee', $collector)->sum('creditamt');

        foreach ($val_writings as $val_writing) {
            $val_writing->refs = formWriting($val_writing->accdate, $val_writing->network, $val_writing->zone, $val_writing->institution, $val_writing->branch, $val_writing->writnumb);

            foreach ($accounts as $account) {
                if ($account->idaccount === $val_writing->account) {
                    $val_writing->acc = $account->accnumb;
                }
            }

            if ($val_writing->coll_aux !== null) {
                if ($collector->idcoll === $val_writing->coll_aux) {
                    $val_writing->aux = pad($collector->code, 6);
                }
            }
            if ($val_writing->aux !== null) {
                foreach ($members as $member) {
                    if ($member->idcollect_mem === $val_writing->aux) {
                        $val_writing->aux = pad($member->coll_memnumb, 6);
                    }
                }
            }

            if (is_numeric($val_writing->operation)) {
                foreach ($operas as $opera) {
                    if ($opera->idoper === (int)$val_writing->operation) {
                        if ($lang === 'fr') {
                            $val_writing->operation = $opera->labelfr;
                        } else {
                            $val_writing->operation = $opera->labeleng;
                        }
                    }
                }
            }

            $val_writing->debit = money((int)$val_writing->debitamt);
            $val_writing->credit = money((int)$val_writing->creditamt);
            $val_writing->accdate = changeFormat($val_writing->accdate);
            $val_writing->datetime = getsDateTime($val_writing->created_at);
        }

        return [
            'data' => $val_writings,
            'sumDebit' => money((int)$sumDebit),
            'sumCredit' => money((int)$sumCredit)
        ];
    }

    /**
     * @param int $network
     * @param int $collector
     * @param int $idcollect
     * @param string $lang
     * @return array
     */
    public static function getFilterTransactionsByColl(int $network, int $collector, int $idcollect, string $lang, string $from = null, string $to = null)
    {
        $date1 = dbDate($from);
        $date2 = dbDate($to);









        $val_writings = self::query()->select('val_writings.*')
            ->join('accounts AS A', 'val_writings.account', '=', 'A.idaccount')
            ->where('val_writings.employee', $collector)
            ->where(static function ($query) use ($date1, $date2) {
                if ($date1 !== null && $date2 === null) {
                    $query->where('val_writings.accdate', '>=', $date1);
                }
                if ($date1 === null && $date2 !== null) {
                    $query->where('val_writings.accdate', '<=', $date2);
                }
                if ($date1 !== null && $date2 !== null) {
                    $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();

        $collects = Collector::getCollectorsCash();
        $accounts = Account::getAccounts();
        $operas = Operation::getOperations();
        $members = Member::getMembers();
        $coll_members = Collect_Mem::getMembers();

        $user = User::getUser($collector);

        $sumDebit = self::query()->where('val_writings.employee', $collector)->sum('debitamt');
        $sumCredit = self::query()->where('val_writings.employee', $collector)->sum('creditamt');

        foreach ($val_writings as $val_writing) {
            $val_writing->refs = formWriting($val_writing->accdate, $val_writing->network, $val_writing->zone, $val_writing->institution, $val_writing->branch, $val_writing->writnumb);

            foreach ($accounts as $account) {
                if ($account->idaccount === $val_writing->account) {
                    $val_writing->acc = $account->accnumb;
                }
            }


            if ($val_writing->aux !== null) {
                foreach ($members as $member) {
                    if ($member->idmember === $val_writing->aux) {
                        $val_writing->aux = pad($member->memnumb, 6);
                    }
                }
            }
            if ($val_writing->coll_aux !== null) {
                foreach ($coll_members as $coll_member) {
                    if ($coll_member->idcollect_mem === $val_writing->coll_aux) {
                        $val_writing->aux = pad($coll_member->coll_memnumb, 6);
                    }
                }
            }
            if ($val_writing->collector !== null) {
                foreach ($collects as $collect) {
                    if ($collect->idcoll === $val_writing->collector) {
                        $val_writing->aux = pad($collector->code, 6);
                    }
                }
            }


            if (is_numeric($val_writing->operation)) {
                foreach ($operas as $opera) {
                    if ($opera->idoper === (int)$val_writing->operation) {
                        if ($lang === 'fr') {
                            $val_writing->operation = $opera->labelfr;
                        } else {
                            $val_writing->operation = $opera->labeleng;
                        }
                    }
                }
            }

            $val_writing->debit = money((int)$val_writing->debitamt);
            $val_writing->credit = money((int)$val_writing->creditamt);
            $val_writing->accdate = changeFormat($val_writing->accdate);
            $val_writing->datetime = getsDateTime($val_writing->created_at);
        }

        return [
            'data' => $val_writings,
            'sumDebit' => money((int)$sumDebit),
            'sumCredit' => money((int)$sumCredit)
        ];
    }

    /**
     * @param int $rev_acc
     * @param int $tax_acc
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getSharingsMob(int $rev_acc, int $month = null)
    {
        if ($month === null) {
            return self::query()->distinct('val_writings.employee')
                ->select('val_writings.*', 'C.code', 'C.name', 'C.surname')
                ->join('users AS U', 'val_writings.employee', '=', 'U.iduser')
                ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
                ->where('account', $rev_acc)
                ->whereRaw('YEAR(date(val_writings.created_at)) = ' . date('Y'))
                ->orderBy('writnumb')->get();
        }

        return self::query()->distinct('val_writings.employee')
            ->select('val_writings.*', 'C.code', 'C.name', 'C.surname')
            ->join('users AS U', 'val_writings.employee', '=', 'U.iduser')
            ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
            ->where('account', $rev_acc)
            ->whereRaw('YEAR(date(val_writings.created_at)) = ' . date('Y') . ' AND MONTH(date(val_writings.created_at)) = ' . $month)
            ->orderBy('writnumb')->get();
    }

    /**
     * @param int $institution
     * @param int $collector
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getReportsByColl(int $institution, int $collector)
    {
        $iParam = Inst_Param::getInstParam($institution);

        $val_writings = self::query()->select('val_writings.creditamt AS amount', 'val_writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
            ->join('collect_mems AS Cm', 'val_writings.aux', '=', 'Cm.idcollect_mem')
            ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
            ->where([
                'val_writings.account' => $iParam->client_acc,
                'val_writings.debitamt' => null,
                'val_writings.employee' => $collector
            ])->orderBy('writnumb')->get();
        $revenue_vals = self::query()->where([
            'val_writings.account' => $iParam->revenue_acc,
            'val_writings.debitamt' => null,
            'val_writings.employee' => $collector
        ])->orderBy('writnumb')->get();
        $tax_vals = self::query()->where([
            'val_writings.account' => $iParam->tax_acc,
            'val_writings.debitamt' => null,
            'val_writings.employee' => $collector
        ])->orderBy('writnumb')->get();

        foreach ($val_writings as $index => $val_writing) {
            $val_writing->total = money($val_writing->amount + $revenue_vals[$index]->creditamt + $tax_vals[$index]->creditamt);
            $val_writing->client = money((int)$val_writing->amount);
            $val_writing->revenue = money((int)$revenue_vals[$index]->creditamt);
            $val_writing->tax = money((int)$tax_vals[$index]->creditamt);

            $col_com = round(($iParam->col_com / 100) * $revenue_vals[$index]->creditamt, 0);
            $inst_com = round(($iParam->inst_com / 100) * $revenue_vals[$index]->creditamt, 0);

            $val_writing->accdate = changeFormat($val_writing->accdate);
            $val_writing->code = pad($val_writing->code, 6);
            $val_writing->name .= ' ' . $val_writing->surname;
            $val_writing->col_name .= ' ' . $val_writing->col_surname;
            $val_writing->col_com = money((int)$col_com);
            $val_writing->inst_com = money((int)$inst_com);
        }

        return $val_writings;
    }

    /**
     * @param int|null $institution
     * @param int|null $collector
     * @param string|null $from
     * @param string|null $to
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getFilterReportsByColl(int $institution = null, int $collector = null, string $from = null, string $to = null)
    {
        $param = Inst_Param::getInstParam($institution);
        $date1 = dbDate($from);
        $date2 = dbDate($to);

        $val_writings = self::query()->select('val_writings.creditamt AS amount', 'val_writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
            ->join('collect_mems AS Cm', 'val_writings.aux', '=', 'Cm.idcollect_mem')
            ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
            ->where([
                'val_writings.account' => $param->client_acc,
                'val_writings.debitamt' => null,
                'val_writings.employee' => $collector
            ])->where(static function ($query) use ($date1, $date2) {
                if ($date1 !== null && $date2 === null) {
                    $query->where('val_writings.accdate', '>=', $date1);
                }
                if ($date1 === null && $date2 !== null) {
                    $query->where('val_writings.accdate', '<=', $date2);
                }
                if ($date1 !== null && $date2 !== null) {
                    $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();
        $revenue_vals = self::query()->where([
            'val_writings.account' => $param->revenue_acc,
            'val_writings.debitamt' => null,
            'val_writings.employee' => $collector
        ])->where(static function ($query) use ($date1, $date2) {
            if ($date1 !== null && $date2 === null) {
                $query->where('val_writings.accdate', '>=', $date1);
            }
            if ($date1 === null && $date2 !== null) {
                $query->where('val_writings.accdate', '<=', $date2);
            }
            if ($date1 !== null && $date2 !== null) {
                $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
            }
        })->orderBy('writnumb')->get();
        $tax_vals = self::query()->where([
            'val_writings.account' => $param->tax_acc,
            'val_writings.debitamt' => null,
            'val_writings.employee' => $collector
        ])->where(static function ($query) use ($date1, $date2) {
            if ($date1 !== null && $date2 === null) {
                $query->where('val_writings.accdate', '>=', $date1);
            }
            if ($date1 === null && $date2 !== null) {
                $query->where('val_writings.accdate', '<=', $date2);
            }
            if ($date1 !== null && $date2 !== null) {
                $query->whereRaw('val_writings.accdate >= ' . $date1 . ' AND val_writings.accdate <= ' . $date2);
            }
        })->orderBy('writnumb')->get();

        foreach ($val_writings as $index => $val_writing) {
            $val_writing->total = money($val_writing->amount + $revenue_vals[$index]->creditamt + $tax_vals[$index]->creditamt);
            $val_writing->client = money((int)$val_writing->amount);
            $val_writing->revenue = money((int)$revenue_vals[$index]->creditamt);
            $val_writing->tax = money((int)$tax_vals[$index]->creditamt);

            $col_com = round(($param->col_com / 100) * $revenue_vals[$index]->creditamt, 0);
            $inst_com = round(($param->inst_com / 100) * $revenue_vals[$index]->creditamt, 0);

            $val_writing->accdate = changeFormat($val_writing->accdate);
            $val_writing->code = pad($val_writing->code, 6);
            $val_writing->name .= ' ' . $val_writing->surname;
            $val_writing->col_name .= ' ' . $val_writing->col_surname;
            $val_writing->col_com = money((int)$col_com);
            $val_writing->inst_com = money((int)$inst_com);
        }

        return $val_writings;
    }

    /**
     * @param int $customer
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCustStatements(int $customer, string $lang)
    {
        return self::query()->where('val_writings.aux', $customer)->orderBy('writnumb')->get();
    }

    /**
     * @param int $customer
     * @param string|null $from
     * @param string|null $to
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getFilterCustStatements(int $customer, string $lang, string $from = null, string $to = null)
    {
        $date1 = dbDate($from);
        $date2 = dbDate($to);

        return self::query()->where('val_writings.aux', $customer)
            ->where(static function ($query) use ($date1, $date2) {
                if ($date1 !== null && $date2 === null) {
                    $query->where('val_writings.accdate', '>=', $date1);
                }
                if ($date1 === null && $date2 !== null) {
                    $query->where('val_writings.accdate', '<=', $date2);
                }
                if ($date1 !== null && $date2 !== null) {
//                    $query->whereRaw("val_writings.accdate BETWEEN '{$date1}' AND '{$date2}'");
                    $query->whereBetween('val_writings.accdate', [$date1, $date2]);
//                    $query->whereRaw("val_writings.accdate >= '{$date1}' AND val_writings.accdate <= '{$date2}'");
//                    $query->orWhereBetween('val_writings.accdate', [$date1, $date2]);
                }
            })->orderBy('writnumb')->get();
    }


    public static function getValFilterCustStatements(int $customer, string $lang, string $from = null, string $to = null)
    {
        $date1 = dbDate($from);
        $date2 = dbDate($to);

        return self::query()->where('val_writings.aux', $customer)
            ->where(static function ($query) use ($date1, $date2) {
                if ($date1 !== null && $date2 === null) {
                    $query->where('val_writings.accdate', '<=', $date1);
                }
                if ($date1 === null && $date2 !== null) {
                    $query->where('val_writings.accdate', '=>', $date2);
                }
                if ($date1 !== null && $date2 !== null) {
                    $query->where('val_writings.accdate', '<=', $date1);
                }
            })->orderBy('writnumb')->get();
    }

}
