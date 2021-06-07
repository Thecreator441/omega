<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AccCommis extends Model
{
    protected $table = 'acc_commis';

    protected $primaryKey = 'idcommis';

    protected $fillable = ['acc_commis'];

    /**
     * @param int $acc_param
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAccCommis(array $where)
    {
        return self::query()->where($where)
            ->join('accounts AS A', 'label_acc', '=', 'idaccount')
            ->select('acc_commis.*', 'A.accnumb')
            ->orderBy('idcommis')->get();
    }

}
