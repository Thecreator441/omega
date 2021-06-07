<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Inst_Param extends Model
{
    protected $table = 'inst_params';

    protected $primaryKey = 'id_inst_param';

    protected $fillable = ['inst_params'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getInstParam(int $id)
    {
        return self::query()->where('institution', $id)->first();
    }
}
