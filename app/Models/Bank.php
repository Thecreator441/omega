<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Bank extends Model
{
    protected $table = 'banks';

    protected $primaryKey = 'idbank';

    protected $fillable = ['banks'];

    private $idbank;

    private $bankcode;

    private $name;

    private $ouracc;

    private $theiracc;

    private $phone1;

    private $phone2;

    private $email;

    private $country;

    private $region;

    private $town;

    private $address;

    private $postcode;

    private $institution;

    private $branch;

    private $member;

    private $updated_at;

    private $created_at;

    /**
     * @param array $where
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $emp = Session::get('employee');

        return self::query()->where('branch', $emp->branch)
            ->orderBy('idbank', 'ASC')
            ->paginate(1);
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getBank(int $id)
    {
        $emp = Session::get('employee');

        return self::query()->where(['idbank' => $id, 'branch' => $emp->branch])->first();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getBanks(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where($where)->where('branch', $emp->branch)->orderBy('bankcode')->get();
        }
        return self::query()->where('branch', $emp->branch)->orderBy('bankcode')->get();
    }
}
