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
            <form action="{{ url('statistics_report/store') }}" method="POST" role="form">
                {{ csrf_field() }}

                <div class="row">
                    <div class="row text-center">
                        <div class="col-xl-2 col-lg-2"></div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="all_members" class="control-label">
                                        <input type="radio" name="filter" id="all_members" value="A" checked>@lang('label.all_members')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="male" class="control-label">
                                        <input type="radio" name="filter" id="male" value="M">@lang('label.male')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="female" class="control-label">
                                        <input type="radio" name="filter" id="female" value="F">@lang('label.female')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="group" class="control-label">
                                        <input type="radio" name="filter" id="group" value="G">@lang('label.group')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2"></div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="loan_type" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 control-label">@lang('label.loan_type')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8">
                                    <select name="loan_type" id="loan_type" class="form-control select2">
                                        <option value=""></option>
                                        @foreach ($loan_types as $loan_type)
                                            <option value="{{$loan_type->idltype}}">{{pad($loan_type->loan_type_code, 3)}} :
                                                @if ($emp->lang == 'fr') {{$loan_type->labelfr}} @else {{$loan_type->labeleng}} @endif </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="radio col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                    <label for="member_filter" class="control-label">
                                        <input type="radio" name="member_filter" id="member_filter" value="MA">@lang('label.member')
                                    </label>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                    <select class="form-control select2" name="member" id="member" disabled>
                                        <option value=""></option>
                                        @foreach($members as $member)
                                            <option value="{{$member->idmember}}">{{pad($member->memnumb, 6)}} : {{ $member->name }} {{ $member->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="radio col-xl-4 col-lg-4 col-md-5 col-sm-12 col-xs-12">
                                    <label for="loan_amt_filter" class="control-label">
                                        <input type="radio" name="loan_amt_filter" id="loan_amt_filter" value="LA">@lang('label.loan_amt')
                                    </label>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                    <select class="form-control" name="loan_sign" id="loan_sign" disabled>
                                        <option value=">">></option>
                                        <option value="<"><</option>
                                        <option value="=">=</option>
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-5 col-sm-8 col-xs-8">
                                    <input type="text" name="loan_amt" id="loan_amt" class="form-control text-bold text-right" disabled>
                                </div>
                            </div>
                        </div>
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
                                        <th colspan="3" class="text-center">@lang('label.total')</th>
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

        $('#loan_amt').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $('input[name="filter"]').click(function () {
            $(this).each(function () {
                $('#member_filter').prop('checked', false);
                $('#member').val('').select2();
                $('#member').prop('disabled', true);

                if ($(this).is(':checked')) {
                    fillLoans($(this).val(), $('#member').val(), $('#loan_sign').val(), trimOver($('#loan_amt').val(), null), $('#loan_off').val(), $('#from').val(), $('#to').val());
                }
            });
        });

        $('#member_filter').click(function () {
            if ($(this).is(":checked")) {
                $('#member').prop('disabled', false);

                $('input[name="filter"]').each(function () {
                    $(this).prop('checked', false)
                });
            } else {
                $('#member').prop('disabled', true);
            }
        });

        $('#loan_amt_filter').click(function () {
            if ($(this).is(":checked")) {
                $('#loan_sign').prop('disabled', false);
                $('#loan_amt').prop('disabled', false);
            } else {
                $('#loan_sign').prop('disabled', true);
                $('#loan_amt').prop('disabled', true);
            }
        });

        $('#search').click(function () {
            fillLoans($(this).val(), $('#member').val(), $('#loan_sign').val(), trimOver($('#loan_amt').val(), null), $('#loan_off').val(), $('#from').val(), $('#to').val());
        });

        function fillLoans (filter, member = null, loan_sign = '=', loan_amt = null, emp = null, from = null, to = null) {
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
                    url: "{{ url('getLoansStatictics') }}",
                    data: {
                        user: '{{ $emp->iduser }}',
                        filter: filter,
                        member: member,
                        loan_sign: loan_sign,
                        loan_amt: loan_amt,
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
                        .column(3, {page: 'all'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                    }, 0);
                        
                    $(api.column(3).footer()).html(money(totAmo));

                    sumAmount();
                }
            });
        }

        function sumAmount() {
            var sum = 0;

            $('.amount').each(function () {
                let numb = trimOver($(this).text(), null);
                if (parseInt(numb))
                    sum += parseInt(numb);
            });
            $('#totAmt').text(money(sum));
        }
    </script>
@stop
