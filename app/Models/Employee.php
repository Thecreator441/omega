<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Employee extends Model
{
    protected $table = 'employees';

    protected $primaryKey = 'idemp';

    private $idemp;

    private $empmat;

    private $name;

    private $surname;

    private $gender;

    private $dob;

    private $pob;

    private $phone1;

    private $phone2;

    private $email;

    private $status;

    private $nic;

    private $issuedate;

    private $issueplace;

    private $cnpsnumb;

    private $pic;

    private $signature;

    private $country;

    private $regorigin;

    private $region;

    private $town;

    private $division;

    private $subdivision;

    private $address;

    private $street;

    private $quarter;

    private $post;

    private $password;

    private $empdate;

    private $network;

    private $institution;

    private $branch;

    private $privilege;

    private $created_at;

    private $updated_at;

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getEmployee(int $id)
    {
        return self::query()->where('idemp', $id)
            ->join('privileges AS P', 'employees.privilege', '=', 'P.idpriv')->first();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getEmployees(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where === null) {
            return self::query()->where('branch', $emp->branch)
                ->orderBy('empmat')->get();
        }
        return self::query()->where($where)
            ->join('privileges AS P', 'employees.privilege', '=', 'P.idpriv')
            ->distinct('idemp')->orderBy('empmat')->get();
    }

    /**
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getUser(string $name)
    {
        return self::query()->where('name', $name)
            ->join('privileges AS P', 'employees.privilege', '=', 'P.idpriv')->first();
    }

}
