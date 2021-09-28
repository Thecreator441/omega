<?php 
$emp = Session::get('employee');

$title = $menu->labeleng;
if ($emp->lang == 'fr') {
    $title = $menu->labelfr;
    App::setLocale('fr');
}
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> {{ $title }} </h3>
        </div>
        <div class="box-body">
            <form action="{{ url('loan_list/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="row">
                    <div class="row text-center">
                        <div class="col-xl-2 col-lg-2"></div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="loan_app" class="control-label">
                                        <input type="radio" name="filter" id="loan_app" value="A" checked>@lang('label.loan_app')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="cloloan" class="control-label">
                                        <input type="radio" name="filter" id="cloloan" value="C">@lang('label.cloloan')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="loan_dem" class="control-label">
                                        <input type="radio" name="filter" id="loan_dem" value="D">@lang('label.loan_dem')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="rejloan" class="control-label">
                                        <input type="radio" name="filter" id="rejloan" value="R">@lang('label.rejloan')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2"></div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-7 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="from" class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label">@lang('label.period')</label>
                                <label for="from" class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-2 control-label text-right"> @lang('label.from')</label>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-10">
                                    <input type="date" name="from" id="from" class="form-control">
                                </div>
                                <label for="to" class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-2 control-label text-center">@lang('label.to')</label>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-10">
                                    <input type="date" name="to" id="to" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-10 col-xs-12">
                            <div class="form-group">
                                <label for="loan_off" class="col-xl-3 col-lg-3 col-md-4 col-sm-3 control-label">@lang('label.loan_off')</label>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-9">
                                    @if($emp->view_other_users === 'Y')
                                        <select class="form-control select2" name="loan_off" id="loan_off">
                                            <option value=""></option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->iduser }}">{{ $employee->name }} {{ $employee->surname }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select class="form-control select2" name="loan_off" id="loan_off" disabled>
                                            @foreach ($employees as $employee)
                                                @if ($emp->idemp == $employee->idemp)
                                                    <option value="{{ $employee->iduser }}" selected>{{ $employee->name }} {{ $employee->surname }}</option>    
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-1 col-lg-1 col-md-12 col-sm-2 col-xs-12">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button type="button" id="search" class="search btn btn-sm bg-green pull-right btn-raised fa fa-search"></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table id="admin-data-table" class="table table-striped table-hover table-condensed table-bordered">
                                <thead>
                                <tr>
                                    <th>@lang('label.loan_no')</th>
                                    <th>@lang('label.member')</th>
                                    <th>@lang('label.loan_type')</th>
                                    <th>@lang('label.loan_pur')</th>
                                    <th>@lang('label.amount')</th>
                                    <th>@lang('label.date')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($loans as $loan)
                                    <tr>
                                        <td class="text-center">{{ pad($loan->loanno, 6) }}</td>
                                        <td>{{ pad($loan->memnumb, 6) }} : {{ $loan->M_name }} {{ $loan->M_surname }}</td>
                                        <td>@if ($emp->lang == 'fr') {{ $loan->lt_labelfr }} @else {{ $loan->lt_labeleng }} @endif</td>
                                        <td>@if ($emp->lang == 'fr') {{ $loan->lp_labelfr }} @else {{ $loan->lp_labeleng }} @endif</td>
                                        <td class="amount text-right text-bold">
                                            @if ((int)$loan->isRef > 0)
                                                {{money((int)$loan->refamt)}}
                                            @else
                                                {{money((int)$loan->amount)}}
                                            @endif
                                        </td>
                                        <td class="text-center">{{changeFormat($loan->created_at)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot id="tableInput" class="bg-antiquewhite text-bold">
                                    <tr>
                                        <th colspan="4" class="text-center">@lang('label.total')</th>
                                        <th id="totAmt" class="text-right text-bold"></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            sumAmount();
        });

        function sumAmount() {
            var sum = 0;

            $('.amount').each(function () {
                let numb = trimOver($(this).text(), null);
                if (parseInt(numb))
                    sum += parseInt(numb);
            });
            $('#totAmt').text(money(sum));
        }

        $('input[type="radio"]').click(function () {
            $(this).each(function () {
                if ($(this).is(':checked')) {
                    if (($(this).val() === 'D') || ($(this).val() === 'R')) {
                        fillLoans("{{ url('getFilterDemLoans') }}", $(this).val(), $('#loan_off').val(), $('#from').val(), $('#to').val());
                    } else if (($(this).val() === 'A') || ($(this).val() === 'C')) {
                        fillLoans("{{ url('getFilterLoans') }}", $(this).val(), $('#loan_off').val(), $('#from').val(), $('#to').val());
                    }
                }
            });
        });

        $('#search').click(function () {
            $('input[type="radio"]').each(function () {
                if ($(this).is(':checked')) {
                    if (($(this).val() === 'D') || ($(this).val() === 'R')) {
                        fillLoans("{{ url('getFilterDemLoans') }}", $(this).val(), $('#loan_off').val(), $('#from').val(), $('#to').val());
                    } else if (($(this).val() === 'A') || ($(this).val() === 'C')) {
                        fillLoans("{{ url('getFilterLoans') }}", $(this).val(), $('#loan_off').val(), $('#from').val(), $('#to').val());
                    }
                }
            });
        });

        function fillLoans (url, status, emp = null, from = null, to = null) {
            $('#admin-data-table').DataTable({
                destroy: true,
                paging: true,
                info: true,
                responsive: true,
                ordering: true,
                FixedHeader: true,
                language: {
                    url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
                },
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: '',
                        className: 'buttons-copy btn btn-sm bg-blue btn-raised fa fa-copy',
                        titleAttr: '@lang('label.copy')',
                    },
                    {
                        extend: 'excel',
                        text: '',
                        className: 'buttons-excel btn btn-sm bg-blue btn-raised fa fa-file-excel-o',
                        titleAttr: '@lang('label.excel')',
                    },
                    {
                        extend: 'pdf',
                        text: '',
                        className: 'buttons-pdf btn btn-sm bg-blue btn-raised fa fa-file-pdf-o',
                        titleAttr: '@lang('label.pdf')',
                    },
                    {
                        extend: 'print',
                        text: '',
                        className: 'buttons-print btn btn-sm bg-blue btn-raised fa fa-print',
                        titleAttr: '@lang('label.print')',
                    }
                ],
                dom:
                    "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: false,
                serverMethod: 'GET',
                ajax: {
                    url: url,
                    data: {
                        user: '{{ $emp->iduser }}',
                        loan_status: status,
                        employee: emp,
                        from: from,
                        to: to
                    },
                    datatype: 'json'
                },
                columns: [
                    {data: 'no', class: 'text-center'},
                    {data: 'mem_infos'},
                    {data: null,
                        render: function(data, type, row) {
                            let type_pret = row.lt_labeleng;
                            if('{{ $emp->lang }}' === 'fr') {
                                type_pret = row.lt_labelfr;
                            }
                            return type_pret;
                        }
                    },
                    {data: null,
                        render: function(data, type, row) {
                            let but_pret = row.lp_labeleng;
                            if('{{ $emp->lang }}' === 'fr') {
                                but_pret = row.lp_labelfr;
                            }
                            return but_pret;
                        }
                    },
                    {data: 'amt', class: 'text-right text-bold amount'},
                    {data: 'date', class: 'text-center'}
                ],
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api(), api;
                    
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        var type = typeof i;
                        
                        if(type === 'string') {
                            i = parseInt(trimOver(i, null));
                        } else if (type === 'number') {
                            i = parseInt(i);
                        } else {
                            i = 0;
                        }
                        return i;
                    };
                    
                    var totAmo = api
                        .column(4, {page: 'all'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                    }, 0);
                        
                    $(api.column(4).footer()).html(money(totAmo));

                    sumAmount();
                }
            });
        }
    </script>
@stop
