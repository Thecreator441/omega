<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AccParam extends Model
{
    protected $table = 'acc_params';

    protected $primaryKey = 'idaccparam';

    protected $fillable = ['acc_params'];

    /**
     * @param int $account
     * @return Builder|Model|object|null
     */
    public static function getAccParam(int $account)
    {
        return self::query()->where('account', $account)->first();
    }

}
