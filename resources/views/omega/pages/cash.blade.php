<?php $emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.cash'))

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="box-tools">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            @if ($cashes->count() != 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            {{ $cashes->links('layouts.includes.pagination') }}
                        </div>
                    </div>
                </div>
            @endif
            <form action="{{ url('cash/store') }}" method="post" role="form" id="cashForm">
                {{csrf_field()}}
                @if ($cashes->count() == 0)
                    <div class="box-header with-border" id="form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cashcode" class="col-md-6 control-label">@lang('label.cash')</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="cashcode" value="PC" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="cashfr"
                                           placeholder="@lang('placeholder.cashfr')">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="casheng"
                                               placeholder="@lang('placeholder.casheng')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cashacc" class="col-md-6 control-label">@lang('label.account')</label>
                                    <div class="col-md-6">
                                        <select class="form-control select2" name="cashacc">
                                            <option></option>
                                            @foreach($accounts as $account)
                                                @if (substrWords($account->accnumb) == '57')
                                                    <option
                                                        value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="accname" id="accname" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="hidden" name="employee" value="{{$emp->idemp}}">
                                        <select class="form-control select2" disabled>
                                            <option
                                                value="{{$emp->idemp}}">{{$emp->name}} {{$emp->surname}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="misacc" class="col-md-4 control-label">@lang('label.misacc')</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" name="misacc">
                                            <option></option>
                                            @foreach($accounts as $account)
                                                <option value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="excacc" class="col-md-4 control-label">@lang('label.excacc')</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" name="excacc">
                                            <option></option>
                                            @foreach($accounts as $account)
                                                <option value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
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
                                        <td id="bil">{{$money->value}}</td>
                                        <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                        <td id="mon{{$money->idmoney}}" class="input"></td>
                                        <td class="sum text-right" id="{{$money->moncode}}Sum"></td>
                                        <td class="text-light-blue word"></td>
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
                                        <td id="mon{{$money->idmoney}}" class="input"></td>
                                        <td class="sum text-right" id="{{$money->moncode}}Sum"></td>
                                        <td class="text-light-blue word"></td>
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

                    <div class="col-md-12">
                        <button type="button" id="delete"
                                class="btn btn-sm bg-red pull-right btn-raised fa fa-trash" disabled>
                        </button>
                        <button type="button" id="update"
                                class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle" disabled>
                        </button>
                        <button type="button" id="save"
                                class="btn btn-sm bg-blue pull-right btn-raised fa fa-save">
                        </button>
                    </div>
                @else
                    @foreach ($cashes as $cash)
                        <div class="box-header with-border" id="form">
                            <input type="hidden" id="idcash" name="idcash" value="{{$cash->idcash}}">
                            <div class="row">
                                <div class="col-md-4">
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
                                        <input type="text" class="form-control" name="cashfr" id="cashfr"
                                               value="{{$cash->labelfr}}" placeholder="@lang('placeholder.cashfr')"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="casheng" id="casheng"
                                                   value="{{$cash->labeleng}}"
                                                   placeholder="@lang('placeholder.casheng')"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cashacc"
                                               class="col-md-6 control-label">@lang('label.account')</label>
                                        <div class="col-md-6">
                                            <select class="form-control select2" name="cashacc" id="cashacc" disabled>
                                                <option></option>
                                                @foreach($accounts as $account)
                                                    @if (substrWords($account->accnumb) == '57')
                                                        @if ($cash->cashacc == $account->idaccount)
                                                            <option value="{{$account->idaccount}}"
                                                                    selected>{{$account->accnumb}}</option>
                                                        @else
                                                            <option
                                                                value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        @foreach($accounts as $account)
                                            @if ($cash->cashacc == $account->idaccount)
                                                <input type="text" class="form-control" name="accname" id="accname"
                                                       readonly
                                                       value="@if ($emp->lang == 'fr'){{$account->labelfr}}@else{{$account->labeleng}}@endif">
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <select name="employee" id="employee" class="form-control select2" disabled>
                                                <option>@lang('placeholder.employee')</option>
                                                @foreach($employees as $employee)
                                                    @if ($cash->employee == $employee->idemp)
                                                        <option value="{{$employee->idemp}}"
                                                                selected>{{$employee->name}} {{$employee->surname}}</option>
                                                    @else
                                                        <option
                                                            value="{{$employee->idemp}}">{{$employee->name}} {{$employee->surname}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="misacc" class="col-md-4 control-label">@lang('label.misacc')</label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" name="misacc" id="misacc" disabled>
                                                <option></option>
                                                @foreach($accounts as $account)
                                                    @if ($cash->misacc == $account->idaccount)
                                                        <option value="{{$account->idaccount}}"
                                                                selected>{{$account->accnumb}}</option>
                                                    @else
                                                        <option
                                                            value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="excacc" class="col-md-4 control-label">@lang('label.excacc')</label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" name="excacc" id="excacc" disabled>
                                                <option></option>
                                                @foreach($accounts as $account)
                                                    @if ($cash->excacc == $account->idaccount)
                                                        <option value="{{$account->idaccount}}"
                                                                selected>{{$account->accnumb}}</option>
                                                    @else
                                                        <option
                                                            value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
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
                                            <td id="bil">{{$money->value}}</td>
                                            <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                            <td id="mon{{$money->idmoney}}"
                                                class="input">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                            <td class="sum text-right" id="{{$money->moncode}}Sum">
                                                {{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                            <td class="text-light-blue word">{{digitToWord($money->value * $cash->{'mon'.$money->idmoney}) }}</td>
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
                                            <td id="mon{{$money->idmoney}}"
                                                class="input">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                            <td class="sum text-right" id="{{$money->moncode}}Sum">
                                                {{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                            <td class="text-light-blue word">{{digitToWord($money->value * $cash->{'mon'.$money->idmoney}) }}</td>
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

                        <div class="col-md-12">
                            <button type="button" id="delete"
                                    class="btn btn-sm bg-red pull-right btn-raised fa fa-trash"></button>
                            <button type="button" id="update"
                                    class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle"></button>
                            <button type="button" id="insert"
                                    class="btn btn-sm bg-blue pull-right btn-raised fa fa-file-o"></button>
                        </div>
                    @endforeach
                @endif
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            let sumIn = 0;

            $('.sum').each(function () {
                if (parseInt(trimOver($(this).text(), null)))
                    sumIn += parseInt(trimOver($(this).text(), null));
            });
            $('#totbil').text(money(sumIn));
            $('#totopera').text(toWord(sumIn, '{{$emp->lang}}'));
        });

        $('#insert').click(function () {
            setEditable();
            $('#cashcode').removeAttr('readonly');
            $('#form :input').val('');
            $('.input, .sum, .word').each(function () {
                $(this).text('');
            });
            $('#totbil').text('');
            $('.select2').select2().trigger('change');
            $(this).replaceWith('<button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
            $('.bg-aqua, .fa-trash').attr('disabled', true);
        });

        $('#update').click(function () {
            setEditable();
            $(this).replaceWith('<button type="button" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>');
        });

        $(document).on('click', '#save, #edit', function () {
            let text = '';
            if ($('#idcash').val() === '')
                text = '@lang('confirm.cassave_text')';
            else
                text = '@lang('confirm.casedit_text')';

            swal({
                    title: '@lang('sidebar.cash')',
                    text: text,
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
                        $('#cashForm').submit();
                    }
                }
            );
        });

        $('#delete').click(function () {
            swal({
                    title: '@lang('sidebar.cash')',
                    text: '@lang('confirm.casdel_text')',
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
                        let form = $('#cashForm');
                        form.attr('action', 'cash/delete');
                        form.submit();
                    }
                }
            );
        });

        function setEditable() {
            $('#cashfr, #casheng').removeAttr('readonly');
            $('.modif').each(function () {
                $(this).removeAttr('readonly');
            });
            $('.select2').removeAttr('disabled');
        }

        $('#cashacc').change(function () {
            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getAccount') }}",
                    method: 'get',
                    data: {
                        account: $(this).val()
                    },
                    success: function (result) {
                        $('#accname').val("@if($emp->lang == 'fr')" + result.labelfr + " @else" + result.labeleng + " @endif");
                    }
                });
            } else {
                $('#accname').val('');
            }
        });
    </script>
@stop
