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

    private $idloanpur;

    private $purcode;

    private $labeleng;

    private $labelfr;

    private $institution;

    private $updated_at;

    private $created_at;

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
            return self::query()->where($where)->where('institution', $emp->institution)->orderBy('purcode')->get();
        }
        return self::query()->where('institution', $emp->institution)->orderBy('purcode')->get();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginates()
    {
        $emp = Session::get('employee');

        return self::query()->where('institution', $emp->institution)
            ->distinct('idloanpur')->orderBy('purcode')->paginate(1);
    }

}
