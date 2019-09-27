<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comakers extends Model
{
    protected $table = 'comakers';

    protected $primaryKey = 'idcomaker';

    protected $fillable = ['comakers'];

    private $idcomaker;

    private $loan;

    private $member;

    private $account;

    private $quartype;

    private $guaramt;

    private $updated_at;

    private $created_at;

    /**
     * @param int $loan
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getComakers(int $loan)
    {
        return self::query()->where('loan', $loan)->get();
    }

}
