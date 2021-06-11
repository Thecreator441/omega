<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class Register extends Model
{
    protected $table = 'registers';

    protected $primaryKey = 'idregister';

    protected $fillable = ['registers'];

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getRegisters()
    {
        $emp = Session::get('employee');

        return self::query()->where('branch', $emp->branch)->get();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getRegistersFile(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where === null) {
            return self::query()->distinct('idregister')
                ->select('registers.*', 'R.labelfr AS rfr', 'R.labeleng AS reng', 'D.label AS dbel', 'S.label AS sbel')
                ->join('countries AS C', 'registers.country', '=', 'idcountry')
                ->join('regions AS R', 'registers.region', '=', 'idregi')
                ->join('towns AS T', 'registers.town', '=', 'idtown')
                ->join('divisions AS D', 'registers.division', '=', 'iddiv')
                ->join('sub_divs AS S', 'registers.subdivision', '=', 'idsub')
                ->where($where)->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->whereRaw('(branches.institution = institutions.idinst)');
                    }
                })
                ->orderBy('regnumb')->get();
        }
        return self::query()->distinct('idregister')
            ->select('registers.*', 'R.labelfr AS rfr', 'R.labeleng AS reng', 'D.label AS dbel', 'S.label AS sbel')
            ->join('countries AS C', 'registers.country', '=', 'idcountry')
            ->join('regions AS R', 'registers.region', '=', 'idregi')
            ->join('towns AS T', 'registers.town', '=', 'idtown')
            ->join('divisions AS D', 'registers.division', '=', 'iddiv')
            ->join('sub_divs AS S', 'registers.subdivision', '=', 'idsub')
            ->where('regstatus', 'R')->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->whereRaw('(branches.institution = institutions.idinst)');
                }
            })
            ->orderBy('regnumb')->get();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getRegister(int $id)
    {
        return self::query()->where('idregister', $id)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast()
    {
        $emp = Session::get('employee');

        return self::query()->where('branch', $emp->branch)->orderByDesc('regnumb')->first();
    }

}
