<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Benef extends Model
{
    protected $table = 'benefs';

    private $idregbene;

    private $fullname;

    private $nic;

    private $relation;

    private $member;

    private $ratio;

    private $created_at;

    private $updated_at;

}
