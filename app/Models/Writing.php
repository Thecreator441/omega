<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use PDF;

class Writing extends Model
{
    protected $table = 'writings';

    protected $primaryKey = 'idwrit';

    protected $fillable = ['writings'];

    public static function getWriting(int $idwrit)
    {
        return self::query()->select('writings.*', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'U.employee AS user_emp', 'U.collector AS col_emp', 'C.cashcode')
            ->join('accounts AS A', 'writings.account', '=', 'A.idaccount')
            ->join('users AS U', 'writings.employee', '=', 'U.iduser')
            ->join('cashes AS C', 'writings.cash', '=', 'C.idcash')
            ->where('idwrit', $idwrit)->first();
    }

    public static function getWritingBy(array $where)
    {
        $emp = Session::get('employee');

        return self::query()->select('writings.*', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'U.employee AS user_emp', 'U.collector AS col_emp', 'C.cashcode')
            ->join('accounts AS A', 'writings.account', '=', 'A.idaccount')
            ->join('cashes AS C', 'writings.cash', '=', 'C.idcash')
            ->join('users AS U', 'writings.employee', '=', 'U.iduser')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('writings.network', $emp->network);
                }
            })->where($where)->orderBy('writnumb')->first();
    }

    public static function getWritings(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->select('writings.*', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'U.employee AS user_emp', 'U.collector AS col_emp', 'C.cashcode')
                ->join('accounts AS A', 'writings.account', '=', 'A.idaccount')
                ->join('cashes AS C', 'writings.cash', '=', 'C.idcash')
                ->join('users AS U', 'writings.employee', '=', 'U.iduser')
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('writings.network', $emp->network);
                    }
                })->where($where)->orderBy('writnumb')->get();
        }

        return self::query()->select('writings.*', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'U.employee AS user_emp', 'U.collector AS col_emp', 'C.cashcode')
            ->join('accounts AS A', 'writings.account', '=', 'A.idaccount')
            ->join('cashes AS C', 'writings.cash', '=', 'C.idcash')
            ->join('users AS U', 'writings.employee', '=', 'U.iduser')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('writings.network', $emp->network);
                }
            })->orderBy('writnumb')->get();
    }

    public static function getWritingsBy(array $where)
    {
        $emp = Session::get('employee');

        return self::query()->select('writings.*', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'U.employee AS user_emp', 'U.collector AS col_emp', 'C.cashcode')
            ->join('accounts AS A', 'writings.account', '=', 'A.idaccount')
            ->join('cashes AS C', 'writings.cash', '=', 'C.idcash')
            ->join('users AS U', 'writings.employee', '=', 'U.iduser')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('writings.network', $emp->network);
                }
            })->where($where)->orderBy('writnumb')->get();
    }

    public static function getJournals(int $network = null, int $zone = null, int $institution = null, int $branch = null, int $user = null, string $state = null, string $lang = 'eng')
    {
        $writings = '';
        $sumDebit = '';
        $sumCredit = '';

        $writings = self::query()->select('writings.*', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'C.cashcode')
        ->join('accounts AS A', 'writings.account', '=', 'A.idaccount')
        ->join('cashes AS C', 'writings.cash', '=', 'C.idcash')
        ->where(static function ($query) use ($user, $state) {
            if ($user !== null && $state === null) {
                $query->where('writings.employee', $user);
            }
            if ($user === null && $state !== null) {
                $query->where('writings.writ_type', $state);
            }
            if ($user !== null && $state !== null) {
                $query->where([
                    'writings.employee' => $user,
                    'writings.writ_type' => $state,
                ]);
            }
        })->where(static function ($query) use ($network, $zone, $institution, $branch) {
            $query->orWhere([
                'writings.branch' => $branch,
                'writings.institution' => $institution,
                'writings.zone' => $zone,
                'writings.network' => $network
            ]);
        })->orderBy('writnumb')->get();

        $sumDebit = self::query()->where(static function ($query) use ($user, $state) {
            if ($user !== null && $state === null) {
                $query->where('writings.employee', $user);
            }
            if ($user === null && $state !== null) {
                $query->where('writings.writ_type', $state);
            }
            if ($user !== null && $state !== null) {
                $query->where([
                    'writings.employee' => $user,
                    'writings.writ_type' => $state,
                ]);
            }
        })->where(static function ($query) use ($network, $zone, $institution, $branch) {
            $query->orWhere([
                'writings.branch' => $branch,
                'writings.institution' => $institution,
                'writings.zone' => $zone,
                'writings.network' => $network
            ]);
        })->sum('debitamt');

        $sumCredit = self::query()->where(static function ($query) use ($user, $state) {
            if ($user !== null && $state === null) {
                $query->where('writings.employee', $user);
            }
            if ($user === null && $state !== null) {
                $query->where('writings.writ_type', $state);
            }
            if ($user !== null && $state !== null) {
                $query->where([
                    'writings.employee' => $user,
                    'writings.writ_type' => $state,
                ]);
            }
        })->where(static function ($query) use ($network, $zone, $institution, $branch) {
            $query->orWhere([
                'writings.branch' => $branch,
                'writings.institution' => $institution,
                'writings.zone' => $zone,
                'writings.network' => $network
            ]);
        })->sum('creditamt');

        foreach ($writings as $writing) {
            $writing->refs = formWriting($writing->accdate, $writing->network, $writing->zone, $writing->institution, $writing->branch, $writing->writnumb);

            $aux = null;
            if ($writing->mem_aux !== null) {
                $member = Member::getMember($writing->mem_aux);
                $writing->code = pad($member->memnumb, 6);
                $writing->name = $member->name;
                $writing->surname = $member->surname;
            } elseif ($writing->emp_aux !== null) {
                $employee = Employee::getEmployee($writing->emp_aux);
                $writing->code = pad($employee->empmat, 6);
                $writing->name = $employee->name;
                $writing->surname = $employee->surname;
            }

            if (is_numeric($writing->operation)) {
                $opera = Operation::getOperation($writing->operation);
                $writing->operation = $opera->labeleng;
                if ($lang === 'fr') {
                    $writing->operation = $opera->labelfr;
                }
            }

            $writing->account = $writing->accnumb;
            $writing->aux = $writing->code . ' - ' . $writing->name . ' ' . $writing->surname;
            // $writing->aux = $writing->code . ' - ' . explode(' ', $writing->name)[0] . ' ' . explode(' ', $writing->surname)[0];
            $writing->debit = money((int)$writing->debitamt);
            $writing->credit = money((int)$writing->creditamt);
            $writing->accdate = changeFormat($writing->accdate);
            $writing->time = getsTime($writing->created_at);
        }

        return [
            'data' => $writings,
            'sumDebit' => money((int)$sumDebit),
            'sumCredit' => money((int)$sumCredit),
            'sumBal' => money((int)$sumDebit - (int)$sumCredit)
        ];
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
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('writings.network', $emp->network);
                }
            })->sum('debitamt');
        }

        return self::query()->where($where)
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('writings.network', $emp->network);
                }
            })->sum('debitamt');
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
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('writings.network', $emp->network);
                }
            })->sum('creditamt');
        }

        return self::query()->where($where)
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('writings.network', $emp->network);
                }
            })->sum('creditamt');
    }




    /**
     * @param int $member
     * @param int $account
     * @return mixed
     */
    public static function getMemSumDebit(int $member, int $account)
    {
        return self::query()->where(['aux' => $member, 'account' => $account])->sum('debitamt');
    }

    /**
     * @param int $member
     * @param int $account
     * @return mixed
     */
    public static function getMemSumCredit(int $member, int $account)
    {
        return self::query()->where(['aux' => $member, 'account' => $account])->sum('creditamt');
    }

    /**
     * @param int|null $branch
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast(int $branch = null)
    {
        $emp = Session::get('employee');

        if ($branch !== null) {
            return self::query()->where('branch', $branch)->distinct('idwrit')->orderByDesc('writnumb')->first();
        }

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('writings.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('writings.institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('writings.zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('writings.network', $emp->network);
            }
        })->distinct('idwrit')->orderByDesc('writnumb')->first();
    }

    /**
     * @param int $rev_acc
     * @param int $month
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getSharings(int $rev_acc, int $month = null)
    {
        $emp = Session::get('employee');

        if ($month === null) {
            return self::query()->distinct('writings.employee')
                ->select('writings.*', 'C.code', 'C.name', 'C.surname')
                ->join('users AS U', 'writings.employee', '=', 'U.iduser')
                ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
                ->where('account', $rev_acc)
                ->whereRaw('YEAR(date(writings.created_at)) = ' . date('Y'))
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('writings.institution', $emp->institution);
                    }
                })->orderBy('writnumb')->get();
        }

        return self::query()->distinct('writings.employee')
            ->select('writings.*', 'C.code', 'C.name', 'C.surname')
            ->join('users AS U', 'writings.employee', '=', 'U.iduser')
            ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
            ->where('account', $rev_acc)
            ->whereRaw('YEAR(date(writings.created_at)) = ' . date('Y') . ' AND MONTH(date(writings.created_at)) = ' . $month)
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
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
            return self::query()->select('writings.*', 'C.code', 'C.name', 'C.surname')->distinct('idwrit')
                ->join('users AS U', 'writings.employee', '=', 'U.iduser')
                ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
                ->where('account', $param->revenue_acc)
                ->whereRaw('YEAR(date(writings.created_at)) = ' . date('Y'))
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
        }

        if ($branch !== null && $month === null) {
            return self::query()->select('writings.*', 'C.code', 'C.name', 'C.surname')->distinct('idwrit')
                ->join('users AS U', 'writings.employee', '=', 'U.iduser')
                ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
                ->where('account', $param->revenue_acc)
                ->whereRaw('YEAR(date(writings.created_at)) = ' . date('Y') . ' AND writings.branch = ' . $branch)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
        }

        if ($branch === null && $month !== null) {
            return self::query()->select('writings.*', 'C.code', 'C.name', 'C.surname')->distinct('idwrit')
                ->join('users AS U', 'writings.employee', '=', 'U.iduser')
                ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
                ->where('account', $param->revenue_acc)
                ->whereRaw('YEAR(date(writings.created_at)) = ' . date('Y') . ' AND MONTH(date(writings.created_at)) = ' . $month)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
        }

        return self::query()->select('writings.*', 'C.code', 'C.name', 'C.surname')->distinct('idwrit')
            ->join('users AS U', 'writings.employee', '=', 'U.iduser')
            ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
            ->where('account', $param->revenue_acc)
            ->whereRaw('writings.branch = ' . $branch . ' AND YEAR(date(writings.created_at)) = ' . date('Y') . ' AND MONTH(date(writings.created_at)) = ' . $month)
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('writings.network', $emp->network);
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

        $writings = self::query()->select('writings.creditamt AS amount', 'writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
            ->join('collect_mems AS Cm', 'writings.aux', '=', 'Cm.idcollect_mem')
            ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
            ->where(['writings.account' => $iParam->client_acc, 'writings.debitamt' => null])
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('writings.network', $emp->network);
                }
                if ($emp->collector !== null) {
                    $query->where('writings.employee', $emp->iduser);
                }
            })->orderBy('writnumb')->get();
        $revenue_vals = self::query()->where(['writings.account' => $iParam->revenue_acc, 'writings.debitamt' => null])
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('writings.network', $emp->network);
                }
                if ($emp->collector !== null) {
                    $query->where('writings.employee', $emp->iduser);
                }
            })->orderBy('writnumb')->get();
        $tax_vals = self::query()->where(['writings.account' => $iParam->tax_acc, 'writings.debitamt' => null])
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('writings.network', $emp->network);
                }
                if ($emp->collector !== null) {
                    $query->where('writings.employee', $emp->iduser);
                }
            })->orderBy('writnumb')->get();

        foreach ($writings as $index => $writing) {
            $writing->total = $writing->amount + $revenue_vals[$index]->creditamt + $tax_vals[$index]->creditamt;
            $writing->client = $writing->amount;
            $writing->revenue = $revenue_vals[$index]->creditamt;
            $writing->tax = $tax_vals[$index]->creditamt;

            $col_com = round(($iParam->col_com / 100) * $revenue_vals[$index]->creditamt, 0);
            $inst_com = round(($iParam->inst_com / 100) * $revenue_vals[$index]->creditamt, 0);

            $writing->col_com = $col_com;
            $writing->inst_com = $inst_com;
        }

        return $writings;
    }

    /**
     * @param int|null $zone
     * @param int|null $institution
     * @param int|null $branch
     * @param int|null $collector
     * @param string|null $from
     * @param string|null $to
     * @return array
     */
    public static function getFilterReports(int $zone = null, int $institution = null, int $branch = null, int $collector = null, string $from = null, string $to = null)
    {
        $emp = Session::get('employee');
        $param = Inst_Param::getInstParam($emp->institution);
        $writings = null;
        $revenue_vals = null;
        $tax_vals = null;
        $date1 = dbDate($from);
        $date2 = dbDate($to);

        if ($emp->level === 'B') {
            $writings = self::query()->select('writings.creditamt AS amount', 'writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
                ->join('collect_mems AS Cm', 'writings.aux', '=', 'Cm.idcollect_mem')
                ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
                ->where([
                    'writings.account' => $param->client_acc,
                    'writings.debitamt' => null,
                    'writings.branch' => $emp->branch
                ])->where(static function ($query) use ($collector, $date1, $date2) {
                    if ($collector !== null && $date1 === null && $date2 === null) {
                        $query->where('writings.employee', $collector);
                    }
                    if ($collector !== null && $date1 !== null && $date2 === null) {
                        $query->where('writings.employee', $collector)
                            ->where('writings.accdate', '>=', $date1);
                    }
                    if ($collector !== null && $date1 === null && $date2 !== null) {
                        $query->where('writings.employee', $collector)
                            ->where('writings.accdate', '<=', $date2);
                    }
                    if ($collector !== null && $date1 !== null && $date2 !== null) {
                        $query->where('writings.employee', $collector)
                            ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                    }
                    if ($collector === null && $date1 !== null && $date2 === null) {
                        $query->where('writings.accdate', '>=', $date1);
                    }
                    if ($collector === null && $date1 === null && $date2 !== null) {
                        $query->where('writings.accdate', '<=', $date2);
                    }
                    if ($collector === null && $date1 !== null && $date2 !== null) {
                        $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                    }
                })->orderBy('writnumb')->get();
            $revenue_vals = self::query()->where([
                'writings.account' => $param->revenue_acc,
                'writings.debitamt' => null,
                'writings.branch' => $emp->branch
            ])->where(static function ($query) use ($collector, $date1, $date2) {
                if ($collector !== null && $date1 === null && $date2 === null) {
                    $query->where('writings.employee', $collector);
                }
                if ($collector !== null && $date1 !== null && $date2 === null) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '>=', $date1);
                }
                if ($collector !== null && $date1 === null && $date2 !== null) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '<=', $date2);
                }
                if ($collector !== null && $date1 !== null && $date2 !== null) {
                    $query->where('writings.employee', $collector)
                        ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
                if ($collector === null && $date1 !== null && $date2 === null) {
                    $query->where('writings.accdate', '>=', $date1);
                }
                if ($collector === null && $date1 === null && $date2 !== null) {
                    $query->where('writings.accdate', '<=', $date2);
                }
                if ($collector === null && $date1 !== null && $date2 !== null) {
                    $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();
            $tax_vals = self::query()->where([
                'writings.account' => $param->tax_acc,
                'writings.debitamt' => null,
                'writings.branch' => $emp->branch
            ])->where(static function ($query) use ($collector, $date1, $date2) {
                if ($collector !== null && $date1 === null && $date2 === null) {
                    $query->where('writings.employee', $collector);
                }
                if ($collector !== null && $date1 !== null && $date2 === null) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '>=', $date1);
                }
                if ($collector !== null && $date1 === null && $date2 !== null) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '<=', $date2);
                }
                if ($collector !== null && $date1 !== null && $date2 !== null) {
                    $query->where('writings.employee', $collector)
                        ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
                if ($collector === null && $date1 !== null && $date2 === null) {
                    $query->where('writings.accdate', '>=', $date1);
                }
                if ($collector === null && $date1 === null && $date2 !== null) {
                    $query->where('writings.accdate', '<=', $date2);
                }
                if ($collector === null && $date1 !== null && $date2 !== null) {
                    $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();
        }

        if ($emp->level === 'I') {
            $writings = self::query()->select('writings.creditamt AS amount', 'writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
                ->join('collect_mems AS Cm', 'writings.aux', '=', 'Cm.idcollect_mem')
                ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
                ->where([
                    'writings.account' => $param->client_acc,
                    'writings.debitamt' => null,
                    'writings.institution' => $emp->institution
                ])->where(static function ($query) use ($branch, $collector, $date1, $date2) {
                    if ($branch !== null && $collector === null && $date1 === null && $date2 === null) {
                        $query->where('writings.branch', $branch);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('writings.branch', $branch)
                            ->where('writings.accdate', '>=', $date1);
                    }
                    if ($branch !== null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('writings.branch', $branch)
                            ->where('writings.accdate', '<=', $date2);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->where('writings.branch', $branch)
                            ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('writings.accdate', '>=', $date1);
                    }
                    if ($branch === null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('writings.accdate', '<=', $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 === null) || ($branch === null && $collector !== null && $date1 === null && $date2 === null)) {
                        $query->where('writings.employee', $collector);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 === null) || ($branch === null && $collector !== null && $date1 !== null && $date2 === null)) {
                        $query->where('writings.employee', $collector)
                            ->where('writings.accdate', '>=', $date1);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 !== null) || ($branch === null && $collector !== null && $date1 === null && $date2 !== null)) {
                        $query->where('writings.employee', $collector)
                            ->where('writings.accdate', '<=', $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 !== null) || ($branch === null && $collector !== null && $date1 !== null && $date2 !== null)) {
                        $query->where('writings.employee', $collector)
                            ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                    }
                })->orderBy('writnumb')->get();
            $revenue_vals = self::query()->where([
                'writings.account' => $param->revenue_acc,
                'writings.debitamt' => null,
                'writings.institution' => $emp->institution
            ])->where(static function ($query) use ($branch, $collector, $date1, $date2) {
                if ($branch !== null && $collector === null && $date1 === null && $date2 === null) {
                    $query->where('writings.branch', $branch);
                }
                if ($branch !== null && $collector === null && $date1 !== null && $date2 === null) {
                    $query->where('writings.branch', $branch)
                        ->where('writings.accdate', '>=', $date1);
                }
                if ($branch !== null && $collector === null && $date1 === null && $date2 !== null) {
                    $query->where('writings.branch', $branch)
                        ->where('writings.accdate', '<=', $date2);
                }
                if ($branch !== null && $collector === null && $date1 !== null && $date2 !== null) {
                    $query->where('writings.branch', $branch)
                        ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
                if ($branch === null && $collector === null && $date1 !== null && $date2 === null) {
                    $query->where('writings.accdate', '>=', $date1);
                }
                if ($branch === null && $collector === null && $date1 === null && $date2 !== null) {
                    $query->where('writings.accdate', '<=', $date2);
                }
                if ($branch === null && $collector === null && $date1 !== null && $date2 !== null) {
                    $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
                if (($branch !== null && $collector !== null && $date1 === null && $date2 === null) || ($branch === null && $collector !== null && $date1 === null && $date2 === null)) {
                    $query->where('writings.employee', $collector);
                }
                if (($branch !== null && $collector !== null && $date1 !== null && $date2 === null) || ($branch === null && $collector !== null && $date1 !== null && $date2 === null)) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '>=', $date1);
                }
                if (($branch !== null && $collector !== null && $date1 === null && $date2 !== null) || ($branch === null && $collector !== null && $date1 === null && $date2 !== null)) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '<=', $date2);
                }
                if (($branch !== null && $collector !== null && $date1 !== null && $date2 !== null) || ($branch === null && $collector !== null && $date1 !== null && $date2 !== null)) {
                    $query->where('writings.employee', $collector)
                        ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();
            $tax_vals = self::query()->where([
                'writings.account' => $param->tax_acc,
                'writings.debitamt' => null,
                'writings.institution' => $emp->institution
            ])->where(static function ($query) use ($branch, $collector, $date1, $date2) {
                if ($branch !== null && $collector === null && $date1 === null && $date2 === null) {
                    $query->where('writings.branch', $branch);
                }
                if ($branch !== null && $collector === null && $date1 !== null && $date2 === null) {
                    $query->where('writings.branch', $branch)
                        ->where('writings.accdate', '>=', $date1);
                }
                if ($branch !== null && $collector === null && $date1 === null && $date2 !== null) {
                    $query->where('writings.branch', $branch)
                        ->where('writings.accdate', '<=', $date2);
                }
                if ($branch !== null && $collector === null && $date1 !== null && $date2 !== null) {
                    $query->where('writings.branch', $branch)
                        ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
                if ($branch === null && $collector === null && $date1 !== null && $date2 === null) {
                    $query->where('writings.accdate', '>=', $date1);
                }
                if ($branch === null && $collector === null && $date1 === null && $date2 !== null) {
                    $query->where('writings.accdate', '<=', $date2);
                }
                if ($branch === null && $collector === null && $date1 !== null && $date2 !== null) {
                    $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
                if (($branch !== null && $collector !== null && $date1 === null && $date2 === null) || ($branch === null && $collector !== null && $date1 === null && $date2 === null)) {
                    $query->where('writings.employee', $collector);
                }
                if (($branch !== null && $collector !== null && $date1 !== null && $date2 === null) || ($branch === null && $collector !== null && $date1 !== null && $date2 === null)) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '>=', $date1);
                }
                if (($branch !== null && $collector !== null && $date1 === null && $date2 !== null) || ($branch === null && $collector !== null && $date1 === null && $date2 !== null)) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '<=', $date2);
                }
                if (($branch !== null && $collector !== null && $date1 !== null && $date2 !== null) || ($branch === null && $collector !== null && $date1 !== null && $date2 !== null)) {
                    $query->where('writings.employee', $collector)
                        ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();
        }

        if ($zone === null && $institution === null && $branch === null && $collector === null && $date1 === null && $date2 === null) {
            $writings = self::query()->select('writings.creditamt AS amount', 'writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
                ->join('collect_mems AS Cm', 'writings.aux', '=', 'Cm.idcollect_mem')
                ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
                ->where(['writings.account' => $param->client_acc, 'writings.debitamt' => null])
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
            $revenue_vals = self::query()->where(['writings.account' => $param->revenue_acc, 'writings.debitamt' => null])
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
            $tax_vals = self::query()->where(['writings.account' => $param->tax_acc, 'writings.debitamt' => null])
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
        }

        foreach ($writings as $index => $writing) {
            $writing->total = money($writing->amount + $revenue_vals[$index]->creditamt + $tax_vals[$index]->creditamt);
            $writing->client = money((int)$writing->amount);
            $writing->revenue = money((int)$revenue_vals[$index]->creditamt);
            $writing->tax = money((int)$tax_vals[$index]->creditamt);

            $col_com = round(($param->col_com / 100) * $revenue_vals[$index]->creditamt, 0);
            $inst_com = round(($param->inst_com / 100) * $revenue_vals[$index]->creditamt, 0);

            $writing->accdate = changeFormat($writing->accdate);
            $writing->code = pad($writing->code, 6);
            $writing->name .= ' ' . $writing->surname;
            $writing->col_name .= ' ' . $writing->col_surname;
            $writing->col_com = money((int)$col_com);
            $writing->inst_com = money((int)$inst_com);
        }

        $val_writings = ValWriting::getFilterReports($zone, $institution, $branch, $collector, $from, $to);

        foreach ($val_writings as $val_writing) {
            $writings->add($val_writing);
        }

        return ['data' => $writings];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getStatements()
    {
        $emp = Session::get('employee');
        $iParam = Inst_Param::getInstParam($emp->institution);

        $writings = self::query()->where('account', $iParam->client_acc)
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('writings.network', $emp->network);
                }
            })->orderBy('writnumb')->get();

        return $writings;
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
        $writings = null;
        $revenue_vals = null;
        $tax_vals = null;
        $date1 = dbDate($from);
        $date2 = dbDate($to);

        if ($emp->level === 'B') {
            $writings = self::query()->select('writings.creditamt AS amount', 'writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
                ->join('collect_mems AS Cm', 'writings.aux', '=', 'Cm.idcollect_mem')
                ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
                ->where([
                    'account' => $param->client_acc,
                    'writings.branch' => $emp->branch
                ])->where(static function ($query) use ($collector, $date1, $date2) {
                    if ($collector !== null && $date1 === null && $date2 === null) {
                        $query->where('writings.employee', $collector);
                    }
                    if ($collector !== null && $date1 !== null && $date2 === null) {
                        $query->where('writings.employee', $collector)
                            ->where('writings.accdate', '>=', $date1);
                    }
                    if ($collector !== null && $date1 === null && $date2 !== null) {
                        $query->where('writings.employee', $collector)
                            ->where('writings.accdate', '<=', $date2);
                    }
                    if ($collector !== null && $date1 !== null && $date2 !== null) {
                        $query->where('writings.employee', $collector)
                            ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                    }
                    if ($collector === null && $date1 !== null && $date2 === null) {
                        $query->where('writings.accdate', '>=', $date1);
                    }
                    if ($collector === null && $date1 === null && $date2 !== null) {
                        $query->where('writings.accdate', '<=', $date2);
                    }
                    if ($collector === null && $date1 !== null && $date2 !== null) {
                        $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                    }
                })->orderBy('writnumb')->get();
            $revenue_vals = self::query()->where([
                'account' => $param->revenue_acc,
                'writings.branch' => $emp->branch
            ])->where(static function ($query) use ($collector, $date1, $date2) {
                if ($collector !== null && $date1 === null && $date2 === null) {
                    $query->where('writings.employee', $collector);
                }
                if ($collector !== null && $date1 !== null && $date2 === null) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '>=', $date1);
                }
                if ($collector !== null && $date1 === null && $date2 !== null) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '<=', $date2);
                }
                if ($collector !== null && $date1 !== null && $date2 !== null) {
                    $query->where('writings.employee', $collector)
                        ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
                if ($collector === null && $date1 !== null && $date2 === null) {
                    $query->where('writings.accdate', '>=', $date1);
                }
                if ($collector === null && $date1 === null && $date2 !== null) {
                    $query->where('writings.accdate', '<=', $date2);
                }
                if ($collector === null && $date1 !== null && $date2 !== null) {
                    $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();
            $tax_vals = self::query()->where([
                'account' => $param->tax_acc,
                'writings.branch' => $emp->branch
            ])->where(static function ($query) use ($collector, $date1, $date2) {
                if ($collector !== null && $date1 === null && $date2 === null) {
                    $query->where('writings.employee', $collector);
                }
                if ($collector !== null && $date1 !== null && $date2 === null) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '>=', $date1);
                }
                if ($collector !== null && $date1 === null && $date2 !== null) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '<=', $date2);
                }
                if ($collector !== null && $date1 !== null && $date2 !== null) {
                    $query->where('writings.employee', $collector)
                        ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
                if ($collector === null && $date1 !== null && $date2 === null) {
                    $query->where('writings.accdate', '>=', $date1);
                }
                if ($collector === null && $date1 === null && $date2 !== null) {
                    $query->where('writings.accdate', '<=', $date2);
                }
                if ($collector === null && $date1 !== null && $date2 !== null) {
                    $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();
        }

        if ($emp->level === 'I') {
            $writings = self::query()->select('writings.creditamt AS amount', 'writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
                ->join('collect_mems AS Cm', 'writings.aux', '=', 'Cm.idcollect_mem')
                ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
                ->where([
                    'account' => $param->client_acc,
                    'writings.institution' => $emp->institution
                ])->where(static function ($query) use ($branch, $collector, $date1, $date2) {
                    if ($branch !== null && $collector === null && $date1 === null && $date2 === null) {
                        $query->where('writings.branch', $branch);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('writings.branch', $branch)
                            ->where('writings.accdate', '>=', $date1);
                    }
                    if ($branch !== null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('writings.branch', $branch)
                            ->where('writings.accdate', '<=', $date2);
                    }
                    if ($branch !== null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->where('writings.branch', $branch)
                            ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 === null) {
                        $query->where('writings.accdate', '>=', $date1);
                    }
                    if ($branch === null && $collector === null && $date1 === null && $date2 !== null) {
                        $query->where('writings.accdate', '<=', $date2);
                    }
                    if ($branch === null && $collector === null && $date1 !== null && $date2 !== null) {
                        $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 === null) || ($branch === null && $collector !== null && $date1 === null && $date2 === null)) {
                        $query->where('writings.employee', $collector);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 === null) || ($branch === null && $collector !== null && $date1 !== null && $date2 === null)) {
                        $query->where('writings.employee', $collector)
                            ->where('writings.accdate', '>=', $date1);
                    }
                    if (($branch !== null && $collector !== null && $date1 === null && $date2 !== null) || ($branch === null && $collector !== null && $date1 === null && $date2 !== null)) {
                        $query->where('writings.employee', $collector)
                            ->where('writings.accdate', '<=', $date2);
                    }
                    if (($branch !== null && $collector !== null && $date1 !== null && $date2 !== null) || ($branch === null && $collector !== null && $date1 !== null && $date2 !== null)) {
                        $query->where('writings.employee', $collector)
                            ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                    }
                })->orderBy('writnumb')->get();
            $revenue_vals = self::query()->where([
                'account' => $param->revenue_acc,
                'writings.institution' => $emp->institution
            ])->where(static function ($query) use ($branch, $collector, $date1, $date2) {
                if ($branch !== null && $collector === null && $date1 === null && $date2 === null) {
                    $query->where('writings.branch', $branch);
                }
                if ($branch !== null && $collector === null && $date1 !== null && $date2 === null) {
                    $query->where('writings.branch', $branch)
                        ->where('writings.accdate', '>=', $date1);
                }
                if ($branch !== null && $collector === null && $date1 === null && $date2 !== null) {
                    $query->where('writings.branch', $branch)
                        ->where('writings.accdate', '<=', $date2);
                }
                if ($branch !== null && $collector === null && $date1 !== null && $date2 !== null) {
                    $query->where('writings.branch', $branch)
                        ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
                if ($branch === null && $collector === null && $date1 !== null && $date2 === null) {
                    $query->where('writings.accdate', '>=', $date1);
                }
                if ($branch === null && $collector === null && $date1 === null && $date2 !== null) {
                    $query->where('writings.accdate', '<=', $date2);
                }
                if ($branch === null && $collector === null && $date1 !== null && $date2 !== null) {
                    $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
                if (($branch !== null && $collector !== null && $date1 === null && $date2 === null) || ($branch === null && $collector !== null && $date1 === null && $date2 === null)) {
                    $query->where('writings.employee', $collector);
                }
                if (($branch !== null && $collector !== null && $date1 !== null && $date2 === null) || ($branch === null && $collector !== null && $date1 !== null && $date2 === null)) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '>=', $date1);
                }
                if (($branch !== null && $collector !== null && $date1 === null && $date2 !== null) || ($branch === null && $collector !== null && $date1 === null && $date2 !== null)) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '<=', $date2);
                }
                if (($branch !== null && $collector !== null && $date1 !== null && $date2 !== null) || ($branch === null && $collector !== null && $date1 !== null && $date2 !== null)) {
                    $query->where('writings.employee', $collector)
                        ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();
            $tax_vals = self::query()->where([
                'account' => $param->tax_acc,
                'writings.institution' => $emp->institution
            ])->where(static function ($query) use ($branch, $collector, $date1, $date2) {
                if ($branch !== null && $collector === null && $date1 === null && $date2 === null) {
                    $query->where('writings.branch', $branch);
                }
                if ($branch !== null && $collector === null && $date1 !== null && $date2 === null) {
                    $query->where('writings.branch', $branch)
                        ->where('writings.accdate', '>=', $date1);
                }
                if ($branch !== null && $collector === null && $date1 === null && $date2 !== null) {
                    $query->where('writings.branch', $branch)
                        ->where('writings.accdate', '<=', $date2);
                }
                if ($branch !== null && $collector === null && $date1 !== null && $date2 !== null) {
                    $query->where('writings.branch', $branch)
                        ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
                if ($branch === null && $collector === null && $date1 !== null && $date2 === null) {
                    $query->where('writings.accdate', '>=', $date1);
                }
                if ($branch === null && $collector === null && $date1 === null && $date2 !== null) {
                    $query->where('writings.accdate', '<=', $date2);
                }
                if ($branch === null && $collector === null && $date1 !== null && $date2 !== null) {
                    $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
                if (($branch !== null && $collector !== null && $date1 === null && $date2 === null) || ($branch === null && $collector !== null && $date1 === null && $date2 === null)) {
                    $query->where('writings.employee', $collector);
                }
                if (($branch !== null && $collector !== null && $date1 !== null && $date2 === null) || ($branch === null && $collector !== null && $date1 !== null && $date2 === null)) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '>=', $date1);
                }
                if (($branch !== null && $collector !== null && $date1 === null && $date2 !== null) || ($branch === null && $collector !== null && $date1 === null && $date2 !== null)) {
                    $query->where('writings.employee', $collector)
                        ->where('writings.accdate', '<=', $date2);
                }
                if (($branch !== null && $collector !== null && $date1 !== null && $date2 !== null) || ($branch === null && $collector !== null && $date1 !== null && $date2 !== null)) {
                    $query->where('writings.employee', $collector)
                        ->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();
        }

        if ($zone === null && $institution === null && $branch === null && $collector === null && $date1 === null && $date2 === null) {
            $writings = self::query()->select('writings.creditamt AS amount', 'writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
                ->join('collect_mems AS Cm', 'writings.aux', '=', 'Cm.idcollect_mem')
                ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
                ->where('account', $param->client_acc)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
            $revenue_vals = self::query()->where('account', $param->revenue_acc)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
            $tax_vals = self::query()->where('account', $param->tax_acc)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
        }

        foreach ($writings as $index => $writing) {
            $writing->total = $writing->amount + $revenue_vals[$index]->creditamt + $tax_vals[$index]->creditamt;
            $writing->client = $writing->amount;
            $writing->revenue = $revenue_vals[$index]->creditamt;
            $writing->tax = $tax_vals[$index]->creditamt;

            $col_com = round(($param->col_com / 100) * $revenue_vals[$index]->creditamt, 0);
            $inst_com = round(($param->inst_com / 100) * $revenue_vals[$index]->creditamt, 0);

            $writing->col_com = $col_com;
            $writing->inst_com = $inst_com;
        }

        $val_writings = ValWriting::getFilterReports($zone, $institution, $branch, $collector, $from, $to);

        foreach ($val_writings as $val_writing) {
            $writings->add($val_writing);
        }

        return $writings;
    }

    /**
     * @param int $network
     * @param int $collector
     * @param int $idcollect
     * @param string $lang
     * @return array
     */
    public static function getJournalsByColl(int $network = null, int $collector = null, int $idcollect = null, string $lang = 'eng')
    {
        $writings = self::query()->select('writings.*')
            ->join('accounts AS A', 'writings.account', '=', 'A.idaccount')
            ->where('writings.employee', $collector)->orderBy('writnumb')->get();
        $accounts = Account::getAccountsMob($network);
        $operas = Operation::getOperations();
        if (Session::exists('employee')) {
            $members = Collect_Mem::getMembers();
            $collect = Collector::getCollectors();
        }
        $user = User::getUser($collector);
        if (!empty($user) && $user->collector !== null) {
            $members = Collect_Mem::getCollectMems($user->collector);
            $collect = Collector::getCollector($user->collector);
        }

        $sumDebit = self::query()->where('writings.employee', $collector)->sum('debitamt');
        $sumCredit = self::query()->where('writings.employee', $collector)->sum('creditamt');

        foreach ($writings as $writing) {
            $writing->refs = formWriting($writing->accdate, $writing->network, $writing->zone, $writing->institution, $writing->branch, $writing->writnumb);

            foreach ($accounts as $account) {
                if ($account->idaccount === $writing->account) {
                    $writing->acc = $account->accnumb;
                }
            }

            if (($writing->coll_aux !== null)) {
                if (is_iterable($collect)) {
                    foreach ($collect as $item) {
                        if ($item->idcoll === $writing->coll_aux) {
                            $writing->aux = pad($item->code, 6);
                        }
                    }
                } else if ($collect->idcoll === $writing->coll_aux) {
                    $writing->aux = pad($collect->code, 6);
                }
            }

            if ($writing->aux !== null) {
                foreach ($members as $member) {
                    if ($member->idcollect_mem === $writing->aux) {
                        $writing->aux = pad($member->coll_memnumb, 6);
                    }
                }
            }

            if (is_numeric($writing->operation)) {
                foreach ($operas as $opera) {
                    if ($opera->idoper === (int)$writing->operation) {
                        if ($lang === 'fr') {
                            $writing->operation = $opera->labelfr;
                        } else {
                            $writing->operation = $opera->labeleng;
                        }
                    }
                }
            }

            $writing->debit = money((int)$writing->debitamt);
            $writing->credit = money((int)$writing->creditamt);
            $writing->accdate = changeFormat($writing->accdate);
            $writing->time = getsTime($writing->created_at);
        }

        return [
            'data' => $writings,
            'sumDebit' => money((int)$sumDebit),
            'sumCredit' => money((int)$sumCredit)
        ];
    }

    /**
     * @param int $rev_acc
     * @param int $month
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getSharingsMob(int $rev_acc, int $month = null)
    {
        if ($month === null) {
            return self::query()->distinct('writings.employee')
                ->select('writings.*', 'C.code', 'C.name', 'C.surname')
                ->join('users AS U', 'writings.employee', '=', 'U.iduser')
                ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
                ->where('account', $rev_acc)
                ->whereRaw('YEAR(date(writings.created_at)) = ' . date('Y'))
                ->orderBy('writnumb')->get();
        }

        return self::query()->distinct('writings.employee')
            ->select('writings.*', 'C.code', 'C.name', 'C.surname')
            ->join('users AS U', 'writings.employee', '=', 'U.iduser')
            ->join('collectors AS C', 'U.collector', '=', 'C.idcoll')
            ->where('account', $rev_acc)
            ->whereRaw('YEAR(date(writings.created_at)) = ' . date('Y') . ' AND MONTH(date(writings.created_at)) = ' . $month)
            ->orderBy('writnumb')->get();
    }

    /**
     * @param int $institution
     * @param int $collector
     * @return array
     */
    public static function getReportsByColl(int $institution, int $collector)
    {
        $iParam = Inst_Param::getInstParam($institution);

        $writings = self::query()->select('writings.creditamt AS amount', 'writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
            ->join('collect_mems AS Cm', 'writings.aux', '=', 'Cm.idcollect_mem')
            ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
            ->where([
                'writings.account' => $iParam->client_acc,
                'writings.debitamt' => null,
                'writings.employee' => $collector
            ])->orderBy('writnumb')->get();
        $revenue_vals = self::query()->where([
            'writings.account' => $iParam->revenue_acc,
            'writings.debitamt' => null,
            'writings.employee' => $collector
        ])->orderBy('writnumb')->get();
        $tax_vals = self::query()->where([
            'writings.account' => $iParam->tax_acc,
            'writings.debitamt' => null,
            'writings.employee' => $collector
        ])->orderBy('writnumb')->get();

        foreach ($writings as $index => $writing) {
            $writing->total = money($writing->amount + $revenue_vals[$index]->creditamt + $tax_vals[$index]->creditamt);
            $writing->client = money((int)$writing->amount);
            $writing->revenue = money((int)$revenue_vals[$index]->creditamt);
            $writing->tax = money((int)$tax_vals[$index]->creditamt);

            $col_com = round(($iParam->col_com / 100) * $revenue_vals[$index]->creditamt, 0);
            $inst_com = round(($iParam->inst_com / 100) * $revenue_vals[$index]->creditamt, 0);

            $writing->accdate = changeFormat($writing->accdate);
            $writing->code = pad($writing->code, 6);
            $writing->name .= ' ' . $writing->surname;
            $writing->col_name .= ' ' . $writing->col_surname;
            $writing->col_com = money((int)$col_com);
            $writing->inst_com = money((int)$inst_com);
        }

        $val_writings = ValWriting::getReportsByColl($institution, $collector);

        foreach ($val_writings as $val_writing) {
            if ($writings !== null) {
                $writings->prepend($val_writing);
            } else {
                $writings->add($val_writing);
            }
        }

        return ['data' => $writings];
    }

    /**
     * @param int|null $institution
     * @param int|null $collector
     * @param string|null $from
     * @param string|null $to
     * @return array|void
     */
    public static function getFilterReportsByColl(int $institution = null, int $collector = null, string $from = null, string $to = null)
    {
        $param = Inst_Param::getInstParam($institution);
        $date1 = dbDate($from);
        $date2 = dbDate($to);

        $writings = self::query()->select('writings.creditamt AS amount', 'writings.accdate', 'Cm.coll_memnumb AS code', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
            ->join('collect_mems AS Cm', 'writings.aux', '=', 'Cm.idcollect_mem')
            ->join('collectors AS C', 'Cm.collector', '=', 'C.idcoll')
            ->where([
                'writings.account' => $param->client_acc,
                'writings.debitamt' => null,
                'writings.employee' => $collector
            ])->where(static function ($query) use ($date1, $date2) {
                if ($date1 !== null && $date2 === null) {
                    $query->where('writings.accdate', '>=', $date1);
                }
                if ($date1 === null && $date2 !== null) {
                    $query->where('writings.accdate', '<=', $date2);
                }
                if ($date1 !== null && $date2 !== null) {
                    $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
                }
            })->orderBy('writnumb')->get();

        $revenue_vals = self::query()->where([
            'writings.account' => $param->revenue_acc,
            'writings.debitamt' => null,
            'writings.employee' => $collector
        ])->where(static function ($query) use ($date1, $date2) {
            if ($date1 !== null && $date2 === null) {
                $query->where('writings.accdate', '>=', $date1);
            }
            if ($date1 === null && $date2 !== null) {
                $query->where('writings.accdate', '<=', $date2);
            }
            if ($date1 !== null && $date2 !== null) {
                $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
            }
        })->orderBy('writnumb')->get();
        $tax_vals = self::query()->where([
            'writings.account' => $param->tax_acc,
            'writings.debitamt' => null,
            'writings.employee' => $collector
        ])->where(static function ($query) use ($date1, $date2) {
            if ($date1 !== null && $date2 === null) {
                $query->where('writings.accdate', '>=', $date1);
            }
            if ($date1 === null && $date2 !== null) {
                $query->where('writings.accdate', '<=', $date2);
            }
            if ($date1 !== null && $date2 !== null) {
                $query->whereRaw('writings.accdate >= ' . $date1 . ' AND writings.accdate <= ' . $date2);
            }
        })->orderBy('writnumb')->get();

        foreach ($writings as $index => $writing) {
            $writing->total = money($writing->amount + $revenue_vals[$index]->creditamt + $tax_vals[$index]->creditamt);
            $writing->client = money((int)$writing->amount);
            $writing->revenue = money((int)$revenue_vals[$index]->creditamt);
            $writing->tax = money((int)$tax_vals[$index]->creditamt);

            $col_com = round(($param->col_com / 100) * $revenue_vals[$index]->creditamt, 0);
            $inst_com = round(($param->inst_com / 100) * $revenue_vals[$index]->creditamt, 0);

            $writing->accdate = changeFormat($writing->accdate);
            $writing->code = pad($writing->code, 6);
            $writing->name .= ' ' . $writing->surname;
            $writing->col_name .= ' ' . $writing->col_surname;
            $writing->col_com = money((int)$col_com);
            $writing->inst_com = money((int)$inst_com);
        }

        $val_writings = ValWriting::getFilterReportsByColl($institution, $collector, $from, $to);

        foreach ($val_writings as $val_writing) {
            $writings->prepend($val_writing);
        }

        return ['data' => $writings];
    }

    /**
     * @param int $customer
     * @param string $lang
     * @return array
     */
    public static function getCustStatements(int $customer, string $lang)
    {
        $val_writings = self::query()->where('writings.aux', $customer)
            ->orderBy('writnumb')->get();


        $operas = Operation::getOperations();

        $custBal = Collect_Bal::getCustomerBalance($customer);
        $operation = 'BALANCE BROUGHT FORWARD';
        if ($lang === 'fr') {
            $operation = 'SOLDE MISE EN AVANT';
        }

        $writings = ValWriting::getCustStatements($customer, $lang);

        // if ((int)$writings->count() === 0) {
        //     foreach ($val_writings as $val_writing) {
        //         $writings->add($val_writing);
        //     }
        // } else {
        //     foreach ($val_writings as $val_writing) {
        //         $writings->prepend($val_writing);
        //     }
        // }

        foreach ($val_writings as $val_writing) {
            $writings->add($val_writing);
        }

        $first = self::query()->where('writings.aux', $customer)->first();

        if ($first === null) {
            // $first = DB::table('val_writings')->where('writings.aux', $customer)->first();
            $first = new self();

            $first->idwrit = null;
            $first->writnumb = null;
            $first->account = null;
            $first->aux = $customer;
            $first->coll_aux = null;
            $first->collector = null;
            $first->debitamt = 0;
            $first->creditamt = 0;
            $first->employee = null;
            $first->cash = null;
            $first->network = null;
            $first->zone = null;
            $first->institution = null;
            $first->branch = null;
            $first->represent = null;
            $first->created_at = null;
            $first->updated_at = null;
        }

        if (!empty($custBal)) {
            $first->accdate = changeFormat($custBal->created_at);
            $first->balance = money((int)$custBal->initbal);
            $first->bal = (int)$custBal->initbal;
        }
        $first->operation = $operation;
        $first->debit = 0;
        $first->credit = 0;

        $writings->prepend($first);

        foreach ($writings as $index => $writing) {
            if ($index > 0) {
                $writing->accdate = changeFormat($writing->accdate);

                if (is_numeric($writing->operation)) {
                    foreach ($operas as $opera) {
                        if ($opera->idoper === (int)$writing->operation) {
                            if ($lang === 'fr') {
                                $writing->operation = $opera->labelfr;
                            } else {
                                $writing->operation = $opera->labeleng;
                            }
                        }
                    }
                }

                $writing->bal = 0;

                if ((int)$writing->debitamt === 0) {
                    $writing->bal = (int)$writings[$index - 1]['bal'] + (int)$writing->creditamt;
                }

                if ((int)$writing->creditamt === 0) {
                    $writing->bal = (int)$writings[$index - 1]['bal'] - (int)$writing->debitamt;
                }

                $writing->balance = money((int)$writing->bal);
                $writing->debit = money((int)$writing->debitamt);
                $writing->credit = money((int)$writing->creditamt);
            }
        }

        return ['data' => $writings];
    }

    /**
     * @param int $customer
     * @param string $lang
     * @param string|null $from
     * @param string|null $to
     * @return array
     */
    public static function getFilterCustStatements(int $customer, string $lang, string $from = null, string $to = null)
    {
        $date1 = dbDate($from);
        $date2 = dbDate($to);

        $prevValWrits = self::query()->where('writings.aux', $customer)
            ->where(static function ($query) use ($date1, $date2) {
                if ($date1 !== null && $date2 === null) {
                    $query->where('writings.accdate', '<=', $date1);
                }
                if ($date1 === null && $date2 !== null) {
                    $query->where('writings.accdate', '=>', $date2);
                }
                if ($date1 !== null && $date2 !== null) {
                    $query->where('writings.accdate', '<=', $date1);
                }
            })->orderBy('writnumb')->get();

        $prevWrits = ValWriting::getValFilterCustStatements($customer, $lang, $from, $to);

        foreach ($prevValWrits as $prevValWrit) {
            $prevWrits->add($prevValWrit);
        }

        $prevFirst = self::query()->where('writings.aux', $customer)->first();

        $custBal = Collect_Bal::getCustomerBalance($customer);
        $operation = 'BALANCE BROUGHT FORWARD';
        if ($lang === 'fr') {
            $operation = 'SOLDE MISE EN AVANT';
        }

        if ($prevFirst === null) {
            $prevFirst = new self();

            $prevFirst->idwrit = null;
            $prevFirst->writnumb = null;
            $prevFirst->account = null;
            $prevFirst->aux = $customer;
            $prevFirst->coll_aux = null;
            $prevFirst->collector = null;
            $prevFirst->debitamt = 0;
            $prevFirst->creditamt = 0;
            $prevFirst->employee = null;
            $prevFirst->cash = null;
            $prevFirst->network = null;
            $prevFirst->zone = null;
            $prevFirst->institution = null;
            $prevFirst->branch = null;
            $prevFirst->represent = null;
            $prevFirst->created_at = null;
            $prevFirst->updated_at = null;
        }

        if (!empty($custBal)) {
            $prevFirst->accdate = changeFormat($custBal->created_at);
            $prevFirst->balance = money((int)$custBal->initbal);
            $prevFirst->bal = (int)$custBal->initbal;
        }
        $prevFirst->operation = $operation;
        $prevFirst->debit = 0;
        $prevFirst->credit = 0;

        $prevWrits->prepend($prevFirst);

        $prevBal = 0;
        $prevDate = $custBal->created_at;

        foreach ($prevWrits as $index => $prevWrit) {
            if ($date1 !== null && $date2 === null && $prevWrit->accdate < $date1) {
                if ($index > 0) {
                    if ((int)$prevWrit->debitamt === 0) {
                        $prevBal += (int)$prevWrits[$index - 1]['bal'] + (int)$prevWrit->creditamt;
                    }

                    if ((int)$prevWrit->creditamt === 0) {
                        $prevBal += (int)$prevWrits[$index - 1]['bal'] - (int)$prevWrit->debitamt;
                    }
                }
                $prevDate = $date1;
            }

            if ($date1 === null && $date2 !== null && $prevWrit->accdate > $date2) {
                if ($index > 0) {
                    if ((int)$prevWrit->debitamt === 0) {
                        $prevBal += (int)$prevWrits[$index - 1]['bal'] + (int)$prevWrit->creditamt;
                    }

                    if ((int)$prevWrit->creditamt === 0) {
                        $prevBal += (int)$prevWrits[$index - 1]['bal'] - (int)$prevWrit->debitamt;
                    }
                }
                $prevDate = $date2;
            }

            if ($date1 !== null && $date2 !== null) {
                if ($prevWrit->accdate > $date1 || $prevWrit->accdate < $date2) {
                    if ($index > 0) {
                        if ((int)$prevWrit->debitamt === 0) {
                            $prevBal += (int)$prevWrits[$index - 1]['bal'] + (int)$prevWrit->creditamt;
                        }

                        if ((int)$prevWrit->creditamt === 0) {
                            $prevBal += (int)$prevWrits[$index - 1]['bal'] - (int)$prevWrit->debitamt;
                        }
                    }
                }
                $prevDate = $date1;
            }
        }

        $val_writings = self::query()->where('writings.aux', $customer)
            ->where(static function ($query) use ($date1, $date2) {
                if ($date1 !== null && $date2 === null) {
                    $query->where('writings.accdate', '>=', $date1);
                }
                if ($date1 === null && $date2 !== null) {
                    $query->where('writings.accdate', '<=', $date2);
                }
                if ($date1 !== null && $date2 !== null) {
                    // $query->whereRaw("writings.accdate BETWEEN '{$date1}' AND '{$date2}'");
                    $query->whereBetween('writings.accdate', [$date1, $date2]);
                    // $query->whereRaw("writings.accdate >= '{$date1}' OR writings.accdate <= '{$date2}'");
                    // $query->orWhereBetween('writings.accdate', [$date1, $date2]);
                }
            })->orderBy('writnumb')->get();

        $operas = Operation::getOperations();

        $writings = ValWriting::getFilterCustStatements($customer, $lang, $from, $to);

        foreach ($val_writings as $val_writing) {
            $writings->add($val_writing);
        }

        $first = self::query()->where('writings.aux', $customer)->first();

        if ($first === null) {
            $first = new self();

            $first->idwrit = null;
            $first->writnumb = null;
            $first->account = null;
            $first->aux = $customer;
            $first->coll_aux = null;
            $first->collector = null;
            $first->debitamt = 0;
            $first->creditamt = 0;
            $first->employee = null;
            $first->cash = null;
            $first->network = null;
            $first->zone = null;
            $first->institution = null;
            $first->branch = null;
            $first->represent = null;
            $first->created_at = null;
            $first->updated_at = null;
        }

        $first->accdate = changeFormat($prevDate);
        $first->balance = money($prevBal);
        $first->bal = $prevBal;
        $first->operation = $operation;
        $first->debit = 0;
        $first->credit = 0;

        $writings->prepend($first);

        foreach ($writings as $index => $writing) {
            if ($index > 0) {
                $writing->accdate = changeFormat($writing->accdate);

                if (is_numeric($writing->operation)) {
                    foreach ($operas as $opera) {
                        if ($opera->idoper === (int)$writing->operation) {
                            if ($lang === 'fr') {
                                $writing->operation = $opera->labelfr;
                            } else {
                                $writing->operation = $opera->labeleng;
                            }
                        }
                    }
                }

                $writing->bal = 0;

                if ((int)$writing->debitamt === 0) {
                    $writing->bal = (int)$writings[$index - 1]['bal'] + (int)$writing->creditamt;
                }

                if ((int)$writing->creditamt === 0) {
                    $writing->bal = (int)$writings[$index - 1]['bal'] - (int)$writing->debitamt;
                }

                $writing->balance = money((int)$writing->bal);
                $writing->debit = money((int)$writing->debitamt);
                $writing->credit = money((int)$writing->creditamt);
            }
        }

        return ['data' => $writings];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getJournal(array $where = [])
    {
        $emp = Session::get('employee');

        if ($where === null) {
            return self::query()->select('writings.*')
                ->join('accounts AS A', 'writings.account', '=', 'A.idaccount')
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('writings.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('writings.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('writings.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('writings.network', $emp->network);
                    }
                })->orderBy('writnumb')->get();
        }

        return self::query()->select('writings.*')
            ->join('accounts AS A', 'writings.account', '=', 'A.idaccount')
            ->where($where)->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('writings.network', $emp->network);
                }
            })->orderBy('writnumb')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getEmployees()
    {
        $emp = Session::get('employee');

        return self::query()->distinct('U.iduser')->select('U.*', 'writings.employee')
            ->join('users AS U', 'writings.employee', '=', 'U.iduser')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('writings.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('writings.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('writings.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('writings.network', $emp->network);
                }
            })->orderBy('U.username')->get();
    }
}
