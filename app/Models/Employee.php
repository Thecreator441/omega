<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Employee extends Model
{
    protected $table = 'employees';

    protected $primaryKey = 'idemp';

    protected $fillable = ['employees'];

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getEmployee(int $id)
    {
        return self::query()->where('idemp', $id)->first();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getEmpUsers(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->select('employees.*', 'U.*')
                ->join('users AS U', 'employees.idemp', '=', 'U.employee')
                ->where($where)->where('employees.branch', $emp->branch)->orderBy('empmat')->get();
        }

        return self::query()->select('employees.*', 'U.*')
            ->join('users AS U', 'employees.idemp', '=', 'U.employee')
            ->where('employees.branch', $emp->branch)
            ->orderBy('empmat')->get();
    }

    /**
     * @param array|null $where
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getEmployees(array $where = null)
    {
        $emp = Session::get('employee');

        if ($where !== null) {
            return self::query()->where($where)
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('zone ', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('network ', $emp->network);
                    }
                })->orderBy('empmat')->get();
        }

        return self::query()->where(static function ($query) use ($emp) {
            if ($emp->level === 'B') {
                $query->where('branch', $emp->branch);
            }
            if ($emp->level === 'I') {
                $query->where('institution', $emp->institution);
            }
            if ($emp->level === 'Z') {
                $query->where('zone ', $emp->zone);
            }
            if ($emp->level === 'N') {
                $query->where('network ', $emp->network);
            }
        })->orderBy('empmat')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getLast()
    {
        $emp = Session::get('employee');

        return self::query()->where('institution', $emp->institution)->orderByDesc('empmat')->first();
    }

    /**
     * @param int|null $inst
     * @param int|null $branch
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|null
     */
    public static function getFilterEmployees(int $inst = null, int $branch = null)
    {
        $emp = Session::get('employee');

        $employees = null;

        if ($inst === null && $branch === null) {
            $employees = self::query()
                ->where(static function ($query) use ($emp) {
                    if ($emp->level === 'B') {
                        $query->where('branch', $emp->branch);
                    }
                    if ($emp->level === 'I') {
                        $query->where('institution', $emp->institution);
                    }
                    if ($emp->level === 'Z') {
                        $query->where('zone ', $emp->zone);
                    }
                    if ($emp->level === 'N') {
                        $query->where('network ', $emp->network);
                    }
                })->orderBy('empmat')->get();
        }
        if ($inst !== null && $branch === null) {
            $employees = self::query()->where('institution', $inst)->orderBy('empmat')->get();
        }
        if ($inst === null && $branch !== null) {
            $employees = self::query()->where('branch', $branch)->orderBy('empmat')->get();
        }
        if ($inst !== null && $branch !== null) {
            $employees = self::query()->where('branch', $branch)->orderBy('empmat')->get();
        }

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
