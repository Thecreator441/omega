<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.closecash'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.closecash') </h3>
        </div>
{{--        <div class="box-header">--}}
{{--            <div class="box-tools pull-right">--}}
{{--                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="box-body">
            <form action="{{ url('cash_close/store') }}" method="post" role="form" id="cashCloseForm">
                {{ csrf_field() }}
                <input type="hidden" id="idcash" name="idcash" value="{{$cash->idcash}}">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cashcode" class="col-md-2 control-label">@lang('label.cash')</label>
                                <div class="col-md-2">
                                    <input type="text" name="cashcode" id="cashcode" class="form-control"
                                           value="{{$cash->cashcode}}" readonly>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="cashname" id="cashname" class="form-control" readonly
                                           value="@if ($emp->lang == 'fr') {{$cash->labelfr}} @else {{$cash->labeleng}} @endif">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-group"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <table id="tableInput"
                                   class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
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
                                            <td id="mon{{$money->idmoney}}">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                            <td class="sum text-right"
                                                id="{{$money->moncode}}Sum">{{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                            <td class="text-light-blue">{{digitToWord($money->value * $cash->{'mon'.$money->idmoney}) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                                <thead>
                                <tr>
                                    <th colspan="5" class="bg-gray"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($moneys as $money)
                                    @if ($money->format == 'C')
                                        <tr>
                                            <td id="bil">{{$money->value}}</td>
                                            <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                            <td id="mon{{$money->idmoney}}">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                            <td class="sum text-right"
                                                id="{{$money->moncode}}Sum">{{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                            <td class="text-light-blue">{{digitToWord($money->value * $cash->{'mon'.$money->idmoney}) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr class="bg-green-active">
                                    <td colspan="3"
                                        style="text-align: center !important;">@lang('label.tobreak')</td>
                                    <td class="text-right text-bold" id="totbil"></td>
                                    <td class="text-left text-bold" id="totopera"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <button type="button" id="close"
                                    class="btn btn-sm bg-blue pull-right btn-raised fa fa-close">
                            </button>
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
            let sumIn = 0;

            $('.sum').each(function () {
                if (parseInt(trim($(this).text())))
                    sumIn += parseInt(trim($(this).text()));
            });
            $('#totbil').text(money(parseInt(sumIn)));
            $('#totopera').text(toWord(sumIn, '{{$emp->lang}}'));
        });

        $('#close').click(function () {
            swal({
                    title: '@lang('confirm.close_header')',
                    text: '@lang('confirm.close_text')',
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
                        $('#cashCloseForm').submit();
                    }
                }
            );
        })
    </script>
@stop
