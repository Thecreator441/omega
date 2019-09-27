<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr') {
    App::setLocale('fr');
    $title = 'Reouverture Caisse';
} else {
    $title = 'Cash Reopening';
}
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="box-tools">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        {{ $cashes->links('layouts.includes.pagination') }}
                    </div>
                </div>
            </div>
            <form action="{{ url('cash_reopen/store') }}" method="post" role="form" id="cashReopenForm">
                {{csrf_field()}}
                <div class="box-header with-border">
                    @foreach ($cashes as $cash)
                        <input type="hidden" id="idcash" name="idcash" value="{{$cash->idcash}}">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="cash_key" class="col-md-2 control-label">@lang('label.cash')</label>
                                    <div class="col-md-2">
                                        <input type="text" name="cash_key" id="cash_key" class="form-control"
                                               value="{{$cash->cashcode}}" readonly>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="cash_name" id="cash_name" class="form-control"
                                               value="@if ($emp->lang == 'fr') {{$cash->labelfr}} @else {{$cash->labeleng}} @endif"
                                               readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cashopen"
                                           class="col-md-6 control-label">@lang('label.cashopen')</label>
                                    <div class="col-md-6">
                                        <input type="text" name="cashopen" id="cashopen"
                                               class="form-control text-bold text-right" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group"></div>

                        <div class="row">
                            <div class="col-md-12">
                                <table id="tableInput"
                                       class="table w-auto table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                                    <caption class="text-blue">@lang('label.break')</caption>
                                    <thead>
                                    <tr class="text-blue">
                                        <th>@lang('label.value')</th>
                                        <th>@lang('label.label')</th>
                                        <th>@lang('label.in')</th>
                                        <th>@lang('label.amount')</th>
                                        <th>@lang('label.letters')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($moneys as $money)
                                        @if ($money->format == 'B')
                                            <tr>
                                                <td id="bil">{{$money->value}}</td>
                                                <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                                <td id="mon{{$money->idmoney}}">
                                                    <input type="text" name="{{$money->moncode}}"
                                                           id="{{$money->moncode}}"
                                                           oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')"
                                                           value="{{money($cash->{'mon'.$money->idmoney}) }}"
                                                           readonly></td>
                                                <td>
                                                    <input type="text" class="sum" id="{{$money->moncode}}Sum"
                                                           value="{{money($money->value * $cash->{'mon'.$money->idmoney} )}}"
                                                           disabled>
                                                </td>
                                                <td class="text-blue word">{{digitToWord($money->value * $cash->{'mon'.$money->idmoney}) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                    <thead>
                                    <tr>
                                        <th colspan="6" class="bg-gray"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($moneys as $money)
                                        @if ($money->format == 'C')
                                            <tr>
                                                <td id="bil">{{$money->value}}</td>
                                                <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                                <td id="mon{{$money->idmoney}}">
                                                    <input type="text" name="{{$money->moncode}}"
                                                           id="{{$money->moncode}}"
                                                           oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')"
                                                           value="{{money($cash->{'mon'.$money->idmoney}) }}"
                                                           readonly></td>
                                                <td>
                                                    <input type="text" class="sum" id="{{$money->moncode}}Sum"
                                                           value="{{money($money->value * $cash->{'mon'.$money->idmoney} )}}"
                                                           disabled>
                                                </td>
                                                <td class="text-blue word">{{digitToWord($money->value * $cash->{'mon'.$money->idmoney}) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="bg-green-active">
                                        <td colspan="4"
                                            style="text-align: center !important;">@lang('label.tobreak')</td>
                                        <td>
                                            <input type="text" class="bg-green-active pull-right text-bold"
                                                   name="totbil" id="totbil" readonly>
                                        </td>
                                    </tr>
                                    <tr class="bg-green-active">
                                        <td colspan="5">
                                            <input type="text" class="bg-green-active text-left text-bold"
                                                   name="totopera" id="totopera" disabled>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <button type="button" id="save"
                                    class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('#cashopen').val(money(parseInt(trim($('#totbil').val()))));

            $('#totopera').val();

            $('#save').click(function () {
                swal({
                        title: '@lang('confirm.reopen_header')',
                        text: '@lang('confirm.reopen_text')',
                        type: 'info',
                        showCancelButton: true,
                        cancelButtonClass: 'bg-red',
                        confirmButtonClass: 'bg-blue',
                        confirmButtonText: '@lang('confirm.yes')',
                        cancelButtonText: '@lang('confirm.no')',
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('#cashReopenForm').submit();
                        }
                    }
                );
            })
        });
    </script>
@stop
