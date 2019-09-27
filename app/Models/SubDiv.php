<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubDiv extends Model
{
    private $idsub;

    private $label;

    private $division;

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
        DB::table('sub_divs')->insert($data);
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
            return DB::table('sub_divs')->where($where)->get();
        }
        return DB::table('sub_divs')->get();
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    private static function updateData(int $id, array $data): bool
    {
        DB::table('sub_divs')->where('idsub', $id)->update($data);
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    private static function deleteData(int $id): bool
    {
        DB::table('sub_divs')->where('idsub', $id)->delete();
        return true;
    }
}
