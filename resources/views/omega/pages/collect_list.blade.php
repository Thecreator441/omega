<?php use App\Models\Branch;use App\Models\Institution;use App\Models\Zone;$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.collector'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.collector') </h3>
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
                    <div class="col-md-1">
                        <div class="form-group">
                            <button type="button" id="search" class="btn btn-sm bg-green btn-raised fa fa-search"></button>
                        </div>
                    </div>
                    <div class="form-group"></div>
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
                    <div class="col-md-1">
                        <div class="form-group">
                            <button type="button" id="search" class="btn btn-sm bg-green btn-raised fa fa-search"></button>
                        </div>
                    </div>
                    <div class="form-group"></div>
                @endif
                @if ($emp->level === 'I')
                    <?php $branchs = Branch::getBranches(['institution' => $emp->institution]); ?>
                    <div class="col-md-5">
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
            </div>

            <table id="admin-data-table" class="table table-bordered table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th> @lang('label.code') </th>
                    <th> @lang('label.name') </th>
                    <th> @lang('label.cash') </th>
                    <th> @lang('label.dob') </th>
                    <th> @lang('label.gender') </th>
                    <th> @lang('label.phone') </th>
                    <th> @lang('label.@') </th>
                    <th> @lang('label.nocust') </th>
                    <th> @lang('label.status') </th>
                    <th> @lang('label.date') </th>
                </tr>
                </thead>
                <tbody id="collectTable">
                @foreach($collectors as $collector)
                    <tr>
                        <td class="text-center">{{pad($collector->code, 3)}}</td>
                        <td>{{$collector->name}} {{$collector->surname}}</td>
                        <td class="text-center">{{$collector->cashcode}}</td>
                        <td class="text-center">{{changeFormat($collector->dob)}}</td>
                        <td>
                            @if ($collector->gender === 'M')
                                @lang('label.male')
                            @else
                                @lang('label.female')
                            @endif
                        </td>
                        <td>{{$collector->phone1}}</td>
                        <td>{{$collector->email}}</td>
                        <td class="text-center">{{$collector->customers}}</td>
                        <td>
                            @if ($collector->login_status === 'F')
                                @lang('label.active')
                            @else
                                @lang('label.inactive')
                            @endif
                        </td>
                        <td class="text-center">{{changeFormat($collector->created_at)}}</td>
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

        $('#search').click(function () {
            fillCollectors($('#institution').val(), $('#branch').val());
        });

        function fillCollectors(institution = null, branch = null) {
            {{--$('#admin-data-table').DataTable({--}}
            {{--    destroy: true,--}}
            {{--    paging: true,--}}
            {{--    info: true,--}}
            {{--    responsive: true,--}}
            {{--    ordering: true,--}}
            {{--    FixedHeader: true,--}}
            {{--    processing: true,--}}
            {{--    serverSide: false,--}}
            {{--    language: {--}}
            {{--        url: "plugins/datatables/lang/{{$emp->lang}}.json"--}}
            {{--    },--}}
            {{--    serverMethod: 'GET',--}}
            {{--    ajax: {--}}
            {{--        url: "{{url('getFilterCollectors')}}",--}}
            {{--        data: {--}}
            {{--            institution: institution,--}}
            {{--            branch: branch--}}
            {{--        },--}}
            {{--        datatype: 'json',--}}
            {{--    },--}}
            {{--    columns: [--}}
            {{--        {data: 'coll_memnumb', class: 'text-center'},--}}
            {{--        {data: 'name'},--}}
            {{--        {data: 'profession'},--}}
            {{--        {data: 'dob', class: 'text-center'},--}}
            {{--        {data: 'gender'},--}}
            {{--        {data: 'phone1'},--}}
            {{--        {data: 'email'},--}}
            {{--        {data: 'benefs', class: 'text-center'},--}}
            {{--        {data: 'coll_memstatus'},--}}
            {{--        {data: 'created_at', class: 'text-center'}--}}
            {{--    ]--}}
            {{--});--}}

            $.ajax({
                url: "{{url('getFilterCollectors')}}",
                method: 'get',
                data: {
                    institution: institution,
                    branch: branch
                },
                success: function (collectors) {
                    console.log(collectors);
                    let line = '';
                    $.each(collectors, function (i, collector) {
                        let surname = '';
                        let gender = 'Male';
                        let status = '@lang('label.active')';

                        if (collector.surname !== null) {
                            surname = collector.surname;
                        }
                        if (collector.gender === 'F') {
                            gender = 'Female';
                        }
                        if (collector.login_status === 'B') {
                            status = '@lang('label.inactive')';
                        }

                        line += '<tr>' +
                            '<td class="text-center">' + pad(collector.code, 3) + '</td>' +
                            '<td>' + collector.name + ' ' + surname + '</td>' +
                            '<td class="text-center">' + collector.cashcode + '</td>' +
                            '<td class="text-center">' + userDate(collector.dob) + '</td>' +
                            '<td>' + gender + '</td>' +
                            '<td>' + collector.phone1 + '</td>' +
                            '<td>' + collector.email + '</td>' +
                            '<td class="text-center">' + collector.customers + '</td>' +
                            '<td>' + status + '</td>' +
                            '<td class="text-center">' + userDate(collector.created_at) + '</td>' +
                            '</tr>';
                    });
                    $('#collectTable').html(line);
                }
            });
        }

    </script>
@stop
