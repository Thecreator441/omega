<?php use App\Models\Branch;use App\Models\Institution;use App\Models\Zone;$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.client'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.client') </h3>
        </div>
        <div class="box-body">
            <div class="row">
                @if ($emp->level === 'N')
                    <?php $zones = Zone::getZones(['network' => $emp->network]); ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="network" class="col-md-4 control-label">@lang('label.network')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="network" name="network">
                                    <option value=""></option>
                                    @foreach($zones as $zone)
                                        <option value="{{$zone->idzone}}">{{$zone->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php $zinstitutes = Institution::getInstitutions(['zone' => $emp->zone]); ?>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="institution" class="col-md-5 control-label">@lang('label.institution')</label>
                            <div class="col-md-7">
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
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="branch" class="col-md-5 control-label">@lang('label.branch')</label>
                            <div class="col-md-7">
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
                    <div class="col-md-1">
                        <div class="form-group">
                            <button type="button" id="search" class="btn btn-sm bg-green btn-raised fa fa-search"></button>
                        </div>
                    </div>
                    <div class="form-group"></div>
                @endif
                @if ($emp->level === 'Z')
                    <?php $institutes = Institution::getInstitutions(['zone' => $emp->zone]); ?>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="institution" class="col-md-5 control-label">@lang('label.institution')</label>
                            <div class="col-md-7">
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
                    <div class="col-md-1">
                        <div class="form-group">
                            <button type="button" id="search" class="btn btn-sm bg-green btn-raised fa fa-search"></button>
                        </div>
                    </div>
                    <div class="form-group"></div>
                @endif
                @if ($emp->level === 'I')
                    <?php $branchs = Branch::getBranches(['institution' => $emp->institution]); ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="branch" class="col-md-3 control-label">@lang('label.branch')</label>
                            <div class="col-md-9">
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
                    <div class="col-md-1">
                        <div class="form-group">
                            <button type="button" id="search" class="btn btn-sm bg-green btn-raised fa fa-search"></button>
                        </div>
                    </div>
                    <div class="form-group"></div>
                @endif
                @if ($emp->collector === null && $emp->coll_mem === null)
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="collector" class="col-md-4 control-label">@lang('label.collector')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="collector" name="collector">
                                    <option value=""></option>
                                    @foreach($collectors as $collector)
                                        <option value="{{$collector->idcoll}}">{{$collector->name}} {{$collector->surname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <button type="button" id="search" class="btn btn-sm bg-green btn-raised fa fa-search"></button>
                        </div>
                    </div>
                    <div class="form-group"></div>
                @endif
            </div>

            <table id="admin-data-table" class="table table-bordered table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th> @lang('label.code') </th>
                    <th> @lang('label.name') </th>
                    <th> @lang('label.prof') </th>
                    <th> @lang('label.dob') </th>
                    <th> @lang('label.gender') </th>
                    <th> @lang('label.phone') </th>
                    <th> @lang('label.@') </th>
                    <th> @lang('label.nobenef') </th>
                    <th> @lang('label.status') </th>
                    <th> @lang('label.date') </th>
                </tr>
                </thead>
                <tbody id="collectTable">
                @foreach($customers as $customer)
                    <tr>
                        <td class="text-center">{{pad($customer->coll_memnumb, 6)}}</td>
                        <td>{{$customer->name}} {{$customer->surname}}</td>
                        <td>{{$customer->profession}}</td>
                        <td class="text-center">{{changeFormat($customer->dob)}}</td>
                        <td>
                            @if ($customer->gender === 'M')
                                @lang('label.male')
                            @else
                                @lang('label.female')
                            @endif
                        </td>
                        <td>{{$customer->phone1}}</td>
                        <td>{{$customer->email}}</td>
                        <td class="text-center">{{$customer->benefs}}</td>
                        <td>
                            @if ($customer->coll_memstatus === 'A')
                                @lang('label.active')
                            @else
                                @lang('label.inactive')
                            @endif
                        </td>
                        <td class="text-center">{{changeFormat($customer->created_at)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('script')
    <script>
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
                    let option = "<option value=''></option>";
                    $.each(institutions, function (i, institution) {
                        option += "<option " +
                            "value=" + institution.idinst + ">" + institution.abbr + " : " + institution.name + "</option>";
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
                url: "{{ url('getCollectorsBy') }}",
                method: 'get',
                data: {
                    branch: $('#branch').val()
                },
                success: function (collectors) {
                    let option = "<option value=''></option>";
                    $.each(collectors, function (i, collector) {
                        let surname = '';
                        if (collector.surname !== null) {
                            surname = collector.surname;
                        }
                        option += "<option " + "value=" + collector.idcoll + ">" + collector.name + " " + surname + "</option>";
                    });
                    $('#collector').html(option);
                }
            });
        });

        $('#search').click(function () {
            fillCustomers($('#institution').val(), $('#branch').val(), $('#collector').val());
        });

        function fillCustomers(institution = null, branch = null, collector = null) {
            $('#admin-data-table').DataTable({
                destroy: true,
                paging: true,
                info: true,
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
                    url: "{{url('getFilterCustomers')}}",
                    data: {
                        institution: institution,
                        branch: branch,
                        collector: collector
                    },
                    datatype: 'json',
                },
                columns: [
                    {data: 'coll_memnumb', class: 'text-center'},
                    {data: 'name'},
                    {data: 'profession'},
                    {data: 'dob', class: 'text-center'},
                    {data: 'gender'},
                    {data: 'phone1'},
                    {data: 'email'},
                    {data: 'benefs', class: 'text-center'},
                    {data: 'coll_memstatus'},
                    {data: 'created_at', class: 'text-center'}
                ]
            });

            {{--$.ajax({--}}
            {{--    url: "{{url('getFilterCustomers')}}",--}}
            {{--    method: 'get',--}}
            {{--    data: {--}}
            {{--        institution: institution,--}}
            {{--        branch: branch,--}}
            {{--        collector: collector--}}
            {{--    },--}}
            {{--    success: function (customers) {--}}
            {{--        let line = '';--}}
            {{--        $.each(customers, function (i, customer) {--}}
            {{--            let surname = '';--}}
            {{--            let gender = 'Male';--}}
            {{--            let status = '@lang('label.active')';--}}

            {{--            if (customer.surname !== null) {--}}
            {{--                surname = customer.surname;--}}
            {{--            }--}}
            {{--            if (customer.gender === 'F') {--}}
            {{--                gender = 'Female';--}}
            {{--            }--}}
            {{--            if (customer.coll_memstatus === 'D') {--}}
            {{--                status = '@lang('label.inactive')';--}}
            {{--            }--}}

            {{--            line += '<tr>' +--}}
            {{--                '<td class="text-center">' + pad(customer.coll_memnumb, 6) + '</td>' +--}}
            {{--                '<td>' + customer.name + ' ' + surname + '</td>' +--}}
            {{--                '<td>' + customer.profession + '</td>' +--}}
            {{--                '<td class="text-center">' + userDate(customer.dob) + '</td>' +--}}
            {{--                '<td>' + gender + '</td>' +--}}
            {{--                '<td>' + customer.phone1 + '</td>' +--}}
            {{--                '<td>' + customer.email + '</td>' +--}}
            {{--                '<td class="text-center">' + customer.benefs + '</td>' +--}}
            {{--                '<td>' + status + '</td>' +--}}
            {{--                '<td class="text-center">' + userDate(customer.created_at) + '</td>' +--}}
            {{--                '</tr>';--}}
            {{--        });--}}
            {{--        $('#collectTable').html(line);--}}
            {{--    }--}}
            {{--});--}}
        }
    </script>
@stop
