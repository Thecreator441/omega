<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AccDate extends Model
{
    protected $table = 'acc_dates';

    protected $primaryKey = 'idaccdate';

    private $idaccdate;

    private $presentdate;

    private $evedate;

    private $accdate;

    private $monthnd;

    private $weekend;

    private $status;

    private $institution;

    private $branch;

    private $created_at;

    private $updated_at;

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getOpenAccDate()
    {
        $emp = Session::get('employee');

        return self::query()->where('status', 'O')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('acc_dates.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('acc_dates.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('acc_dates.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('acc_dates.network', $emp->network);
                }
            })->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCloseAccDate()
    {
        $emp = Session::get('employee');

        return self::query()->where('status', 'C')
            ->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('acc_dates.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('acc_dates.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('acc_dates.zone', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('acc_dates.network', $emp->network);
                }
            })->first();
    }

}
