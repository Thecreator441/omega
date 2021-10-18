<?php $emp = Session::get('employee');

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
            <form action="{{ url('check_report/store') }}" method="POST" id="cheRegForm" role="form">
                {{ csrf_field() }}

                <div class="row">
                    <div class="row text-center">
                        <div class="col-xl-2 col-lg-2"></div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="all" class="control-label">
                                        <input type="radio" name="filter" id="all" value="A" checked>@lang('label.all')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="paid" class="control-label">
                                        <input type="radio" name="filter" id="paid" value="P">@lang('label.paid_checks')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="unpaid" class="control-label">
                                        <input type="radio" name="filter" id="unpaid" value="U">@lang('label.unpaid_checks')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="drop" class="control-label">
                                        <input type="radio" name="filter" id="drop" value="D">@lang('label.drop_checks')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="member" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 control-label">@lang('label.member')</label>
                                <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10">
                                    <select class="form-control select2" name="member" id="member" required>
                                        <option value=""></option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->idmember }}">{{pad($member->memnumb, 6)}} : {{ $member->name }} {{ $member->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="bank"  class="col-xl-1 col-lg-2 col-md-2 col-sm-2 control-label">@lang('label.bank')</label>
                                <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10">
                                    <select class="form-control select2" name="bank" id="bank">
                                        <option value=""></option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->idbank }}">{{ pad($bank->bankcode, 3) }} : @if($emp->lang === 'eng') {{ $bank->labeleng }} @else {{ $bank->labelfr }} @endif </option>
                                        @endforeach
                                    </select>
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
                        <div class="col-xl-6 col-lg-6 col-md-5 col-sm-12 col-xs-12">
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
                                    <th>@lang('label.checkno')</th>
                                    <th>@lang('label.bank')</th>
                                    <th>@lang('label.carrier')</th>
                                    <th>@lang('label.opera')</th>
                                    <th>@lang('label.amount')</th>
                                    <th>@lang('label.status')</th>
                                    <th>@lang('label.date')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($checks as $check)
                                    <tr>
                                        <td>{{$check->checknumb}}</td>
                                        <td>{{$check->bank}}</td>
                                        <td>{{ $check->carrier }}</td>
                                        <td>{{ $check->opera }}</td>
                                        <td class="text-right text-bold amount">{{money((int)$check->amount)}}</td>
                                        <td>{{ $check->state }}</td>
                                        <td class="text-center">{{changeFormat($check->created_at)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot id="tableInput" class="bg-antiquewhite text-bold">
                                    <tr>
                                        <th colspan="4" class="text-center">@lang('label.total')</th>
                                        <th id="totAmt" class="text-right text-bold">{{ money($totalAmt) }}</th>
                                        <th colspan="2"></th>
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
                    fillChecks($(this).val(), $('#member').val(), $('#bank').val(), $('#from').val(), $('#to').val());
                }
            });
        });

        $('#search').click(function () {
            $('input[type="radio"]').each(function () {
                if ($(this).is(':checked')) {
                    fillChecks($(this).val(), $('#member').val(), $('#bank').val(), $('#from').val(), $('#to').val());
                }
            });
        });

        function fillChecks(status, member = null, bank = null, from = null, to = null) {
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
                    url: "{{ url('getFilterChecks') }}",
                    data: {
                        user: '{{ $emp->iduser }}',
                        status: status,
                        member: member,
                        bank: bank,
                        from: from,
                        to: to
                    },
                    datatype: 'json'
                },
                columns: [
                    {data: 'checknumb'},
                    {data: 'bank'},
                    {data: 'carrier'},
                    {data: 'opera'},
                    {data: 'amt', class: 'text-right text-bold amount'},
                    {data: 'state'},
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
