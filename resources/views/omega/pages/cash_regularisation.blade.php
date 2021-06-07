<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.regulcash'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.regulcash') </h3>
        </div>
        <div class="box-body">
            <form action="{{ url('cash_regularisation/store') }}" method="post" role="form" id="ocoutForm">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <h3 class="bg-antiquewhite text-blue text-bold text-center">@lang('label.break')</h3>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="collector" class="col-md-3 control-label">@lang('label.cash')</label>
                                        <div class="col-md-9">
                                            <select class="form-control select2" id="collector" name="collector">
                                                <option value=""></option>
                                                @foreach($cashes as $cashs)
                                                    <option value="{{$cashs->idcash}}">{{$cashs->cashcode}} : @if ($emp->lang === 'fr') {{$cashs->labelfr}} @else {{$cashs->labeleng}} @endif</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="cash_diff" class="col-md-2 control-label">@lang('label.diff')s</label>
                                        <div class="col-md-7">
                                            <select class="form-control select2" name="cash_diff" id="cash_diff">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="amount" class="form-control text-right text-bold" placeholder="@lang('label.amount')" id="amount" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <table id="tableInput"
                               class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                            <thead>
                            <tr>
                                <th colspan="2" class="bg-purples">@lang('label.notes')</th>
                                <th class="bilSum"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($moneys as $money)
                                @if ($money->format == 'B')
                                    <tr>
                                        <td id="billet">{{money($money->value)}}</td>
                                        <td><input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                   oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                        </td>
                                        <td class="sum text-right text-bold" id="{{$money->moncode}}Sum"></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="bg-purples" colspan="2"
                                    style="text-align: center !important;">@lang('label.tobreak')</th>
                                <th class="bg-blue">
                                    <input type="text" class="bg-blue pull-right text-bold" name="totbil" id="totbil"
                                           readonly style="text-align: right !important;">
                                </th>
                            </tr>
                            <tr>
                                <th colspan="3" class="bg-blue">
                                    <input type="text" class="bg-blue pull-right text-bold" id="toword" disabled>
                                </th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table id="tableInput2"
                               class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                            <thead>
                            <tr>
                                <th colspan="2" class="bg-purples">@lang('label.coins')</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($moneys as $money)
                                @if ($money->format == 'C')
                                    <tr>
                                        <td id="billet">{{$money->value}}</td>
                                        <td><input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                   oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                        </td>
                                        <td class="sum text-right text-bold" id="{{$money->moncode}}Sum" style="width: 250px"></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-11">
                        <table class="table table-responsive" id="tableInput">
                            <thead>
                            <tr class="text-bold text-blue bg-antiquewhite text-left">
                                {{--                                @foreach($accounts as $account)--}}
                                {{--                                    @if ($cash->cashacc == $account->idaccount)--}}
                                {{--                                        <td style="width: 25%">--}}
                                {{--                                            @if($emp->lang == 'fr') {{$account->labelfr }} @else {{$account->labeleng }} @endif--}}
                                {{--                                        </td>--}}
                                {{--                                        <td>{{$account->accnumb }}</td>--}}
                                {{--                                    @endif--}}
                                {{--                                @endforeach--}}
                                <td>@lang('label.totrans')</td>
                                <td style="width: 15%"><input type="text" style="text-align: left" name="totrans"
                                                              id="totrans" readonly></td>
                                <td>@lang('label.diff')</td>
                                <td id="diff" class="text-right" style="width: 15%"></td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-1">
                        <button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            if ($('#cont tr').length === 0) {
                $('#minus').attr('disabled', true);
            }
        });

        function sum(amount, valueId, sumId) {
            $(valueId).val(money($(valueId).val()));
            $(sumId).text(money(amount * trimOver($(valueId).val(), null)));

            let sum = 0;

            $('.sum').each(function () {
                let numb = trimOver($(this).text(), null);
                if (parseInt(numb))
                    sum += parseInt(numb);
            });
            $('#totbil').val(money(sum));
            $('#toword').val(toWord(sum, '{{$emp->lang}}'));

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

        $('#collector').change(function () {
            $.ajax({
                url: "{{ url('getCashDiffs') }}",
                method: 'get',
                data: {
                    collector: $(this).val()
                },
                success: function (cash_diffs) {
                    let option = "<option value=''></option>";
                    $.each(cash_diffs, function (i, cash_diff) {
                        option += "<option " + "value=" + cash_diff.id_cash_diff + ">" + cash_diff.accnumb + " : @if($emp->lang == 'fr') " + cash_diff.acc_fr + " @else " + cash_diff.acc_en + " @endif</option>";
                    });
                    $('#cash_diff').html(option);
                    $('#amount').val('');
                }
            });
        });

        $('#cash_diff').change(function () {
            $.ajax({
                url: "{{ url('getCashDiff') }}",
                method: 'get',
                data: {
                    id: $('#cash_diff').val()
                },
                success: function (cash_diff) {
                    let amount = cash_diff.amount - cash_diff.paid_amt;

                    $('#amount').val(money(amount));
                },
                error: function (errors) {
                    console.log(errors);
                }
            });
        });

        $(document).on('click', '#save', function () {
            let totbil = $('#totbil').val();
            let totrans = $('#totrans').val();

            if (totbil === totrans || !isNaN(totbil) || !isNaN(totrans) || totrans !== 0 || totbil !== 0) {
                mySwal('@lang('sidebar.regulcash')', '@lang('confirm.regulcash_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#ocoutForm');
            } else {
                myOSwal('@lang('sidebar.regulcash')', '@lang('confirm.regulcasherror_text')', 'error');
            }
        });
    </script>
@stop
