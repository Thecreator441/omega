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
            <form action="{{ url('loan_simulation/print') }}" method="GET" role="form" class="needs-validation" id="loanSimulation">
                {{ csrf_field() }}
                <div class="row">
                    <div class="row">
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-7 col-xs-12">
                            <div class="form-group">
                                <label for="member" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 control-label">@lang('label.member')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10">
                                    <select class="form-control select2" name="member" id="member" required>
                                        <option value=""></option>
                                        @foreach($members as $member)
                                            <option value="{{$member->idmember}}">{{pad($member->memnumb, 6)}} : {{ $member->name }} {{ $member->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-xs-12">
                            <div class="form-group">
                                <label for="amount" class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-xs-2 control-label">@lang('label.amount')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8 col-xs-10">
                                    <input type="text" name="amount" id="amount" class="form-control text-bold text-right">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="amorti" class="col-xl-2 col-lg-4 col-md-4 control-label">@lang('label.amort')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8">
                                    <select name="amorti" id="amorti" class="form-control select2">
                                        <option value="C" selected>@lang('label.constamort')</option>
                                        <option value="V">@lang('label.varamort')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="grace" class="col-xl-4 col-lg-5 col-md-5 control-label">@lang('label.grace')</label>
                                <div class="col-xl-8 col-lg-7 col-md-7">
                                    <select name="grace" id="grace" class="form-control select2">
                                        <option value="D">@lang('label.day1')</option>
                                        <option value="W">@lang('label.week1')</option>
                                        <option value="B">@lang('label.mon1/2')</option>
                                        <option value="M" selected>@lang('label.mon1')</option>
                                        <option value="T">@lang('label.trim1')</option>
                                        <option value="S">@lang('label.sem1')</option>
                                        <option value="A">@lang('label.ann1')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="period" class="col-xl-2 col-lg-4 col-md-4 control-label">@lang('label.periodicity')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8">
                                    <select name="period" id="period" class="form-control select2">
                                        <option value="D">@lang('label.daily')</option>
                                        <option value="W">@lang('label.weekly')</option>
                                        <option value="B">@lang('label.bimens')</option>
                                        <option value="M" selected>@lang('label.mens')</option>
                                        <option value="T">@lang('label.trim')</option>
                                        <option value="S">@lang('label.sem')</option>
                                        <option value="A">@lang('label.ann')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="int_rate" class="col-xl-6 col-lg-5 col-md-5 col-sm-6 control-label">@lang('label.monintrate')</label>
                                <div class="col-xl-6 col-lg-7 col-md-7 col-sm-6">
                                    <input type="text" name="int_rate" id="int_rate" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="tax_rate" class="col-xl-4 col-lg-6 col-md-6 col-sm-5 control-label">@lang('label.taxrate')</label>
                                <div class="col-xl-8 col-lg-6 col-md-6 col-sm-7">
                                    <input type="text" name="tax_rate" id="tax_rate" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="numb_inst" class="col-xl-4 col-lg-6 col-md-6 col-sm-6 control-label">@lang('label.noinstal')</label>
                                <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6">
                                    <input type="text" name="numb_inst" id="numb_inst" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="inst1" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 control-label">@lang('label.inst1')</label>
                                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-7">
                                    <input type="date" name="inst1" id="date" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                </div>

                <div class="row" id="tableInput">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {{-- <button type="submit" id="print" class="btn btn-sm bg-blue pull-right btn-raised fa fa-print"></button> --}}
                        <button type="button" id="preview" class="btn btn-sm bg-green pull-right btn-raised fa fa-eye"></button>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table id="loan-data-table" class="table table-striped table-hover table-condensed table-bordered no-padding">
                                <thead>
                                    <tr class="text-center text-bold">
                                        <th>@lang('label.install')</th>
                                        <th>@lang('label.capital')</th>
                                        <th>@lang('label.amort')</th>
                                        <th>@lang('label.interest')</th>
                                        <th>@lang('label.annuity')</th>
                                        <th>@lang('label.tax')</th>
                                        <th>@lang('label.total')</th>
                                        <th>@lang('label.date')</th>
                                    </tr>
                                </thead>
                                <tbody id="amorDisplay">
                                </tbody>
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
            $('#date').val(installment_date($('#grace').val()));
        });

        $('#grace').change(function () {
            $('#date').val(installment_date($(this).val()));
        });

        $('#amount').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $(document).on('click', '#preview', function () {
            $('#loan-data-table').DataTable({
                destroy: true,
                paging: false,
                info: false,
                searching: false,
                responsive: true,
                ordering: false,
                FixedHeader: true,
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: '',
                        className: 'buttons-copy btn btn-sm bg-blue btn-raised fa fa-copy',
                        titleAttr: '@lang('label.copy')',
                        footer: true
                    },
                    {
                        extend: 'excel',
                        text: '',
                        className: 'buttons-excel btn btn-sm bg-blue btn-raised fa fa-file-excel-o',
                        titleAttr: '@lang('label.excel')',
                        footer: true
                    },
                    {
                        extend: 'pdf',
                        text: '',
                        className: 'buttons-pdf btn btn-sm bg-blue btn-raised fa fa-file-pdf-o',
                        titleAttr: '@lang('label.pdf')',
                        footer: true
                    },
                    {
                        extend: 'print',
                        text: '',
                        className: 'buttons-print btn btn-sm bg-blue btn-raised fa fa-print',
                        titleAttr: '@lang('label.print')',
                        footer: true
                    }
                ],
                dom:
                    "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: false,
                language: {
                    url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
                },
                serverMethod: 'GET',
                ajax: {
                    url: "{{ url('getLoanSimulationPreview') }}",
                    data: {
                        amount: $('#amount').val(),
                        numb_inst: $('#numb_inst').val(),
                        int_rate: $('#int_rate').val(),
                        tax_rate: $('#tax_rate').val(),
                        period: $('#period').val(),
                        inst1: $('#inst1').val(),
                        date: $('#date').val(),
                        amorti: $('#amorti').val()
                    },
                    datatype: 'json'
                },
                columns: [
                    {data: 'intallment', class: 'text-center'},
                    {data: 'capital', class: 'text-right text-bold'},
                    {data: 'amort_amt', class: 'text-right text-bold'},
                    {data: 'int_amt', class: 'text-right text-bold'},
                    {data: 'ann_amt', class: 'text-right text-bold'},
                    {data: 'tax_amt', class: 'text-right text-bold'},
                    {data: 'tot_amt', class: 'text-right text-bold'},
                    {data: 'date', class: 'text-center'}
                ],
            });
        });

        $(document).on('click', '#print', function () {
            var forms = document.getElementsByClassName("needs-validation");

            var validator = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener("submit", function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        $('#loanSimulation').submit();
                    }
                }, false);
            });
        });
    </script>
@stop
