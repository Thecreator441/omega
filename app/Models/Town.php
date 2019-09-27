<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Town extends Model
{
    private $idtown;

    private $label;

    private $region;

    private $updated_at;

    private $created_at;

    /**
     * @param array $data
     * @return bool
     */
    private static function insertData(array $data): bool
    {
        DB::table('towns')->insert($data);
        return true;
    }

    /**
     * @param array $where
     * @return Collection
     */
    private static function getData(array $where = []): Collection
    {
        if (!empty($where)) {
            return DB::table('towns')->where($where)->get();
        }
        return DB::table('towns')->get();
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    private static function updateData(int $id, array $data): bool
    {
        DB::table('towns')->where('idtown', $id)->update($data);
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    private static function deleteData(int $id): bool
    {
        DB::table('towns')->where('idtown', $id)->delete();
        return true;
    }
}
