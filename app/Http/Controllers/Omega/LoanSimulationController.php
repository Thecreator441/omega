<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class LoanSimulationController extends Controller
{
    public function index()
    {
        if (dateOpen()) {
            $members = Member::getMembers(['members.memstatus' => 'A']);
            $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

            return view('omega.pages.loan_simulation', compact('members', 'menu'));
        }
        return Redirect::route('omega')->with('danger', trans('alertDanger.opdate'));
    }

    public function view()
    {
        // return Request::all();

        $tot_amort_amt = 0;
        $tot_int_amt = 0;
        $tot_ann_amt = 0;
        $tot_tax_amt = 0;
        $tot_tot_amt = 0;

        $amount = trimOver(Request::input('amount'), ' ');
        $inst_no = trimOver(Request::input('amount'), ' ');
        $int_rate = (float)Request::input('int_rate') / (float)100;
        $tax_rate = (float)Request::input('tax_rate') / (float)100;
        $period = Request::input('period');

        $simulations = [];

        for ($i = 1; $i < $inst_no + 1; $i++) {
            $amort_amt = 0;
            $capital = $amount;
            $date = new \DateTime(Request::input('inst1'));
            
            if (Request::input('amorti') === 'C') {
                $amort_amt = $amount / $inst_no;

                if ($i > 1) {
                    $new_capital = $amount - $amort_amt;
                    for ($j = 1; $j < $i - 1; $j++) {
                        $new_capital -= $amort_amt;
                    }
                    $capital = $new_capital;
                }
            }

            if (Request::input('amorti') === 'V') {
                $amort_amt = ($capital * $int_rate) / (pow((1 + $int_rate), $inst_no) - 1);

                if ($i > 1) {
                    $new_capital = $capital - $amort_amt;
                    $amo = ($new_capital * $int_rate) / (pow((1 + $int_rate), $inst_no - 1) - 1);

                    for ($j = 1; $j < $i - 1 ; $j++) {
                        $new_capital -= $amo;
                        $amo = ($new_capital * $int_rate) / (pow((1 + $int_rate), ($inst_no - ($j + 1))) - 1);
                    }

                    $capital = $new_capital;
                    $amort_amt = $amo;
                }
            }

            if ($i === 1) {
                $date = $date;
            } else {
                if ($period === 'D') {
                    $interval = $i - 1;
                    $date = $date->add(new \DateInterval("P{$interval}D"));
                } else if ($period === 'W') {
                    $interval = 7 * ($i - 1);
                    $date = $date->add(new \DateInterval("P{$interval}D"));
                    $date = date.addDays(7 * ($i - 1));
                } else if ($period === 'B') {
                    $interval = 15 * ($i - 1);
                    $date = $date->add(new \DateInterval("P{$interval}D"));
                } else if ($period === 'M') {
                    $interval = ($i - 1);
                    $date = $date->add(new \DateInterval("P{$interval}M"));
                } else if ($period === 'T') {
                    $interval = 3 * ($i - 1);
                    $date = $date->add(new \DateInterval("P{$interval}M"));
                } else if ($period === 'S') {
                    $interval = 6 * ($i - 1);
                    $date = $date->add(new \DateInterval("P{$interval}M"));
                } else {
                    $interval = 12 * ($i - 1);
                    $date = $date->add(new \DateInterval("P{$interval}M"));
                }
            }

            $int_amt = $capital * $int_rate;
            $ann_amt = $amort_amt + $int_amt;
            $tax_amt = $int_amt * $tax_rate;
            $tot_amt = $ann_amt + $tax_amt;

            $date = $date->format('d/m/Y');

            $tot_amort_amt += $amort_amt;
            $tot_int_amt += $int_amt;
            $tot_ann_amt += $ann_amt;
            $tot_tax_amt += $tax_amt;
            $tot_tot_amt += $tot_amt;

            $simulations['intallment'] = $i;
            $simulations['capital'] = $capital;
            $simulations['amort_amt'] = $amort_amt;
            $simulations['int_amt'] = $int_amt;
            $simulations['ann_amt'] = $ann_amt;
            $simulations['tax_amt'] = $tax_amt;
            $simulations['tot_amt'] = $tot_amt;
            $simulations['date'] = $date;

            $simulations['capital'] = 0;
            $simulations['amort_amt'] = 0;
            $simulations['int_amt'] = 0;
            $simulations['ann_amt'] = 0;
            $simulations['tax_amt'] = 0;
        }

        return ['data' => $simulations];
    }

    public function print()
    {
        return Request::all();
    }
}
