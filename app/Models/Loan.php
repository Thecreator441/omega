<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class loan extends Model
{
    protected $table = 'loans';

    protected $primaryKey = 'idloan';

    protected $fillable = ['loans'];

    /**
     * @param int $idloan
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLoan(int $idloan)
    {
        $loan = self::query()->select('loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 
        'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
        'LP.labeleng AS lp_labeleng', 'U.iduser')
        ->join('members AS M', 'loans.member', '=', 'M.idmember')
        ->join('users AS U', 'loans.employee', '=', 'U.iduser')
        ->join('employees AS E', 'U.employee', '=', 'E.idemp')
        ->join('loan_types AS LT', 'loans.loantype', '=', 'LT.idltype')
        ->join('loan_purs AS LP', 'loans.loanpur', '=', 'LP.idloanpur')
        ->where('idloan', $idloan)->first();

        if($loan !== null) {
            if ($loan->guarantee === 'F' || $loan->guarantee === 'F&M') {
                $loan->comakers = Comaker::getComakers(['loan' => $loan->idloan]);
            }
    
            if ($loan->guarantee === 'M' || $loan->guarantee === 'F&M') {
                $loan->mortgages = Mortgage::getMortgages(['loan' => $loan->idloan]);
            }
        }

        return $loan;
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getLoanBy(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            $loan = self::query()->select('loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 
            'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
            'LP.labeleng AS lp_labeleng', 'U.iduser')
            ->join('members AS M', 'loans.member', '=', 'M.idmember')
            ->join('users AS U', 'loans.employee', '=', 'U.iduser')
            ->join('employees AS E', 'U.employee', '=', 'E.idemp')
            ->join('loan_types AS LT', 'loans.loantype', '=', 'LT.idltype')
            ->join('loan_purs AS LP', 'loans.loanpur', '=', 'LP.idloanpur')
            ->where($where)->where(static function ($query) use ($emp) {
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
            })->first();
        } else {
            $loan = self::query()->select('loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 
            'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
            'LP.labeleng AS lp_labeleng', 'U.iduser')
            ->join('members AS M', 'loans.member', '=', 'M.idmember')
            ->join('users AS U', 'loans.employee', '=', 'U.iduser')
            ->join('employees AS E', 'U.employee', '=', 'E.idemp')
            ->join('loan_types AS LT', 'loans.loantype', '=', 'LT.idltype')
            ->join('loan_purs AS LP', 'loans.loanpur', '=', 'LP.idloanpur')
            ->where(static function ($query) use ($emp) {
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
            })->first();
        }

        if ($loan !== null) {
            if ($loan->guarantee === 'F' || $loan->guarantee === 'F&M') {
                $loan->comakers = Comaker::getComakers(['loan' => $loan->idloan]);
            }
    
            if ($loan->guarantee === 'M' || $loan->guarantee === 'F&M') {
                $loan->mortgages = Mortgage::getMortgages(['loan' => $loan->idloan]);
            }
        }

        return $loan;
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getLoans(array $where = null)
    {
        $emp = Session::get('employee');
        $loans = [];

        if ($where !== null) {
            $loans = self::query()->select('loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 
            'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
            'LP.labeleng AS lp_labeleng', 'U.iduser')
            ->join('members AS M', 'loans.member', '=', 'M.idmember')
            ->join('users AS U', 'loans.employee', '=', 'U.iduser')
            ->join('employees AS E', 'U.employee', '=', 'E.idemp')
            ->join('loan_types AS LT', 'loans.loantype', '=', 'LT.idltype')
            ->join('loan_purs AS LP', 'loans.loanpur', '=', 'LP.idloanpur')
            ->where($where)->where(static function ($query) use ($emp) {
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
            })->get();
        } else {
            $loans = self::query()->select('loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 
            'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
            'LP.labeleng AS lp_labeleng', 'U.iduser')
            ->join('members AS M', 'loans.member', '=', 'M.idmember')
            ->join('users AS U', 'loans.employee', '=', 'U.iduser')
            ->join('employees AS E', 'U.employee', '=', 'E.idemp')
            ->join('loan_types AS LT', 'loans.loantype', '=', 'LT.idltype')
            ->join('loan_purs AS LP', 'loans.loanpur', '=', 'LP.idloanpur')
            ->where(static function ($query) use ($emp) {
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
            })->get();
        }

        if ((int)$loans->count() > 0) {
            foreach ($loans as $loan) {
                if ($loan->guarantee === 'F' || $loan->guarantee === 'F&M') {
                    $loan->comakers = Comaker::getComakers(['loan' => $loan->idloan]);
                }
        
                if ($loan->guarantee === 'M' || $loan->guarantee === 'F&M') {
                    $loan->mortgages = Mortgage::getMortgages(['loan' => $loan->idloan]);
                }
            }
        }

        return $loans;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast()
    {
        $emp = Session::get('employee');

        $loan = self::query()->select('loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 
        'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
        'LP.labeleng AS lp_labeleng', 'U.iduser')
        ->join('members AS M', 'loans.member', '=', 'M.idmember')
        ->join('users AS U', 'loans.employee', '=', 'U.iduser')
        ->join('employees AS E', 'U.employee', '=', 'E.idemp')
        ->join('loan_types AS LT', 'loans.loantype', '=', 'LT.idltype')
        ->join('loan_purs AS LP', 'loans.loanpur', '=', 'LP.idloanpur')
        ->where(static function ($query) use ($emp) {
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
        })->orderByDesc('loanno')->first();

        if ($loan !== null) {
            if ($loan->guarantee === 'F' || $loan->guarantee === 'F&M') {
                $loan->comakers = Comaker::getComakers(['loan' => $loan->idloan]);
            }
    
            if ($loan->guarantee === 'M' || $loan->guarantee === 'F&M') {
                $loan->mortgages = Mortgage::getMortgages(['loan' => $loan->idloan]);
            }
        }

        return $loan;
    }

    /**
     * @param string $status
     * @param string|null $employee
     * @param string|null $from
     * @param string|null $to
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getFilterLoans(string $user, string $status, int $employee = null, string $from = null, string $to = null)
    {
        $emp = User::getUserInfos((int)$user);

        $loans = self::query()->select('loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 
        'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
        'LP.labeleng AS lp_labeleng', 'U.iduser')
        ->join('members AS M', 'loans.member', '=', 'M.idmember')
        ->join('users AS U', 'loans.employee', '=', 'U.iduser')
        ->join('employees AS E', 'U.employee', '=', 'E.idemp')
        ->join('loan_types AS LT', 'loans.loantype', '=', 'LT.idltype')
        ->join('loan_purs AS LP', 'loans.loanpur', '=', 'LP.idloanpur')
        ->where(static function ($query) use ($emp) {
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
        })->where(static function ($query) use ($employee) {
            if((int)$employee > 0) {
                $query->where('loans.employee', $employee);
            }
        })->where(static function ($query) use ($from, $to) {
            $from = dbDate($from);
            $to = dbDate($to);

            if ($from !== null && $to === null) {
                $query->whereRaw("DATE(loans.created_at) >= '{$from}'");
            }
            if ($from === null && $to !== null) {
                $query->whereRaw("DATE(loans.created_at) <= '{$to}'");
            }
            if ($from !== null && $to !== null) {
                $query->whereRaw("DATE(loans.created_at) BETWEEN '{$from}' AND '{$to}'");
            }
        })->where('loans.loanstat', $status)->get();

        if ((int)$loans->count() > 0) {
            foreach ($loans as $loan) {
                $loan->no = pad($loan->loanno, 6);
                $loan->mem_infos = pad($loan->memnumb, 6) . ' : ' . $loan->M_name . ' ' . $loan->M_surname;
                $loan->amt = money((int)$loan->amount);
                $loan->date = changeFormat($loan->created_at);
                if((int)$loan->isRef > 0) {
                    $loan->amt = money((int)$loan->refamt);
                }

                if ($loan->guarantee === 'F' || $loan->guarantee === 'F&M') {
                    $loan->comakers = Comaker::getComakers(['loan' => $loan->idloan]);
                }
        
                if ($loan->guarantee === 'M' || $loan->guarantee === 'F&M') {
                    $loan->mortgages = Mortgage::getMortgages(['loan' => $loan->idloan]);
                }
            }
        }

        return ['data' => $loans];
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
            ->where('loanstat', 'A')->where(static function ($query) use ($emp) {
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
     * @param string $status
     * @param string|null $employee
     * @param string|null $from
     * @param string|null $to
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getLoansStatictics(string $user, string $filter = null, int $member = null, string $loan_sign = '<', int $loan_amt = null, int $employee = null, string $from = null, string $to = null)
    {
        $emp = User::getUserInfos((int)$user);

        $loans = self::query()->select('loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'M.gender', 'E.empmat', 'E.name AS e_name', 
        'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
        'LP.labeleng AS lp_labeleng', 'U.iduser')
        ->join('members AS M', 'loans.member', '=', 'M.idmember')
        ->join('users AS U', 'loans.employee', '=', 'U.iduser')
        ->join('employees AS E', 'U.employee', '=', 'E.idemp')
        ->join('loan_types AS LT', 'loans.loantype', '=', 'LT.idltype')
        ->join('loan_purs AS LP', 'loans.loanpur', '=', 'LP.idloanpur')
        ->where(static function ($query) use ($emp) {
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
        })->where(static function ($query) use ($employee) {
            if((int)$employee > 0) {
                $query->where('loans.employee', $employee);
            }
        })->where(static function ($query) use ($from, $to) {
            $from = dbDate($from);
            $to = dbDate($to);

            if ($from !== null && $to === null) {
                $query->whereRaw("DATE(loans.created_at) >= '{$from}'");
            }
            if ($from === null && $to !== null) {
                $query->whereRaw("DATE(loans.created_at) <= '{$to}'");
            }
            if ($from !== null && $to !== null) {
                $query->whereRaw("DATE(loans.created_at) BETWEEN '{$from}' AND '{$to}'");
            }
        })->where(static function ($query) use ($member) {
            if((int)$member > 0) {
                $query->where('loans.member', $member);
            }
        })->where(static function ($query) use ($loan_sign, $loan_amt) {
            if((int)$loan_amt > 0) {
                $query->where('loans.amount', $loan_sign, $loan_amt)
                ->orWhere('loans.refamt', $loan_sign, $loan_amt);
            }
        })->where(static function ($query) use ($filter) {
            if($filter !== null) {
                if ($filter !== 'A') {
                    $query->where('M.gender', $filter);
                }
            }
        })->get();

        if ((int)$loans->count() > 0) {
            foreach ($loans as $loan) {
                $loan->no = pad($loan->loanno, 6);
                $loan->mem_infos = pad($loan->memnumb, 6) . ' : ' . $loan->M_name . ' ' . $loan->M_surname;
                $loan->amt = money((int)$loan->amount);
                $loan->date = changeFormat($loan->created_at);
                if((int)$loan->isRef > 0) {
                    $loan->amt = money((int)$loan->refamt);
                }

                if ($loan->guarantee === 'F' || $loan->guarantee === 'F&M') {
                    $loan->comakers = Comaker::getComakers(['loan' => $loan->idloan]);
                }
        
                if ($loan->guarantee === 'M' || $loan->guarantee === 'F&M') {
                    $loan->mortgages = Mortgage::getMortgages(['loan' => $loan->idloan]);
                }
            }
        }

        return ['data' => $loans];
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getLoanCond(array $where = null)
    {
        $emp = Session::get('employee');
        if ($where !== null) {
            return self::query()->where('status', 'A')->where($where)->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                    if ($emp->code === 5) {
                        $query->whereRaw("isforce = 'N' AND amount < 2000000");
                    } else {
                        $query->whereRaw("(isforce = 'Y' OR isforce = 'N') AND amount >= 2000000");
                    }
                }
                if ($emp->level === 'I') {
                    $query->where('institution', $emp->institutions)
                        ->whereRaw('isforce = Y OR isforce = N');
                }
            })->orderBy('Loanno')->get();
        }

        return self::query()->where('status', 'A')->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
                if ($emp->code === 5) {
                    $query->whereRaw("isforce = 'N' AND amount < 2000000");
                } else {
                    $query->whereRaw("(isforce = 'Y' OR isforce = 'N') AND amount >= 2000000");
                }
            }
            if ($emp->level === 'I') {
                $query->where('institution', $emp->institutions)
                    ->whereRaw('isforce = Y OR isforce = N');
            }
        })->orderBy('Loanno')->get();
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
    public static function getMemLoans(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where != null) {
            return self::query()->select('loans.*', 'Lt.pen_req_tax', 'A.accnumb', 'Lt.loan_acc', 'Lt.labelfr', 'Lt.labeleng')
                ->join('loan_types AS Lt', 'loans.loantype', '=', 'Lt.idltype')
                ->join('accounts AS A', 'Lt.loan_acc', '=', 'A.idaccount')
                ->where('loanstat', 'A')->where(static function ($query) use ($emp) {
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
                })->where($where)->orderBy('loanno')->get();
        }

        return self::query()->select('loans.*', 'Lt.pen_req_tax', 'A.accnumb', 'Lt.loan_acc', 'Lt.labelfr', 'Lt.labeleng')
            ->join('loan_types AS Lt', 'loans.loantype', '=', 'Lt.idltype')
            ->join('accounts AS A', 'Lt.loan_acc', '=', 'A.idaccount')
            ->where('loanstat', 'A')->where(static function ($query) use ($emp) {
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
            })->orderBy('loanno')->get();
    }

}
