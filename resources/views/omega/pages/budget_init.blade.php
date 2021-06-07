{{--    $title = 'Initialisation Budget';--}}
{{--    $title = 'Budget Initialisation';--}}

<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.budget_init'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.budget_init') </h3>
        </div>
        <div class="box-body">
            <form action="{{ url('budget_init/store') }}" method="POST" role="form" id="budgetForm">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group">
                            <div class="radio">
                                <label for="exp">
                                    <input type="radio" name="type" class="type" id="exp" value="E">@lang('label.budget_exp')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group">
                            <div class="radio">
                                <label for="inv">
                                    <input type="radio" name="type" class="type" id="inv" value="I">@lang('label.budget_inv')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-xs-6">
                        <div class="form-group">
                            <label for="branch" class="col-md-3 control-label"> @lang('label.branch')</label>
                            <div class="col-md-9">
                                <select class="form-control select2" name="branch" id="branch" disabled>
                                    <option value=""></option>
                                    @foreach($branches as $branch)
                                        @if ($emp->branch === $branch->idbranch)
                                            <option value="{{$branch->idbranch}}" selected>{{$branch->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <div class="form-group">
                            <label for="service" class="col-md-4 control-label"> @lang('label.service')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" name="service" id="service">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="direction" class="col-md-4 col-xs-3 control-label"> @lang('label.direction')</label>
                            <div class="col-md-8 col-xs-9">
                                <select class="form-control select2" name="direction" id="direction">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label for="account" class="col-md-2 col-xs-3 control-label"> @lang('label.account')</label>
                            <div class="col-md-4 col-xs-9">
                                <select class="form-control select2" name="account" id="account">
                                    <option value=""></option>
                                    {{--                                    @foreach($accounts as $account)--}}
                                    {{--                                        <option value="{{$account->idaccount}}">{{$account->accnumb}}</option>--}}
                                    {{--                                    @endforeach--}}
                                </select>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <input type="text" name="acc_name" id="acc_name" class="form-control"
                                       disabled="disabled">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <div class="form-group">
                            <label for="budget_line" class="col-md-4 control-label"> @lang('label.budget_line')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" name="budget_line" id="budget_line">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-6">
                        <div class="form-group">
                            <label for="budget_amt" class="col-md-4 control-label"> @lang('label.amount')</label>
                            <div class="col-md-8">
                                <input type="text" name="budget_amt" id="budget_amt" class="form-control text-bold amt text-right">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <label for="jan" class="col-md-4 text-black control-label"> @lang('label.jan')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-right text-bold mon_amt" name="jan" id="jan" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <label for="feb" class="col-md-4 text-black control-label"> @lang('label.feb')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-right text-bold mon_amt" name="feb" id="feb" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <label for="mar" class="col-md-4 text-black control-label"> @lang('label.mar')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-right text-bold mon_amt" name="mar" id="mar" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <label for="apr" class="col-md-4 text-black control-label"> @lang('label.apr')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-right text-bold mon_amt" name="apr" id="apr" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <label for="may" class="col-md-4 text-black control-label"> @lang('label.may')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-right text-bold mon_amt" name="may" id="may" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <label for="jun" class="col-md-4 text-black control-label"> @lang('label.jun')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-right text-bold mon_amt" name="jun" id="jun" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <label for="jul" class="col-md-4 text-black control-label"> @lang('label.jul')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-right text-bold mon_amt" name="jul" id="jul" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <label for="aug" class="col-md-4 text-black control-label"> @lang('label.aug')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-right text-bold mon_amt" name="aug" id="aug" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <label for="sep" class="col-md-4 text-black control-label"> @lang('label.sep')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-right text-bold mon_amt" name="sep" id="sep" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <label for="oct" class="col-md-4 text-black control-label"> @lang('label.oct')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-right text-bold mon_amt" name="oct" id="oct" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <label for="nov" class="col-md-4 text-black control-label"> @lang('label.nov')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-right text-bold mon_amt" name="nov" id="nov" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <label for="dec" class="col-md-4 text-black control-label"> @lang('label.dec')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-right text-bold mon_amt" name="dec" id="dec" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <button type="button" id="save" class="btn bg-blue pull-right btn-sm btn-raised fa fa-save"></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('.type').click(function () {
            $('#budget_amt').val('');
            $('.mon_amt').each(function () {
                $(this).val('');
            });

            if ($(this).is(':checked')) {
                if ($(this).val() === 'E') {
                    $.ajax({
                        url: "{{ url('getAccounts') }}",
                        method: 'get',
                        success: function (accounts) {
                            let option = "<option value=''></option>";
                            $.each(accounts, function (i, account) {
                                let classe = parseInt(account.class);

                                if (classe === 6 || classe === 7) {
                                    option += "<option value=" + account.idaccount + ">" + pad(account.accnumb, 12) + "</option>";
                                }
                            });
                            $('#account').html(option);
                        }
                    });
                    $('#budget_amt').attr('disabled', false)
                } else if ($(this).val() === 'I') {
                    $.ajax({
                        url: "{{ url('getAccounts') }}",
                        method: 'get',
                        success: function (accounts) {
                            let option = "<option value=''></option>";
                            $.each(accounts, function (i, account) {
                                let classe = parseInt(account.class);
                                if (classe === 2) {
                                    option += "<option value=" + account.idaccount + ">" + pad(account.accnumb, 12) + "</option>";
                                }
                            });
                            $('#account').html(option);
                        }
                    });
                    $('#budget_amt').attr('disabled', true)
                }
            }
        });

        $('#account').change(function () {
            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getAccount') }}",
                    method: 'get',
                    data: {
                        account: $('#account').val()
                    },
                    success: function (result) {
                        $('#acc_name').val("@if($emp->lang == 'fr')" + result.labelfr + " @else" + result.labeleng + " @endif");
                    }
                });
            } else {
                $('#acc_name').val('');
            }
        });

        $(document).on('keyup', '#budget_amt', function () {
            let amount = trimOver($(this).val(), null);
            let dist = parseFloat(amount / 12);
            console.log(Math.round(dist));

            $('.mon_amt').each(function () {
                $(this).val(money(dist));
            });
        });

        $(document).on('input', '.amt, .mon_amt', function () {
            $(this).val(money($(this).val()));
        });

        $(document).on('input', '.mon_amt', function () {
            sumAmount();
        });

        function sumAmount() {
            let sumAmt = 0;

            $('.mon_amt').each(function () {
                let amount = trimOver($(this).val(), null);
                if (parseInt(amount)) {
                    sumAmt += parseInt(amount);
                }
            });

            $('#budget_amt').val(money(sumAmt));
        }

        $('#save').click(function () {
            let sumAmt = 0;

            $('.mon_amt').each(function () {
                let amount = trimOver($(this).val(), null);
                if (parseInt(amount)) {
                    sumAmt += parseInt(amount);
                }
            });

            let tot_amt = trimOver($('#budget_amt').val(), null);

            if (sumAmt === parseInt(tot_amt)) {
                mySwal('@lang('sidebar.budget_init')', '@lang('confirm.budget_init_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#budgetForm');
            } else {
                myOSwal('@lang('sidebar.budget_init')', '@lang('confirm.budget_init_error_text')', 'error');
            }
        });
    </script>
@stop
