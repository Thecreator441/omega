<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Branch extends Model
{
    protected $table = 'branches';

    protected $primaryKey = 'idbranch';

    protected $fillable = ['branches'];

    /**
     * @param int $idbranch
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getBranch(int $idbranch)
    {
        return self::query()->where('idbranch', $idbranch)->first();
    }

    /**
     * @param array $where
     * @return Branch[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getBranches(array $where = [])
    {
        if ($where !== null) {
         return self::query()->select('branches.*', 'I.abbr')
             ->join('institutions AS I', 'institution', '=', 'I.idinst')
             ->where($where)->orderBy('name')->get();
        }
        return self::query()->select('branches.*', 'I.abbr')
            ->join('institutions AS I', 'institution', '=', 'I.idinst')
            ->orderBy('name')->get();
    }

}
