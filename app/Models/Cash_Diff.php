<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Cash_Diff extends Model
{
    protected $table = 'cash_diffs';

    protected $primaryKey = 'id_cash_diff';

    protected $fillable = ['cash_diffs'];

    /**
     * @param int $id
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getCashDiff(int $id, string $status = 'N')
    {
        return self::query()->where(['id_cash_diff' => $id, 'diff_status' => $status])->first();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCashDiffs(array $where = [])
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where($where)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('institution ', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('zone ', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('branch ', $emp->branch);
                    }
                })->orderBy('created_at')->get();
        }

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('institution ', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('zone ', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('branch ', $emp->branch);
            }
        })->orderBy('created_at')->get();
    }
}
