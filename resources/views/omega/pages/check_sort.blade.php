<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.sort'))

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="box-tools">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('check_sort/store') }}" method="post" role="form" id="checkSortForm">
                {{ csrf_field() }}
                <div class="box-header with-border" id="form">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="check" class="col-md-3 control-label">@lang('label.checkno')</label>
                                <div class="col-md-9">
                                    <select name="check" id="check" class="form-control select2">
                                        <option></option>
                                        @foreach ($checks as $check)
                                            <option value="{{$check->idcheck}}">{{$check->checknumb}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="mem_numb" class="col-md-2 control-label">@lang('label.member')</label>
                                <div class="col-md-3">
                                    <input type="text" name="mem_numb" id="mem_numb" class="form-control" disabled>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" name="mem_name" id="mem_name" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="bank" class="col-md-3 control-label">@lang('label.bank')</label>
                                <div class="col-md-9">
                                    <input type="text" name="bank" id="bank" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="carrier"
                                       class="col-md-3 control-label">@lang('label.carrier')</label>
                                <div class="col-md-9">
                                    <input type="text" name="carrier" id="carrier" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date" class="col-md-4 control-label">@lang('label.date')</label>
                                <div class="col-md-8">
                                    <input type="text" name="date" id="date" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-5 bg-maroon-gradient"></div>
                    <div class="col-md-2 text-center text-blue text-bold">@lang('label.memotacc')</div>
                    <div class="col-md-5 bg-maroon-gradient"></div>

                    <table
                        class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <thead>
                        <tr class="bg-purples">
                            <th>@lang('label.account')</th>
                            <th>@lang('label.entitle')</th>
                            <th>@lang('label.opera')</th>
                            <th>@lang('label.amount')</th>
                        </tr>
                        </thead>
                        <tbody class="text-bold" id="mem_acc">
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12">
                    <div class="col-md-5 bg-maroon-gradient"></div>
                    <div
                        class="col-md-2 text-center text-blue text-bold">@lang('label.memloanacc')</div>
                    <div class="col-md-5 bg-maroon-gradient"></div>

                    <table id="simul-data-table"
                           class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <thead>
                        <tr class="bg-purples">
                            <th>@lang('label.account')</th>
                            <th>@lang('label.fines')</th>
                            <th>@lang('label.late')</th>
                            <th>@lang('label.amount')</th>
                            <th>@lang('label.balance')</th>
                            <th>@lang('label.retint')</th>
                            <th>@lang('label.totint')</th>
                            <th>@lang('label.payment')</th>
                            <th>@lang('label.interest')</th>
                            <th>@lang('label.diff')</th>
                        </tr>
                        </thead>
                        <tbody id="loan_acc">
                        </tbody>
                    </table>
                </div>

                <div class="col-md-11" id="tableInput">
                    <table class="table table-responsive">
                        <thead>
                        <tr class="text-bold text-blue bg-antiquewhite text-right">
                            @foreach($accounts as $account)
                                @if ($cash->cashacc == $account->idaccount)
                                    <td style="width: 25%">
                                        @if($emp->lang == 'fr') {{$account->labelfr }} @else {{$account->labeleng }} @endif
                                    </td>
                                    <td>{{$account->accnumb }}</td>
                                @endif
                            @endforeach
                            <td>@lang('label.totrans')</td>
                            <td style="width: 15%">
                                <input type="text" style="text-align: right" name="totrans" id="totrans" readonly></td>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-md-1">
                    <button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save">
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('#check').change(function () {
            $.ajax({
                url: "{{ url('getToSortChecks') }}",
                method: 'get',
                data: {
                    check: $(this).val(),
                }, success: function (check) {
                    $('#mem_numb').val(pad(parseInt(check.memnumb), 6));

                    let surname = check.surname;
                    if (check.surname !== null) {
                        surname = '';
                    }
                    $('#mem_name').val(check.name + ' ' + surname);

                    $('#bank').val(check.ouracc + ' : ' + check.bname);
                    $('#carrier').val(check.carrier);
                    $('#date').val(userDate(check.created_at));

                    $.ajax({
                        url: "{{ url('getCheckAccs') }}",
                        method: 'get',
                        data: {
                            check: check.idcheck
                        },
                        success: function (checkAccs) {
                            let memLine = '';
                            let loanLine = '';

                            $.each(checkAccs, function (i, checkAcc) {
                                if (checkAcc.type === 'N') {
                                    memLine += "<tr>" +
                                        "<td><input type='hidden' name='accounts[]' value='" + checkAcc.account + "'>" + checkAcc.accnumb + "</td>" +
                                        "<td>@if ($emp->lang == 'fr')" + checkAcc.labelfr + " @else " + checkAcc.labeleng + "@endif</td>" +
                                        "<td><input type='hidden' name='operations[]' value='" + checkAcc.operation + "'>" +
                                        "@if ($emp->lang == 'fr')" + checkAcc.credtfr + " @else " + checkAcc.credteng + "@endif</td>" +
                                        "<td class='text-right' class='amount'><input type='hidden' name='amounts[]' value='" + parseInt(checkAcc.accamt) + "'>" +
                                        money(parseInt(checkAcc.accamt)) + "</td>" +
                                        "</tr>";
                                    $('#mem_acc').html(memLine);
                                } else if (checkAcc.type === 'L') {

                                }
                            });
                            $('#totrans').val(money(check.amount));
                        }, error: function (errors) {
                            $.each(errors, function (i, error) {
                                console.log(error.message);
                            });
                        }
                    });
                }, error: function (errors) {
                    $.each(errors, function (i, error) {
                        console.log(error.message);
                    });
                }
            });
        });

        $('#save').click(function () {
            let tot = parseInt(trimOver($('#totrans').val(), null));

            if (!isNaN(tot) && tot !== 0) {
                swal({
                        title: '@lang('sidebar.sort')',
                        text: '@lang('confirm.checksort_text')',
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
                            $('#checkSortForm').submit();
                        }
                    }
                )
            } else {
                swal({
                        title: '@lang('sidebar.sort')',
                        text: '@lang('confirm.checksorterror_text')',
                        type: 'error',
                        confirmButtonClass: 'bg-blue',
                        confirmButtonText: 'OK',
                        closeOnConfirm: true,
                    }
                )
            }
        });
    </script>
@stop
