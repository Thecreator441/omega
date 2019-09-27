<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr') {
    App::setLocale('fr');
    $title = 'Reconciliation Caisse';
} else {
    $title = 'Cash Reconciliation';
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
            <form action="{{ url('cash_reconciliation/store') }}" method="post" role="form" id="cashReconForm">
                {{csrf_field()}}
                @if ($writings->count() == 0)
                    @foreach ($valwritings as $valwriting)
                        @if ($loop->last)
                            <input type="hidden" name="writnumb" id="writnumb"
                                   value="{{$valwriting->writnumb + 1}}">
                        @endif
                    @endforeach
                @else
                    @foreach ($writings as $writing)
                        @if ($loop->last)
                            <input type="hidden" name="writnumb" id="writnumb"
                                   value="{{$writing->writnumb + 1}}">
                        @endif
                    @endforeach
                @endif
                <div class="box-header with-border" id="form">
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
                                        @if ($cash->employee == $employee->idemp)
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
                                                <td id="mon{{$money->idmoney}}"><input type="hidden" name="{{$money->moncode}}"
                                                    value="{{money($cash->{'mon'.$money->idmoney}) }}">
                                                    {{money($cash->{'mon'.$money->idmoney}) }}</td>
                                                <td id="mon{{$money->idmoney}}"
                                                    class="inamt">{{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                                <td>
                                                    <input type="text" class="tot" id="{{$money->moncode}}"
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
                                                <td id="mon{{$money->idmoney}}"><input type="hidden" name="{{$money->moncode}}"
                                                           value="{{money($cash->{'mon'.$money->idmoney}) }}">
                                                    {{money($cash->{'mon'.$money->idmoney}) }}</td>
                                                <td id="mon{{$money->idmoney}}"
                                                    class="inamt">{{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                                <td>
                                                    <input type="text" class="tot" id="{{$money->moncode}}"
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
                                        <td colspan="4" class="bg-green-active text-right text-bold" id="totinword"></td>
                                        <td colspan="2" class="bg-green-active text-right text-bold" id="totopera"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center !important;">@lang('label.diff')</td>
                                        <td colspan="2" id="diff"></td>
                                        <td colspan="2" id="diffinword"></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row" id="closure" style="display: none">
                    <div class="col-md-11">
                        <div class="form-group">
                            <label for="opera" class="col-md-3 text-right control-label">@lang('label.opera')</label>
                            <div class="col-md-9">
                                <select name="opera" id="opera" class="form-control" readonly>
                                    @foreach ($operas as $opera)
                                        @if ($opera->idoper == 58)
                                            <option value="{{$opera->idoper}}" selected>{{$opera->opercode}}
                                                : @if ($emp->lang == 'fr') {{$opera->labelfr}} @else {{$opera->labeleng}} @endif</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" id="close"
                                        class="btn btn-sm bg-blue pull-right btn-raised fa fa-times" disabled>
                                </button>
                                {{--                            <button type="button" id="print"--}}
                                {{--                                    class="btn btn-sm bg-gray pull-right btn-raised fa fa-print">--}}
                                {{--                            </button>--}}
                            </div>
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

            $('.inamt').each(function () {
                if (parseInt(trimOver($(this).text(), null)))
                    sumIn += parseInt(trimOver($(this).text(), null));
            });
            $('#totin').val(money(parseInt(sumIn)));
            $('#totinword').text(toWord(sumIn, '{{$emp->lang}}'));
        });

        $('.tot').each(function () {
            $(this).keyup(function () {
                if (parseInt(trimOver($('#totbil').val(), null)))
                    setDisplay();
            });
        });

        function setDisplay() {
            let diff = parseInt(trimOver($('#diff').text(), null));

            if (diff < 0 || diff > 0) {
                $('#diff').attr('class', 'text-red');
                $('#closure').css('display', 'none');
                $('#close').attr('disabled', true);
            } else {
                $('#diff').attr('class', 'text-white');
                $('#closure').css('display', 'block');
                $('#close').removeAttr('disabled');
            }
        }

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
                        $('#cashReconForm').submit();
                    }
                }
            );
        })
    </script>
@stop
