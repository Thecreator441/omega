<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SMS extends Model
{
    protected $table = 'sms';

    protected $primaryKey = 'idsms';

    protected $fillable = ['sms'];

    /**
     * @param int $idsms
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getSMS(int $idsms)
    {
        return self::query()->where('idsms', $idsms)->first();
    }

    /**
     * @param array $where
     * @return Branch[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getSMSs(array $where = [])
    {
        if ($where !== null) {
         return self::query()->where($where)->orderBy('created_at')->get();
        }
        return self::query()->orderBy('created_at')->get();
    }
    
    public static function getNoSMS(array $where = null, string $date1 = null, string $date2 = null)
    {
        if($where === null) {
            return self::query()->where('status', 'S')
            ->where(static function ($query) use ($date1, $date2) {
                if ($date1 !== null && $date2 === null) {
                    $query->whereRaw("DATE(sms.created_at) >= '{$date1}'");
                }
                if ($date1 === null && $date2 !== null) {
                    $query->whereRaw("DATE(sms.created_at) <= '{$date2}'");
                }
                if ($date1 !== null && $date2 !== null) {
                    $query->whereRaw("DATE(sms.created_at) BETWEEN '{$date1}' AND '{$date2}'");
                }
            })->orderBy('created_at')->get();
        } else {
            return self::query()->where($where)->where('status', 'S')
            ->where(static function ($query) use ($date1, $date2) {
                if ($date1 !== null && $date2 === null) {
                    $query->whereRaw("DATE(sms.created_at) >= '{$date1}'");
                }
                if ($date1 === null && $date2 !== null) {
                    $query->whereRaw("DATE(sms.created_at) <= '{$date2}'");
                }
                if ($date1 !== null && $date2 !== null) {
                    $query->whereRaw("DATE(sms.created_at) BETWEEN '{$date1}' AND '{$date2}'");
                }
            })->orderBy('created_at')->get();
        }
    }

}
