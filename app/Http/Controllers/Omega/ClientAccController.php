<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Cash;
use App\Models\Collect_Mem;
use App\Models\Collector;
use App\Models\Institution;
use App\Models\Network;
use App\Models\Operation;
use App\Models\User;
use App\Models\ValWriting;
use App\Models\Writing;
use App\Models\Zone;

class ClientAccController extends Controller
{
    public function index()
    {
        $collectors = Collector::getCollectorsCash();
        $members = Collect_Mem::getMembers();
        $writings = Writing::getStatements();
        $val_writings = ValWriting::getStatements();
        $operas = Operation::getOperations();

        foreach ($val_writings as $val_writing) {
            $writings->add($val_writing);
        }

        $writings = $writings->sortKeysDesc();

        return view('omega.pages.client_acc', compact(
            'members',
            'collectors',
            'writings',
            'operas'
        ));
    }
}
