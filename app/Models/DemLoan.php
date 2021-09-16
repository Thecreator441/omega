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
        $dem_loan = self::query()->select('dem_loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 'E.surname AS e_surname',
            'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 'LP.labeleng AS lp_labeleng')
            ->join('members AS M', 'dem_loans.member', '=', 'idmember')
            ->join('employees AS E', 'dem_loans.employee', '=', 'idemp')
            ->join('loan_types AS LT', 'dem_loans.loantype', '=', 'idltype')
            ->join('loan_purs AS LP', 'dem_loans.loanpur', '=', 'idloanpur')
            ->where('iddemloan', $iddemloan)->first();

        if ($dem_loan->guarantee === 'F' || $dem_loan->guarantee === 'F&M') {
            $dem_loan->comakers = DemComaker::getDemComakers(['demloan' => $dem_loan->iddemloan]);
        }

        if ($dem_loan->guarantee === 'M' || $dem_loan->guarantee === 'F&M') {
            $dem_loan->mortgages = DemMortgage::getDemMortgages(['demloan' => $dem_loan->iddemloan]);
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
            $dem_loan = self::query()->select('dem_loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 'E.surname AS e_surname',
                'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 'LP.labeleng AS lp_labeleng')
                ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
                ->join('employees AS E', 'dem_loans.employee', '=', 'E.idemp')
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
            $dem_loan = self::query()->select('dem_loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 'E.surname AS e_surname',
                'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 'LP.labeleng AS lp_labeleng')
                ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
                ->join('employees AS E', 'dem_loans.employee', '=', 'E.idemp')
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
            $dem_loans = self::query()->select('dem_loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 'E.surname AS e_surname',
                'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 'LP.labeleng AS lp_labeleng')
                ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
                ->join('employees AS E', 'dem_loans.employee', '=', 'E.idemp')
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
            $dem_loans = self::query()->select('dem_loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 'E.surname AS e_surname',
                'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 'LP.labeleng AS lp_labeleng')
                ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
                ->join('employees AS E', 'dem_loans.employee', '=', 'E.idemp')
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

        if ($empl !== null) {
            return self::query()->where(['dem_loans.status' => $stat, 'employee' => $empl])->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('dem_loans.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('dem_loans.institution', $emp->institutions);
                }
            })
                ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
                ->join('loan_types AS Lt', 'dem_loans.loantype', '=', 'Lt.idltype')
                ->join('loan_purs AS Lp', 'dem_loans.loanpur', '=', 'Lp.idloanpur')
                ->select('dem_loans.*', 'M.memnumb', 'M.name', 'M.surname', 'Lt.lcode', 'Lt.labelfr AS Ltfr', 'Lt.labeleng AS Lteng',
                    'Lp.purcode', 'Lp.labelfr AS Lpfr', 'Lp.labeleng AS Lpeng')
                ->orderBy('demloanno')->get();
        }

        if ($dateFr !== null) {
            return self::query()->where('dem_loans.status', $stat)->where('created_at', '>', $dateFr)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('dem_loans.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('dem_loans.institution', $emp->institutions);
                    }
                })
                ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
                ->join('loan_types AS Lt', 'dem_loans.loantype', '=', 'Lt.idltype')
                ->join('loan_purs AS Lp', 'dem_loans.loanpur', '=', 'Lp.idloanpur')
                ->select('dem_loans.*', 'M.memnumb', 'M.name', 'M.surname', 'Lt.lcode', 'Lt.labelfr AS Ltfr', 'Lt.labeleng AS Lteng',
                    'Lp.purcode', 'Lp.labelfr AS Lpfr', 'Lp.labeleng AS Lpeng')
                ->orderBy('demloanno')->get();
        }

        if ($dateTo !== null) {
            return self::query()->where('dem_loans.status', $stat)->where('created_at', '<', $dateTo)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('dem_loans.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('dem_loans.institution', $emp->institutions);
                    }
                })
                ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
                ->join('loan_types AS Lt', 'dem_loans.loantype', '=', 'Lt.idltype')
                ->join('loan_purs AS Lp', 'dem_loans.loanpur', '=', 'Lp.idloanpur')
                ->select('dem_loans.*', 'M.memnumb', 'M.name', 'M.surname', 'Lt.lcode', 'Lt.labelfr AS Ltfr', 'Lt.labeleng AS Lteng',
                    'Lp.purcode', 'Lp.labelfr AS Lpfr', 'Lp.labeleng AS Lpeng')
                ->orderBy('demloanno')->get();
        }

        if ($dateFr !== null && $dateTo !== null) {
            return self::query()->where('dem_loans.status', $stat)->where('created_at', '<', $dateTo)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('dem_loans.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('dem_loans.institution', $emp->institutions);
                    }
                })
                ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
                ->join('loan_types AS Lt', 'dem_loans.loantype', '=', 'Lt.idltype')
                ->join('loan_purs AS Lp', 'dem_loans.loanpur', '=', 'Lp.idloanpur')
                ->select('dem_loans.*', 'M.memnumb', 'M.name', 'M.surname', 'Lt.lcode', 'Lt.labelfr AS Ltfr', 'Lt.labeleng AS Lteng',
                    'Lp.purcode', 'Lp.labelfr AS Lpfr', 'Lp.labeleng AS Lpeng')
                ->orderBy('demloanno')->get();
        }

        return self::query()->where('dem_loans.status', $stat)->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('dem_loans.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('dem_loans.institution', $emp->institutions);
            }
        })
            ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
            ->join('loan_types AS Lt', 'dem_loans.loantype', '=', 'Lt.idltype')
            ->join('loan_purs AS Lp', 'dem_loans.loanpur', '=', 'Lp.idloanpur')
            ->select('dem_loans.*', 'M.memnumb', 'M.name', 'M.surname', 'Lt.lcode', 'Lt.labelfr AS Ltfr', 'Lt.labeleng AS Lteng',
                'Lp.purcode', 'Lp.labelfr AS Lpfr', 'Lp.labeleng AS Lpeng')
            ->orderBy('demloanno')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast()
    {
        $emp = Session::get('employee');

        $dem_loan = self::query()->select('dem_loans.*', 'M.memnumb', 'M.name AS M_name', 'M.surname AS m_surname', 'E.empmat', 'E.name AS e_name', 'E.surname AS e_surname',
            'LT.loan_type_code', 'LT.labelfr AS lt_labelfr', 'LT.labeleng AS lt_labeleng', 'LP.labelfr AS lp_labelfr', 'LP.labeleng AS lp_labeleng')
            ->join('members AS M', 'dem_loans.member', '=', 'M.idmember')
            ->join('employees AS E', 'dem_loans.employee', '=', 'E.idemp')
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
}
