<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Loan extends Model
{
    protected $table = 'loans';

    protected $primaryKey = 'idloan';

    protected $fillable = ['loans'];

    private $idloan;

    private $loanno;

    private $member;

    private $memacc;

    private $amount;

    private $intrate;

    private $nbrinst;

    private $demdate;

    private $appdate;

    private $amortype;

    private $periodicity;

    private $remamt;

    private $annuity;

    private $vat;

    private $insrdate1;

    private $loanpur;

    private $loantype;

    private $employee;

    private $loanstat;

    private $isRef;

    private $isRes;

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
            })->orderBy('loanno', 'ASC')->get();
        }

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('institution', $emp->institutions);
            }
        })->orderBy('loanno', 'ASC')->get();
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
                ->orderBy('loanno', 'ASC')->get();
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
                ->orderBy('loanno', 'ASC')->get();
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
                ->orderBy('loanno', 'ASC')->get();
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
                ->orderBy('loanno', 'ASC')->get();
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
                ->orderBy('loanno', 'ASC')->get();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast()
    {
        $emp = Session::get('employee');

        return self::query()->where('branch', $emp->branch)->orderByDesc('loanno')->first();
    }
}
