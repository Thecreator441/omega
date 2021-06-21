<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class MemBalance extends Model
{
    protected $table = 'mem_balances';

    protected $primaryKey = 'idbal';

    protected $fillable = ['mem_balances'];

    /**
     * @param int $member
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMemBal(int $member)
    {
        return self::query()->select('mem_mem_balances.*', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'At.labelfr AS atlabelfr', 'At.labeleng AS atlabeleng', 'At.accabbr')
            ->join('accounts AS A', 'mem_mem_balances.account', '=', 'A.idaccount')
            ->join('acc_types AS At', 'A.acctype', '=', 'At.idacctype')
            ->where('member', $member)->orderBy('A.accnumb')->get();
    }

    /**
     * @param int $member
     * @param int $account
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMemAcc(int $member, int $account)
    {
        return self::query()->select('mem_mem_balances.*', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'At.labelfr AS atlabelfr', 'At.labeleng AS atlabeleng', 'At.accabbr')
            ->join('accounts AS A', 'mem_mem_balances.account', '=', 'A.idaccount')
            ->join('acc_types AS At', 'A.acctype', '=', 'At.idacctype')
            ->where(['member' => $member, 'account' => $account])->first();
    }

    /**
     * @param int $member
     * @param string|null $date
     * @return array[]
     */
    public static function getFilterMemAccs(int $member, string $date = null)
    {
        $emp = Session::get('employee');
        $comakers = Comaker::getComakers(['member' => $member]);
        $dem_comakers = DemComaker::getDemComakers(['member' => $member]);
        $acc_bals = self::getMemAccBal($member);

        $block_amt = 0;
        $account = 0;

        foreach ($comakers as $comaker) {
            $block_amt = (int)$comaker->guaramt - (int)$comaker->paidguar;
            $account = $comaker->account;
        }

        foreach ($dem_comakers as $dem_comaker) {
            $block_amt = (int)$dem_comaker->guaramt - (int)$dem_comaker->paidguar;
            $account = $dem_comaker->account;
        }

        $result = [];

        foreach ($acc_bals as $acc_bal) {
            $amount = (int)$acc_bal->available;
            if ($amount === 0) {
                $amount = (int)$acc_bal->evebal;
            }

            $description = $acc_bal->labeleng;
            if ($emp->lang === 'fr') {
                $description = $acc_bal->labelfr;
            }

            if ($acc_bal->accabbr === 'Or' || $acc_bal->accabbr === 'Co') {
                $acc_bal->account = $acc_bal->accnumb;
                $acc_bal->description = $description;
                $acc_bal->amount = money($amount);
                $acc_bal->debt_oper = $acc_bal->debteng;
                if ($emp->lang === 'fr') {
                    $acc_bal->debt_oper = $acc_bal->debtfr;
                }
                if ($acc_bal->account === $account) {
                    $acc_bal->blocked = money($block_amt);
                    $acc_bal->available = money($amount - $block_amt);
                } else {
                    $acc_bal->blocked = money(0);
                    $acc_bal->available = money($amount);
                }

                $result[] = $acc_bal;
            }
        }

        return ['data' => $result];
    }

    /**
     * @param int $member
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMemAccBal(int $member)
    {
        return self::query()->where('member', $member)
            ->join('accounts AS A', 'mem_balances.account', '=', 'A.idaccount')
            ->join('acc_types AS At', 'A.acctype', '=', 'At.idacctype')
            ->select('mem_balances.*', 'A.accnumb', 'At.accabbr', 'A.labelfr', 'A.labeleng', 'A.idplan')
            ->distinct('member')->orderBy('A.accnumb')->get();
    }

}