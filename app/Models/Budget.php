<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $table = 'budgets';

    protected $primaryKey = 'idbudget';

    protected $fillable = ['budgets'];

    /**
     * @param int $budget
     * @return Builder|Model|object|null
     */
    public static function getBudget(int $budget)
    {
        return self::query()->where('idbudget', $budget)->first();
    }

}
