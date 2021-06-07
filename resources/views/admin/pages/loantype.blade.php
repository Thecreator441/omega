<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.loantype'))

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        {{ $loantypes->links('layouts.includes.pagination') }}
                    </div>
                </div>
            </div>
            <form action="{{ route('admin/loantype/store') }}" method="post" role="form" id="loanTypeForm">
                {{ csrf_field() }}
                <div id="form">
                    @if ($loantypes->count() == 0)
                        <div class="box-header with-border">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="loaneng"
                                               class="col-md-3 control-label">@lang('label.labeleng')</label>
                                        <div class="col-md-9">
                                            <input type="text" name="loaneng" id="loaneng" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="loanfr"
                                               class="col-md-3 control-label">@lang('label.labelfr')</label>
                                        <div class="col-md-9">
                                            <input type="text" name="loanfr" id="loanfr" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="maxdur"
                                               class="col-md-6 control-label">@lang('label.maxdur')</label>
                                        <div class="col-md-6">
                                            <input type="text" name="maxdur" id="maxdur"
                                                   class="form-control text-right">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="maxamt"
                                               class="col-md-6 control-label">@lang('label.maxamt')</label>
                                        <div class="col-md-6">
                                            <input type="text" name="maxamt" id="maxamt"
                                                   class="form-control text-right text-bold">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inst&pen"
                                               class="col-md-6 control-label">@lang('label.inst&pen')</label>
                                        <div class="col-md-6">
                                            <input type="text" name="inst&pen" id="inst&pen" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loanacc"
                                               class="col-md-6 control-label">@lang('label.loanacc')</label>
                                        <div class="col-md-6">
                                            <select name="loanacc" id="loanacc" class="form-control select2">
                                                <option value=""></option>
                                                @foreach ($accounts as $account)
                                                    <option
                                                        value="{{$account->idaccount}}">{{$account->accplan}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="period"
                                               class="col-md-5 control-label">@lang('label.periodicity')</label>
                                        <div class="col-md-7">
                                            <select id="period" name="period" class="form-control select2">
                                                <option value=""></option>
                                                <option value="D">@lang('label.daily')</option>
                                                <option value="W">@lang('label.weekly')</option>
                                                <option value="B">@lang('label.bimens')</option>
                                                <option value="M" selected>@lang('label.mens')</option>
                                                <option value="T">@lang('label.trim')</option>
                                                <option value="S">@lang('label.sem')</option>
                                                <option value="A">@lang('label.ann')</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="intpayacc"
                                               class="col-md-3 control-label">@lang('label.intpayacc')</label>
                                        <div class="col-md-3">
                                            <div class="row">
                                                <select name="intpayacc" id="intpayacc" class="form-control select2">
                                                    <option value=""></option>
                                                    @foreach ($accounts as $account)
                                                        @if (substrWords($account->accnumb, 1) == 7)
                                                            <option
                                                                value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="intacc_name" id="intacc_name" class="form-control"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label for="penreg">
                                                    <input type="checkbox" name="penreg" id="penreg" value="Y">&nbsp;&nbsp;
                                                    @lang('label.penreg')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="penRegInfo" style="display: none">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="taxpen"
                                                       class="col-md-6 control-label">@lang('label.taxpen')</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="taxpen" id="taxpen"
                                                           class="form-control text-right">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="penacc"
                                                       class="col-md-5 control-label">@lang('label.penacc')</label>
                                                <div class="col-md-7">
                                                    <select name="penacc" id="penacc" class="form-control select2">
                                                        <option value=""></option>
                                                        @foreach ($accounts as $account)
                                                            @if (substrWords($account->accnumb, 1) == 6)
                                                                <option
                                                                    value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="penacc_name" id="penacc_name"
                                                           class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <button type="button" id="delete" disabled
                                                class="btn btn-sm bg-red pull-right btn-raised fa fa-trash">
                                        </button>
                                        <button type="button" id="update" disabled
                                                class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle">
                                        </button>
                                        <button type="button" id="save"
                                                class="btn btn-sm bg-blue pull-right btn-raised fa fa-save">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach ($loantypes as $loantype)
                            <input type="hidden" id="idloantype" name="idloantype" value="{{$loantype->idltype}}">
                            <div class="box-header with-border">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="loaneng"
                                                   class="col-md-3 control-label">@lang('label.labeleng')</label>
                                            <div class="col-md-9">
                                                <input type="text" name="loaneng" id="loaneng" class="form-control"
                                                       value="{{$loantype->labeleng}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="loanfr"
                                                   class="col-md-3 control-label">@lang('label.labelfr')</label>
                                            <div class="col-md-9">
                                                <input type="text" name="loanfr" id="loanfr" class="form-control"
                                                       value="{{$loantype->labelfr}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="maxdur"
                                                   class="col-md-6 control-label">@lang('label.maxdur')</label>
                                            <div class="col-md-6">
                                                <input type="text" name="maxdur" id="maxdur"
                                                       class="form-control text-right" readonly
                                                       value="{{$loantype->maxdur}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="maxamt"
                                                   class="col-md-6 control-label">@lang('label.maxamt')</label>
                                            <div class="col-md-6">
                                                <input type="text" name="maxamt" id="maxamt"
                                                       class="form-control text-right text-bold" readonly
                                                       value="{{money((int)$loantype->maxamt)}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inst&pen"
                                                   class="col-md-6 control-label">@lang('label.inst&pen')</label>
                                            <div class="col-md-6">
                                                <input type="text" name="inst&pen" id="inst&pen" class="form-control"
                                                       readonly
                                                       value="{{$loantype->datescapepen}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="loanacc"
                                                   class="col-md-6 control-label">@lang('label.loanacc')</label>
                                            <div class="col-md-6">
                                                <select name="loanacc" id="loanacc" class="form-control select2"
                                                        disabled>
                                                    <option></option>
                                                    @foreach ($accounts as $account)
                                                        @if ($account->idaccount == $loantype->loanaccart)
                                                            <option value="{{$account->idaccount}}"
                                                                    selected>{{$account->accplan}}</option>
                                                        @else
                                                            <option
                                                                value="{{$account->idaccount}}">{{$account->accplan}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="period"
                                                   class="col-md-5 control-label">@lang('label.periodicity')</label>
                                            <div class="col-md-7">
                                                <select id="period" name="period" class="form-control select2">
                                                    <option value=""></option>
                                                    <option value="D"
                                                            @if ($loantype->period == 'D') selected @endif>@lang('label.daily')</option>
                                                    <option value="W"
                                                            @if ($loantype->period == 'W') selected @endif>@lang('label.weekly')</option>
                                                    <option value="B"
                                                            @if ($loantype->period == 'B') selected @endif>@lang('label.bimens')</option>
                                                    <option value="M"
                                                            @if ($loantype->period == 'M') selected @endif>@lang('label.mens')</option>
                                                    <option value="T"
                                                            @if ($loantype->period == 'T') selected @endif>@lang('label.trim')</option>
                                                    <option value="S"
                                                            @if ($loantype->period == 'S') selected @endif>@lang('label.sem')</option>
                                                    <option value="A"
                                                            @if ($loantype->period == 'A') selected @endif>@lang('label.ann')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="intpayacc"
                                                   class="col-md-3 control-label">@lang('label.intpayacc')</label>
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <select name="intpayacc" id="intpayacc" class="form-control select2"
                                                            disabled>
                                                        <option value=""></option>
                                                        @foreach ($accounts as $account)
                                                            @if (substrWords($account->accnumb, 1) == 7)
                                                                @if ($account->idaccount == $loantype->intacc)
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
                                            <div class="col-md-6">
                                                @foreach ($accounts as $account)
                                                    @if (substrWords($account->accnumb, 1) == 7)
                                                        @if ($account->idaccount == $loantype->intacc)
                                                            <input type="text" name="intacc_name" id="intacc_name"
                                                                   class="form-control" disabled
                                                                   value="@if ($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif">
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label for="penreg">
                                                        <input type="checkbox" name="penreg" id="penreg" value="Y"
                                                               @if ($loantype->penreq == 'Y') checked @endif disabled>&nbsp;&nbsp;
                                                        @lang('label.penreg')</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="penRegInfo" style="display: none">
                                        <div class="col-md-12">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="taxpen"
                                                           class="col-md-6 control-label">@lang('label.taxpen')</label>
                                                    <div class="col-md-6">
                                                        <input type="text" name="taxpen" id="taxpen" readonly
                                                               value="{{round($loantype->pentax)}}"
                                                               class="form-control text-right">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="penacc"
                                                           class="col-md-5 control-label">@lang('label.penacc')</label>
                                                    <div class="col-md-7">
                                                        <select name="penacc" id="penacc" class="form-control select2"
                                                                disabled>
                                                            <option></option>
                                                            @foreach ($accounts as $account)
                                                                @if (substrWords($account->accnumb, 1) == 6)
                                                                    @if ($account->idaccount == $loantype->penacc)
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
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        @foreach ($accounts as $account)
                                                            @if (substrWords($account->accnumb, 1) == 6)
                                                                @if ($account->idaccount == $loantype->penacc)
                                                                    <input type="text" name="penacc_name"
                                                                           id="penacc_name"
                                                                           class="form-control" disabled
                                                                           value="@if ($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif">
                                                                @endif
                                                            @endIf
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <button type="button" id="delete"
                                                class="btn btn-sm bg-red pull-right btn-raised fa fa-trash">
                                        </button>
                                        <button type="button" id="update"
                                                class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle">
                                        </button>
                                        <button type="button" id="insert"
                                                class="btn btn-sm bg-blue pull-right btn-raised fa fa-file-o">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            verifCheckbox();
        });

        $('#maxamt').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $('#insert').click(function () {
            setEditable();
            $('#form :input').val('');
            $('#form input[type="radio"], #loanTypeForm input[type="checkbox"]').removeAttr('checked');
            $('.select2').select2().trigger('change');
            $(this).replaceWith('<button class="btn btn-sm bg-blue pull-right btn-raised fa fa-save" id="save" type="button"></button>');
            $('.bg-aqua').replaceWith('<button class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle" disabled id="update" type="button"></button>');
            $('#form .bg-red').attr('disabled', true);
            verifCheckbox();
        });

        $('#update').click(function () {
            setEditable();
            $(this).replaceWith('<button type="button" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>');
        });

        $('input[type="checkbox"]').each(function () {
            $(this).click(function () {
                verifCheckbox();
            })
        });

        $('#intpayacc').change(function () {
            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    account: $(this).val()
                },
                success: function (account) {
                    $('#intacc_name').val("@if($emp->lang == 'fr') " + account.labelfr + " @else " + account.labeleng + " @endif ");
                }
            });
        });

        $('#penacc').change(function () {
            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    account: $(this).val()
                },
                success: function (account) {
                    $('#penacc_name').val("@if($emp->lang == 'fr') " + account.labelfr + " @else " + account.labeleng + " @endif ");
                }
            });
        });

        $(document).on('click', '#save, #edit', function () {
            let text = '';
            if ($('#idloantype').val() === '')
                text = '@lang('confirm.ltypesave_text')';
            else
                text = '@lang('confirm.ltypeedit_text')';

            swal({
                    title: '@lang('sidebar.loantype')',
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
                        $('#loanTypeForm').submit();
                    }
                }
            );
        });

        $('#delete').click(function () {
            swal({
                    title: '@lang('sidebar.loantype')',
                    text: '@lang('confirm.ltypedel_text')',
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
                        let form = $('#loanTypeForm');
                        form.attr('action', 'admin/loantype/delete');
                        form.submit();
                    }
                }
            );
        });

        function setEditable() {
            $('#form :input').removeAttr('readonly');
            $('select, #form input[type="radio"], #form input[type="checkbox"]').removeAttr('disabled');
        }

        function verifCheckbox() {
            if ($('#penreg').is(':checked')) {
                $('#penRegInfo').show();
            } else {
                $('#penRegInfo').hide();
            }
        }
    </script>
@stop
