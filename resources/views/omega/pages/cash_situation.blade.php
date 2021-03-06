<?php $emp = Session::get('employee');

$title = $menu->labeleng;
if ($emp->lang == 'fr') {
    $title = $menu->labelfr;
    App::setLocale('fr');
}
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> {{ $title }} </h3>
            <div class="box-tools pull-right">
                {{ $cashes->appends(request()->query())->links('layouts.includes.pagination') }}
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('cash_situation/store') }}" method="post" role="form" id="cashSitForm">
                {{csrf_field()}}

                    @foreach ($cashes as $cash)
                        <div class="row" id="form">
                            <input type="hidden" id="idcash" name="idcash" value="{{$cash->idcash}}">

                            <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="cashcode" class="col-md-2 col-xs-2 control-label">@lang('label.cash')</label>
                                        <div class="col-md-10 col-xs-10">
                                            <input type="text" id="cashcode" class="form-control" value="{{$cash->cashcode}} : @if ($emp->lang == 'fr') {{$cash->labelfr}} @else {{$cash->labeleng}} @endif" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="cashstatus" class="col-md-2 col-xs-2 control-label">@lang('label.status')</label>
                                        <div class="col-md-10 col-xs-10">
                                            <input type="text" id="cashstatus" class="form-control" value="@if ($cash->status == 'O') @lang('label.open') @elseif ($cash->status == 'I') @lang('label.close_init') @elseif ($cash->status == 'C') @lang('label.close') @else @lang('label.reopen')  @endif" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="employee" class="col-md-2 col-xs-2 control-label">@lang('label.user')</label>
                                        <div class="col-md-10 col-xs-10">
                                            <input type="text" id="employee" class="form-control" disabled value="{{$emp->name}} {{$emp->surname}}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                        </div>

                        <div class="row" id="tableInput">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table id="billet-data-table" class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
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
                                                    <td id="mon{{$money->idmoney}}" class="text-right text-bold">
                                                        <input type="hidden" name="{{$money->moncode}}" id="{{$money->moncode}}" value="{{ $cash->{'mon'.$money->idmoney} }}">
                                                        {{money($cash->{'mon'.$money->idmoney}) }}
                                                    </td>
                                                    <td class="text-right amount text-bold" id="{{$money->moncode}}Sum">{{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                                    <td class="text-light-blue text-bold {{ $money->moncode }}SumWord"></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr><td colspan="5" class="bg-gray"></td></tr>
                                        @foreach ($moneys as $money)
                                            @if ($money->format == 'C')
                                                <tr>
                                                    <td id="bil">{{$money->value}}</td>
                                                    <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                                    <td id="mon{{$money->idmoney}}" class="text-right text-bold">
                                                        <input type="hidden" name="{{$money->moncode}}" id="{{$money->moncode}}" value="{{ $cash->{'mon'.$money->idmoney} }}">
                                                        {{money($cash->{'mon'.$money->idmoney}) }}
                                                    </td>
                                                    <td class="text-right amount text-bold" id="{{$money->moncode}}Sum">{{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                                    <td class="text-light-blue text-bold {{ $money->moncode }}SumWord"></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr class="bg-green-active">
                                            <td colspan="3" style="text-align: center !important;">@lang('label.tobreak')</td>
                                            <td class="text-bold text-right" id="totamt"></td>
                                            <td class="text-bold" id="totinword"></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            let sumIn = 0;
    
            $('.amount').each(function () {
                var input = trimOver($(this).text(), null);
                
                if (parseInt(input)) {
                    sumIn += parseInt(input);
                    $('.' + $(this).prop('id') + 'Word').text(toWord(input, '{{$emp->lang}}'));
                }
            });

            $('#totamt').text(money(sumIn));
            $('#totinword').text(toWord(sumIn, '{{$emp->lang}}'));
        });

        function submitForm() {
            let cash = parseInt($('#cashfr').val());
            let tot = parseInt(trimOver($('#totamt').text(), null));

            if (cash !== '' && !isNaN(tot) && tot !== 0) {
                mySwal('{{ $title }}', '@lang('confirm.reception_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#recFundsForm');
            } else {
                myOSwal('{{ $title }}', '@lang('confirm.reception_error_text')', 'error');
            }
        }
    </script>
@stop
