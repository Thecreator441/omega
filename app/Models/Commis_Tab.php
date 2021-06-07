<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commis_Tab extends Model
{
    protected $table = 'commis_tabs';

    protected $primaryKey = 'id_comm_tab';

    protected $fillable = ['commis_tabs'];

    /**
     * @param int $param
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCommisTab(int $param)
    {
        return self::query()->where('branch_param', $param)->first();
    }
}
