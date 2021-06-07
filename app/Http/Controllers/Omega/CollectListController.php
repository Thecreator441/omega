<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Cash;
use App\Models\Collect_Mem;
use App\Models\Collector;
use App\Models\Institution;
use App\Models\Network;
use App\Models\User;
use App\Models\Zone;

class CollectListController extends Controller
{
    public function index()
    {
        $networks = Network::getNetworks();
        $zones = Zone::getZones();
        $institutions = Institution::getInstitutions();
        $branches = Branch::getBranches();
        $collectors = Collector::getCollectors();

        foreach ($collectors as $collector) {
            $user = User::getUserBy(['collector' => $collector->idcoll]);
            $cash = Cash::getEmpCash($user->iduser);
            $customers = Collect_Mem::getCollectMems($collector->idcoll);

            if (!empty($user)) {
                foreach ($user->getAttributes() as $index => $item) {
                    $collector->$index = $item;
                }
            }
            if (!empty($cash)) {
                foreach ($cash->getAttributes() as $index => $item) {
                    $collector->$index = $item;
                }
            }
            $collector->customers = $customers->count();
        }

        return view('omega.pages.collect_list', compact(
            'networks',
            'zones',
            'institutions',
            'branches',
            'collectors'
        ));
    }
}
