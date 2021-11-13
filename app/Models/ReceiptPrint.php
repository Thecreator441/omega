<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReceiptPrint extends Model
{
    protected $primaryKey = 'idprint';

    protected $table = 'receipt_prints';

    protected $fillable = ['receipt_prints'];

    /**
     * @param int $idacctype
     * @return Builder|Model|object|null
     */
    public static function getReceiptPrint(int $idacctype)
    {
        return self::query()->where('idacctype', $idacctype)->first();
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getReceiptPrints(array $where = null)
    {
        if ($where !== null) {
            return self::query()->where($where)->orderBy('accabbr')->get();
        }
        return self::query()->orderBy('accabbr')->get();
    }
}
