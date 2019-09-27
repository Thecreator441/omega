<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class LoanMan extends Model
{
    protected $table = 'loan_mans';

    protected $primaryKey = 'idloanman';

    private $idloanman;

    private $employee;

    private $member;

    private $created_at;

    private $updated_at;

    /**
     * @param int $member
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLoanMan(int $member)
    {
        return self::query()->where('member', $member)->first();
    }

}
