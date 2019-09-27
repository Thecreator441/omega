<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.reject'))

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('loan_reject/store') }}" method="POST" role="form" id="rejectForm">
                {{csrf_field()}}
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="loan" class="col-md-5 control-label">@lang('label.loanno')</label>
                                <div class="col-md-7">
                                    <select class="form-control select2" name="loan" id="loan">
                                        <option></option>
                                        @foreach ($loans as $loan)
                                            <option value="{{$loan->iddemloan}}">{{pad($loan->demloanno, 6)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="member" class="col-md-5 control-label">@lang('label.member')</label>
                                <div class="col-md-7">
                                    <input type="text" name="member" id="member" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-12">
                                <input type="text" name="mem_name" id="mem_name" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="loanamt" class="col-md-5 control-label">@lang('label.demamt')</label>
                                <div class="col-md-7">
                                    <input type="text" id="loanamt"
                                           class="form-control text-bold text-right" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="period" class="col-md-5 control-label">@lang('label.periodicity')</label>
                                <div class="col-md-7">
                                    <select id="period" class="form-control select2" disabled>
                                        <option value=""></option>
                                        <option value="D">@lang('label.daily')</option>
                                        <option value="W">@lang('label.weekly')</option>
                                        <option value="B">@lang('label.bimens')</option>
                                        <option value="M">@lang('label.mens')</option>
                                        <option value="T">@lang('label.trim')</option>
                                        <option value="S">@lang('label.sem')</option>
                                        <option value="A">@lang('label.ann')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="amorti" class="col-md-4 control-label">@lang('label.amort')</label>
                                <div class="col-md-8">
                                    <select id="amorti" class="form-control select2" disabled>
                                        <option value=""></option>
                                        <option value="C">@lang('label.constamort')</option>
                                        <option value="V">@lang('label.varamort')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="grace" class="col-md-5 control-label">@lang('label.grace')</label>
                                <div class="col-md-7">
                                    <select name="grace" id="grace" class="form-control select2" disabled>
                                        <option value=""></option>
                                        <option value="1">@lang('label.day1')</option>
                                        <option value="7">@lang('label.week1')</option>
                                        <option value="15">@lang('label.mon1/2')</option>
                                        <option value="30">@lang('label.mon1')</option>
                                        <option value="90">@lang('label.trim1')</option>
                                        <option value="180">@lang('label.sem1')</option>
                                        <option value="360">@lang('label.ann1')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="numb_inst" class="col-md-5 control-label">@lang('label.noinstal')</label>
                                <div class="col-md-7">
                                    <input type="text" id="numb_inst" class="form-control text-right" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="int_rate" class="col-md-5 control-label">@lang('label.monintrate')</label>
                                <div class="col-md-7">
                                    <input type="text" id="int_rate" class="form-control text-right" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tax_rate" class="col-md-5 control-label">@lang('label.taxrate')</label>
                                <div class="col-md-7">
                                    <input type="text" id="tax_rate" class="form-control text-right" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inst1" class="col-md-5 control-label">@lang('label.inst1')</label>
                                <div class="col-md-7">
                                    <input type="date" id="date" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            {{--                            <div class="form-group">--}}
                            {{--                                <button type="button" id="print"--}}
                            {{--                                        class="btn btn-sm bg-default pull-right btn-raised fa fa-print"></button>--}}
                            {{--                                <button type="button" id="display"--}}
                            {{--                                        class="btn btn-sm bg-green pull-right btn-raised fa fa-eye"></button>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                </div>

                {{--                <div class="col-md-12">--}}
                {{--                    <table class="table table-bordered table-striped table-hover table-condensed table-responsive">--}}
                {{--                        <thead>--}}
                {{--                        <tr class="text-center text-bold">--}}
                {{--                            <th>@lang('label.install')</th>--}}
                {{--                            <th>@lang('label.capital')</th>--}}
                {{--                            <th>@lang('label.amort')</th>--}}
                {{--                            <th>@lang('label.interest')</th>--}}
                {{--                            <th>@lang('label.annuity')</th>--}}
                {{--                            <th>@lang('label.tax')</th>--}}
                {{--                            <th>@lang('label.total')</th>--}}
                {{--                            <th>@lang('label.date')</th>--}}
                {{--                        </tr>--}}
                {{--                        </thead>--}}
                {{--                        <tbody id="amorDisplay">--}}
                {{--                        </tbody>--}}
                {{--                        <tfoot id="tableInput">--}}
                {{--                        <tr>--}}
                {{--                            <td></td>--}}
                {{--                            <td><input type="text" disabled></td>--}}
                {{--                            <td><input type="text" name="amoAmt" id="amoAmt" class="text-bold text-blue text-right"--}}
                {{--                                       readonly></td>--}}
                {{--                            <td><input type="text" name="intAmt" id="intAmt" class="text-bold text-blue text-right"--}}
                {{--                                       readonly></td>--}}
                {{--                            <td><input type="text" name="annAmt" id="annAmt" class="text-bold text-blue text-right"--}}
                {{--                                       readonly></td>--}}
                {{--                            <td><input type="text" name="taxAmt" id="taxAmt" class="text-bold text-blue text-right"--}}
                {{--                                       readonly></td>--}}
                {{--                            <td><input type="text" name="totAmt" id="totAmt" class="text-bold text-blue text-right"--}}
                {{--                                       readonly></td>--}}
                {{--                            <td></td>--}}
                {{--                        </tr>--}}
                {{--                        </tfoot>--}}
                {{--                    </table>--}}
                {{--                </div>--}}

                <div class="col-md-12">
                    <div class="col-md-12">
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
        $('#loan').change(function () {
            $.ajax({
                url: "{{ url('getDemLoan') }}",
                method: 'get',
                data: {
                    loan: $(this).val()
                },
                success: function (loan) {
                    $.ajax({
                        url: "{{ url('getMember') }}",
                        method: 'get',
                        data: {
                            member: loan.member
                        },
                        success: function (member) {
                            $('#member').val(pad(member.memnumb, 6));
                            if (member.surname === null) {
                                $('#mem_name').val(member.name);
                            } else {
                                $('#mem_name').val(member.name + ' ' + member.surname);
                            }
                        }
                    });
                    $('#loanamt').val(money(parseInt(loan.amount)));
                    $('#period').val(loan.periodicity).trigger('change');
                    $('#amorti').val(loan.amortype).trigger('change');
                    $('#grace').val(loan.grace).trigger('change');
                    $('#numb_inst').val(loan.nbrinst);
                    $('#tax_rate').val();
                    $('#int_rate').val(loan.intrate);
                    $('#date').val(formDate(loan.grace));
                }
            });
        });

        $(document).on('click', '#save', function () {
            let loan = parseInt($('#loan').val());

            if (!isNaN(loan)) {
                swal({
                        title: '@lang('sidebar.reject')',
                        text: '@lang('confirm.reject_text')',
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
                            $('#rejectForm').submit();
                        }
                    }
                );
            } else {
                swal({
                        title: '@lang('sidebar.reject')',
                        text: '@lang('confirm.rejecterr_text')',
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
