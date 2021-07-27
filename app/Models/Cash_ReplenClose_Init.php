<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Cash_ReplenClose_Init extends Model
{
    protected $table = 'cashes_replenclose_inits';

    protected $primaryKey = 'idcash_replenclose_init';

    protected $fillable = ['cashes_replenclose_inits'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCashReplenCloseInit(int $id)
    {
        return self::query()->where('idcash_replenclose_init', $id)->first();
    }
    
    /**
     * @param int $cash
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCashInit(int $cash, string $type = 'R')
    {
        return self::query()->where(['init_cash' => $cash, 'init_type' => $type])->first();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCashInitBy(array $where)
    {
        return self::query()->where($where)->first();
    }
    
    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCashInits(array $where = [])
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
                        $query->where('branch', $emp->branch);
                    }
                })->orderBy('created_at')->get();
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
                $query->where('branch', $emp->branch);
            }
        })->orderBy('created_at')->get();
    }
}
