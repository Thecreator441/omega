<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Network extends Model
{
    private $idnetwork;

    private $name;

    private $phone1;

    private $phone2;

    private $email;

    private $country;

    private $region;

    private $town;

    private $address;

    private $postcode;

    private $updated_at;

    private $created_at;

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getNetwork()
    {
        $emp = Session::get('employee');
        $network = null;

        if ($emp->branch !== null || $emp->institution !== null) {
            $network = Zone::query()->where('idbranch', $emp->branch)
                ->orWhere('idinst', $emp->institution)
                ->join('institutions', 'idzone', '=', 'institutions.zone')
                ->join('branches', 'idinst', '=', 'branches.institution')
                ->select('network')->distinct()->first();
        }

        if ($emp->network !== null) {
            $network = $emp->network;
        }
        return $network;
    }
}
