<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Backup extends Model
{
    protected $table = 'backups';

    protected $primaryKey = 'idbackup';

    protected $fillable = ['backups'];

    /**
     * @param int $idbackup
     * @return Builder|Model|object|null
     */
    public static function getBackup(int $idbackup)
    {
        return self::query()->where('idbackup', $idbackup)->first();
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getBackups(array $where = [])
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where(static function ($query) use ($emp) {
                if ($emp->level === 'B') {
                    $query->where('backups.branch', $emp->branch);
                }
                if ($emp->level === 'I') {
                    $query->where('backups.institution', $emp->institution);
                }
                if ($emp->level === 'Z') {
                    $query->where('backups.zone ', $emp->zone);
                }
                if ($emp->level === 'N') {
                    $query->where('backups.network ', $emp->network);
                }
            })->where($where)->orderBy('created_at')->get();
        }

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('backups.branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('backups.institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('backups.zone ', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('backups.network ', $emp->network);
            }
        })->orderBy('created_at')->get();
    }

}
