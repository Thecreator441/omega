<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $table = 'installments';

    protected $primaryKey = 'idinstall';

    protected $fillable = ['installments'];

    private $idinstall;

    private $loan;

    private $installno;

    private $capital;

    private $amort;

    private $interest;

    private $annuity;

    private $tax;

    private $total;

    private $instdate;

    private $created_at;

    private $updated_at;

    /**
     * @param int $loan
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getInstalls(int $loan)
    {
        return self::query()->where('loan', $loan)->get();
    }
}
