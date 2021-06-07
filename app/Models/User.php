<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'iduser';

    protected $fillable = ['users'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getUser(int $id)
    {
        return self::query()->where('iduser', $id)->first();
    }

    public static function getUserInfos(int $iduser)
    {
        $user = self::getUser($iduser);
        $priv = Privilege::getPrivilege($user->privilege);

        foreach ($priv->getAttributes() as $index => $value) {
            if ($user->created_at !== $user->$index || $user->upated_at !== $user->$index) {
                $user->$index = $value;
            }
        }

        $empl = null;

        if ($user->level !== 'P') {
            $empl = Employee::getEmployee($user->employee);
        } else {
            $empl = Platform::getPlatform($user->platform);
        }
        
        foreach ($empl->getAttributes() as $index => $value) {
            if ($user->created_at !== $user->$index || $user->upated_at !== $user->$index) {
                $user->$index = $value;
            }
        }

        return $user;
    }

    /**
     * @param null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getUsers($where = null)
    {
        if ($where !== null) {
            return self::query()->select('users.*', 'P.idpriv', 'P.code', 'P.labelfr', 'P.labeleng', 'P.level')
                ->join('privileges AS P', 'users.privilege', '=', 'P.idpriv')
                ->where(static function ($query) use ($where) {
                    if (is_array($where)) {
                        $query->where($where);
                    } else {
                        $query->whereRaw($where);
                    }
                })->orderBy('username')->get();
        }
        return self::query()->select('users.*', 'P.idpriv', 'P.code', 'P.labelfr', 'P.labeleng', 'P.level')
            ->join('privileges AS P', 'users.privilege', '=', 'P.idpriv')
            ->orderBy('username')->get();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCollectors(array $where = null)
    {
        if ($where !== null) {
            return self::query()->select('users.*', 'P.code', 'P.labelfr', 'P.labeleng', 'P.level')
                ->join('privileges AS P', 'users.privilege', '=', 'P.idpriv')
                ->where($where)->whereRaw('collector != NULL')->orderBy('username')->get();
        }
        return self::query()->select('users.*', 'P.code', 'P.labelfr', 'P.labeleng', 'P.level')
            ->join('privileges AS P', 'users.privilege', '=', 'P.idpriv')
            ->whereRaw('collector != NULL')->orderBy('username')->get();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getEmployees(array $where = null)
    {
        if ($where !== null) {
            return self::query()->select('users.*', 'P.code', 'P.labelfr', 'P.labeleng', 'P.level')
                ->join('privileges AS P', 'users.privilege', '=', 'P.idpriv')
                ->where($where)->whereRaw('employee != NULL')->orderBy('username')->get();
        }
        return self::query()->select('users.*', 'P.code', 'P.labelfr', 'P.labeleng', 'P.level')
            ->join('privileges AS P', 'users.privilege', '=', 'P.idpriv')
            ->whereRaw('employee != NULL')->orderBy('username')->get();
    }

    /**
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getUserByName(string $name)
    {
        return self::query()->where('username', $name)->first();
    }

    /**
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getUsersByName(string $name)
    {
        return self::query()->where('username', $name)->get();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getUserBy(array $where)
    {
        return self::query()->where($where)->first();
    }

}
