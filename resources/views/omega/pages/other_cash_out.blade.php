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
            <form action="{{ url('other_cash_out/store') }}" method="post" role="form" id="ocoutForm" class="needs-validation">
                {{ csrf_field() }}

                <div class="row" id="tableInput">
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        <div class="row">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="represent" class="col-xl-1 col-lg-2 col-sm-2 control-label">@lang('label.represent')</label>
                                        <div class="col-xl-11 col-lg-10 col-md-10">
                                            <input type="text" class="form-control" name="represent" id="represent">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="account" class="col-xl-1 col-lg-2 col-md-2 control-label">@lang('label.account')</label>
                                        <div class="col-xl-11 col-lg-10 col-md-10">
                                            <select class="form-control select2" id="account">
                                                <option></option>
                                                @foreach($accounts as $account)
                                                    @if (substrWords($account->accnumb, 1) != 6)
                                                        <option value="{{$account->idaccount}}">{{$account->accnumb}} : @if($emp->lang == 'fr') {{ $account->labelfr }} @else {{ $account->labeleng }} @endif</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="desc" class="col-xl-1 col-lg-2 col-sm-2 control-label">@lang('label.desc')</label>
                                        <div class="col-xl-11 col-lg-10 col-md-10">
                                            <input type="text" class="form-control" id="desc">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-7 col-xs-8">
                                    <div class="form-group">
                                        <label for="amount" class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">@lang('label.amount')</label>
                                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                            <input type="text" class="form-control text-right text-bold" id="amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-xs-4">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <button type="button" id="minus" class="btn btn-sm pull-right bg-red btn-raised fa fa-minus"></button>
                                            <button type="button" id="plus" class="btn btn-sm pull-right bg-green btn-raised fa fa-plus"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table id="billet-data-table2" class="table table-striped table-hover table-condensed table-bordered no-padding">
                                        <thead>
                                        <tr class="bg-purples">
                                            <th></th>
                                            <th>@lang('label.account')</th>
                                            <th>@lang('label.entitle')</th>
                                            <th>@lang('label.amount')</th>
                                        </tr>
                                        </thead>
                                        <tbody id="cont">
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right">@lang('label.totdist')</td>
                                            <td class="bg-blue text-right" id="totdist"></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="table-responsive">
                            <table id="billet-data-table" class="table table-striped table-hover table-condensed table-bordered no-padding">
                                <thead class="text-bold">
                                <tr>
                                    <th colspan="3" class="bg-purples">@lang('label.notes')</th>
                                    <th class="bilSum"></th>
                                </tr>
                                </thead>
                                <tbody class="text-bold">
                                @foreach ($moneys as $money)
                                    @if ($money->format == 'B')
                                        <tr>
                                            <td id="mon{{$money->idmoney}} billet" class="input text-right">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                            <td id="billet">{{$money->value}}</td>
                                            <td id="billeting"><input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                                    oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                            </td>
                                            <td class="sum text-right" id="{{$money->moncode}}Sum"></td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <th colspan="3" class="bg-purples">@lang('label.coins')</th>
                                    <th></th>
                                </tr>
                                @foreach ($moneys as $money)
                                    @if ($money->format == 'C')
                                        <tr>
                                            <td id="mon{{$money->idmoney}} billet" class="input text-right">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                            <td id="billet">{{$money->value}}</td>
                                            <td id="billeting"><input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                                      oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                            </td>
                                            <td class="sum text-right" id="{{$money->moncode}}Sum"></td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                                <tfoot class="text-bold">
                                <tr>
                                    <th class="bg-purples" colspan="3"
                                        style="text-align: center !important;">@lang('label.tobreak')</th>
                                    <th class="bg-blue">
                                        <input type="text" class="bg-blue pull-right text-bold" name="totbil" id="totbil"
                                               disabled style="text-align: right !important;">
                                    </th>
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
        $(document).ready(function () {
            if ($('#cont tr').length === 0) {
                $('#minus').attr('disabled', true);
            }
        });

        $('#account').change(function () {
            if (!isNaN($(this).val())) {
                $.ajax({
                    url: "{{ url('getAccount') }}",
                    method: 'get',
                    data: {
                        id: $(this).val()
                    },
                    success: function (account) {
                        $('#desc').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                    }
                });
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

            sumAmount();
        }

        $('#amount').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $('#plus').click(function () {
            let acc = $('#account');
            let opera = $('#desc');
            let amount = $('#amount');

            let accId = acc.select2('data')[0]['id'];
            let accText = acc.select2('data')[0]['text'];

            var accNumb = accText.split(':')[0];

            let line = '<tr>' +
                '<td style="text-align: center; width: 5%"><input type="checkbox" class="check"></td>' +
                '<td class="text-center"><input type="hidden" name="accounts[]" value="' + accId + '">' + accNumb + '</td>' +
                '<td><input type="hidden" name="operations[]" value="' + opera.val() + '">' + opera.val() + '</td>' +
                '<td class="text-right text-bold amount"><input type="hidden" name="amounts[]" value="' + amount.val() + '">' + money(amount.val()) + '</td>' +
                '</tr>';

            $('#billet-data-table2').DataTable().destroy()
            
            $('#cont').append(line);
            $('#minus').removeAttr('disabled');

            sumAmount();

            acc.val('').select2();
            opera.val('');
            amount.val('');
        });

        $('#minus').click(function () {
            $('.check').each(function () {
                if ($(this).is(':checked'))
                    $(this).closest('tr').remove();
            });
            sumAmount();
        });

        $('#minus').hover(function () {
            if ($('#cont tr').length === 0)
                $(this).attr('disabled', true);
        });

        function sumAmount() {
            let sum = 0;
            $('.amount').each(function () {
                let numb = trimOver($(this).text(), null);
                if (parseInt(numb))
                    sum += parseInt(numb);
            });
            $('#totdist').text(money(sum));
            $('#totrans').val(money(sum));

            let dif = parseInt(trimOver($('#totbil').val(), null)) - sum;
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
            if (parseInt(trimOver($('#diff').text(), null)) === 0) {
                mySwal("{{ $title }}", '@lang('confirm.other_cash_out_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#ocoutForm');
            } else {
                myOSwal("{{ $title }}", '@lang('confirm.other_cash_out_error_text')', 'error');
            }
        }
    </script>
@stop


