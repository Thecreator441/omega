<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Division extends Model
{
    private $iddiv;

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
//        $country = self::getData(['isocode' => $data['isocode']]);
//        if ($country === null) {
        DB::table('divisions')->insert($data);
        return true;
//        }
//        return false;
    }

    /**
     * @param array $where
     * @return \Illuminate\Support\Collection
     */
    private static function getData(array $where = []): \Illuminate\Support\Collection
    {
        if (!empty($where)) {
            return DB::table('divisions')->where($where)->get();
        }
        return DB::table('divisions')->get();
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    private static function updateData(int $id, array $data): bool
    {
        DB::table('divisions')->where('iddiv', $id)->update($data);
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    private static function deleteData(int $id): bool
    {
        DB::table('divisions')->where('iddiv', $id)->delete();
        return true;
    }
}
