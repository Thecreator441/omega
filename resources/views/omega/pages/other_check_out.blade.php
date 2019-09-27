<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.ocheout'))

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('other_check_out/store') }}" method="post" role="form" id="ocheoutForm">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bank" class="col-md-3 control-label">@lang('label.bank')</label>
                                <div class="col-md-9">
                                    <select class="form-control select2" name="bank" id="bank">
                                        <option></option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->idbank }}">{{pad($bank->bankcode, 6)}}
                                                : {{$bank->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="checkno" id="checkno" class="form-control"
                                       placeholder="@lang('label.checkno')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="represent" id="represent"
                                           placeholder="@lang('label.carrier')">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                @foreach ($operas as $opera)
                                    @if ($opera->opercode == 41)
                                        <input type="text" class="form-control" disabled
                                               value="{{pad($opera->opercode, 3)}} : @if ($emp->lang == 'fr') {{$opera->labelfr}}@else {{$opera->labeleng}} @endif">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account" class="col-md-2 control-label">@lang('label.account')</label>
                                <div class="col-md-3">
                                    <select class="form-control select2" id="account">
                                        <option></option>
                                        @foreach($accounts as $account)
                                            <option value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <input type="text" class="form-control" name="acc_name" id="acc_name" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="desc" placeholder="@lang('label.desc')">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="form-group">
                                        <input type="text" class="form-control text-right text-bold" id="amount"
                                               placeholder="@lang('label.amount')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="form-group">
                                        <button type="button" id="minus"
                                                class="btn btn-sm bg-red pull-right btn-raised fa fa-minus"></button>
                                        <button type="button" id="plus"
                                                class="btn btn-sm bg-green pull-right btn-raised fa fa-plus"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <table
                        class="table table-striped table-hover table-bordered table-condensed table-responsive no-padding">
                        <thead>
                        <tr>
                            <th colspan="2">@lang('label.account')</th>
                            <th>@lang('label.desc')</th>
                            <th>@lang('label.amount')</th>
                        </tr>
                        </thead>
                        <tbody id="cont">
                        </tbody>
                        <tfoot id="tableInput">
                        <tr>
                            <td colspan="3" class="text-right">@lang('label.totdist')</td>
                            <td class="bg-blue text-right"><input type="text" name="totdist" id="totdist" readonly></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-md-12">
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
            $('#checkno').verifNumber();

            if ($('#cont tr').length === 0) {
                $('#minus').attr('disabled', true);
            }
        });

        $('#account').change(function () {
            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    account: $(this).val()
                },
                success: function (account) {
                    $('#acc_name').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                }
            });
        });

        $('#amount').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $('#plus').click(function () {
            let acc = $('#account');
            let opera = $('#desc');
            let amount = $('#amount');

            let accId = acc.select2('data')[0]['id'];
            let accText = acc.select2('data')[0]['text'];

            let line = '<tr>' +
                '<td style="text-align: center; width: 5%"><input type="checkbox" class="check"></td>' +
                '<td><input type="hidden" name="accounts[]" value="' + accId + '">' + accText + '</td>' +
                '<td><input type="hidden" name="operations[]" value="' + opera.val() + '">' + opera.val() + '</td>' +
                '<td class="text-right text-bold amount"><input type="hidden" name="amounts[]" value="' + amount.val() + '">' + amount.val() + '</td>' +
                '</tr>';

            $('#cont').append(line);
            $('#minus').removeAttr('disabled');

            sumAmount();

            acc.val('').trigger('change');
            opera.val('');
            amount.val('');
            $('#acc_name').val('');
        });

        $('#minus').hover(function () {
            if ($('#cont tr').length === 0)
                $(this).attr('disabled', true);
        });

        $('#minus').click(function () {
            $('.check').each(function () {
                if ($(this).is(':checked'))
                    $(this).closest('tr').remove();

                $('#check').attr('checked', false);
            });
            getDiff();
        });

        function sumAmount() {
            let sum = 0;
            $('.amount').each(function () {
                let numb = trimOver($(this).text(), null);
                if (parseInt(numb))
                    sum += parseInt(numb);
            });

            $('#totdist').val(money(parseInt(sum)));
        }

        $(document).on('click', '#save', function () {
            let tot = parseInt(trimOver($('#totdist').text(), null));
            if (tot !== 0) {
                swal({
                        title: '@lang('sidebar.ocheout')',
                        text: '@lang('confirm.ocheout_text')',
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
                            $('#ocheoutForm').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('sidebar.ocheout')',
                        text: '@lang('confirm.ocouterror_text')',
                        type: 'error',
                        confirmButtonClass: 'bg-blue',
                        confirmButtonText: 'OK',
                        closeOnConfirm: true,
                    }
                );
            }
        });
    </script>
@stop
