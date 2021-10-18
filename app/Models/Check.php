<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Check extends Model
{
    protected $table = 'checks';

    protected $primaryKey = 'idcheck';

    protected $fillable = ['checks'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCheckOnly(int $id)
    {

        return self::query()->select('checks.*', 'B.bankcode', 'B.labelfr AS b_labelfr', 'B.labeleng AS b_labeleng', 'O.labelfr AS o_labelfr', 'O.labeleng AS o_labeleng')
        ->join('banks AS B', 'checks.bank', '=', 'B.idbank')
        ->join('operations AS O', 'checks.operation', '=', 'O.idoper')
        ->where('idcheck', $id)->first();

    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCheck(int $id)
    {
        $emp = Session::get('employee');
        $operations = Operation::getOperations();

        $check = self::query()->select('checks.*', 'B.bankcode', 'B.labelfr AS b_labelfr', 'B.labeleng AS b_labeleng', 'O.labelfr AS o_labelfr', 'O.labeleng AS o_labeleng')
        ->join('banks AS B', 'checks.bank', '=', 'B.idbank')
        ->join('operations AS O', 'checks.operation', '=', 'O.idoper')
        ->where('idcheck', $id)->first();

        if ($check !== null) {
            $check_accs_amts = CheckAccAmt::getCheckAccAmts(['check_acc_amts.checkno' => $check->idcheck]);
            
            if ((int)$check_accs_amts->count() > 0) {
                $check_accs = [];

                foreach ($check_accs_amts as $check_acc_amt) {
                    $check_acc_amt->acc = $check_acc_amt->a_labeleng;
                    if ($emp->lang === 'fr') {
                        $check_acc_amt->acc = $check_acc_amt->a_labelfr;
                    }

                    if(is_numeric($check_acc_amt->operation)) {
                        foreach ($operations as $operation) {
                            if ($operation->idoper === $check_acc_amt->operation) {
                                $check_acc_amt->operation = $operation->labeleng;
                                if ($emp->lang === 'fr') {
                                    $check_acc_amt->operation = $operation->labelfr;
                                }
                            }
                        }
                    }

                    $check_accs[] = $check_acc_amt;
                }

                $check->check_acc_amts = $check_accs;
            }
        }

        return $check;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getChecks(array $where = null)
    {
        $emp = Session::get('employee');
        $operations = Operation::getOperations();
        
        if ($where === null) {
            $checks = self::query()->select('checks.*', 'B.bankcode', 'B.labelfr AS b_labelfr', 'B.labeleng AS b_labeleng', 'O.labelfr AS o_labelfr', 'O.labeleng AS o_labeleng')
            ->join('banks AS B', 'checks.bank', '=', 'B.idbank')
            ->join('operations AS O', 'checks.operation', '=', 'O.idoper')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'N') {
                    $query->where('checks.network', $emp->network);
                }
                if ($emp->level === 'Z') {
                    $query->where('checks.zone', $emp->zone);
                }
                if ($emp->level === 'I') {
                    $query->where('checks.institution', $emp->institution);
                }
                if ($emp->level === 'B') {
                    $query->where('checks.branch', $emp->branch);
                }
            })->orderBy('checknumb')->get();
        }

        $checks = self::query()->select('checks.*', 'B.bankcode', 'B.labelfr AS b_labelfr', 'B.labeleng AS b_labeleng', 'O.labelfr AS o_labelfr', 'O.labeleng AS o_labeleng')
        ->join('banks AS B', 'checks.bank', '=', 'B.idbank')
        ->join('operations AS O', 'checks.operation', '=', 'O.idoper')
        ->where(static function ($query) use ($emp) {
            if ($emp->level === 'N') {
                $query->where('checks.network', $emp->network);
            }
            if ($emp->level === 'Z') {
                $query->where('checks.zone', $emp->zone);
            }
            if ($emp->level === 'I') {
                $query->where('checks.institution', $emp->institution);
            }
            if ($emp->level === 'B') {
                $query->where('checks.branch', $emp->branch);
            }
        })->where($where)->orderBy('checknumb')->get();

        if ((int)$checks->count() > 0) {
            foreach ($checks as $check) {
                $check_accs_amts = CheckAccAmt::getCheckAccAmts(['check_acc_amts.checkno' => $check->idcheck]);

                if ((int)$check_accs_amts->count() > 0) {
                    $check_accs = [];
                
                    foreach ($check_accs_amts as $check_acc_amt) {
                        $check_acc_amt->acc = $check_acc_amt->a_labeleng;
                        if ($emp->lang === 'fr') {
                            $check_acc_amt->acc = $check_acc_amt->a_labelfr;
                        }

                        if(is_numeric($check_acc_amt->operation)) {
                            foreach ($operations as $operation) {
                                if ($operation->idoper === $check_acc_amt->operation) {
                                    $check_acc_amt->operation = $operation->labeleng;
                                    if ($emp->lang === 'fr') {
                                        $check_acc_amt->operation = $operation->labelfr;
                                    }
                                }
                            }
                        }

                        $check_accs[] = $check_acc_amt;
                    }

                    $check->check_acc_amts = $check_accs;
                }
            }
        }

        return $checks;
    }

    /**
     * @param string $user
     * @param string $status
     * @param string|null $member
     * @param string|null $bank
     * @param string|null $from
     * @param string|null $to
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getFilterChecks(string $user, string $status, int $member = null, int $bank = null, string $from = null, string $to = null)
    {
        $emp = User::getUserInfos((int)$user);
        $members = Member::getMembers(['members.memstatus' => 'A']);
        $operations = Operation::getOperations();

        $checks = self::query()->select('checks.*', 'B.bankcode', 'B.labelfr AS b_labelfr', 'B.labeleng AS b_labeleng', 'O.labelfr AS o_labelfr', 'O.labeleng AS o_labeleng')
        ->join('banks AS B', 'checks.bank', '=', 'B.idbank')
        ->join('operations AS O', 'checks.operation', '=', 'O.idoper')
        ->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('checks.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('checks.institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('checks.zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('checks.network', $emp->network);
            }
        })->where(static function ($query) use ($member) {
            if((int)$member > 0) {
                $query->where('checks.member', $member);
            }
        })->where(static function ($query) use ($bank) {
            if((int)$bank > 0) {
                $query->where('checks.bank', $bank);
            }
        })->where(static function ($query) use ($from, $to) {
            $from = dbDate($from);
            $to = dbDate($to);

            if ($from !== null && $to === null) {
                $query->whereRaw("DATE(checks.created_at) >= '{$from}'");
            }
            if ($from === null && $to !== null) {
                $query->whereRaw("DATE(checks.created_at) <= '{$to}'");
            }
            if ($from !== null && $to !== null) {
                $query->whereRaw("DATE(checks.created_at) BETWEEN '{$from}' AND '{$to}'");
            }
        })->where(static function ($query) use ($status) {
            if($status === 'D' || $status === 'P' || $status === 'U') {
                $query->where('checks.status', $status);
            }
        })->get();

        $totalAmt = 0;
        if ((int)$checks->count() > 0) {
            foreach ($checks as $check) {
                $bank = $check->b_labeleng;
                $check->opera = $check->o_labeleng;
                if ($emp->lang === 'fr') {
                    $bank = $check->b_labelfr;
                    $check->opera = $check->o_labelfr;
                }
                $check->bank = pad($check->bankcode, 3) . ' : ' . $bank;

                if($check->member !== null) {
                    foreach ($members as $member) {
                        if ($member->idmember == $check->member) {
                            $check->carrier = pad($member->memnumb, 6) . ' : ' . $member->name . ' ' . $member->surname;
                        }
                    }
                }

                if ($check->status === 'D') {
                    $check->state = 'Dropped';
                } else if ($check->status === 'P') {
                    $check->state = 'Paid';
                } else if ($check->status === 'U') {
                    $check->state = 'Unpaid';
                }

                if ($emp->lang === 'fr') {
                    if ($check->status === 'D') {
                        $check->state = 'Déposés';
                    } else if ($check->status === 'P') {
                        $check->state = 'Payés';
                    } else if ($check->status === 'U') {
                        $check->state = 'Impayés';
                    }
                }
                $check->amt = money((int)$check->amount);
                $check->date = changeFormat($check->created_at);

                $check_accs_amts = CheckAccAmt::getCheckAccAmts(['check_acc_amts.checkno' => $check->idcheck]);

                if ((int)$check_accs_amts->count() > 0) {
                    $check_accs = [];
                
                    foreach ($check_accs_amts as $check_acc_amt) {
                        $check_acc_amt->acc = $check_acc_amt->a_labeleng;
                        if ($emp->lang === 'fr') {
                            $check_acc_amt->acc = $check_acc_amt->a_labelfr;
                        }

                        if(is_numeric($check_acc_amt->operation)) {
                            foreach ($operations as $operation) {
                                if ($operation->idoper === $check_acc_amt->operation) {
                                    $check_acc_amt->operation = $operation->labeleng;
                                    if ($emp->lang === 'fr') {
                                        $check_acc_amt->operation = $operation->labelfr;
                                    }
                                }
                            }
                        }

                        $check_accs[] = $check_acc_amt;
                    }

                    $check->check_acc_amts = $check_accs;
                }

                $totalAmt += $check->amount;
            }
        }

        return [
            'data' => $checks,
            'total' => $totalAmt
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getDroppedChecks()
    {
        $emp = Session::get('employee');

        return self::query()->select('checks.*', 'B.bankcode', 'B.labelfr AS b_labelfr', 'B.labeleng AS b_labeleng', 
        'O.opercode', 'O.labelfr AS o_labelfr', 'O.labeleng AS o_labeleng')
        ->join('banks AS B', 'checks.bank', '=', 'B.idbank')
        ->join('operations AS O', 'checks.operation', '=', 'O.idoper')
        ->where('status', 'D')
        ->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('checks.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('checks.institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('checks.zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('checks.network', $emp->network);
            }
        })->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getNotSortChecks()
    {
        $emp = Session::get('employee');

        return self::query()->select('checks.*', 'B.bankcode', 'B.labelfr AS b_labelfr', 'B.labeleng AS b_labeleng', 
        'O.opercode', 'O.labelfr AS o_labelfr', 'O.labeleng AS o_labeleng')
        ->join('banks AS B', 'checks.bank', '=', 'B.idbank')
        ->join('operations AS O', 'checks.operation', '=', 'O.idoper')
        ->where(['status' => 'P', 'type' => 'I', 'sorted' => 'N'])
        ->where('checks.member', '!=', null)
        ->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('checks.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('checks.institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('checks.zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('checks.network', $emp->network);
            }
        })->orderBy('checknumb')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getOtherNotSortChecks()
    {
        $emp = Session::get('employee');

        return self::query()->select('checks.*', 'B.bankcode', 'B.labelfr AS b_labelfr', 'B.labeleng AS b_labeleng', 
        'O.opercode', 'O.labelfr AS o_labelfr', 'O.labeleng AS o_labeleng')
        ->join('banks AS B', 'checks.bank', '=', 'B.idbank')
        ->join('operations AS O', 'checks.operation', '=', 'O.idoper')
        ->where(['checks.status' => 'P', 'checks.type' => 'I', 'checks.sorted' => 'N', 'checks.member' => null])
        ->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('checks.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('checks.institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('checks.zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('checks.network', $emp->network);
            }
        })->orderBy('checknumb')->get();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getToSortChecks(int $id)
    {
        $emp = Session::get('employee');

        return self::query()->where('idcheck', $id)
        ->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('checks.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('checks.institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('checks.zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('checks.network', $emp->network);
            }
        })->join('members AS M', 'checks.member', '=', 'M.idmember')
        ->join('banks AS B', 'checks.bank', '=', 'B.idbank')
        ->select('checks.*', 'M.memnumb', 'M.name', 'M.surname', 'B.ouracc', 'B.name AS bname')
        ->orderBy('checknumb')->first();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getOtherToSortChecks(int $id)
    {
        $emp = Session::get('employee');

        return self::query()->where('idcheck', $id)
        ->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('checks.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('checks.institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('checks.zone', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('checks.network', $emp->network);
            }
        })->join('banks AS B', 'checks.bank', '=', 'B.idbank')
        ->select('checks.*', 'B.ouracc', 'B.name AS bname')
        ->orderBy('checknumb')->first();
    }
}
