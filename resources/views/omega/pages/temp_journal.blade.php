<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr') {
    App::setLocale('fr');
    $title = 'Journal Temporaire';
} else {
    $title = 'Temporal Journal';
}
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('temp_journal/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="general" class="text-blue">
                                        <input type="radio" name="state" id="general" checked>&nbsp;@lang('label.gen')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="cin" class="text-green">
                                        <input type="radio" name="state" id="cin">&nbsp;@lang('sidebar.cin')</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="cout" class="text-yellow">
                                        <input type="radio" name="state" id="cout">&nbsp;@lang('sidebar.cout')</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="forced" class="text-red">
                                        <input type="radio" name="state" id="forced"> @lang('label.foroper')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                        @if ($emp->privilege === 5)
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="date1" class="col-md-2 control-label">@lang('label.period')</label>
                                    <label for="date1" class="col-md-1 control-label">@lang('label.from')</label>
                                    <div class="col-md-4">
                                        <input type="text" name="date1" id="date1" class="form-control">
                                    </div>
                                    <label for="date2"
                                           class="col-md-1 control-label text-center">@lang('label.to')</label>
                                    <div class="col-md-4">
                                        <input type="text" name="date2" id="date2" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user" class="col-md-3 control-label">@lang('label.user')</label>
                                    <div class="col-md-9">
                                        <select name="user" id="user" class="from-control select2">
                                            <option></option>
                                            @foreach ($employees as $employee)
                                                <option
                                                    value="{{$employee->idemp}}">{{$employee->name}} {{$employee->surname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="user" class="col-md-3 control-label">@lang('label.user')</label>
                                        <div class="col-md-9">
                                            <select name="user" id="user" class="from-control select2" disabled>
                                                <option
                                                    value="{{$emp->idemp}}">{{$emp->name}} {{$emp->surname}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <table id="bootstrap-data-table"
                           class="table display table-bordered table-hover table-striped">
                        <caption class="text-center text-blue text-bold">@lang('label.total')
                            : {{$writings->count()}}</caption>
                        <thead>
                        <tr>
                            <th>@lang('label.refer')</th>
                            <th>@lang('label.account')</th>
                            <th>@lang('label.aux')</th>
                            <th>@lang('label.opera')</th>
                            <th>@lang('label.debt')</th>
                            <th>@lang('label.credt')</th>
                            <th>@lang('label.date')</th>
                            <th>@lang('label.cash')</th>
                            <th>@lang('label.user')</th>
                            <th>@lang('label.opera') @lang('label.date')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($writings as $writing)
                            <tr>
                                <td>{{formDate($writing->created_at).''.pad($writing->network).''.pad($writing->institution).''.pad($writing->institution).''.pad($writing->branch).''.pad($writing->writnumb, 6)}}</td>
                                <td>
                                    @foreach ($accounts as $account)
                                        @if ($account->idaccount == $writing->account)
                                            {{$account->accnumb}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($members as $member)
                                        @if ($member->idmember == $writing->aux)
                                            {{pad($member->memnumb, 6)}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if (!is_numeric($writing->operation))
                                        {{$writing->operation}}
                                    @else
                                        @foreach ($operas as $opera)
                                            @if ($opera->idoper == $writing->operation)
                                                @if($emp->lang == 'fr') {{$opera->labelfr}} @else {{$opera->labeleng}} @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td class="debit text-right text-bold">{{money((int)$writing->debitamt)}}</td>
                                <td class="credit text-right text-bold">{{money((int)$writing->creditamt)}}</td>
                                <td class="text-center">{{changeFormat($writing->date, 'user')}}</td>
                                <td>
                                    @foreach ($cashes as $cash)
                                        @if ($cash->idcash == $writing->cash)
                                            {{$cash->cashcode}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($employees as $employee)
                                        @if ($employee->idemp == $writing->employee)
                                            {{$employee->name}} {{$employee->surname}}
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-center">{{changeFormat($writing->created_at, 'user')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot id="tableInput" class="bg-antiquewhite">
                        <tr class="text-right text-blue">
                            <td colspan="4"></td>
                            <td>{{money((int)$debit)}}</td>
                            <td>{{money((int)$credit)}}</td>
                            <td colspan="2" class="text-black">@lang('label.balance')</td>
                            <td id="tot_bal">{{money((int)$debit - (int)$credit)}}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-md-12">
                    <button type="submit" id="print" class="btn btn-sm bg-blue pull-right btn-raised fa fa-print">
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            let balance = parseInt(trimOver($('#tot_bal').text(), null));
            let tot_bal = $('#tot_balance');
            if (balance < 0 || balance > 0) {
                tot_bal.attr('class', 'text-red');
                tot_bal.text(money(balance));
            } else {
                tot_bal.attr('class', 'text-blue');
                tot_bal.text(money(balance));
            }
        });

        $('#print').click(function () {
            swal({
                    title: '@lang('confirm.monexc_header')',
                    text: '@lang('confirm.monexc_text')',
                    type: 'info',
                    showCancelButton: true,
                    cancelButtonClass: 'bg-red',
                    confirmButtonClass: 'bg-blue',
                    confirmButtonText: '@lang('confirm.yes')',
                    cancelButtonText: '@lang('confirm.no')',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $('#monExcForm').submit();
                    }
                }
            );
        })
    </script>
@stop
