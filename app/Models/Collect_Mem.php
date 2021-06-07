<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Collect_Mem extends Model
{
    protected $table = 'collect_mems';

    protected $primaryKey = 'idcollect_mem';

    protected $fillable = ['collect_mems'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMember(int $id)
    {
        return self::query()->where('idcollect_mem', $id)->first();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMemBal(int $id)
    {
        return self::query()->select('collect_mems.name', 'collect_mems.surname', 'Cb.*')
            ->join('collect_bals AS Cb', 'collect_mems.idcollect_mem', '=', 'Cb.member')
            ->where('idcollect_mem', $id)->first();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMembers(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where($where)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('network', $emp->network);
                    }
                })->orderBy('coll_memnumb')->get();
        }
        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('network', $emp->network);
            }
        })->orderBy('coll_memnumb')->get();
    }

    /**
     * @param int|null $branch
     * @param int|null $collector
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast(int $branch = null, int $collector = null)
    {
        if ($branch === null && $collector === null) {
            $emp = Session::get('employee');

            return self::query()->where([
                'branch' => $emp->branch,
                'collector' => $emp->idcoll
            ])->orderByDesc('coll_memnumb')->first();
        }

        return self::query()->where([
            'branch' => $branch,
            'collector' => $collector
        ])->orderByDesc('coll_memnumb')->first();
    }

    /**
     * @param int|null $inst
     * @param int|null $branch
     * @param int|null $collector
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|null
     */
    public static function getFilterCustomers(int $inst = null, int $branch = null, int $collector = null)
    {
        $emp = Session::get('employee');

        $customers = null;

        if ($inst === null && $branch === null && $collector === null) {
            $customers = self::query()
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('zone ', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('network ', $emp->network);
                    }
                })->orderBy('coll_memnumb')->get();
        }
        if ($inst !== null && $branch === null && $collector === null) {
            $customers = self::query()->where('institution', $inst)->orderBy('coll_memnumb')->get();
        }
        if ($inst === null && $branch !== null && $collector === null) {
            $customers = self::query()->where('branch', $branch)->orderBy('coll_memnumb')->get();
        }
        if ($inst === null && $branch === null && $collector !== null) {
            $customers = self::query()->where('collector', $collector)->orderBy('coll_memnumb')->get();
        }
        if ($inst !== null && $branch !== null && $collector === null) {
            $customers = self::query()->where('branch', $branch)->orderBy('coll_memnumb')->get();
        }
        if ($inst === null && $branch !== null && $collector !== null) {
            $customers = self::query()->where(['branch' => $branch, 'collector' => $collector])->orderBy('coll_memnumb')->get();
        }
        if ($inst !== null && $branch !== null && $collector !== null) {
            $customers = self::query()->where(['branch' => $branch, 'collector' => $collector])->orderBy('coll_memnumb')->get();
        }

        foreach ($customers as $customer) {
            $gender = 'Male';
            $status = 'Active';

            $cust_benefs = Collect_Mem_Benef::getCollectMemBenefs($customer->idcollect_mem);

            $customer->benefs = $cust_benefs->count();
            $customer->name .= ' ' . $customer->surname;
            $customer->coll_memnumb = pad($customer->coll_memnumb, 6);
            $dob = changeFormat($customer->dob);
//            $created_at = changeFormat($customer->created_at);

            if ($customer->gender === 'F') {
                $gender = 'Female';
            }
            if ($customer->coll_memstatus === 'D') {
                $status = 'Inactive';
            }

            $customer->dob = $dob;
//            $customer->created_at = $created_at;
            $customer->gender = $gender;
            $customer->coll_memstatus = $status;
        }

        return ['data' => $customers];
    }

    /**
     * @param int|null $inst
     * @param int|null $branch
     * @param int|null $collector
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|null
     */
    public static function getFilterCustBals(int $inst = null, int $branch = null, int $collector = null)
    {
        $emp = Session::get('employee');

        $customers = null;

        if ($inst === null && $branch === null && $collector === null) {
            $customers = self::query()
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('zone ', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('network ', $emp->network);
                    }
                })->orderBy('coll_memnumb')->get();
        }
        if ($inst !== null && $branch === null && $collector === null) {
            $customers = self::query()->where('institution', $inst)->orderBy('coll_memnumb')->get();
        }
        if ($inst === null && $branch !== null && $collector === null) {
            $customers = self::query()->where('branch', $branch)->orderBy('coll_memnumb')->get();
        }
        if ($inst === null && $branch === null && $collector !== null) {
            $customers = self::query()->where('collector', $collector)->orderBy('coll_memnumb')->get();
        }
        if ($inst !== null && $branch !== null && $collector === null) {
            $customers = self::query()->where('branch', $branch)->orderBy('coll_memnumb')->get();
        }
        if ($inst === null && $branch !== null && $collector !== null) {
            $customers = self::query()->where(['branch' => $branch, 'collector' => $collector])->orderBy('coll_memnumb')->get();
        }
        if ($inst !== null && $branch !== null && $collector !== null) {
            $customers = self::query()->where(['branch' => $branch, 'collector' => $collector])->orderBy('coll_memnumb')->get();
        }

        foreach ($customers as $customer) {
            $balance = Collect_Bal::getMemBal($customer->idcollect_mem);
            if (!empty($balance)) {
                foreach ($balance->getAttributes() as $index => $attribute) {
                    $customer->$index = $attribute;
                }
            }

            $customer->code = pad($customer->coll_memnumb, 6);
            $customer->name .= ' ' . $customer->surname;

            $amount = 0;

            if ((int)$customer->available === 0)
                $amount = money((int)$customer->evebal);
            else {
                $amount = money((int)$customer->available);
            }
            $customer->amount = $amount;
        }

        return ['data' => $customers];
    }

    /**
     * @param int $idcoll
     * @param string $lang
     * @return array
     */
    public static function getCollectMemsByColl(int $idcoll, string $lang = 'eng')
    {
        $customers = self::getCollectMems($idcoll);
        $professions = Profession::getProfessions($lang);

        foreach ($customers as $customer) {
            $gender = 'Male';
            $status = 'Active';

            $cust_benefs = Collect_Mem_Benef::getCollectMemBenefs($customer->idcollect_mem);

            $customer->benefs = $cust_benefs->count();
            $customer->name .= ' ' . $customer->surname;
            $customer->coll_memnumb = pad($customer->coll_memnumb, 6);
            $dob = changeFormat($customer->dob);
//            $created_at = changeFormat($customer->created_at);

            if (is_numeric($customer->profession)) {
                foreach ($professions as $profession) {
                    if ($profession->idprof === (int)$customer->profession) {
                        $customer->profession = $profession->labeleng;
                        if ($lang === 'fr') {
                            $customer->profession = $profession->labelfr;
                        }
                    }
                }
            }

            if ($customer->gender === 'F') {
                $gender = 'Female';
            }
            if ($customer->coll_memstatus === 'D') {
                $status = 'Inactive';
            }

            $customer->dob = $dob;
//            $customer->created_at = $created_at;
            $customer->gender = $gender;
            $customer->coll_memstatus = $status;
        }

        return ['data' => $customers];
    }

    /**
     * @param int $idcoll
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCollectMems(int $idcoll)
    {
        return self::query()->where('collector', $idcoll)->orderBy('coll_memnumb')->get();
    }
}
