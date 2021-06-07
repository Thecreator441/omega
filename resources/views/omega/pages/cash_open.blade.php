<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.opencash'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.opencash') </h3>
        </div>
        <div class="box-body">
            <form action="{{ url('cash_open/store') }}" method="post" role="form" id="cashOpenForm">
                {{csrf_field()}}
                <div class="box-header with-border">
                    <input type="hidden" id="idcash" name="idcash" value="{{$cash->idcash}}">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-5">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cashopen" class="col-md-6 control-label">@lang('label.cashopen')</label>
                                <div class="col-md-6">
                                    <input type="text" name="cashopen" id="cashopen"
                                           class="form-control text-bold text-right" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
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
                                            <td id="mon{{$money->idmoney}}" class="text-right">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                            <td class="text-right amount text-bold">{{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
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
                                            <td id="mon{{$money->idmoney}}" class="text-right">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                            <td class="text-right amount text-bold">{{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr class="bg-green-active">
                                    <td colspan="3"
                                        style="text-align: center !important;">@lang('label.tobreak')</td>
                                    <td class="text-bold text-right" id="totamt"></td>
                                    <td class="text-bold" id="totinword"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <button type="button" id="open"
                                    class="btn btn-sm bg-blue pull-right btn-raised fa fa-folder-open"></button>
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

            $('.amount').each(function () {
                if (parseInt(trimOver($(this).text(), null))) {
                    $(this).after("<td class='text-light-blue text-bold'>" + toWord(parseInt(trimOver($(this).text(), null)), '{{$emp->lang}}') + "</td>");
                    sumIn += parseInt(trimOver($(this).text(), null));
                }
            });
            $('#totamt').text(money(parseInt(sumIn)));
            $('#totinword').text(toWord(sumIn, '{{$emp->lang}}'));

            $('#cashopen').val(money(parseInt(sumIn)));
        });

        $('#open').click(function () {
            mySwal('@lang('sidebar.opencash')', '@lang('confirm.open_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#cashOpenForm');
        })
    </script>
@stop
