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
        </div>
        <div class="box-body">
            <form action="{{ url('reception/store') }}" method="post" role="form" id="recFundsForm" class="needs-validation">
                {{ csrf_field() }}

                <div class="row">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-2"></div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-xs-12">
                            <div class="form-group">
                                <label for="cashfr" class="col-xl-1 col-lg-2 col-md-3 col-sm-4 col-xs-3 control-label">@lang('label.cashfr')</label>
                                <div class="col-xl-11 col-lg-10 col-md-9 col-sm-8 col-xs-9">
                                    <select name="cashfr" id="cashfr" class="form-control select2" disabled>
                                        @foreach($cashes as $cash)
                                            @if ($cash->idcash === $cash_replen_init->cash)
                                                <option value="{{$cash->idcash}}">{{$cash->cashcode}}
                                                : @if ($emp->lang == 'fr') {{$cash->labelfr}} @else {{$cash->labeleng}} @endif
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="cashfr" value="{{ $cash_replen_init->cash }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-2"></div>
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
                                                <input type="hidden" name="{{$money->moncode}}" id="{{$money->moncode}}" value="{{ $cash_replen_init->{'mon'.$money->idmoney} }}">
                                                {{money($cash_replen_init->{'mon'.$money->idmoney}) }}
                                            </td>
                                            <td class="text-right amount text-bold" id="{{$money->moncode}}Sum">{{money($money->value * $cash_replen_init->{'mon'.$money->idmoney} )}}</td>
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
                                                <input type="hidden" name="{{$money->moncode}}" id="{{$money->moncode}}" value="{{ $cash_replen_init->{'mon'.$money->idmoney} }}">
                                                {{money($cash_replen_init->{'mon'.$money->idmoney}) }}
                                            </td>
                                            <td class="text-right amount text-bold" id="{{$money->moncode}}Sum">{{money($money->value * $cash_replen_init->{'mon'.$money->idmoney} )}}</td>
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
                            <input type="hidden" name="totamt" class="totamt">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
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
                var input = trimOver($(this).text(), null);
                
                if (parseInt(input)) {
                    sumIn += parseInt(input);
                    $('.' + $(this).prop('id') + 'Word').text(toWord(input, '{{$emp->lang}}'));
                }
            });

            $('#totamt').text(money(sumIn));
            $('.totamt').val(sumIn);
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
