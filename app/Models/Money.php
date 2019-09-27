<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Money extends Model
{
    protected $table = 'moneys';

    private $idmoney;

    private $moncode;

    private $value;

    private $format;

    private $labeleng;

    private $labelfr;

    private $currency;

    private $updated_at;

    private $created_at;

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMoneys()
    {
        $emp = Session::get('employee');

        return self::query()->where('C.idcountry', $emp->country)
            ->join('countries AS C', 'C.currency', '=', 'moneys.currency')
            ->select('moneys.*', 'C.labelfr AS coulabelfr', 'C.labeleng AS coulabeleng')
            ->orderByDesc('value')->get();
    }

}
