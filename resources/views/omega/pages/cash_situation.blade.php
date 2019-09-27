<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr') {
    App::setLocale('fr');
    $title = 'Situation Caisse';
} else {
    $title = 'Cash Situation';
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
            @if ($emp->privilege == 5)
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            {{ $cashes->links('layouts.includes.pagination') }}
                        </div>
                    </div>
                </div>
            @endif
            <form action="{{ url('cash_situation/print') }}" method="post" role="form" id="cashSitForm">
                {{csrf_field()}}
                @if ($emp->privilege == 5)
                    @foreach ($cashes as $cash)
                        <div class="box-header with-border" id="form">
                            <input type="hidden" id="idcash" name="idcash" value="{{$cash->idcash}}">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cash" class="col-md-3 control-label">@lang('label.cash')</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="cash" id="cash" disabled
                                                   value="{{$cash->cashcode}} :@if ($emp->lang == 'fr') {{$cash->labelfr}} @else {{$cash->labeleng}} @endif">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        @foreach($employees as $employee)
                                            @if ($cash->employee == $employee->idemp)
                                                <input type="text" name="employee" id="employee" class="form-control"
                                                       disabled value="{{$employee->name}} {{$employee->surname}}">
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>

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
                                            <td id="bil">{{money($money->value)}}</td>
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
                    @endforeach
                @else
                    <div class="box-header with-border" id="form">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cash" class="col-md-3 control-label">@lang('label.cash')</label>
                                    <div class="col-md-9">
                                        <input type="text" name="cash" id="cash" class="form-control" disabled
                                               value="{{$cashes->cashcode}} :@if ($emp->lang == 'fr') {{$cashes->labelfr}} @else {{$cashes->labeleng}} @endif">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="employee" id="employee" class="form-control"
                                           disabled value="{{$emp->name}} {{$emp->surname}}">
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>

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
                                        <td id="bil">{{money($money->value)}}</td>
                                        <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                        <td id="mon{{$money->idmoney}}">{{money($cashes->{'mon'.$money->idmoney}) }}</td>
                                        <td class="sum text-right"
                                            id="{{$money->moncode}}Sum">{{money($money->value * $cashes->{'mon'.$money->idmoney} )}}</td>
                                        <td class="text-light-blue">{{digitToWord($money->value * $cashes->{'mon'.$money->idmoney}) }}</td>
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
                                        <td id="mon{{$money->idmoney}}">{{money($cashes->{'mon'.$money->idmoney}) }}</td>
                                        <td class="sum text-right"
                                            id="{{$money->moncode}}Sum">{{money($money->value * $cashes->{'mon'.$money->idmoney} )}}</td>
                                        <td class="text-light-blue">{{digitToWord($money->value * $cashes->{'mon'.$money->idmoney}) }}</td>
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
                @endif

                <div class="col-md-12">
                    <button type="button" id="print"
                            class="btn btn-sm bg-gray pull-right btn-raised fa fa-print"></button>
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
                let input = trimOver($(this).text(), null);
                if (parseInt(input))
                    sumIn += parseInt(input);
            });
            $('#totbil').text(money(sumIn));
            $('#totopera').text(toWord(sumIn, '{{$emp->lang}}'));
        });
    </script>
@stop
