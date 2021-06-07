<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Collect_Bal extends Model
{
    protected $table = 'collect_bals';

    protected $primaryKey = 'idcol_bal';

    protected $fillable = ['collect_bals'];

    /**
     * @param int $member
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMemBal(int $member)
    {
        return self::query()->where('member', $member)->first();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCustBals(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->select('collect_bals.*', 'Cm.coll_memnumb', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
                ->join('collect_mems as Cm', 'collect_bals.member', '=', 'Cm.idcollect_mem')
                ->join('collectors as C', 'Cm.collector', '=', 'C.idcoll')
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('Cm.branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('Cm.institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('Cm.zone', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('Cm.network', $emp->network);
                    }
                })->where($where)->orderBy('coll_memnumb')->get();
        }

        return self::query()->select('collect_bals.*', 'Cm.coll_memnumb', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
            ->join('collect_mems as Cm', 'collect_bals.member', '=', 'Cm.idcollect_mem')
            ->join('collectors as C', 'Cm.collector', '=', 'C.idcoll')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('Cm.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('Cm.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('Cm.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('Cm.network', $emp->network);
                }
            })->orderBy('coll_memnumb')->get();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCustBalsByColl(int $collector)
    {
        $customers = self::query()->select('collect_bals.*', 'Cm.coll_memnumb', 'Cm.name', 'Cm.surname', 'C.name AS col_name', 'C.surname AS col_surname')
            ->join('collect_mems as Cm', 'collect_bals.member', '=', 'Cm.idcollect_mem')
            ->join('collectors as C', 'Cm.collector', '=', 'C.idcoll')
            ->where('Cm.collector', $collector)->orderBy('coll_memnumb')->get();

        foreach ($customers as $customer) {
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
     * @param int $customer
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCustomerBalance(int $customer)
    {
        return self::query()->select('collect_bals.*', 'A.accnumb')
            ->join('accounts AS A', 'collect_bals.account', '=', 'A.idaccount')
            ->where('member', $customer)->first();
    }
}
