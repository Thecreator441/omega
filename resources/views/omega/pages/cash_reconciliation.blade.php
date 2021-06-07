<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.reconcash'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.reconcash') </h3>
        </div>
        <div class="box-body">
            @if ($emp->collector === null && $emp->coll_mem === null)
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            {{ $cashes->links('layouts.includes.pagination') }}
                        </div>
                    </div>
                </div>
            @endif
            <form action="{{ url('cash_reconciliation/store') }}" method="post" role="form" id="cashReconForm">
                {{csrf_field()}}
                @if ($emp->collector === null && $emp->coll_mem === null)
                    <div class="box-header" id="form">
                        @foreach ($cashes as $cash)
                            <input type="hidden" id="idcash" name="idcash" value="{{$cash->idcash}}">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cashcode" class="col-md-6 control-label">@lang('label.cash')</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="cashcode" id="cashcode"
                                                   value="{{$cash->cashcode}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="cash" id="cash"
                                               value="{{$cash->labelfr}}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        @foreach($employees as $employee)
                                            @if ($cash->employee == $employee->iduser)
                                                <input type="text" name="employee" id="employee" class="form-control"
                                                       readonly value="{{$employee->name}} {{$employee->surname}}">
                                            @endif
                                        @endforeach
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
                                            <th> @lang('label.amount')</th>
                                            <th>@lang('label.out')</th>
                                            <th>@lang('label.amount')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($moneys as $money)
                                            @if ($money->format == 'B')
                                                <tr>
                                                    <td id="bil">{{$money->value}}</td>
                                                    <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                                    <td id="mon{{$money->idmoney}}"><input type="hidden" value="{{money($cash->{'mon'.$money->idmoney}) }}">
                                                        {{money($cash->{'mon'.$money->idmoney}) }}</td>
                                                    <td id="mon{{$money->idmoney}}"
                                                        class="inamt">{{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                                    <td>
                                                        <input type="text" class="tot" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                               oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="sum" id="{{$money->moncode}}Sum" disabled>
                                                    </td>
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
                                                    <td id="mon{{$money->idmoney}}"><input type="hidden"
                                                                                           value="{{money($cash->{'mon'.$money->idmoney}) }}">
                                                        {{money($cash->{'mon'.$money->idmoney}) }}</td>
                                                    <td id="mon{{$money->idmoney}}"
                                                        class="inamt">{{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                                    <td>
                                                        <input type="text" class="tot" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                               oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="sum" id="{{$money->moncode}}Sum" disabled>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                        <tfoot class="bg-green-active">
                                        <tr>
                                            <td colspan="2"
                                                style="text-align: center !important;">@lang('label.tobreak')</td>
                                            <td colspan="2">
                                                <input type="text" class="bg-green-active pull-right text-bold"
                                                       name="totin" id="totin" readonly>
                                            </td>
                                            <td colspan="2"><input type="text" class="bg-green-active pull-right text-bold"
                                                                   name="totbil" id="totbil" readonly></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="bg-green-active text-bold" id="totinword"></td>
                                            <td colspan="2" class="bg-green-active text-bold" id="totopera"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center !important;">@lang('label.diff')</td>
                                            <td colspan="2"><input type="text" class="bg-green-active pull-left text-bold"
                                                                   name="diff" id="diff" readonly></td>
                                            <td colspan="2" id="diffinword"></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="row" id="closure" style="display: none">
                                <div class="col-md-12">
                                    <button type="button" id="close" class="btn btn-sm bg-red pull-right btn-raised fa fa-times"></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="box-header with-border" id="form">
                        <input type="hidden" id="idcash" name="idcash" value="{{$cashes->idcash}}">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cashcode" class="col-md-6 control-label">@lang('label.cash')</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="cashcode" id="cashcode"
                                               value="{{$cashes->cashcode}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="cash" id="cash"
                                           value="@if ($emp->lang === 'fr'){{$cashes->labelfr}} @else {{$cashes->labeleng}} @endif" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="employee" id="employee" class="form-control"
                                           disabled value="{{$emp->name}} {{$emp->surname}}">
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
                                        <th> @lang('label.amount')</th>
                                        <th>@lang('label.out')</th>
                                        <th>@lang('label.amount')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($moneys as $money)
                                        @if ($money->format == 'B')
                                            <tr>
                                                <td id="bil">{{$money->value}}</td>
                                                <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                                <td id="mon{{$money->idmoney}}"><input type="hidden" value="{{money($cashes->{'mon'.$money->idmoney}) }}">
                                                    {{money($cashes->{'mon'.$money->idmoney}) }}</td>
                                                <td id="mon{{$money->idmoney}}"
                                                    class="inamt">{{money($money->value * $cashes->{'mon'.$money->idmoney} )}}</td>
                                                <td>
                                                    <input type="text" class="tot" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                           oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                                </td>
                                                <td>
                                                    <input type="text" class="sum" id="{{$money->moncode}}Sum" disabled>
                                                </td>
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
                                                <td id="mon{{$money->idmoney}}"><input type="hidden"
                                                                                       value="{{money($cashes->{'mon'.$money->idmoney}) }}">
                                                    {{money($cashes->{'mon'.$money->idmoney}) }}</td>
                                                <td id="mon{{$money->idmoney}}"
                                                    class="inamt">{{money($money->value * $cashes->{'mon'.$money->idmoney} )}}</td>
                                                <td>
                                                    <input type="text" class="tot" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                           oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                                </td>
                                                <td>
                                                    <input type="text" class="sum" id="{{$money->moncode}}Sum" disabled>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                    <tfoot class="bg-green-active">
                                    <tr>
                                        <td colspan="2"
                                            style="text-align: center !important;">@lang('label.tobreak')</td>
                                        <td colspan="2">
                                            <input type="text" class="bg-green-active pull-right text-bold"
                                                   name="totin" id="totin" readonly>
                                        </td>
                                        <td colspan="2"><input type="text" class="bg-green-active pull-right text-bold"
                                                               name="totbil" id="totbil" readonly></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="bg-green-active text-bold" id="totinword"></td>
                                        <td colspan="2" class="bg-green-active text-bold" id="totopera"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center !important;">@lang('label.diff')</td>
                                        <td colspan="2"><input type="text" class="bg-green-active pull-left text-bold"
                                                               name="diff" id="diff" readonly></td>
                                        <td colspan="2" id="diffinword"></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            let sumIn = 0;

            $('.inamt').each(function () {
                if (parseInt(trimOver($(this).text(), null)))
                    sumIn += parseInt(trimOver($(this).text(), null));
            });
            $('#totin').val(money(parseInt(sumIn)));
            $('#totinword').text(toWord(sumIn, '{{$emp->lang}}'));
        });

        function sum(amount, valueId, sumId) {
            $(valueId).val(money($(valueId).val()));
            $(sumId).val(money(amount * trimOver($(valueId).val(), null)));

            sumAmount();
        }

        $(document).on('input', '.amount', function () {
            $(this).val(money($(this).val()));

            sumAmount();
        });

        function sumAmount() {
            let sumIn = 0;

            $('.sum').each(function () {
                let input = trimOver($(this).val(), null);
                if (parseInt(input)) {
                    sumIn += parseInt(input);
                }
            });
            $('#totbil').val(money(sumIn));
            $('#totopera').text(toWord(sumIn, '{{$emp->lang}}'));

            setDisplay();
        }

        $('.tot').each(function () {
            $(this).keyup(function () {
                if (parseInt(trimOver($('#totbil').val(), null)))
                    setDisplay();
            });
        });

        function setDisplay() {
            let diff = Math.abs(parseInt(trimOver($('#totin').val(), null)) - parseInt(trimOver($('#totbil').val(), null)));

            $('#diff').val(money(diff));
            $('#diffinword').text(toWord(diff, '{{$emp->lang}}'));
            $('#closure').css('display', 'block');

            if (diff < 0 || diff > 0) {
                $('#diff').attr('class', 'text-red');
            } else {
                $('#diff').attr('class', 'text-white');
            }
        }

        $('#close').click(function () {
            let totin = parseInt(trimOver($('#totin').val(), null));
            let totbil = parseInt(trimOver($('#totbil').val(), null));

            let icon = 'info';
            let text = '@lang('confirm.close_text')';

            if (totin < totbil) {
                icon = 'error';
                text = '@lang('confirm.excess_text')';
            } else if (totin > totbil) {
                icon = 'error';
                text = '@lang('confirm.shortage_text')';
            }

            mySwal('@lang('sidebar.closecash')', text, '@lang('confirm.no')', '@lang('confirm.yes')', '#cashReconForm', icon);
        })
    </script>
@stop
