<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemComakers extends Model
{
    protected $table = 'dem_comakers';

    protected $primaryKey = 'iddemcomaker';

    protected $fillable = ['dem_comakers'];

    private $iddemcomaker;

    private $demloan;

    private $member;

    private $account;

    private $quartype;

    private $guaramt;

    private $status;

    private $updated_at;

    private $created_at;

    /**
     * @param int $demloan
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getComakers(int $demloan)
    {
        return self::query()->where('demloan', $demloan)->get();
    }

}
