<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class AccDate extends Model
{
    protected $table = 'acc_dates';

    protected $primaryKey = 'idaccdate';

    protected $fillable = ['acc_dates'];

    /**
     * @param int $idaccdate
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getAccDate(int $idaccdate)
    {
        return self::query()->where('idaccdate', $idaccdate)->first();
    }

    /**
     * @param int|null $branch
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getOpenAccDate(int $branch = null)
    {
        /*
		$emp = Session::get('employee');

        if ($branch === null) {
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
*/
        return self::query()->where([
            'status' => 'O',
            'branch' => $branch
        ])->first();
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
