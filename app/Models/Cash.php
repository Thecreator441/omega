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

    private $idcash;

    private $cashcode;

    private $labelfr;

    private $labeleng;

    private $cashacc;

    private $status;

    private $employee;

    private $institution;

    private $branch;

    private $mon1;

    private $mon2;

    private $mon3;

    private $mon4;

    private $mon5;

    private $mon6;

    private $mon7;

    private $mon8;

    private $mon9;

    private $mon10;

    private $mon11;

    private $mon12;

    private $closed_at;

    private $updated_at;

    private $created_at;

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getCashes()
    {
        $emp = Session::get('employee');

        return DB::table(DB::raw('branches AS B, cashes AS C, institutions AS I'))
            ->select('C.*')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('C.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->whereRaw('(branches.institution = institutions.idinst)');
                }
            })->distinct('idcash')->orderBy('idcash', 'ASC')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCashDetail()
    {
        $emp = Session::get('employee');

        return self::query()->where('employee', $emp->idemp)
            ->join('accounts', 'cashes.cashacc', '=', 'accounts.idaccount')
            ->select('cashes.*', 'accounts.accnumb', 'accounts.labelfr AS acclabelfr', 'accounts.labeleng AS acclabeleng')
            ->first();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCash(int $id)
    {
        return self::query()->where('idcash', $id)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getEmpCash()
    {
        $emp = Session::get('employee');

        return self::query()->where('employee', $emp->idemp)->where(static function ($query) use ($emp) {
            $query->orWhere(['status' => 'O', 'cashes.status' => 'R'])->orWhere('status', 'C');
        })->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getEmpCashOpen()
    {
        $emp = Session::get('employee');

        return self::query()->where('employee', $emp->idemp)->where(static function ($query) {
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
    public static function getCloseCash()
    {
        $emp = Session::get('employee');

        return self::query()->where('status', 'C')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('institution ', $emp->institution);
                }
            })->orderBy('idcash', 'ASC')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getOpenCash()
    {
        $emp = Session::get('employee');

        return self::query()->orWhere(['status' => 'O', 'cashes.status' => 'R'])
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('institution ', $emp->institution);
                }
            })->orderBy('idcash', 'ASC')->get();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $emp = Session::get('employee');

        return self::query()->orWhere('status', 'C')
            ->join('institutions AS I', 'cashes.institution', '=', 'I.idinst')
            ->join('branches AS B', 'cashes.branch', '=', 'B.idbranch')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('cashes.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('cashes.institution ', $emp->institution);
                }
            })
            ->distinct('idcash')->orderBy('idcash')->paginate(1);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginateOpen(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
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
                    $query->where('cashes.institution ', $emp->institution);
                }
            })
            ->distinct('idcash')->orderBy('idcash', 'ASC')->paginate(1);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginateAll(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $emp = Session::get('employee');

        return self::query()->join('institutions AS I', 'cashes.institution', '=', 'I.idinst')
            ->join('branches AS B', 'cashes.branch', '=', 'B.idbranch')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('cashes.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('cashes.institution ', $emp->institution);
                }
            })
            ->distinct('idcash')->orderBy('idcash', 'ASC')->paginate(1);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getReopenPaginate()
    {
        $emp = Session::get('employee');

        return self::query()->where(['C.status' => 'C', 'C.closed_at' => getsDate(now())])
            ->join('institutions AS I', 'cashes.institution', '=', 'I.idinst')
            ->join('branches AS B', 'cashes.branch', '=', 'B.idbranch')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('cashes.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('cashes.institution ', $emp->institution);
                }
            })
            ->distinct('idcash')->orderBy('idcash', 'ASC')->paginate(1);
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
}
