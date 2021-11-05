<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('label.inst_param'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('label.inst_param') </h3>
        </div>
        <div class="box-body">
            <form action="{{ url('institution_param/store') }}" method="post" role="form" id="cinForm" class="needs-validation">
                {{ csrf_field() }}

                @if($param === null)
                    <input type="hidden" name="idparam" id="idparam" value="">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-error">
                                <label for="client_acc" class="col-md-2 control-label">@lang('label.client_acc') <span class="text-red text-bold">*</span></label>
                                <div class="col-md-2">
                                    <select name="client_acc" id="client_acc" class="form-control select2" required>
                                        <option value=""></option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->idaccount }}">
                                                {{ $account->accnumb }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="client_acc_name" class="form-control" disabled>
                                    <span class="help-block">@lang('placeholder.client_acc')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-error">
                                <label for="tax_acc" class="col-md-2 control-label">@lang('label.tax_acc') <span class="text-red text-bold">*</span> </label>
                                <div class="col-md-2">
                                    <select name="tax_acc" id="tax_acc" class="form-control select2" required>
                                        <option value=""></option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->idaccount }}">
                                                {{ $account->accnumb }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="tax_acc_name" class="form-control" disabled>
                                    <span class="help-block">@lang('placeholder.tax_acc')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-error">
                                <label for="revenue_acc" class="col-md-2 control-label">@lang('label.revenue_acc') <span class="text-red text-bold">*</span> </label>
                                <div class="col-md-2">
                                    <select name="revenue_acc" id="revenue_acc" class="form-control select2" required>
                                        <option value=""></option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->idaccount }}">
                                                {{ $account->accnumb }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="revenue_acc_name" class="form-control" disabled>
                                    <span class="help-block">@lang('placeholder.revenue_acc')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--                    <div class="row">--}}
                    {{--                        <div class="col-md-12">--}}
                    {{--                            <div class="form-group">--}}
                    {{--                                <label for="pay_revenue_acc" class="col-md-2 control-label">@lang('label.pay_revenue_acc')</label>--}}
                    {{--                                <div class="col-md-2">--}}
                    {{--                                    <select name="pay_revenue_acc" id="pay_revenue_acc" class="form-control select2">--}}
                    {{--                                        <option value=""></option>--}}
                    {{--                                        @foreach($accounts as $account)--}}
                    {{--                                            <option value="{{ $account->idaccount }}">--}}
                    {{--                                                {{ $account->accnumb }}--}}
                    {{--                                            </option>--}}
                    {{--                                        @endforeach--}}
                    {{--                                    </select>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="col-md-8">--}}
                    {{--                                    <input type="text" id="pay_revenue_acc_name" class="form-control" disabled>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h4 for="" class="text-blue text-bold">@lang('sidebar.com_sharing')</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="form-group has-error">
                                    <label for="inst_com" class="col-md-5 control-label">@lang('label.inst_com') <span class="text-red text-bold">*</span></label>
                                    <div class="col-md-7">
                                        <input type="text" name="inst_com" id="inst_com" class="text-bold form-control text-right" required>
                                        <span class="help-block">@lang('placeholder.inst_com')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-error">
                                    <label for="inst_acc" class="col-md-2 control-label">@lang('label.inst_acc') <span class="text-red text-bold">*</span></label>
                                    <div class="col-md-3">
                                        <select name="inst_acc" id="inst_acc" class="form-control select2" required>
                                            <option value=""></option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->idaccount }}">
                                                    {{ $account->accnumb }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="inst_acc_name" class="form-control" disabled>
                                        <span class="help-block">@lang('placeholder.inst_acc')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="form-group has-error">
                                    <label for="col_com" class="col-md-5 control-label">@lang('label.col_com') <span class="text-red text-bold">*</span></label>
                                    <div class="col-md-7">
                                        <input type="text" name="col_com" id="col_com" class="text-bold form-control text-right" required>
                                        <span class="help-block">@lang('placeholder.client_acc')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-error">
                                    <label for="collect_acc" class="col-md-2 control-label">@lang('label.collect_acc') <span class="text-red text-bold">*</span></label>
                                    <div class="col-md-3">
                                        <select name="collect_acc" id="collect_acc" class="form-control select2" required>
                                            <option value=""></option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->idaccount }}">
                                                    {{ $account->accnumb }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="collect_acc_name" class="form-control" disabled>
                                        <span class="help-block">@lang('placeholder.client_acc')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="idparam" id="idparam" value="{{$param->id_inst_param}}">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-error">
                                <label for="client_acc" class="col-md-2 control-label">@lang('label.client_acc') <span class="text-red text-bold">*</span></label>
                                <div class="col-md-2">
                                    <select name="client_acc" id="client_acc" class="form-control select2" required>
                                        <option value=""></option>
                                        @foreach($accounts as $account)
                                            @if ($account->idaccount === $param->client_acc)
                                                <option value="{{$account->idaccount}}" selected>{{$account->accnumb}}</option>
                                            @else
                                                <option value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="client_acc_name" class="form-control" disabled>
                                    <span class="help-block">@lang('placeholder.client_acc')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-error">
                                <label for="tax_acc" class="col-md-2 control-label">@lang('label.tax_acc') <span class="text-red text-bold">*</span></label>
                                <div class="col-md-2">
                                    <select name="tax_acc" id="tax_acc" class="form-control select2" required>
                                        <option value=""></option>
                                        @foreach($accounts as $account)
                                            @if ($account->idaccount === $param->tax_acc)
                                                <option value="{{$account->idaccount}}" selected>{{$account->accnumb}}</option>
                                            @else
                                                <option value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="tax_acc_name" class="form-control" disabled>
                                    <span class="help-block">@lang('placeholder.tax_acc')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-error">
                                <label for="revenue_acc" class="col-md-2 control-label">@lang('label.revenue_acc') <span class="text-red text-bold">*</span></label>
                                <div class="col-md-2">
                                    <select name="revenue_acc" id="revenue_acc" class="form-control select2" required>
                                        <option value=""></option>
                                        @foreach($accounts as $account)
                                            @if ($account->idaccount === $param->revenue_acc)
                                                <option value="{{$account->idaccount}}" selected>{{$account->accnumb}}</option>
                                            @else
                                                <option value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="revenue_acc_name" class="form-control" disabled>
                                    <span class="help-block">@lang('placeholder.revenue_acc')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--                    <div class="row">--}}
                    {{--                        <div class="col-md-12">--}}
                    {{--                            <div class="form-group">--}}
                    {{--                                <label for="pay_revenue_acc" class="col-md-2 control-label">@lang('label.pay_revenue_acc')</label>--}}
                    {{--                                <div class="col-md-2">--}}
                    {{--                                    <select name="pay_revenue_acc" id="pay_revenue_acc" class="form-control select2">--}}
                    {{--                                        <option value=""></option>--}}
                    {{--                                        @foreach($accounts as $account)--}}
                    {{--                                            @if ($account->idaccount === $param->pay_revenue_acc)--}}
                    {{--                                                <option value="{{$account->idaccount}}" selected>{{$account->accnumb}}</option>--}}
                    {{--                                            @else--}}
                    {{--                                                <option value="{{$account->idaccount}}">{{$account->accnumb}}</option>--}}
                    {{--                                            @endif--}}
                    {{--                                        @endforeach--}}
                    {{--                                    </select>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="col-md-8">--}}
                    {{--                                    <input type="text" id="pay_revenue_acc_name" class="form-control" disabled>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h4 for="" class="text-blue text-bold">@lang('sidebar.com_sharing')</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="form-group has-error">
                                    <label for="inst_com" class="col-md-5 control-label">@lang('label.inst_com') <span class="text-red text-bold">*</span></label>
                                    <div class="col-md-7">
                                        <input type="text" name="inst_com" id="inst_com" value="{{$param->inst_com}}" class="text-bold form-control text-right" required>
                                        <span class="help-block">@lang('placeholder.inst_com')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-error">
                                    <label for="inst_acc" class="col-md-2 control-label">@lang('label.inst_acc') <span class="text-red text-bold">*</span></label>
                                    <div class="col-md-3">
                                        <select name="inst_acc" id="inst_acc" class="form-control select2" required>
                                            <option value=""></option>
                                            @foreach($accounts as $account)
                                                @if ($account->idaccount === $param->inst_acc)
                                                    <option value="{{$account->idaccount}}" selected>{{$account->accnumb}}</option>
                                                @else
                                                    <option value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="inst_acc_name" class="form-control" disabled>
                                        <span class="help-block">@lang('placeholder.inst_acc')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="form-group has-error">
                                    <label for="col_com" class="col-md-5 control-label">@lang('label.col_com') <span class="text-red text-bold">*</span></label>
                                    <div class="col-md-7">
                                        <input type="text" name="col_com" id="col_com" value="{{$param->col_com}}" class="text-bold form-control text-right" required>
                                        <span class="help-block">@lang('placeholder.col_com')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-error">
                                    <label for="collect_acc" class="col-md-2 control-label">@lang('label.collect_acc') <span class="text-red text-bold">*</span></label>
                                    <div class="col-md-3">
                                        <select name="collect_acc" id="collect_acc" class="form-control select2" required>
                                            <option value=""></option>
                                            @foreach($accounts as $account)
                                                @if ($account->idaccount === $param->collect_acc)
                                                    <option value="{{$account->idaccount}}" selected>{{$account->accnumb}}</option>
                                                @else
                                                    <option value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="collect_acc_name" class="form-control" disabled>
                                        <span class="help-block">@lang('placeholder.col_acc')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    id: $('#collect_acc').val()
                },
                success: function (account) {
                    $('#collect_acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                }
            });

            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    id: $('#inst_acc').val()
                },
                success: function (account) {
                    $('#inst_acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                }
            });

            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    id: $('#pay_revenue_acc').val()
                },
                success: function (account) {
                    $('#pay_revenue_acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                }
            });

            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    id: $('#client_acc').val()
                },
                success: function (account) {
                    $('#client_acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                }
            });

            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    id: $('#revenue_acc').val()
                },
                success: function (account) {
                    $('#revenue_acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                }
            });

            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    id: $('#tax_acc').val()
                },
                success: function (account) {
                    $('#tax_acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                }
            });

        });

        $('#collect_acc').change(function () {
            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    id: $('#collect_acc').val()
                },
                success: function (account) {
                    $('#collect_acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                }
            });
        });

        $('#inst_acc').change(function () {
            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    id: $('#inst_acc').val()
                },
                success: function (account) {
                    $('#inst_acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                }
            });
        });

        $('#pay_revenue_acc').change(function () {
            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    id: $('#pay_revenue_acc').val()
                },
                success: function (account) {
                    $('#pay_revenue_acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                }
            });
        });

        $('#client_acc').change(function () {
            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    id: $('#client_acc').val()
                },
                success: function (account) {
                    $('#client_acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                }
            });
        });

        $('#revenue_acc').change(function () {
            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    id: $('#revenue_acc').val()
                },
                success: function (account) {
                    $('#revenue_acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                }
            });
        });

        $('#tax_acc').change(function () {
            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    id: $('#tax_acc').val()
                },
                success: function (account) {
                    $('#tax_acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                }
            });
        });

        function submitForm() {
            let text = '@lang('confirm.inspasave_text')';
            if ($('#idparam').val() !== '') {
                text = '@lang('confirm.inspaedit_text')';
            }

            mySwal('@lang('sidebar.institute')', text, '@lang('confirm.no')', '@lang('confirm.yes')', '#cinForm');
        }
    </script>
@stop
