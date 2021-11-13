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
     * @param string $acctype
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMemBals(int $member, string $acctype = null)
    {
        if ($acctype !== null) {
            return self::query()->select('mem_balances.*', 'A.idplan', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'At.labelfr AS atlabelfr', 'At.labeleng AS atlabeleng', 'At.accabbr')
                ->join('accounts AS A', 'mem_balances.account', '=', 'A.idaccount')
                ->join('acc_types AS At', 'A.acctype', '=', 'At.idacctype')
                ->where(['member' => $member, 'At.accabbr' => $acctype])->orderBy('A.accnumb')->get();
        }
        return self::query()->select('mem_balances.*', 'A.idplan', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'At.labelfr AS atlabelfr', 'At.labeleng AS atlabeleng', 'At.accabbr')
            ->join('accounts AS A', 'mem_balances.account', '=', 'A.idaccount')
            ->join('acc_types AS At', 'A.acctype', '=', 'At.idacctype')
            ->where('member', $member)->orderBy('A.accnumb')->get();
    }

    /**
     * @param int $member
     * @param string $acctype
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMemCashOutBals(int $member, string $acctype = null)
    {
        $members = self::query()->select('mem_balances.*', 'A.idplan', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'At.labelfr AS atlabelfr', 'At.labeleng AS atlabeleng', 'At.accabbr')
            ->join('accounts AS A', 'mem_balances.account', '=', 'A.idaccount')
            ->join('acc_types AS At', 'A.acctype', '=', 'At.idacctype')
            ->where('member', $member)->orderBy('A.accnumb')->get();

        if ($acctype !== null) {
            $members = self::query()->select('mem_balances.*', 'A.idplan', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'At.labelfr AS atlabelfr', 'At.labeleng AS atlabeleng', 'At.accabbr')
                ->join('accounts AS A', 'mem_balances.account', '=', 'A.idaccount')
                ->join('acc_types AS At', 'A.acctype', '=', 'At.idacctype')
                ->where(['member' => $member, 'At.accabbr' => $acctype])->orderBy('A.accnumb')->get();
        }
        
        $comakers = Comaker::getComakers(['member' => $member]);
        $demComakers = DemComaker::getDemComakers(['member' => $member]);

        $block_amt = 0;
        $block_acc = 0;
        
        foreach ($comakers as $comaker) {
            $block_amt += (int)$comaker->guaramt - (int)$comaker->paidguar;
            $block_acc = (int)$comaker->account;
        }

        foreach ($demComakers as $demComaker) {
            $block_amt += (int)$demComaker->guaramt - (int)$demComaker->paidguar;
            $block_acc = (int)$demComaker->account;
        }

        $membals = [];
        foreach ($members as $member) {
            $member->block_amt = 0;
            $member->block_acc = 0;

            if ($member->account === $block_amt) {
                $member->block_amt = $block_amt;
                $member->block_acc = $block_acc;
            }

            if ($member->accabbr === 'Or' || $member->accabbr === 'Co' && ($member->availabel + $member->block_amt) > 0) {
                $membals[] = $member;
            }
        }

        return $membals;
    }

    /**
     * @param int $member
     * @param int $account
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getMemAcc(int $member, int $account)
    {
        return self::query()->select('mem_balances.*', 'A.idplan', 'A.accnumb', 'A.labelfr AS acclabelfr', 'A.labeleng AS acclabeleng', 'At.labelfr AS atlabelfr', 'At.labeleng AS atlabeleng', 'At.accabbr')
            ->join('accounts AS A', 'mem_balances.account', '=', 'A.idaccount')
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
}
