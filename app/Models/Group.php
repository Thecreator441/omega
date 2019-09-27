<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class Group extends Model
{
    protected $table = 'groups';

    protected $primaryKey = 'idgroup';

    protected $fillable = ['groups'];

    private $idgroup;

    private $code;

    private $name;

    private $account;

    private $institut;

    private $branch;

    private $created_at;

    private $updated_at;

    /**
     * @param int $member
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMemBal(int $member)
    {
        return self::query()->where('member', $member)
            ->join('accounts AS A', 'balances.account', '=', 'A.idaccount')
            ->join('operations AS O', 'balances.operation', '=', 'O.idoper')
            ->select('balances.*')
            ->distinct('member')->orderBy('A.accnumb', 'ASC')->get();
    }

    /**
     * @param int $member
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMemAccBal(int $member)
    {
        return self::query()->where('member', $member)
            ->join('accounts AS A', 'balances.account', '=', 'A.idaccount')
            ->join('acc_types AS At', 'A.acctype', '=', 'At.idacctype')
            ->join('operations AS O', 'balances.operation', '=', 'O.idoper')
            ->select('balances.*', 'A.accnumb', 'At.accabbr', 'A.labelfr', 'A.labeleng', 'O.labelfr AS operfr',
                'O.labeleng AS opereng', 'O.debtfr', 'O.debteng', 'O.credtfr', 'O.credteng', 'A.accplan')
            ->distinct('member')->orderBy('A.accnumb', 'ASC')->get();
    }

    /**
     * @param int $member
     * @param int $account
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMemAcc(int $member, int $account)
    {
        return self::query()->where(['member' => $member, 'account' => $account])->first();
    }
}
