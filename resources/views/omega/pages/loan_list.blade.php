<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.list'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.list') </h3>
        </div>
        {{--        <div class="box-header">--}}
        {{--            <div class="box-tools">--}}
        {{--                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div class="box-body">
            <form action="{{ url('loan_list/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="loanap" class="control-label">
                                        <input type="radio" name="filter" id="loanap" value="Ar"
                                               checked>&nbsp;&nbsp;@lang('label.loanap')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="loanal" class="control-label">
                                        <input type="radio" name="filter" id="loanal"
                                               value="Al">&nbsp;&nbsp;@lang('label.loanal')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="rejloan" class="control-label">
                                        <input type="radio" name="filter" id="rejloan"
                                               value="R">&nbsp;&nbsp;@lang('label.rejloan')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="cloloan" class="control-label">
                                        <input type="radio" name="filter" id="cloloan"
                                               value="C">&nbsp;&nbsp;@lang('label.cloloan')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date1" class="col-md-2 control-label">@lang('label.period')</label>
                                <label for="date1"
                                       class="col-md-1 control-label text-right"> @lang('label.from')</label>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <input type="date" name="date1" id="date1" class="form-control">
                                    </div>
                                </div>
                                <label for="date2"
                                       class="col-md-1 control-label text-center">@lang('label.to')</label>
                                <div class="col-md-4">
                                    <input type="date" name="date2" id="date2" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="loanoff" class="col-md-4 control-label">@lang('label.loanoff')</label>
                                <div class="col-md-8">
                                    @if ($emp->privilege == 6)
                                        <select class="form-control select2" name="loanoff" id="loanoff" disabled>
                                            @foreach ($employees as $employee)
                                                @if ($emp->idemp == $employee->idemp)
                                                    <option
                                                        value="{{$employee->iduser}}">{{$employee->username}} {{$employee->surname}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @else
                                        <select class="form-control select2" name="loanoff" id="loanoff">
                                            <option value="0">@lang('label.all')</option>
                                            @foreach ($employees as $employee)
                                                <option
                                                    value="{{$employee->iduser}}">{{$employee->username}} {{$employee->surname}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button type="button" id="search"
                                        class="btn btn-sm bg-green pull-right btn-raised fa fa-search">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table id="admin-data-table"
                               class="table table-striped table-hover table-condensed table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th style="width: 7%">@lang('label.loanno')</th>
                                <th style="width: 7%">@lang('label.member')</th>
                                <th style="width: 30%">@lang('label.name')</th>
                                <th>@lang('label.loanty')</th>
                                <th>@lang('label.loanpur')</th>
                                <th class="cin">@lang('label.amount')</th>
                                <th style="width: 7%">@lang('label.date')</th>
                            </tr>
                            </thead>
                            <tbody id="listReport">
                            @foreach ($loans as $loan)
                                <tr>
                                    <td>{{pad($loan->loanno, 6)}}</td>
                                    @foreach ($members as $member)
                                        @if ($member->idmember == $loan->member)
                                            <td>{{pad($member->memnumb, 6)}}</td>
                                            <td>{{$member->name}} {{$member->surname}}</td>
                                        @endif
                                    @endforeach
                                    @foreach ($ltypes as $ltype)
                                        @if ($ltype->idltype == $loan->loantype)
                                            <td>{{--{{pad($ltype->lcode, 3)}}
                                            : --}}@if ($emp->lang == 'fr') {{$ltype->labelfr}} @else {{$ltype->labeleng}} @endif</td>
                                        @endif
                                    @endforeach
                                    @foreach ($lpurs as $lpur)
                                        @if ($lpur->idloanpur == $loan->loanpur)
                                            <td>{{--{{pad($lpur->purcode, 3)}}
                                            : --}}@if ($emp->lang == 'fr') {{$lpur->labelfr}} @else {{$lpur->labeleng}} @endif</td>
                                        @endif
                                    @endforeach
                                    <td class="text-right text-bold">
                                        @if ($loan->isRef > 1)
                                            {{money((int)$loan->refamt)}}
                                        @else
                                            {{money((int)$loan->amount)}}
                                        @endif
                                    </td>
                                    <td class="text-center">{{changeFormat($loan->appdate)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="button" id="print" class="btn btn-sm bg-default pull-right btn-raised fa fa-print">
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('input[type="radio"]').click(function () {
            $(this).each(function () {
                if ($(this).is(':checked')) {
                    if (($(this).val() === 'Al') || ($(this).val() === 'R')) {
                        fillLoans("{{ url('getFilterDemLoans') }}", $(this).val());
                    } else if (($(this).val() === 'Ar') || ($(this).val() === 'C')) {
                        fillLoans("{{ url('getFilterLoans') }}", $(this).val());
                    }
                }
            });
        });

        $('#search').click(function () {
            $('input[type="radio"]').each(function () {
                if ($(this).is(':checked')) {
                    if (($(this).val() === 'Al') || ($(this).val() === 'R')) {
                        fillLoans("{{ url('getFilterDemLoans') }}", $(this).val(), $('#employee').val(), $('#date1').val(), $('#date2').val());
                    } else if (($(this).val() === 'Ar') || ($(this).val() === 'C')) {
                        fillLoans("{{ url('getFilterLoans') }}", $(this).val(), $('#employee').val(), $('#date1').val(), $('#date2').val());
                    }
                }
            });
        });

        function fillLoans(url, stat, emp = null, dateFr = null, dateTo = null) {
            $.ajax({
                url: url,
                method: 'get',
                data: {
                    loanstat: stat,
                    employee: emp,
                    dateFr: dateFr,
                    dateTo: dateTo
                },
                success: function (loans) {
                    let line = '';
                    $.each(loans, function (i, loan) {
                        let surname = '';
                        if (loan.surname !== null) {
                            surname = loan.surname;
                        }

                        let no = loan.loanno;
                        if (isNaN(loan.loanno)) {
                            no = loan.demloanno;
                        }

                        let amt = loan.amount;
                        if (loan.isRef > 1) {
                            amt = loan.refamt;
                        }

                        line += '<tr>' +
                            '<td style="width: 7%">' + pad(no, 6) + '</td>' +
                            '<td style="width: 7%">' + pad(loan.memnumb, 6) + '</td>' +
                            '<td style="width: 30%">' + loan.name + ' ' + surname + '</td>' +
                            '<td>@if ($emp->lang == 'fr') ' + loan.Ltfr + '@else ' + loan.Lteng + '@endif</td>' +
                            '<td>@if ($emp->lang == 'fr') ' + loan.Lpfr + '@else ' + loan.Lpeng + ' @endif</td>' +
                            '<td class="text-right text-bold cin">' + money(parseInt(amt)) + '</td>' +
                            '<td style="width: 7%" class="text-center">' + userDate(loan.created_at) + '</td>' +
                            '</tr>';
                    });
                    $('#listReport').html(line);
                }
            });
        }

        $('#save').click(function () {
            swal({
                    title: '@lang('sidebar.list')',
                    text: '@lang('confirm.lapp_text')',
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
                        $('#lappForm').submit();
                    }
                }
            );
        });
    </script>
@stop
