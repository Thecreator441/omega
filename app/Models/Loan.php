<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Loan extends Model
{
    protected $table = 'loans';

    protected $primaryKey = 'idloan';

    protected $fillable = ['loans'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLoan(int $id)
    {
        return self::query()->where('idloan', $id)->first();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getLoans(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where($where)->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('institution', $emp->institutions);
                }
            })->orderBy('loanno')->get();
        }

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('institution', $emp->institutions);
            }
        })->orderBy('loanno')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getLoansMember()
    {
        $emp = Session::get('employee');

        return self::query()->select('loans.*', 'M.gender', 'Lt.labelfr', 'Lt.labeleng')
            ->join('members AS M', 'loans.member', '=', 'M.idmember')
            ->join('loan_types AS Lt', 'loans.loantype', '=', 'Lt.idltype')
            ->where('loanstat', 'Ar')->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('loans.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('loans.institution', $emp->institutions);
                }
            })
            ->orderBy('loanno')->get();
    }

    /**
     * @param string $stat
     * @param string|null $empl
     * @param string|null $dateFr
     * @param string|null $dateTo
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getFilterLoans(string $stat, string $empl = null, string $dateFr = null, string $dateTo = null)
    {
        $emp = Session::get('employee');

        if ($empl === null || $dateFr === null || $dateTo === null) {
            return self::query()->where('loanstat', $stat)->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('loans.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('loans.institution', $emp->institutions);
                }
            })->join('members AS M', 'loans.member', '=', 'M.idmember')
                ->join('loan_types AS Lt', 'loans.loantype', '=', 'Lt.idltype')
                ->join('loan_purs AS Lp', 'loans.loanpur', '=', 'Lp.idloanpur')
                ->select('loans.*', 'M.memnumb', 'M.name', 'M.surname', 'Lt.lcode', 'Lt.labelfr AS Ltfr', 'Lt.labeleng AS Lteng',
                    'Lp.purcode', 'Lp.labelfr AS Lpfr', 'Lp.labeleng AS Lpeng')
                ->orderBy('loanno')->get();
        }

        if ($empl !== null) {
            return self::query()->where(['loanstat' => $stat, 'employee' => $empl])->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('loans.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('loans.institution', $emp->institutions);
                }
            })
                ->join('members AS M', 'loans.member', '=', 'M.idmember')
                ->join('loan_types AS Lt', 'loans.loantype', '=', 'Lt.idltype')
                ->join('loan_purs AS Lp', 'loans.loanpur', '=', 'Lp.idloanpur')
                ->select('loans.*', 'M.memnumb', 'M.name', 'M.surname', 'Lt.lcode', 'Lt.labelfr AS Ltfr', 'Lt.labeleng AS Lteng',
                    'Lp.purcode', 'Lp.labelfr AS Lpfr', 'Lp.labeleng AS Lpeng')
                ->orderBy('loanno')->get();
        }

        if ($dateFr !== null) {
            return self::query()->where('loanstat', $stat)->where('created_at', '>', $dateFr)->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('loans.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('loans.institution', $emp->institutions);
                }
            })
                ->join('members AS M', 'loans.member', '=', 'M.idmember')
                ->join('loan_types AS Lt', 'loans.loantype', '=', 'Lt.idltype')
                ->join('loan_purs AS Lp', 'loans.loanpur', '=', 'Lp.idloanpur')
                ->select('loans.*', 'M.memnumb', 'M.name', 'M.surname', 'Lt.lcode', 'Lt.labelfr AS Ltfr', 'Lt.labeleng AS Lteng',
                    'Lp.purcode', 'Lp.labelfr AS Lpfr', 'Lp.labeleng AS Lpeng')
                ->orderBy('loanno')->get();
        }

        if ($dateTo !== null) {
            return self::query()->where('loanstat', $stat)->where('created_at', '<', $dateTo)->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('loans.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('loans.institution', $emp->institutions);
                }
            })
                ->join('members AS M', 'loans.member', '=', 'M.idmember')
                ->join('loan_types AS Lt', 'loans.loantype', '=', 'Lt.idltype')
                ->join('loan_purs AS Lp', 'loans.loanpur', '=', 'Lp.idloanpur')
                ->select('loans.*', 'M.memnumb', 'M.name', 'M.surname', 'Lt.lcode', 'Lt.labelfr AS Ltfr', 'Lt.labeleng AS Lteng',
                    'Lp.purcode', 'Lp.labelfr AS Lpfr', 'Lp.labeleng AS Lpeng')
                ->orderBy('loanno')->get();
        }

        if ($dateFr !== null && $dateTo !== null) {
            return self::query()->where('loanstat', $stat)->where('created_at', '<', $dateTo)->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('loans.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('loans.institution', $emp->institutions);
                }
            })
                ->join('members AS M', 'loans.member', '=', 'M.idmember')
                ->join('loan_types AS Lt', 'loans.loantype', '=', 'Lt.idltype')
                ->join('loan_purs AS Lp', 'loans.loanpur', '=', 'Lp.idloanpur')
                ->select('loans.*', 'M.memnumb', 'M.name', 'M.surname', 'Lt.lcode', 'Lt.labelfr AS Ltfr', 'Lt.labeleng AS Lteng',
                    'Lp.purcode', 'Lp.labelfr AS Lpfr', 'Lp.labeleng AS Lpeng')
                ->orderBy('loanno')->get();
        }
    }

    /**
     * @param int|null $lType
     * @param int|null $lOff
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getProvLoans(int $lType = null, int $lOff = null)
    {
        $emp = Session::get('employee');

        if ($lType !== null && $lOff !== null) {
            return self::query()->select('loans.*', 'M.memnumb', 'M.name', 'M.surname')
                ->where(['loantype' => $lType, 'employee' => $lOff, 'loanstat' => 'Ar'])
                ->join('members AS M', 'loans.member', '=', 'M.idmember')
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('loans.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('loans.institution', $emp->institutions);
                    }
                })->orderBy('loanno')->get();
        }

        if ($lType !== null) {
            return self::query()->select('loans.*', 'M.memnumb', 'M.name', 'M.surname')
                ->where(['loantype' => $lType, 'loanstat' => 'Ar'])
                ->join('members AS M', 'loans.member', '=', 'M.idmember')
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('loans.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('loans.institution', $emp->institutions);
                    }
                })->orderBy('loanno')->get();
        }

        if ($lOff !== null) {
            return self::query()->select('loans.*', 'M.memnumb', 'M.name', 'M.surname')
                ->where(['employee' => $lOff, 'loanstat' => 'Ar'])
                ->join('members AS M', 'loans.member', '=', 'M.idmember')
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('loans.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('loans.institution', $emp->institutions);
                    }
                })->orderBy('loanno')->get();
        }

        return self::query()->select('loans.*', 'M.memnumb', 'M.name', 'M.surname')
            ->where('loanstat', 'Ar')
            ->join('members AS M', 'loans.member', '=', 'M.idmember')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('loans.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('loans.institution', $emp->institutions);
                }
            })->orderBy('loanno')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast()
    {
        $emp = Session::get('employee');

        return self::query()->where('branch', $emp->branch)->orderByDesc('loanno')->first();
    }

    public static function getFilterMemLoans(int $member, string $date = null)
    {
        $emp = Session::get('employee');
        $loans = self::getMemLoans(['member' => $member]);

        foreach ($loans as $loan) {
            $loan_amt = (int)$loan->amount;
            if ((int)$loan->isRef > 0) {
                $loan_amt = (int)$loan->refamt;
            }

            $paid_amt = (int)$loan->paidamt;
            $rem_amt = $loan_amt - (int)$loan->paidamt;
            $accr_amt = (int)$loan->accramt;

            $loan_type = LoanType::getLoanType($loan->loantype);
            $installs = Installment::getInstalls($loan->idloan);

            $days = 0;
            $tot_paid = 0;
            $diff = 0;

            foreach ($installs as $install) {
                $date0 = new \DateTime($loan->instdate1);
                $date1 = new \DateTime($loan->lastdate);
                $date2 = new \DateTime($loan->instdate);
                $date3 = new \DateTime($date);

                if ($date3 >= $date0) {
                    $tot_paid += (int)$install->amort;
                    $diff = $paid_amt - $tot_paid;
                    if ($date1 <= $date2) {
                        if ($diff > 0) {
                            $interval = $date2->diff($date3);
                            $days = $interval->days;
                        } else {
                            if ($paid_amt > 0) {
                                $interval = $date3->diff($date1);
                                $days = $interval->days;
                            } else {
                                $interval = $date3->diff($date0);
                                $days = $interval->days;
                            }
                        }
                    }
                }
            }

            $inst_amt = round(($rem_amt * $loan->intrate) / 100);

            $loan->loan_no = pad($loan->loanno, 6);
            $loan->account = $loan->accnumb;
            $loan->loan_type = $loan_type->labeleng;
            if ($emp->lang === 'fr') {
                $loan->loan_type = $loan_type->labelfr;
            }
            $loan->install_no = $installs->count();
            $loan->date = changeFormat($loan->appdate);
            $loan->last_date = changeFormat($loan->appdate);
            if ($loan->lastdate !== null) {
                $loan->last_date = changeFormat($loan->lastdate);
            }
            $loan->loan_amt = money($loan_amt);
            $loan->capital = money($rem_amt);


            if ($diff >= 0) {
                $total_ints = $inst_amt + $accr_amt;

                $loan->delay = '-' . $days;
                $loan->interest = money($inst_amt);
                $loan->fine_int = money(0);
                $loan->accr_int = money($accr_amt);
                $loan->total_int = money($total_ints);
            } else {
                $pen_amt = round(($rem_amt * $days * $loan_type->pentax) / 1200);
                $total_ints = $inst_amt + $pen_amt + $accr_amt;

                $loan->delay = '+' . $days;
                $loan->interest = money($inst_amt);
                $loan->fine_int = money($pen_amt);
                $loan->accr_int = money($accr_amt);
                $loan->total_int = money($total_ints);
            }
        }

        return ['data' => $loans];
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMemLoans(array $where)
    {
        $emp = Session::get('employee');

        return self::query()->where($where)->where('loanstat', 'Ar')->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('loans.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('loans.institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('loans.zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('loans.network', $emp->network);
            }
        })
            ->join('loan_types AS Lt', 'loans.loantype', '=', 'Lt.idltype')
            ->join('accounts AS A', 'Lt.loanacc', '=', 'A.idaccount')
            ->select('loans.*', 'Lt.pentax', 'A.accnumb', 'Lt.loanacc', 'Lt.labelfr', 'Lt.labeleng')
            ->orderBy('loanno')->get();
    }

}
