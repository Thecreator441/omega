<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Branch extends Model
{
    private $idbranch;

    private $name;

    private $phone1;

    private $phone2;

    private $email;

    private $region;

    private $town;

    private $address;

    private $postcode;

    private $institution;

    private $updated_at;

    private $created_at;

    /**
     * @param array $where
     * @return \Illuminate\Support\Collection
     */
    private static function getData(array $where = []): \Illuminate\Support\Collection
    {
        if (!empty($where)) {
            return DB::table('branches')->where($where)->get();
        }
        return DB::table('branches')->get();
//        "SELECT B.idbillet, B.value, B.labaeleng, B.labelfr, B.format, C.label, C.format FROM billetings B, currencies C WHERE B.idcurrency = C.idcurrency"
    }

    /**
     * @param array $data
     * @return bool
     */
    private static function insertData(array $data): bool
    {
        DB::table('branches')->insert($data);
        return true;
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    private static function updateData(int $id, array $data): bool
    {
        DB::table('branches')->where('idbranch', $id)->update($data);
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    private static function deleteData(int $id): bool
    {
        DB::table('branches')->where('idbranch', $id)->delete();
        return true;
    }
}
