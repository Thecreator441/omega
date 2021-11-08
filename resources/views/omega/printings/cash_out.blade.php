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
    
    <table class="table no-padding table-condensed">
        <thead>
            <tr>
                <td style="width: 80%">
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

                    <table class="table no-padding table-condensed">
                        <tbody>
                            <tr>
                                <th class="text-center text-bold" style="width: 50%">@lang('label.tellersign')</th>
                                <th class="text-center text-bold" style="width: 50%">@lang('label.memsign')</th>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width: 20%">
                    <table class="table no-padding table-condensed">
                        <thead>
                            <tr class="text-bold text-center">
                                <th>@lang('label.value')</th>
                                <th>@lang('label.num')</th>
                                <th> @lang('label.amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($moneys as $money)
                                @if((int)$userCash->{'mon'.$money->idmoney} > 0)
                                    <tr>
                                        <td class="text-right">{{ money($money->value) }}</td>
                                        <td class="text-center">{{ money($userCash->{'mon'.$money->idmoney}) }}</td>
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
                                <td colspan="3" class="bg-green-active text-bold text-center">{{ $userCash->totalWord }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>
        </thead>
    </table>

@stop
