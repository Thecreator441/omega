<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $table = 'operations';

    protected $primaryKey = 'idoper';

    private $idoper;

    private $opercode;

    private $labelfr;

    private $labeleng;

    private $debtfr;

    private $debteng;

    private $credtfr;

    private $credteng;

    private $updated_at;

    private $created_at;

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginate()
    {
        return self::query()->orderBy('opercode')->paginate(1);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getOperations()
    {
        return self::query()->orderBy('opercode')->get();
    }

    /**
     * @param int|null $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getOperation(int $id = null)
    {
        return self::query()->where('idoper', $id)->first();
    }

    /**
     * @param int $code
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getByCode(int $code)
    {
        return self::query()->where('opercode', $code)->first();
    }
}
