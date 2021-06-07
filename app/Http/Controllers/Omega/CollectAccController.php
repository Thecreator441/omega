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
use App\Models\ValWriting;
use App\Models\Writing;
use App\Models\Zone;

class CollectAccController extends Controller
{
    public function index()
    {
        $networks = Network::getNetworks();
        $zones = Zone::getZones();
        $institutions = Institution::getInstitutions();
        $branches = Branch::getBranches();
        $collectors = Collector::getCollectorsCash();
        $writings = Writing::getReports();
        $val_writings = ValWriting::getReports();

        foreach ($val_writings as $val_writing) {
            $writings->add($val_writing);
        }

//        $finalWrit = $writings->sortBy('writnumb');
//        $test = Writing::getFilterCollects(null, null, null, null, '2020-02-20', null);
//
//        dd($test);

        return view('omega.pages.collect_acc', compact(
            'networks',
            'zones',
            'institutions',
            'branches',
            'collectors',
            'writings'
        ));
    }
}
