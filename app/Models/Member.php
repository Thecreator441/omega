<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Member extends Model
{
    protected $table = 'members';

    protected $primaryKey = 'idmember';

    protected $fillable = ['members'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMember(int $id)
    {
        return self::query()->where('idmember', $id)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMembers()
    {
        $emp = Session::get('employee');

        return self::query()->distinct('idmember')->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('institution', $emp->branch);
            }
            if ($emp->level === 'Z') {
                $query->where('zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('network', $emp->network);
            }
        })->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getActiveMembers()
    {
        $emp = Session::get('employee');

        return self::query()->distinct('idmember')->where('memstatus', 'A')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('institution', $emp->branch);
                }
                if ($emp->level === 'Z') {
                    $query->where('zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('network', $emp->network);
                }
            })->orderBy('memnumb')->get();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMembersFile(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where === null) {
            return self::query()->distinct('idmember')
                ->select('members.*', 'R.labelfr AS rfr', 'R.labeleng AS reng', 'D.label AS dbel', 'S.label AS sbel')
                ->join('countries AS C', 'members.country', '=', 'idcountry')
                ->join('regions AS R', 'members.region', '=', 'idregi')
                ->join('towns AS T', 'members.town', '=', 'idtown')
                ->join('divisions AS D', 'members.division', '=', 'iddiv')
                ->join('sub_divs AS S', 'members.subdivision', '=', 'idsub')
                ->where($where)->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('institution', $emp->branch);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('network', $emp->network);
                    }
                })
                ->orderBy('memnumb')->get();
        }
        return self::query()->distinct('idmember')
            ->select('members.*', 'R.labelfr AS rfr', 'R.labeleng AS reng', 'D.label AS dbel', 'S.label AS sbel')
            ->join('countries AS C', 'members.country', '=', 'idcountry')
            ->join('regions AS R', 'members.region', '=', 'idregi')
            ->join('towns AS T', 'members.town', '=', 'idtown')
            ->join('divisions AS D', 'members.division', '=', 'iddiv')
            ->join('sub_divs AS S', 'members.subdivision', '=', 'idsub')
            ->where('memstatus', 'A')->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('institution', $emp->branch);
                }
                if ($emp->level === 'Z') {
                    $query->where('zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('network', $emp->network);
                }
            })
            ->orderBy('memnumb')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast()
    {
        $emp = Session::get('employee');

        return self::query()->where('branch', $emp->branch)->orderByDesc('memnumb')->first();
    }

}
