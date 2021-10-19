<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Operation extends Model
{
    protected $table = 'operations';

    protected $primaryKey = 'idoper';

    protected $fillable = ['operations'];

    /**
     * @param int|null $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getOperation(int $id = null)
    {
        return self::query()->where('idoper', $id)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getOperationBy(array $where)
    {
        return self::query()->where($where)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getOperations(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where($where)->orderBy('opercode')->get();
        }
        
        return self::query()->orderBy('opercode')->get();
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
