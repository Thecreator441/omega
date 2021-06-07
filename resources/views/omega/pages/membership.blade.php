<?php
$emp = Session::get('employee');

if ($emp->lang === 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.membership'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.membership') </h3>
        </div>
{{--        <div class="box-header">--}}
{{--            <div class="box-tools pull-right">--}}
{{--                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="box-body">
            <form action="{{ url('membership/store') }}" method="post" role="form" id="memSaveForm">
                {{ csrf_field() }}
                <div class="col-md-3">
                    <div class="form-group">
                        <h3 class="bg-antiquewhite text-blue text-bold text-center">@lang('label.break')</h3>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="register" class="col-md-4 control-label">@lang('label.register')</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" name="register" id="register">
                                            <option></option>
                                            @foreach($registers as $register)
                                                <option
                                                    value="{{$register->idregister}}">{{pad($register->regnumb, 6)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="represent"
                                           class="col-md-3 control-label">@lang('label.represent')</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="represent" id="represent">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
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
                                    <td class="sum text-right" id="{{$money->moncode}}Sum"></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
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
                                    <td class="sum text-right" id="{{$money->moncode}}Sum"></td>
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
                                       disabled style="text-align: right !important;">
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-9" id="tableInput">
                    <table
                        class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <thead>
                        <tr class="bg-antiquewhite text-blue">
                            <th>@lang('label.account')</th>
                            <th>@lang('label.entitle')</th>
                            <th>@lang('label.opera')</th>
                            <th>@lang('label.amount')</th>
                        </tr>
                        </thead>
                        <tbody id="mem_table">
                        @foreach ($mem_sets as $mem_set)
                            @if ($mem_set->accabbr == 'O')
                                <tr>
                                    <td><input type="hidden" name="account[]" value="{{$mem_set->account}}">
                                        {{$mem_set->accnumb}}</td>
                                    <td>
                                        @if($emp->lang == 'fr') {{$mem_set->acclabelfr}} @else {{$mem_set->acclabeleng}} @endif
                                    </td>
                                    <td>
                                        <input type="hidden" name="operation[]" value="{{$mem_set->operation}}">
                                        @if($emp->lang == 'fr') {{$mem_set->credtfr}} @else {{$mem_set->credteng}} @endif
                                    </td>
                                    <td>
                                        <input type="text" class="amount" name="amount[]"
                                               value="{{money((int)$mem_set->amount)}}"
                                               @if ((int)$mem_set->amount != 0) readonly @endif>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <thead class="bg-antiquewhite text-blue">
                        <tr>
                            <th colspan="4" class="text-center">@lang('label.gacc')</th>
                        </tr>
                        </thead>
                        <tbody id="gl_table">
                        @foreach ($mem_sets as $mem_set)
                            @if ($mem_set->accabbr == 'I')
                                <tr>
                                    <td><input type="hidden" name="account[]" value="{{$mem_set->account}}">
                                        {{$mem_set->accnumb}}</td>
                                    <td>
                                        @if($emp->lang == 'fr') {{$mem_set->acclabelfr}} @else {{$mem_set->acclabeleng}} @endif
                                    </td>
                                    <td>
                                        <input type="hidden" name="operation[]" value="{{$mem_set->operation}}">
                                        @if($emp->lang == 'fr') {{$mem_set->credtfr}} @else {{$mem_set->credteng}} @endif
                                    </td>
                                    <td>
                                        <input type="text" class="amount" name="amount[]"
                                               value="{{money((int)$mem_set->amount)}}"
                                               @if ((int)$mem_set->amount != 0) readonly @endif>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="bg-purples text-right text-bold">
                            <td colspan="4" id="totopera"></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-md-11" id="tableInput">
                    <table class="table table-responsive">
                        <thead>
                        <tr class="text-bold text-blue bg-antiquewhite text-left">
                            @foreach($accounts as $account)
                                @if ($cash->cashacc == $account->idaccount)
                                    <td style="width: 25%">
                                        @if($emp->lang == 'fr') {{$account->labelfr }} @else {{$account->labeleng }} @endif
                                    </td>
                                    <td>{{$account->accnumb }}</td>
                                @endif
                            @endforeach
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
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('#mem_table').append(addRow(5, $('#mem_table tr').length));
            $('#gl_table').append(addRow(7, $('#gl_table tr').length));

            function addRow(monLength, infLength) {
                let dim = monLength - infLength;
                let tabLigne = null;
                for (let i = 0; i < dim; i++) {
                    tabLigne += '<tr>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td><input type="text" disabled></td>' +
                        '</tr>';
                }
                return tabLigne;
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

        $('.amount').on('input', function () {
            $(this).val(money($(this).val()));
            sumAmount();
        });

        function sumAmount() {
            let sum = 0;

            $('.amount').each(function () {
                let numb = trimOver($(this).val(), null);

                if (parseInt(numb))
                    sum += parseInt(numb);
            });

            $('#totrans').val(money(sum));
            $('#totopera').text(toWord(sum), '{{$emp->lang}}');

            let dif = parseInt(trimOver($('#totbil').val(), null) - sum);

            if (dif < 0 || dif > 0) {
                $('#diff').attr('class', 'text-red');
                $('#diff').text(money(dif));
            }
            if (dif < 0) {
                $('#diff').attr('class', 'text-red');
                return false;
            } else {
                $('#diff').attr('class', 'text-blue');
                $('#diff').text(money(dif));
            }
        }

        $('#register').change(function () {
            $.ajax({
                url: "{{ url('getRegister') }}",
                method: 'get',
                data: {
                    register: $(this).val()
                },
                success: function (register) {
                    if (register.surname === null) {
                        $('#represent').val(register.name);
                    } else {
                        $('#represent').val(register.name + ' ' + register.surname);
                    }
                }
            });
        });

        $('#save').click(function () {
            let diff = parseInt(trimOver($('#diff').text(), null));
            let trans = parseInt(trimOver($('#totrans').val(), null));
            let bill = parseInt(trimOver($('#totbil').val(), null));

            if ((trans === bill) && (diff === 0)) {
                swal({
                        title: '@lang('sidebar.membership')',
                        text: '@lang('confirm.memsave_text')',
                        type: 'info',
                        showCancelButton: true,
                        cancelButtonClass: 'bg-red',
                        confirmButtonClass: 'bg-green',
                        confirmButtonText: '@lang('confirm.yes')',
                        cancelButtonText: '@lang('confirm.no')',
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('#memSaveForm').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('sidebar.membership')',
                        text: '@lang('confirm.memsaveerror_text')',
                        type: 'error',
                        confirmButtonClass: 'bg-blue',
                        confirmButtonText: 'OK',
                        closeOnConfirm: true
                    },
                );
            }
        })
    </script>
@stop
