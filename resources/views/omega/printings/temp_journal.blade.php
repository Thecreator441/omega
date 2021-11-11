<?php
$emp = Session::get('employee');

$title = $menu->labeleng;
if ($emp->lang == 'fr') {
    $title = $menu->labelfr;
    App::setLocale('fr');
}
//dd($accs);
?>

@extends('layouts.printing')

@section('title', $title)

@section('content')   
    
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table  class="table display table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>@lang('label.refer')</th>
                        <th>@lang('label.account')</th>
                        <th>@lang('label.aux')</th>
                        <th>@lang('label.opera')</th>
                        <th>@lang('label.debt')</th>
                        <th>@lang('label.credt')</th>
                        <th>@lang('label.date')</th>
                        <th>@lang('label.time')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($writings as $writing)
                        <tr>
                            <td class="text-center">{{ $writing->refs }}</td>
                            <td class="text-center">{{ $writing->account }}</td>
                            <td class="text-center">{{ $writing->aux }} </td>
                            <td>{{ $writing->operation }}</td>
                            <td class="debit text-right text-bold">{{ $writing->debit }}</td>
                            <td class="credit text-right text-bold">{{ $writing->credit }}</td>
                            <td class="text-center">{{ $writing->accdate }}</td>
                            <td class="text-center">{{ $writing->time }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot id="tableInput" class="bg-antiquewhite">
                    <tr class="text-right text-blue text-bold">
                        <th colspan="4"></th>
                        <th id="debit" class="text-right">{{ $sumDebit }}</th>
                        <th id="credit" class="text-right">{{ $sumCredit }}</th>
                        <th class="text-black text-center">@lang('label.balance')</th>
                        <th id="tot_bal" class="text-center text-black">{{ $sumBal }}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@stop
