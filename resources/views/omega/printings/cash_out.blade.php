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
        <div class="col-md-12">
            <table class="table no-padding table-condensed">
                <thead>
                <tr class="text-bold text-center">
                    <th>@lang('label.account')</th>
                    <th>@lang('label.entitle')</th>
                    <th>@lang('label.amount')</th>
                    <th>@lang('label.fees')</th>
                    <th>@lang('label.balance')</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($accs as $key => $account)
                        <tr>
                            <td class="text-center">{{ $account['accnumb'] }}</td>
                            <td>{{ $account['entitle'] }}</td>
                            <td class="text-right text-bold">{{ money((int)$account['amount']) }}</td>
                            <td class="text-right text-bold">{{ money((int)$account['fee']) }}</td>
                            <td class="text-right text-bold">{{ money((int)$account['balance']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table no-padding table-condensed">
                <thead>
                    <tr class="text-bold text-center">
                        <th>@lang('label.value')</th>
                        <th>@lang('label.in')</th>
                        <th> @lang('label.amount')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($moneys as $money)
                        @if((int)$userCash->{'mon'.$money->idmoney} > 0)
                            <tr>
                                <td class="text-right">{{ money($money->value) }}</td>
                                <td class="text-right">{{ money($userCash->{'mon'.$money->idmoney}) }}</td>
                                <td class="text-right text-bold">{{ money($money->value * $userCash->{'mon'.$money->idmoney}) }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-center">@lang('label.tobreak')</td>
                        <td class="text-right text-bold">{{ money($userCash->total) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="bg-green-active text-bold text-right">{{ $userCash->totalWord }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 text-center">@lang('label.tellersign')</div>
        <div class="col-xs-6 text-center">@lang('label.memsign')</div>
        </div>
    </div>
@stop
