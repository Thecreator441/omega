<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Mortgage extends Model
{
    protected $table = 'mortgages';

    protected $primaryKey = 'idmortgage';

    protected $fillable = ['mortgages'];

    private $idmortgage;

    private $mortgno;

    private $name;

    private $nature;

    private $member;

    private $loan;

    private $amount;

    private $act_amount;

    private $created_at;

    private $updated_at;

    public static function getLast(int $loan)
    {
        return self::query()->where('loan', $loan)->orderByDesc('mortgno')->first();
    }

    /**
     * @param int $loan
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMortgages(int $loan)
    {
        return self::query()->where('loan', $loan)->get();
    }
}
