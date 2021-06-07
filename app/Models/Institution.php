<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $table = 'institutions';

    protected $primaryKey = 'idinst';

    protected $fillable = ['institutions'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getInstitution(int $id)
    {
        return self::query()->where('idinst', $id)->first();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getInstitutions(array $where = null)
    {
        if ($where !== null) {
            return self::query()->where($where)->orderBy('name')->get();
        }
        return self::query()->orderBy('name')->get();
    }

    /**
     * @param int $institution
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getParams(int $institution)
    {
        return self::query()->select('institutions.strategy', 'N.category')
            ->join('zones AS Z', 'institutions.zone', '=', 'Z.idzone')
            ->join('networks AS N', 'Z.network', '=', 'N.idnetwork')
            ->where('idinst', $institution)
            ->distinct('idinst')->first();

    }

    /**
     * @return Builder|Model|object|null
     */
    public static function getLast()
    {
        return self::query()->orderByDesc('idinst')->first();
    }
}
