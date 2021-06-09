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
<div class="box" id="form" style="display: none;">
    <div class="box-header with-border">
        <h3 class="box-title text-bold" id="title"> @lang('label.new_cash')</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                <i class="fa fa-close"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <form action="{{ route('cash/store') }}" method="post" role="form" id="cashForm" class="needs-validation">
            {{ csrf_field() }}

            <div class="fillform">
                <input type="hidden" id="idcash" name="idcash" value="">

                @if ($cashes->count() > 0)
                    <div class="row">
                        <div class="col-md-2 col=xs-12">
                            <div class="form-group has-error">
                                <label for="cash_code" class="col-md-4 col-xs-3 control-label">@lang('label.code')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8 col-xs-9">
                                    <input type="text" name="cash_code" id="cash_code" class="form-control text-right code_" value="{{ (int)$cashes->count() + 1 }}" readonly required>
                                    <div class="help-block">@lang('placeholder.code')</div>
                                </div>
                            </div>
                        </div>
                        @if($emp->lang == 'fr')
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labelfr" class="col-md-2 control-label">@lang('label.cash_fr')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                        <div class="help-block">@lang('placeholder.cash_fr')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labeleng" class="col-md-2 control-label">@lang('label.cash_eng')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                        <div class="help-block">@lang('placeholder.cash_eng')</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labeleng" class="col-md-2 control-label">@lang('label.cash_eng')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                        <div class="help-block">@lang('placeholder.cash_eng')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labelfr" class="col-md-2 control-label">@lang('label.cash_fr')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                        <div class="help-block">@lang('placeholder.cash_fr')</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-2 col=xs-12">
                            <div class="form-group has-error">
                                <label for="cash_code" class="col-md-4 col-xs-3 control-label">@lang('label.code')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8 col-xs-9">
                                    <input type="text" name="cash_code" id="cash_code" class="form-control text-right code_" value="{{ (int)$cashes->count() + 1 }}" readonly required>
                                    <div class="help-block">@lang('placeholder.code')</div>
                                </div>
                            </div>
                        </div>
                        @if($emp->lang == 'fr')
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labelfr" class="col-md-2 control-label">@lang('label.cash_fr')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="labelfr" id="labelfr" value="CAISSE PRINCIPALE" readonly required>
                                        <div class="help-block">@lang('placeholder.cash_fr')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labeleng" class="col-md-2 control-label">@lang('label.cash_eng')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="labeleng" id="labeleng" value="MAIN TILL" readonly required>
                                        <div class="help-block">@lang('placeholder.cash_eng')</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labeleng" class="col-md-2 control-label">@lang('label.cash_eng')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="labeleng" id="labeleng" value="MAIN TILL" readonly required>
                                        <div class="help-block">@lang('placeholder.cash_eng')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labelfr" class="col-md-2 control-label">@lang('label.cash_fr')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="labelfr" id="labelfr" value="CAISSE PRINCIPALE" readonly required>
                                        <div class="help-block">@lang('placeholder.cash_fr')</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group has-error">
                            <label for="cashacc" class="col-md-3 control-label">@lang('label.cashacc')<span class="text-red text-bold">*</span></label>
                            <div class="col-md-9">
                                <select name="cashacc" id="cashacc" class="select2" required>
                                    <option value=""></option>
                                    @foreach ($accplans as $accplan)
                                        @if ((int)$accplan->class === 5)
                                            <option value="{{ $accplan->idaccplan }}">{{ substrWords($accplan->plan_code, 6) }} : @if($emp->lang == 'fr') {{ $accplan->labelfr }} @else {{ $accplan->labeleng }} @endif </option>        
                                        @endif
                                    @endforeach
                                </select>
                                <div class="help-block">@lang('placeholder.cashacc')</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group has-error">
                            <label for="employee" class="col-md-3 control-label">@lang('label.employee')<span class="text-red text-bold">*</span></label>
                            <div class="col-md-9">
                                <select name="employee" id="employee" class="select2" required>
                                    <option value=""></option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->iduser }}">{{ $employee->name }} {{ $employee->surname }}</option>        
                                    @endforeach
                                </select>
                                <div class="help-block">@lang('placeholder.employee')</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group has-error">
                            <label for="misacc" class="col-md-3 control-label">@lang('label.misacc')<span class="text-red text-bold">*</span></label>
                            <div class="col-md-9">
                                <select name="misacc" id="misacc" class="select2" required>
                                    <option value=""></option>
                                    @foreach ($accplans as $accplan)
                                        @if ((int)$accplan->class === 4)
                                            <option value="{{ $accplan->idaccplan }}">{{ substrWords($accplan->plan_code, 6) }} : @if($emp->lang == 'fr') {{ $accplan->labelfr }} @else {{ $accplan->labeleng }} @endif </option>        
                                        @endif
                                    @endforeach
                                </select>
                                <div class="help-block">@lang('placeholder.misacc')</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group has-error">
                            <label for="excacc" class="col-md-3 control-label">@lang('label.excacc')<span class="text-red text-bold">*</span></label>
                            <div class="col-md-9">
                                <select name="excacc" id="excacc" class="select2" required>
                                    <option value=""></option>
                                    @foreach ($accplans as $accplan)
                                        @if ((int)$accplan->class === 4)
                                            <option value="{{ $accplan->idaccplan }}">{{ substrWords($accplan->plan_code, 6) }} : @if($emp->lang == 'fr') {{ $accplan->labelfr }} @else {{ $accplan->labeleng }} @endif </option>        
                                        @endif
                                    @endforeach
                                </select>
                                <div class="help-block">@lang('placeholder.excacc')</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-header">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="col-md-12 col-xs-12">
                                    <h3 class="row text-blue text-muted">@lang('label.break')</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" id="tableInput">
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
                                            <td id="bil">{{money($money->value)}}</td>
                                            <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                            <td class="input">
                                                <input type="text" class="tot {{ $money->moncode }}In" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                       oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                            </td>
                                            <td class="sum text-right {{ $money->moncode }}Sum" id="{{$money->moncode}}Sum"></td>
                                            <td class="text-light-blue text-bold {{ $money->moncode }}SumWord"></td>
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
                                            <td id="bil">{{money($money->value)}}</td>
                                            <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                            <td class="input">
                                                <input type="text" class="tot {{ $money->moncode }}In" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                       oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                            </td>
                                            <td class="sum text-right {{ $money->moncode }}Sum" id="{{$money->moncode}}Sum"></td>
                                            <td class="text-light-blue text-bold {{ $money->moncode }}SumWord"></td>
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
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <button type="submit" id="save" class="btn btn-sm bg-blue pull-right fa fa-save btn-raised"></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">{{ $title }}</h3>
            @if ($emp->level === 'B')
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="new_cash">
                        <i class="fa fa-plus"></i>&nbsp;@lang('label.new_cash')
                    </button>
                </div>
            @endif
        </div>
        <div class="box-body">
            <table id="admin-data-table" class="table table-condensed table-striped table-responsive table-hover table-responsive-xl table-bordered">
                <thead>
                <tr>
                    <th>@lang('label.code')</th>
                    <th>{{ $title }}</th>
                    <th>@lang('label.cashacc')</th>
                    <th>@lang('label.misacc')</th>
                    <th>@lang('label.excacc')</th>                    
                    <th>@lang('label.employee')</th>
                    <th>@lang('label.date')</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cashes as $cash)
                    <tr>
                        <td class="text-center">{{pad($cash->branch, 3)}}-{{pad($cash->cashcode, 3)}}</td>
                        <td>@if($emp->lang == 'fr') {{ $cash->labelfr }} @else {{ $cash->labeleng }} @endif</td>
                        <td class="text-center">{{ $cash->casAcc_Numb }}</td>
                        <td class="text-center">{{ $cash->misAcc_Numb }}</td>
                        <td class="text-center">{{ $cash->excAcc_Numb }}</td>
                        <td>{{ $cash->name }} {{ $cash->surname }}</td>
                        <td class="text-center">{{changeFormat($cash->created_at)}}</td>
                        <td class="text-center">
                            <button type="button" class="btn bg-green btn-sm fa fa-eye" onclick="view('{{$cash->idcash}}')"></button>
                            @if ($emp->level === 'B')
                                <button type="button" class="btn bg-aqua btn-sm fa fa-edit" onclick="edit('{{$cash->idcash}}')"></button>
                                <button type="button" class="btn bg-red btn-sm fa fa-trash-o" onclick="remove('{{$cash->idcash}}')"></button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <form action="{{route('cash/delete')}}" method="post" role="form" id="delForm" style="display: none">
                {{ csrf_field() }}
                <input type="hidden" name="cash" id="cash" value="">
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            sumAmount();
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
            $('#totbil').text(money(sum));

            sumAmount();
        }

        $(document).on('input', '.amount', function () {
            $(this).val(money($(this).val()));

            sumAmount();
        });

        function sumAmount() {
            let sumIn = 0;

            $('.sum').each(function () {
                var input = trimOver($(this).text(), null);
                
                if (parseInt(input)) {
                    sumIn += parseInt(input);
                    $('.' + $(this).prop('id') + 'Word').text(toWord(input, '{{$emp->lang}}'));
                }
            });

            $('#totbil').text(money(sumIn));
            $('#totopera').text(toWord(sumIn, '{{$emp->lang}}'));
        }

        $('#new_cash').click(function () {
            in_out_form();

            $.ajax({
                url: "{{ url('getCashes') }}",
                method: 'get',
                data: {
                    branch: "{{ $emp->branch }}"
                },
                success: function (cashes) {
                    $('#cash_code').val(cashes.length + 1);
                }
            });

            $('#form').show();
        });

        function view(idcash) {
            $.ajax({
                url: "{{ url('getCash') }}",
                method: 'get',
                data: {
                    cash: idcash
                },
                success: function (cash) {
                    setDisabled(true);
                    
                    $('#title').text("@if($emp->lang === 'fr') " + cash.labelfr + " @else " + cash.labeleng + "@endif");

                    $('#idcash').val(cash.idcash);
                    $('#cash_code').val(cash.cashcode);
                    $('#labeleng').val(cash.labeleng);
                    $('#labelfr').val(cash.labelfr);
                    $('#employee').val(cash.employee).select2();

                    $.ajax({
                        url: "{{ url('getAccount') }}",
                        method: 'get',
                        data: {
                            id: cash.cashacc
                        },
                        success: function (cashAcc) {
                            $('#cashacc').val(cashAcc.idplan).select2();
                        }
                    });

                    $.ajax({
                        url: "{{ url('getAccount') }}",
                        method: 'get',
                        data: {
                            id: cash.misacc
                        },
                        success: function (misAcc) {
                            $('#misacc').val(misAcc.idplan).select2();
                        }
                    });

                    $.ajax({
                        url: "{{ url('getAccount') }}",
                        method: 'get',
                        data: {
                            id: cash.excacc
                        },
                        success: function (excAcc) {
                            $('#excacc').val(excAcc.idplan).select2();
                        }
                    });

                    $('#save').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit" style="display: none"></button>');
                    $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save" style="display: none"></button>');

                    $('#form').show();
                }
            });
        }

        function edit(idcash) {
            $.ajax({
                url: "{{ url('getCash') }}",
                method: 'get',
                data: {
                    cash: idcash
                },
                success: function (cash) {
                    setDisabled(false);
                    $('#title').text("@lang('label.edit') @if($emp->lang === 'fr') " + cash.labelfr + " @else " + cash.labeleng + "@endif");

                    $('#idcash').val(cash.idcash);
                    $('#cash_code').val(cash.cashcode);
                    $('#labeleng').val(cash.labeleng);
                    $('#labelfr').val(cash.labelfr);
                    $('#employee').val(cash.employee).select2();

                    $.ajax({
                        url: "{{ url('getAccount') }}",
                        method: 'get',
                        data: {
                            id: cash.cashacc
                        },
                        success: function (cashAcc) {
                            $('#cashacc').val(cashAcc.idplan).select2();
                        }
                    });

                    $.ajax({
                        url: "{{ url('getAccount') }}",
                        method: 'get',
                        data: {
                            id: cash.misacc
                        },
                        success: function (misAcc) {
                            $('#misacc').val(misAcc.idplan).select2();
                        }
                    });

                    $.ajax({
                        url: "{{ url('getAccount') }}",
                        method: 'get',
                        data: {
                            id: cash.excacc
                        },
                        success: function (excAcc) {
                            $('#excacc').val(excAcc.idplan).select2();
                        }
                    });

                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit edit"></button>');

                    $('#form').show();
                }
            });
        }

        function remove(idcash) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.cash_del_text')',
                closeOnClickOutside: false,
                allowOutsideClick: false,
                closeOnEsc: false,
                buttons: {
                    cancel: {
                        text: ' @lang('confirm.no')',
                        value: false,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-red fa fa-close"
                    },
                    confirm: {
                        text: ' @lang('confirm.yes')',
                        value: true,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-green fa fa-check"
                    },
                },
            }).then(function (isConfirm) {
                if (isConfirm) {
                    $('#cash').val(idcash);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#form').hide();
            in_out_form();
        });

        function in_out_form() {
            setDisabled(false);
            
            $('#title').text('@lang('label.new_cash')');
            $('#idcash').val('');
            $('.fillform :input').val('');
            $('.fillform :input[type="checkbox"]').prop('checked', false);
            $('.select2').val('').select2();
            $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }

        function submitForm() {
            var text = "@lang('confirm.cash_save_text')";
            if ($('#idcash').val() !== '') {
                text = "@lang('confirm.cash_edit_text')";
            }

            mySwal("{{ $title }}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#cashForm');
        }
    </script>
@stop
