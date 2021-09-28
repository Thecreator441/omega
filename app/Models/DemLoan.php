<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class DemLoan extends Model
{
    protected $table = 'dem_loans';

    protected $primaryKey = 'iddemloan';

    protected $fillable = ['dem_loans'];

    /**
     * @param int $iddemloan
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getDemLoan(int $iddemloan)
    {
        $dem_loan = self::query()->select('dem_loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 
        'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
        'LP.labeleng AS lp_labeleng', 'U.iduser')
        ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
        ->join('users AS U', 'dem_loans.employee', '=', 'U.iduser')
        ->join('employees AS E', 'U.employee', '=', 'E.idemp')
        ->join('loan_types AS LT', 'dem_loans.loantype', '=', 'LT.idltype')
        ->join('loan_purs AS LP', 'dem_loans.loanpur', '=', 'LP.idloanpur')
        ->where('iddemloan', $iddemloan)->first();

        if ($dem_loan !== null) {
            if ($dem_loan->guarantee === 'F' || $dem_loan->guarantee === 'F&M') {
                $dem_loan->comakers = DemComaker::getDemComakers(['demloan' => $dem_loan->iddemloan]);
            }
    
            if ($dem_loan->guarantee === 'M' || $dem_loan->guarantee === 'F&M') {
                $dem_loan->mortgages = DemMortgage::getDemMortgages(['demloan' => $dem_loan->iddemloan]);
            }
        }

        return $dem_loan;
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getDemLoanBy(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            $dem_loan = self::query()->select('dem_loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 
            'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
            'LP.labeleng AS lp_labeleng', 'U.iduser')
            ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
            ->join('users AS U', 'dem_loans.employee', '=', 'U.iduser')
            ->join('employees AS E', 'U.employee', '=', 'E.idemp')
            ->join('loan_types AS LT', 'dem_loans.loantype', '=', 'LT.idltype')
            ->join('loan_purs AS LP', 'dem_loans.loanpur', '=', 'LP.idloanpur')
            ->where($where)->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('dem_loans.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('dem_loans.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('dem_loans.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('dem_loans.network', $emp->network);
                }
            })->first();
        } else {
            $dem_loan = self::query()->select('dem_loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 
            'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
            'LP.labeleng AS lp_labeleng', 'U.iduser')
            ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
            ->join('users AS U', 'dem_loans.employee', '=', 'U.iduser')
            ->join('employees AS E', 'U.employee', '=', 'E.idemp')
            ->join('loan_types AS LT', 'dem_loans.loantype', '=', 'LT.idltype')
            ->join('loan_purs AS LP', 'dem_loans.loanpur', '=', 'LP.idloanpur')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('dem_loans.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('dem_loans.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('dem_loans.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('dem_loans.network', $emp->network);
                }
            })->first();
        }

        if ($dem_loan !== null) {
            if ($dem_loan->guarantee === 'F' || $dem_loan->guarantee === 'F&M') {
                $dem_loan->comakers = DemComaker::getDemComakers(['demloan' => $dem_loan->iddemloan]);
            }
    
            if ($dem_loan->guarantee === 'M' || $dem_loan->guarantee === 'F&M') {
                $dem_loan->mortgages = DemMortgage::getDemMortgages(['demloan' => $dem_loan->iddemloan]);
            }
        }

        return $dem_loan;
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getDemLoans(array $where = null)
    {
        $emp = Session::get('employee');
        $dem_loans = [];

        if ($where !== null) {
            $dem_loans = self::query()->select('dem_loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 
            'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
            'LP.labeleng AS lp_labeleng', 'U.iduser')
            ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
            ->join('users AS U', 'dem_loans.employee', '=', 'U.iduser')
            ->join('employees AS E', 'U.employee', '=', 'E.idemp')
            ->join('loan_types AS LT', 'dem_loans.loantype', '=', 'LT.idltype')
            ->join('loan_purs AS LP', 'dem_loans.loanpur', '=', 'LP.idloanpur')
            ->where($where)->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('dem_loans.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('dem_loans.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('dem_loans.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('dem_loans.network', $emp->network);
                }
            })->get();
        } else {
            $dem_loans = self::query()->select('dem_loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 
            'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
            'LP.labeleng AS lp_labeleng', 'U.iduser')
            ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
            ->join('users AS U', 'dem_loans.employee', '=', 'U.iduser')
            ->join('employees AS E', 'U.employee', '=', 'E.idemp')
            ->join('loan_types AS LT', 'dem_loans.loantype', '=', 'LT.idltype')
            ->join('loan_purs AS LP', 'dem_loans.loanpur', '=', 'LP.idloanpur')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('dem_loans.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('dem_loans.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('dem_loans.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('dem_loans.network', $emp->network);
                }
            })->get();
        }

        if ((int)$dem_loans->count() > 0) {
            foreach ($dem_loans as $dem_loan) {
                if ($dem_loan->guarantee === 'F' || $dem_loan->guarantee === 'F&M') {
                    $dem_loan->comakers = DemComaker::getDemComakers(['demloan' => $dem_loan->iddemloan]);
                }
        
                if ($dem_loan->guarantee === 'M' || $dem_loan->guarantee === 'F&M') {
                    $dem_loan->mortgages = DemMortgage::getDemMortgages(['demloan' => $dem_loan->iddemloan]);
                }
            }
        }

        return $dem_loans;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast()
    {
        $emp = Session::get('employee');

        $dem_loan = self::query()->select('dem_loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 
        'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
        'LP.labeleng AS lp_labeleng', 'U.iduser')
        ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
        ->join('users AS U', 'dem_loans.employee', '=', 'U.iduser')
        ->join('employees AS E', 'U.employee', '=', 'E.idemp')
        ->join('loan_types AS LT', 'dem_loans.loantype', '=', 'LT.idltype')
        ->join('loan_purs AS LP', 'dem_loans.loanpur', '=', 'LP.idloanpur')
        ->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('dem_loans.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('dem_loans.institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('dem_loans.zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('dem_loans.network', $emp->network);
            }
        })->orderByDesc('demloanno')->first();

        if ($dem_loan !== null) {
            if ($dem_loan->guarantee === 'F' || $dem_loan->guarantee === 'F&M') {
                $dem_loan->comakers = DemComaker::getDemComakers(['demloan' => $dem_loan->iddemloan]);
            }
    
            if ($dem_loan->guarantee === 'M' || $dem_loan->guarantee === 'F&M') {
                $dem_loan->mortgages = DemMortgage::getDemMortgages(['demloan' => $dem_loan->iddemloan]);
            }
        }

        return $dem_loan;
    }

    /**
     * @param string $status
     * @param string|null $employee
     * @param string|null $from
     * @param string|null $to
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getFilterDemLoans(string $user, string $status, int $employee = null, string $from = null, string $to = null)
    {
        $emp = User::getUserInfos((int)$user);

        $dem_loans = self::query()->select('dem_loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 
        'E.surname AS e_surname', 'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 
        'LP.labeleng AS lp_labeleng', 'U.iduser')
        ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
        ->join('users AS U', 'dem_loans.employee', '=', 'U.iduser')
        ->join('employees AS E', 'U.employee', '=', 'E.idemp')
        ->join('loan_types AS LT', 'dem_loans.loantype', '=', 'LT.idltype')
        ->join('loan_purs AS LP', 'dem_loans.loanpur', '=', 'LP.idloanpur')
        ->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('dem_loans.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('dem_loans.institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('dem_loans.zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('dem_loans.network', $emp->network);
            }
        })->where(static function ($query) use ($employee) {
            if((int)$employee > 0) {
                $query->where('dem_loans.employee', $employee);
            }
        })->where(static function ($query) use ($from, $to) {
            $from = dbDate($from);
            $to = dbDate($to);

            if ($from !== null && $to === null) {
                $query->where('dem_loans.created_at', '>=', $from);
            } else if ($from === null && $to !== null) {
                $query->where('dem_loans.created_at', '<=', $to);
            } else if ($from !== null && $to !== null) {
                $query->whereRaw("dem_loans.created_at >= $from AND dem_loans.created_at <= $to");
            }
        })->where('dem_loans.loanstat', $status)->get();

        if ((int)$dem_loans->count() > 0) {
            foreach ($dem_loans as $dem_loan) {
                $dem_loan->no = pad($dem_loan->demloanno, 6);
                $dem_loan->mem_infos = pad($dem_loan->memnumb, 6) . ' : ' . $dem_loan->M_name . ' ' . $dem_loan->M_surname;
                $dem_loan->amt = money((int)$dem_loan->amount);
                $dem_loan->date = changeFormat($dem_loan->created_at);

                if ($dem_loan->guarantee === 'F' || $dem_loan->guarantee === 'F&M') {
                    $dem_loan->comakers = DemComaker::getDemComakers(['demloan' => $dem_loan->iddemloan]);
                }
        
                if ($dem_loan->guarantee === 'M' || $dem_loan->guarantee === 'F&M') {
                    $dem_loan->mortgages = DemMortgage::getDemMortgages(['demloan' => $dem_loan->iddemloan]);
                }
            }
        }

        return ['data' => $dem_loans];
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getDemLoansCond(array $where = null)
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
            })->orderBy('demloanno')->get();
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
        })->orderBy('demloanno')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAllDemLoans()
    {
        $emp = Session::get('employee');
        return self::query()->where('status', 'A')->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('institution', $emp->institutions);
            }
        })->orderBy('demloanno')->get();
    }

}
