<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Region extends Model
{
    private $idregi;

    private $labelfr;

    private $labeleng;

    private $country;

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
        DB::table('regions')->insert($data);
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
            return DB::table('regions')->where($where)->get();
        }
        return DB::table('regions')->get();
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    private static function updateData(int $id, array $data): bool
    {
        DB::table('regions')->where('idregi', $id)->update($data);
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    private static function deleteData(int $id): bool
    {
        DB::table('regions')->where('idregi', $id)->delete();
        return true;
    }
}
