<?php
use App\Models\Branch;use App\Models\Institution;use App\Models\Zone;$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.client_acc'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.client_acc') </h3>
        </div>
        <div class="box-body">
            <div class="row">
                @if ($emp->level === 'N')
                    <?php $zones = Zone::getZones(['network' => $emp->network]); ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="zone" class="col-md-4 control-label">@lang('label.zone')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="network" name="zone">
                                    <option value=""></option>
                                    @foreach($zones as $zone)
                                        <option value="{{$zone->idzone}}">{{$zone->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php $zinstitutes = Institution::getInstitutions(['zone' => $emp->zone]); ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="institution" class="col-md-4 control-label">@lang('label.institution')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="institution" name="institution">
                                    <option value=""></option>
                                    @foreach($zinstitutes as $zinstitute)
                                        <option value="{{$zinstitute->idinst}}">{{$zinstitute->abbr}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php $zbranchs = Branch::getBranches(['zone' => $emp->zone]); ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="branch" class="col-md-4 control-label">@lang('label.branch')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="branch" name="branch">
                                    <option value=""></option>
                                    @foreach($zbranchs as $zbranch)
                                        <option
                                            value="{{$zbranch->idbranch}}">{{$zbranch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @if ($emp->employee !== null)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="collector" class="col-md-4 control-label">@lang('label.collector')</label>
                                <div class="col-md-8">
                                    <select name="collector" id="collector" class="from-control select2">
                                        <option value=""></option>
                                        @foreach ($collectors as $collector)
                                            <option value="{{$collector->idcoll}}">{{pad($collector->code, 3)}} : {{$collector->name}} {{$collector->surname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if ($emp->level === 'Z')
                    <?php $institutes = Institution::getInstitutions(['zone' => $emp->zone]); ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="institution" class="col-md-4 control-label">@lang('label.institution')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="institution" name="institution">
                                    <option value=""></option>
                                    @foreach($institutes as $institute)
                                        <option value="{{$institute->idinst}}">{{$institute->abbr}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php $zbranchs = Branch::getBranches(['zone' => $emp->zone]); ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="branch" class="col-md-4 control-label">@lang('label.branch')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="branch" name="branch">
                                    <option value=""></option>
                                    @foreach($zbranchs as $zbranch)
                                        <option
                                            value="{{$zbranch->idbranch}}">{{$zbranch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @if ($emp->employee !== null)
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="collector" class="col-md-4 control-label">@lang('label.collector')</label>
                                <div class="col-md-8">
                                    <select name="collector" id="collector" class="from-control select2">
                                        <option value=""></option>
                                        @foreach ($collectors as $collector)
                                            <option value="{{$collector->idcoll}}">{{pad($collector->code, 3)}} : {{$collector->name}} {{$collector->surname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if ($emp->level === 'I')
                    <?php $branchs = Branch::getBranches(['institution' => $emp->institution]); ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="branch" class="col-md-2 control-label">@lang('label.branch')</label>
                            <div class="col-md-10">
                                <select class="form-control select2" id="branch" name="branch">
                                    <option value=""></option>
                                    @foreach($branchs as $branch)
                                        <option
                                            value="{{$branch->idbranch}}">{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @if ($emp->employee !== null)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="collector" class="col-md-2 control-label">@lang('label.collector')</label>
                                <div class="col-md-10">
                                    <select name="collector" id="collector" class="from-control select2">
                                        <option value=""></option>
                                        @foreach ($collectors as $collector)
                                            <option value="{{$collector->idcoll}}">{{pad($collector->code, 3)}} : {{$collector->name}} {{$collector->surname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-error">
                            <label for="member" class="col-md-2 control-label">@lang('label.member')<span class="text-bold text-red">*</span></label>
                            @if ($emp->collector !== null)
                                <div class="col-md-3">
                                    <select class="form-control select2" name="member" id="member">
                                        <option value=""></option>
                                        @foreach($members as $member)
                                            <option value="{{$member->idcollect_mem}}">{{pad($member->coll_memnumb, 6)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="col-md-3">
                                    <select class="form-control select2" name="member" id="member">
                                        <option value=""></option>
                                    </select>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="represent" id="represent" placeholder="@lang('label.represent')" disabled>
                                <span class="help-block">@lang('placeholder.cust')</span>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control text-right text-bold" name="balance" id="balance" placeholder="@lang('label.balance')" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="date1" class="col-md-2 control-label">@lang('label.from')</label>
                            <div class="col-md-5">
                                <input type="date" name="date1" id="date1" class="form-control">
                            </div>
                            <label for="date2" class="col-md-1 control-label text-center">@lang('label.to')</label>
                            <div class="col-md-4">
                                <input type="date" name="date2" id="date2" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <button type="button" id="search" class="btn btn-sm bg-green btn-raised fa fa-search"></button>
                        </div>
                    </div>
            </div>

            <div class="form-group"></div>

            <table id="admin-data-table" class="table table-bordered table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th> @lang('label.date') </th>
                    <th> @lang('label.opera') </th>
                    <th> @lang('label.balance') </th>
                    <th> @lang('label.debt') </th>
                    <th> @lang('label.credt') </th>
                </tr>
                </thead>
                <tbody id="collect1">
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            // fillSharings($('#branch').val(), $('#month').val());

            sumFields();
        });

        function sumFields() {
            let totCol = 0;

            $('.col_com').each(function () {
                let numb = trimOver($(this).text(), null);
                if (parseInt(numb))
                    totCol += parseInt(numb);
            });
            $('#totcol_com').val(money(totCol));
        }

        /**
         * Get the institution based on the zone
         */
        $('#zone').change(function () {
            $.ajax({
                url: "{{ url('getInstitutions') }}",
                method: 'get',
                data: {
                    zone: $('#zone').val()
                },
                success: function (institutions) {
                    let option = '<option value=""></option>';
                    $.each(institutions, function (i, institution) {
                        option += "<option value='" + institution.idinst + "'>" + institution.abbr + " : " + institution.name + "</option>";
                    });
                    $('#institution').html(option);
                }
            });
        });

        /**
         * Get the institution based on the zone
         */
        $('#institution').change(function () {
            $.ajax({
                url: "{{ url('getBranches') }}",
                method: 'get',
                data: {
                    institution: $('#institution').val()
                },
                success: function (branchs) {
                    let option = "<option value=''></option>";
                    $.each(branchs, function (i, branch) {
                        option += "<option " +
                            "value=" + branch.idbranch + ">" + branch.name + "</option>";
                    });
                    $('#branch').html(option);
                }
            });
        });

        /**
         * Get the institution based on the zone
         */
        $('#branch').change(function () {
            $.ajax({
                url: "{{ url('getCollectorsCash') }}",
                method: 'get',
                data: {
                    branch: $('#branch').val()
                },
                success: function (collectors) {
                    let option = '<option value=""></option>';
                    $.each(collectors, function (i, collector) {
                        let surname = '';
                        if (collector.surname !== null) {
                            surname = collector.surname;
                        }
                        option += "<option value='" + collector.idcoll + "'>" + pad(collector.code, 3) + " : " + collector.name + " " + surname + "</option>";
                    });
                    $('#collector').html(option);
                },
                error: function (errors) {
                    console.log(errors);
                }
            });
        });

        $('#collector').change(function () {
            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{url('getCustomers')}}",
                    method: 'GET',
                    data: {
                        collector: $('#collector').val()
                    },
                    success: function (customers) {
                        let option = "<option value=''></option>";
                        $.each(customers, function (i, customer) {
                            option += "<option " + "value=" + customer.idcollect_mem + ">" + pad(customer.coll_memnumb, 6) + "</option>";
                        });
                        $('#member').html(option)
                    },
                    error: function (errors) {
                        console.log(errors);
                    }
                });
            }
        });

        $('#member').change(function () {
            $('#member').focusout();
            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{url('getCustomer')}}",
                    method: 'GET',
                    data: {
                        customer: $(this).val()
                    },
                    success: function (customer) {
                        if (customer.surname === null) {
                            $('#represent').val(customer.name);
                        } else {
                            $('#represent').val(customer.name + ' ' + customer.surname);
                        }

                        $.ajax({
                            url: "{{url('getCustomerBalance')}}",
                            method: 'GET',
                            data: {
                                customer: customer.idcollect_mem
                            },
                            success: function (custBal) {
                                $('#balance').val(custBal.ava);
                            }
                        });

                        getFilterCustStatements($('#member').val(), $('#date1').val(), $('#date2').val());
                    }
                });
            }
        });

        $('#search').click(function () {
            if ($('#member').val() !== '') {
                getFilterCustStatements($('#member').val(), $('#date1').val(), $('#date2').val());
            } else {
                $('#member').focusin();
            }
        });

        function getFilterCustStatements(customer = null, date1 = null, date2 = null) {
            $('#admin-data-table').DataTable({
                destroy: true,
                paging: true,
                info: true,
                searching: true,
                responsive: true,
                ordering: true,
                FixedHeader: true,
                processing: true,
                serverSide: false,
                language: {
                    url: "plugins/datatables/lang/{{$emp->lang}}.json"
                },
                serverMethod: 'GET',
                ajax: {
                    url: "{{url('getFilterCustStatements')}}",
                    data: {
                        customer: customer,
                        language: "{{$emp->lang}}",
                        date1: date1,
                        date2: date2
                    },
                    datatype: 'json'
                },
                columns: [
                    {data: 'accdate', class: 'text-center'},
                    {data: 'operation'},
                    {data: 'balance', class: 'text-bold text-right credit'},
                    {data: 'debit', class: 'text-bold text-right debit'},
                    {data: 'credit', class: 'text-bold text-right credit'}
                ]
            });
        }
    </script>
@stop
