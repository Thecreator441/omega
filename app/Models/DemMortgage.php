<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemMortgage extends Model
{
    protected $table = 'dem_mortgages';

    protected $primaryKey = 'iddemmortgage';

    protected $fillable = ['dem_mortgages'];

    private $iddemmortgage;

    private $demmortgno;

    private $name;

    private $nature;

    private $member;

    private $loan;

    private $amount;

    private $act_amount;

    private $status;

    private $created_at;

    private $updated_at;

    public static function getLast(int $loan)
    {
        return self::query()->where('loan', $loan)->orderBy('demmortgno', 'DESC')->first();
    }

    /**
     * @param int $demloan
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMortgages(int $demloan)
    {
        return self::query()->where('loan', $demloan)->get();
    }
}
