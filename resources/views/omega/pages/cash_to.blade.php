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
            <form action="{{ url('cash_to/store') }}" method="post" role="form" id="cashToBank" class="needs-validation">
                {{csrf_field()}}

                <div class="row">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="form-group">
                                <label for="account" class="col-xl-1 col-lg-1 col-md-2 col-sm-2 control-label">@lang('label.account')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-11 col-lg-11 col-md-10 col-sm-10">
                                    <select class="form-control select2" name="account" id="account" required>
                                        <option value=""></option>
                                        @foreach($banks as $bank)
                                            <option value="{{$bank->idaccount}}">{{$bank->accnumb}} : @if($emp->lang === 'fr')
                                                {{ $bank->labelfr}}
                                            @else
                                                {{ $bank->labeleng}}
                                            @endif</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="amount" class="col-xl-2 col-lg-4 col-md-4 col-sm-3 col-xs-3 control-label">@lang('label.amount')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-9 col-xs-9">
                                    <input type="text" class="form-control text-right text-bold" name="amount" id="amount">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                </div>

                <div class="row" id="tableInput">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-condensed table-bordered no-padding">
                                <thead>
                                    <tr class="text-blue">
                                        <th>@lang('label.value')</th>
                                        <th>@lang('label.label')</th>
                                        <th>@lang('label.in')</th>
                                        <th>@lang('label.out')</th>
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
                                                <td style="width: 10%;">
                                                    <input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                           oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum', '#{{$money->moncode}}Word')">
                                                </td>
                                                <td class="sum" id="{{$money->moncode}}Sum"></td>
                                                <td class="text-blue word" id="{{$money->moncode}}Word"></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr><th colspan="6" class="bg-gray"></th></tr>
                                    @foreach ($moneys as $money)
                                        @if ($money->format == 'C')
                                            <tr>
                                                <td id="bil">{{money($money->value)}}</td>
                                                <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                                <td id="mon{{$money->idmoney}}">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                                <td style="width: 10%;">
                                                    <input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                           oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum', '#{{$money->moncode}}Word')">
                                                </td>
                                                <td class="sum" id="{{$money->moncode}}Sum"></td>
                                                <td class="text-blue word" id="{{$money->moncode}}Word"></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-green-active">
                                        <td colspan="4" style="text-align: center !important;">@lang('label.tobreak')</td>
                                        <td>
                                            <input type="text" class="bg-green-active pull-right text-bold"
                                                   name="totbil" id="totbil" readonly>
                                        </td>
                                        <td class="text-left text-bold" id="totopera"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row" id="tableInput2">
                    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-xs-12 ">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr class="text-bold text-blue bg-antiquewhite text-left">
                                    <td style="width: 25%">
                                        @if($emp->lang == 'fr') {{$cash->labelfr }} @else {{$cash->labeleng }} @endif
                                    </td>
                                    <td>{{$cash->casAcc_Numb }}</td>
                                    <td>@lang('label.totrans')</td>
                                    <td style="width: 15%">
                                        <input type="text" style="text-align: left" name="totrans" id="totrans" readonly></td>
                                    <td>@lang('label.diff')</td>
                                    <td id="diff" class="text-right" style="width: 15%"></td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-xs-12">
                        <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('#amount').on('input', function () {
            $(this).val(money($(this).val()));
            sumAll();
        });

        function sum(amount, valueId, sumId, wordId) {
            $(valueId).val(money($(valueId).val()));
            let totAmt = amount * trimOver($(valueId).val(), null);
            $(sumId).text(money(totAmt));
            $(wordId).text(toWord(totAmt));

            sumAll();
        }

        function sumAll() {
            let sum = 0;

            $('.sum').each(function () {
                let numb = trimOver($(this).text(), null);

                if (parseInt(numb))
                    sum += parseInt(numb);
            });
            $('#totbil').val(money(sum));
            $('#totopera').text(toWord(sum));

            $('#totrans').val(money(sum));

            let dif = parseInt(trimOver($('#amount').val(), null)) - sum;
            let diff = $('#diff');

            if (dif < 0) {
                diff.attr('class', 'text-red');
                diff.text(money(dif));
            } else if (diff > 0) {
                diff.attr('class', 'text-green');
                diff.text(money(dif));
            } else {
                diff.attr('class', 'text-blue');
                diff.text(money(dif));
            }
        }

        function submitForm() {
            let amt = parseInt(trimOver($('#amount').val(), null));
            let tot = parseInt(trimOver($('#totrans').val(), null));

            if (amt === tot) {
                mySwal("{{ $title }}", "@lang('confirm.cash_to_bank_text')", '@lang('confirm.no')', '@lang('confirm.yes')', '#cashToBank');
            } else {
                myOSwal("{{ $title }}", "@lang('confirm.cash_to_bank_error_text')", 'error');
            }
        }
    </script>
@stop
