<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RegBenef extends Model
{
    protected $table = 'reg_benefs';

    protected $primaryKey = 'idregbene';

    private $idregbene;

    private $fullname;

    private $relation;

    private $register;

    private $ratio;

    private $created_at;

    private $updated_at;

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getRegBenef(array $where)
    {
        return self::query()->where($where)->get();
    }

}
