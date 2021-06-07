<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Platform extends Model
{
    protected $table = 'platforms';

    protected $primaryKey = 'idplat';

    protected $fillable = ['platforms'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getPlatform(int $id)
    {
        return self::query()->where('idplat', $id)->first();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getPlatUsers(array $where = null)
    {
        if ($where !== null) {
            return self::query()->select('platforms.*', 'U.*')
                ->join('users AS U', 'platforms.idplat', '=', 'U.platform')
                ->where($where)->orderBy('platmat')->get();
        }

        return self::query()->select('platforms.*', 'U.*')
            ->join('users AS U', 'platforms.idplat', '=', 'U.platform')
            ->orderBy('platmat')->get();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getPlatforms(array $where = null)
    {
        if ($where !== null) {
            return self::query()->where($where)->orderBy('platmat')->get();
        }
        return self::query()->orderBy('platmat')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast(array $where = [])
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where($where)->orderByDesc('platmat')->first();
        }

        return self::query()->orderByDesc('platmat')->first();
    }

    /**
     * @param int|null $inst
     * @param int|null $branch
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|null
     */
    public static function getFilterPlatforms()
    {
        $employees = self::query()->orderBy('platmat')->get();

//        foreach ($employees as $employee) {
//            $user = User::getUserBy(['employee' => $employee->idemp]);
//            $priv = Privilege::getPrivilege($user->privilege);
//            foreach ($user->getAttributes() as $index => $item) {
//                $employee->$index = $item;
//            }
//            foreach ($priv->getAttributes() as $index => $item) {
//                $employee->$index = $item;
//            }
//        }

        return $employees;

    }
}
