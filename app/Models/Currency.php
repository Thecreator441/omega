<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Currency extends Model
{

    private $idcurrency;

    private $label;

    private $format;

    private $updated_at;

    private $created_at;

    /**
     * @param array $where
     * @return \Illuminate\Support\Collection
     */
    private static function getData(array $where = []): \Illuminate\Support\Collection
    {
        if (!empty($where)) {
            return DB::table('currencies')->where($where)->get();
        }
        return DB::table('currencies')->get();
    }

    /**
     * @param array $data
     * @return bool
     */
    private static function insertData(array $data): bool
    {
        DB::table('currencies')->insert($data);
        return true;
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    private static function updateData(int $id, array $data): bool
    {
        DB::table('currencies')->where('idcurrency', $id)->update($data);
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    private static function deleteData(int $id): bool
    {
        DB::table('currencies')->where('idcurrency', $id)->delete();
        return true;
    }
}
