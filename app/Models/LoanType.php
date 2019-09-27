<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class LoanType extends Model
{
    protected $table = 'loan_types';

    protected $primaryKey = 'idltype';

    protected $fillable = ['loan_types'];

    private $idltype;

    private $ltnumb;

    private $labeleng;

    private $labelfr;

    private $period;

    private $maxdur;

    private $maxamt;

    private $datescapepen;

    private $intacc;

    private $loanaccart;

    private $getcomaker;

    private $blockacc;

    private $paytax;

    private $taxrate;

    private $taxacc;

    private $usequote;

    private $quoterate;

    private $quoteaccplan;

    private $penreq;

    private $pentax;

    private $penacc;

    private $institution;

    private $created_at;

    private $updated_at;

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLoanType(int $id)
    {
        return self::query()->where('idltype', $id)->join('accounts AS A', 'loanacc', '=', 'A.idaccount')
            ->select('loan_types.*', 'A.accnumb')->first();
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getLoanTypes(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where($where)->where('institution', $emp->institution)->orderBy('lcode')->get();
        }
        return self::query()->where('institution', $emp->institution)->orderBy('lcode')->get();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginates()
    {
        $emp = Session::get('employee');

        return self::query()->where('institution', $emp->institution)
            ->distinct('idltype')->orderBy('lcode')->paginate(1);
    }

    /**
     * @param int $id
     * @return Builder|Model|object|null
     */
    public static function getAccChart(int $id)
    {
        return self::query()->where('idltype', $id)
            ->join('accounts AS A', 'loanaccart', '=', 'idaccount')
            ->orderBy('accnumb', 'ASC')->first();
    }
}
