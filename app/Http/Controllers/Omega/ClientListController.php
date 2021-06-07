<?php

namespace App\Http\Controllers\Omega;

use App\Http\Controllers\Controller;
use App\Models\Collect_Mem;
use App\Models\Collect_Mem_Benef;
use App\Models\Collector;
use Illuminate\Support\Facades\Session;

class ClientListController extends Controller
{
    public function index()
    {
        $emp = Session::get('employee');

        $customers = Collect_Mem::getMembers();
        $collectors = Collector::getCollectors();

        if ($emp->collector !== null) {
            $customers = Collect_Mem::getMembers(['collector' => $emp->idcoll]);
        }

        foreach ($customers as $customer) {
            $cust_benefs = Collect_Mem_Benef::getCollectMemBenefs($customer->idcollect_mem);
            $customer->benefs = $cust_benefs->count();
        }

        return view('omega.pages.client_list', compact(
            'collectors',
            'customers'
        ));
    }
}
