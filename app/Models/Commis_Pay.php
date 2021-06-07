<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Commis_Pay extends Model
{
    protected $table = 'commis_pays';

    protected $primaryKey = 'id_commis_pay';

    protected $fillable = ['commis_pays'];

    /**
     * @param int $branch
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCommisPay()
    {
        $emp = Session::get('employee');

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
        })->first();
    }

    /**
     * @param int $branch
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCommisPayMob()
    {
        return self::query()->first();
    }


    /**
     * @param int $branch
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMonth(int $branch)
    {
        return self::query()->where('branch', $branch)->first();
    }
}
