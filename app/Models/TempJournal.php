<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class TempJournal extends Model
{
    private $idtempj;

    private $writnumb;

    private $account;

    private $aux;

    private $operation;

    private $debitamt;

    private $creditamt;

    private $accdate;

    private $employee;

    private $institution;

    private $branch;

    private $represent;

    private $updated_at;

    private $created_at;


    /**
     * @param array $data
     * @return bool
     */
    private static function insertData(array $data): bool
    {
        DB::table('writings')->insert($data);
        return true;
    }

    /**
     * @param array $where
     * @return \Illuminate\Support\Collection
     */
    private static function getData(array $where = []): \Illuminate\Support\Collection
    {
        if (!empty($where)) {
            return DB::table('writings')->where($where)->get();
        }
        return DB::table('writings')->get();
    }

    /**
     * @param array $where
     * @return int
     */
    private static function getCount(array $where = []): int
    {
        if (!empty($where)) {
            return self::getData($where)->count();
        }
        return self::getData()->count();
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    private static function updateData(int $id, array $data): bool
    {
        DB::table('writings')->where('idreg', $id)->update($data);
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    private static function deleteData(int $id): bool
    {
        DB::table('writings')->where('idreg', $id)->delete();
        return true;
    }

}
