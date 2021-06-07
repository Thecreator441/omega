<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class LoanPur extends Model
{
    protected $table = 'loan_purs';

    protected $primaryKey = 'idloanpur';

    protected $fillable = ['loan_purs'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLoanPur(int $id)
    {
        return self::query()->where('idloanpur', $id)->first();
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getLoanPurs(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where($where)->get();
        }
        return self::query()->get();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginates()
    {
        return self::query()->distinct('idloanpur')->orderBy('purcode')->paginate(1);
    }

    /**
     * @return string
     */
    public static function getLast()
    {
        return self::query()->orderByDesc('purcode')->first();
    }

}
