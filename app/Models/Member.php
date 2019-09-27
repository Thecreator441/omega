<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Member extends Model
{
    protected $table = 'members';

    protected $primaryKey = 'idmember';

    private $idmember;

    private $memnumb;

    private $name;

    private $surname;

    private $gender;

    private $dob;

    private $pob;

    private $phone1;

    private $phone2;

    private $email;

    private $status;

    private $profession;

    private $nic;

    private $pic;

    private $signature;

    private $issuedate;

    private $issueplace;

    private $cnpsnumb;

    private $memtype;

    private $assno;

    private $asstype;

    private $assmemno;

    private $taxpaynumb;

    private $comregis;

    private $regime;

    private $country;

    private $regorigin;

    private $region;

    private $town;

    private $division;

    private $subdivision;

    private $address;

    private $street;

    private $quarter;

    private $witnes_name;

    private $witnes_nic;

    private $network;

    private $zone;

    private $institution;

    private $branch;

    private $memstatus;

    private $updated_at;

    private $created_at;

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

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->whereRaw('(branches.institution = institutions.idinst)');
            }
        })->distinct('idmember')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getActiveMembers()
    {
        $emp = Session::get('employee');

        return self::query()->where('memstatus', 'A')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->whereRaw('(branches.institution = institutions.idinst)');
                }
            })->distinct('idmember')->orderBy('memnumb', 'ASC')->get();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMembersFile(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where === null) {
            return self::query()->where($where)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->whereRaw('(branches.institution = institutions.idinst)');
                    }
                })->join('countries AS C', 'members.country', '=', 'idcountry')
                ->join('regions AS R', 'members.region', '=', 'idregi')
                ->join('regions AS Ro', 'members.regorigin', '=', 'Ro.idregi')
                ->join('towns AS T', 'members.town', '=', 'idtown')
                ->join('divisions AS D', 'members.division', '=', 'iddiv')
                ->join('sub_divs AS S', 'members.subdivision', '=', 'idsub')
                ->select('members.*', 'R.labelfr AS rfr', 'R.labeleng AS reng', 'D.label AS dbel', 'S.label AS sbel')
                ->distinct('idmember')->orderBy('memnumb')->get();
        }
        return self::query()->where('memstatus', 'A')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->whereRaw('(branches.institution = institutions.idinst)');
                }
            })->join('countries AS C', 'members.country', '=', 'idcountry')
            ->join('regions AS R', 'members.region', '=', 'idregi')
            ->join('regions AS Ro', 'members.regorigin', '=', 'Ro.idregi')
            ->join('towns AS T', 'members.town', '=', 'idtown')
            ->join('divisions AS D', 'members.division', '=', 'iddiv')
            ->join('sub_divs AS S', 'members.subdivision', '=', 'idsub')
            ->select('members.*', 'R.labelfr AS rfr', 'R.labeleng AS reng', 'D.label AS dbel', 'S.label AS sbel')
            ->distinct('idmember')->orderBy('memnumb')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getDeadMembers()
    {
        $emp = Session::get('employee');

        return self::query()->where('memstatus', 'D')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->whereRaw('(branches.institution = institutions.idinst)');
                }
            })->distinct('idmember')->get();
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
