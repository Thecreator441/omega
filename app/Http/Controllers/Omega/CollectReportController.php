<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Collector;
use App\Models\Institution;
use App\Models\Network;
use App\Models\ValWriting;
use App\Models\Writing;
use App\Models\Zone;

class CollectReportController extends Controller
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

        $writings = $writings->sortKeysDesc();

        return view('omega.pages.collect_report', compact(
            'networks',
            'zones',
            'institutions',
            'branches',
            'collectors',
            'writings'
        ));
    }
}
