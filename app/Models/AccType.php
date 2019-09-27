<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AccType extends Model
{
    private $idacctype;

    private $accabbr;

    private $labelfr;

    private $labeleng;

    private $updated_at;

    private $created_at;

    /**
     * @param array $where
     * @return Collection
     */
    private static function getData(array $where = []): Collection
    {
        if (!empty($where)) {
            return DB::table('acc_types')->where($where)->get();
        }
        return DB::table('acc_types')->get();
    }

    /**
     * @param array $data
     * @return bool
     */
    private static function insertData(array $data): bool
    {
        DB::table('acc_types')->insert($data);
        return true;
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    private static function updateData(int $id, array $data): bool
    {
        DB::table('acc_types')->where('idacctype', $id)->update($data);
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    private static function deleteData(int $id): bool
    {
        DB::table('acc_types')->where('idacctype', $id)->delete();
        return true;
    }
}
