<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Branch_Param extends Model
{
    protected $table = 'branch_params';

    protected $primaryKey = 'idbranch_param';

    protected $fillable = ['branch_params'];

    /**
     * @param int $idbranch
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getBranchParam(int $idbranch)
    {
        return self::query()->where('branch', $idbranch)->first();
    }
}
