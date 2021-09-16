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

        <div class="box-body" id="tableInput">
            <form action="{{ url('membership/store') }}" method="post" role="form" id="memSaveForm" class="needs-validation">
                {{ csrf_field() }}
                
                <div class="row">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="register" class="col-xl-1 col-lg-1 col-md-2 col-sm-2 control-label">@lang('label.register')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-11 col-lg-11 col-md-10 col-sm-10">
                                    <select class="form-control select2" name="register" id="register" required>
                                        <option value=""></option>
                                        @foreach($registers as $register)
                                            <option value="{{$register->idregister}}">{{pad($register->regnumb, 6)}} : {{ $register->name }} {{ $register->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="represent" class="col-xl-1 col-lg-2 col-md-3 col-sm-3 control-label">@lang('label.represent')</label>
                                <div class="col-xl-11 col-lg-10 col-md-9 col-sm-9">
                                    <input type="text" class="form-control" name="represent" id="represent">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-condensed table-bordered no-padding">
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
                                        <td id="billet">{{$money->value}}</td>
                                        <td><input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                    oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                        </td>
                                        <td class="sum text-right" id="{{$money->moncode}}Sum"></td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <th colspan="2" class="bg-purples">@lang('label.coins')</th>
                                <th></th>
                            </tr>
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
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-condensed table-bordered no-padding">
                            <thead>
                            <tr class="bg-antiquewhite text-blue">
                                <th>@lang('label.account')</th>
                                <th>@lang('label.entitle')</th>
                                <th>@lang('label.amount')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($mem_sets as $mem_set)
                                    @if ($mem_set->accabbr === 'Or')
                                        <tr>
                                            <td><input type="hidden" name="mem_sets[]" value="{{$mem_set->idmemset}}">{{$mem_set->accnumb}}</td>
                                            <td>
                                                <input type="hidden" name="accounts[]" value="{{$mem_set->account}}">
                                                <input type="hidden" name="operations[]" value="{{$mem_set->operation}}">
                                                @if($emp->lang == 'fr') {{$mem_set->acclabelfr}} @else {{$mem_set->acclabeleng}} @endif
                                            </td>
                                            <td>
                                                <input type="text" class="amount" name="amounts[]" value="{{money((int)$mem_set->amount)}}" @if ((int)$mem_set->amount > 0) readonly @endif>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr class="bg-antiquewhite text-blue">
                                    <th colspan="3" class="text-center">@lang('label.gl_account')</th>
                                </tr>
                                @foreach ($mem_sets as $mem_set)
                                    @if ($mem_set->accabbr !== 'Or')
                                        <tr>
                                            <td><input type="hidden" name="mem_sets[]" value="{{$mem_set->idmemset}}">{{$mem_set->accnumb}}</td>
                                            <td>
                                                <input type="hidden" name="accounts[]" value="{{$mem_set->account}}">
                                                <input type="hidden" name="operations[]" value="{{$mem_set->operation}}">
                                                @if($emp->lang == 'fr') {{$mem_set->acclabelfr}} @else {{$mem_set->acclabeleng}} @endif
                                            </td>
                                            <td>
                                                <input type="text" class="amount" name="amounts[]" value="{{money((int)$mem_set->amount)}}" @if ((int)$mem_set->amount > 0) readonly @endif>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr class="bg-purples text-right text-bold">
                                <td colspan="3" id="totopera"></td>
                            </tr>
                            </tfoot>
                        </table>
                        </div>
                    </div>
                </div>

                <div class="row">
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
            //$('#mem_table').append(addRow(5, $('#mem_table tr').length));
            //$('#gl_table').append(addRow(7, $('#gl_table tr').length));

            function addRow(monLength, infLength) {
                let dim = monLength - infLength;
                let tabLigne = null;
                for (let i = 0; i < dim; i++) {
                    tabLigne += '<tr>' +
                        '<td></td>' +
                        '<td></td>' +
                        {{-- '<td></td>' + --}}
                        '<td><input type="text" disabled></td>' +
                        '</tr>';
                }
                return tabLigne;
            }

            var totAmt = 0;
            $('.amount').each(function () {
                var amt = trimOver($(this).val(), null);

                if (parseInt(amt))
                    totAmt += parseInt(amt);
            });
            $('#totrans').val(money(totAmt));
            $('#totopera').text(toWord(totAmt), '{{$emp->lang}}');
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

        function submitForm() {
            let diff = parseInt(trimOver($('#diff').text(), null));
            let trans = parseInt(trimOver($('#totrans').val(), null));
            let bill = parseInt(trimOver($('#totbil').val(), null));

            if ((trans === bill) && (diff === 0)) {
                mySwal("{{ $title }}", "@lang('confirm.memsave_text')", '@lang('confirm.no')', '@lang('confirm.yes')', '#memSaveForm');
            } else {
                myOSwal("{{ $title }}", "@lang('confirm.memsaveerror_text')", 'error');
            }
        }
    </script>
@stop
