<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanMan extends Model
{
    protected $table = 'loan_mans';

    protected $primaryKey = 'idloanman';

    protected $fillable = ['loan_mans'];

    /**
     * @param int $member
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLoanMan(int $member)
    {
        return self::query()->where('member', $member)->first();
    }

}
