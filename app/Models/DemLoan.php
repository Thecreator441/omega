<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class DemLoan extends Model
{
    protected $table = 'dem_loans';

    protected $primaryKey = 'iddemloan';

    protected $fillable = ['dem_loans'];

    private $iddemloan;

    private $demloanno;

    private $member;

    private $memacc;

    private $transacc;

    private $amount;

    private $intrate;

    private $nbrinst;

    private $demdate;

    private $appdate;

    private $amortype;

    private $periodicity;

    private $remamt;

    private $annuity;

    private $year;

    private $vat;

    private $insrdate1;

    private $loanpur;

    private $loantype;

    private $employee;

    private $loanstat;

    private $isforce;

    private $isforceby;

    private $institution;

    private $branch;

    private $updated_at;

    private $created_at;

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLoan(int $id)
    {
        return self::query()->where('iddemloan', $id)->first();
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
            })->distinct('idloan')->get();
        }

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('institution', $emp->institutions);
            }
        })->distinct('idloan')->get();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getDemLoans(array $where = null)
    {
        $emp = Session::get('employee');
        if ($where !== null) {
            return self::query()->where('status', 'Al')->where($where)->where(static function ($query) use ($emp) {
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

        return self::query()->where('status', 'Al')->where(static function ($query) use ($emp) {
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
        return self::query()->where('status', 'Al')->where(static function ($query) use ($emp) {
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

        return self::query()->where('branch', $emp->branch)->orderByDesc('demloanno')->first();
    }
}
