<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Benef extends Model
{
    protected $table = 'benefs';

    protected $primaryKey = 'idbene';

    protected $fillable = ['benefs'];

    /**
     * @param int $member
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getBenefs(int $member)
    {
        return self::query()->where('member', $member)->get();
    }

}
