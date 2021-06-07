<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plat_Param extends Model
{
    protected $table = 'plat_params';

    protected $primaryKey = 'id_plat_param';

    protected $fillable = ['plat_params'];

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getPlatParam()
    {
        return self::query()->first();
    }
}
