<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $table = 'installments';

    protected $primaryKey = 'idinstall';

    protected $fillable = ['installments'];

    /**
     * @param int $loan
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getInstalls(int $loan)
    {
        return self::query()->where('loan', $loan)->get();
    }
}
