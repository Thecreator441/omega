<?php use App\Models\Branch;use App\Models\Institution;use App\Models\Zone;$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.employee'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.employee') </h3>
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
                    <th> @lang('label.nam&sur') </th>
                    <th> @lang('label.dob') </th>
                    <th> @lang('label.gender') </th>
                    <th> @lang('label.phone') </th>
                    <th> @lang('label.@') </th>
{{--                    <th> @lang('label.privilege') </th>--}}
{{--                    <th> @lang('label.status') </th>--}}
                    <th> @lang('label.date') </th>
                </tr>
                </thead>
                <tbody id="collectTable">
                @foreach($employees as $employee)
                    <tr>
                        <td class="text-center">{{pad($employee->empmat, 6)}}</td>
                        <td>{{$employee->name}} {{$employee->surname}}</td>
                        <td class="text-center">{{changeFormat($employee->dob)}}</td>
                        <td>
                            @if ($employee->gender === 'M')
                                @lang('label.male')
                            @else
                                @lang('label.female')
                            @endif
                        </td>
                        <td>{{$employee->phone1}}</td>
                        <td>{{$employee->email}}</td>
{{--                        <td>{{$employee->privilege}}</td>--}}
{{--                        <td>--}}
{{--                            @if ($employee->login_status === 'F')--}}
{{--                                @lang('label.active')--}}
{{--                            @else--}}
{{--                                @lang('label.inactive')--}}
{{--                            @endif--}}
{{--                        </td>--}}
                        <td class="text-center">{{changeFormat($employee->created_at)}}</td>
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
            fillEmployees($('#institution').val(), $('#branch').val());
        });

        function fillEmployees(institution = null, branch = null) {
            $.ajax({
                url: "{{url('getFilterEmployees')}}",
                method: 'get',
                data: {
                    institution: institution,
                    branch: branch
                },
                success: function (employees) {
                    let line = '';
                    $.each(employees, function (i, employee) {
                        let surname = '';
                        let gender = 'Male';
                        {{--let status = '@lang('label.active')';--}}

                        if (employee.surname !== null) {
                            surname = employee.surname;
                        }
                        if (employee.gender === 'F') {
                            gender = 'Female';
                        }
                        {{--if (employee.login_status === 'B') {--}}
                        {{--    status = '@lang('label.inactive')';--}}
                        {{--}--}}

                        line += '<tr>' +
                            '<td class="text-center">' + pad(employee.empmat, 6) + '</td>' +
                            '<td>' + employee.name + ' ' + surname + '</td>' +
                            '<td class="text-center">' + userDate(employee.dob) + '</td>' +
                            '<td>' + gender + '</td>' +
                            '<td>' + employee.phone1 + '</td>' +
                            '<td>' + employee.email + '</td>' +
                            // '<td>' + employee.privilege + '</td>' +
                            // '<td>' + status + '</td>' +
                            '<td class="text-center">' + userDate(employee.created_at) + '</td>' +
                            '</tr>';
                    });
                    $('#collectTable').html(line);
                }
            });
        }

    </script>
@stop
