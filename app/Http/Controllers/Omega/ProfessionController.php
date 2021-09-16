<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Profession;
use App\Models\Priv_Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class ProfessionController extends Controller
{
    public function index()
    {
        $professions = Profession::getProfessions();
        $menu = Priv_Menu::getMenu(Request::input("level"), Request::input("menu"));

        return view('omega.pages.profession', compact('menu', 'professions'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $idprofession = Request::input('idcountry');
            $profession = null;

            if ($idprofession === null) {
                $profession = new Profession();
            } else {
                $profession = Profession::getProfession($idprofession);
            }

            $profession->labelfr = Request::input('labelfr');
            $profession->labeleng = Request::input('labeleng');

            if ($idprofession === null) {
                $profession->save();
            } else {
                $profession->update((array)$profession);
            }

            DB::commit();
            if ($idprofession === null) {
                return Redirect::back()->with('success', trans('alertSuccess.profsave'));
            }
            return Redirect::back()->with('success', trans('alertSuccess.profedit'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            if ($idprofession === null) {
                return Redirect::back()->with('danger', trans('alertDanger.profsave'));
            }
            return Redirect::back()->with('danger', trans('alertDanger.profedit'));
        }
    }

    public function delete(): \Illuminate\Http\RedirectResponse
    {
        $idprofession = Request::input('country');

        DB::beginTransaction();
        try {
            Profession::getProfession($idprofession)->delete();

            DB::commit();
            return Redirect::back()->with('success', trans('alertSuccess.profdel'));
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return Redirect::back()->with('danger', trans('alertDanger.profdel'));
        }
    }
}
