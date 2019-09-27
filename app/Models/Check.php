<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Check extends Model
{
    protected $table = 'checks';

    protected $primaryKey = 'idcheck';

    protected $fillable = ['checks'];

    private $idcheck;

    private $checknumb;

    private $label;

    private $bank;

    private $status;

    private $amount;

    private $carrier;

    private $institution;

    private $branch;

    private $member;

    private $updated_at;

    private $created_at;

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCheck(int $id)
    {
        return self::query()->where('idcheck', $id)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getChecks()
    {
        $emp = Session::get('employee');

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->whereRaw('(branches.institution = institutions.idinst)');
            }
        })->distinct('idcheck')->orderBy('checknumb')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getDroppedChecks()
    {
        $emp = Session::get('employee');

        return self::query()->where('status', 'D')->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->whereRaw('(branches.institution = institutions.idinst)');
            }
        })->distinct('idcheck')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getNotSortChecks()
    {
        $emp = Session::get('employee');

        return self::query()->where(['status' => 'P', 'type' => 'I', 'sorted' => 'N'])->where('member', '!=', null)
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->whereRaw('(branches.institution = institutions.idinst)');
                }
            })->distinct('idcheck')->orderBy('checknumb')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getOtherNotSortChecks()
    {
        $emp = Session::get('employee');

        return self::query()->where(['status' => 'P', 'type' => 'I', 'sorted' => 'N', 'member' => null])
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->whereRaw('(branches.institution = institutions.idinst)');
                }
            })->distinct('idcheck')->orderBy('checknumb')->get();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getToSortChecks(int $id)
    {
        $emp = Session::get('employee');

        return self::query()->where('idcheck', $id)
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('checks.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->whereRaw('(branches.institution = institutions.idinst)');
                }
            })
            ->join('members AS M', 'checks.member', '=', 'M.idmember')
            ->join('banks AS B', 'checks.bank', '=', 'B.idbank')
            ->select('checks.*', 'M.memnumb', 'M.name', 'M.surname', 'B.ouracc', 'B.name AS bname')
            ->distinct('idcheck')->orderBy('checknumb')->first();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getOtherToSortChecks(int $id)
    {
        $emp = Session::get('employee');

        return self::query()->where('idcheck', $id)
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('checks.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->whereRaw('(branches.institution = institutions.idinst)');
                }
            })
            ->join('banks AS B', 'checks.bank', '=', 'B.idbank')
            ->select('checks.*', 'B.ouracc', 'B.name AS bname')
            ->distinct('idcheck')->orderBy('checknumb')->first();
    }
}
