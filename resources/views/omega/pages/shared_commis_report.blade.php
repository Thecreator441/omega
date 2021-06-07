<?php

use App\Models\Branch;use App\Models\Institution;use App\Models\Zone;

$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.shared_commis_report'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.shared_commis_report') </h3>
        </div>
        <div class="box-body">
            <div class="row">
                @if ($emp->level === 'N')
                    <input type="hidden" name="network" id="network" value="{{$emp->network}}">
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
                @endif
                @if ($emp->level === 'Z')
                        <input type="hidden" name="zone" id="zone" value="{{$emp->zone}}">
                    <?php $institutes = Institution::getInstitutions(['zone' => $emp->zone]); ?>
                    <div class="col-md-3">
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
                @endif
                @if ($emp->level === 'I')
                        <input type="hidden" name="institution" id="institution" value="{{$emp->institution}}">
                    <?php $branchs = Branch::getBranches(['institution' => $emp->institution]); ?>
                    <div class="col-md-3">
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
                @endif
                @if ($emp->collector === null)
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="collector" class="col-md-3 control-label">@lang('label.collector')s</label>
                            <div class="col-md-9">
                                <select name="collector" id="collector" class="from-control select2">
                                    <option value=""></option>
                                    @foreach ($collectors as $collector)
                                        <option value="{{$collector->iduser}}">{{pad($collector->code, 3)}} : {{$collector->name}} {{$collector->surname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @else
                        <input type="hidden" name="collector" id="collector" value="{{$emp->iduser}}">
                @endif
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date1" class="col-md-1 control-label">@lang('label.from')</label>
                        <div class="col-md-5">
                            <input type="date" name="date1" id="date1" class="form-control">
                        </div>
                        <label for="date2" class="col-md-1 control-label text-center">@lang('label.to')</label>
                        <div class="col-md-5">
                            <input type="date" name="date2" id="date2" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <button type="button" id="search" class="btn btn-sm bg-green btn-raised fa fa-search"></button>
                    </div>
                </div>
                <div class="form-group"></div>
            </div>

            <table id="admin-data-table" class="table table-bordered table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th> @lang('label.date') </th>
                    <th> @lang('label.custcode') </th>
                    <th> @lang('label.custnam&sur') </th>
                    <th> @lang('label.amount') </th>
                    <th> @lang('label.commis')s</th>
                    <th> @lang('label.tax') </th>
                    <th>@lang('label.col_com')</th>
                    <th>@lang('label.inst_com')</th>
                </tr>
                </thead>
                <tbody id="collectTable">
                @foreach($writings as $writing)
                    <tr>
                        <td class="text-center">{{changeFormat($writing->accdate)}}</td>
                        <td class="text-center">{{pad($writing->code, 6)}}</td>
                        <td>{{$writing->name}} {{$writing->surname}}</td>
                        <td class="text-right text-bold">{{money((int)($writing->total))}}</td>
                        <td class="text-right text-bold">{{money((int)($writing->revenue))}}</td>
                        <td class="text-right text-bold">{{money((int)($writing->tax))}}</td>
                        <td class="text-right text-bold">{{money((int)($writing->col_com))}}</td>
                        <td class="text-right text-bold">{{money((int)($writing->inst_com))}}</td>
                    </tr>
                @endforeach
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
                url: "{{ url('getCollectorsCash') }}",
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
                        option += "<option " + "value=" + collector.iduser + ">" + pad(collector.code, 6) + " : " + collector.name + " " + surname + "</option>";
                    });
                    $('#collector').html(option);
                },
                error: function (errors) {
                    console.log(errors);
                }
            });
        });

        $('#search').click(function () {
            getFilterReports($('#zone').val(), $('#institution').val(), $('#branch').val(), $('#collector').val(), $('#date1').val(), $('#date2').val());
        });

        function getFilterReports(zone = null, institution = null, branch = null, collector = null, date1 = null, date2 = null) {
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
                    url: "{{url('getFilterReports')}}",
                    data: {
                        zone: zone,
                        institution: institution,
                        branch: branch,
                        collector: collector,
                        date1: date1,
                        date2: date2,
                    },
                    datatype: 'json'
                },
                columns: [
                    {data: 'accdate', class: 'text-center'},
                    {data: 'code', class: 'text-center'},
                    {data: 'name'},
                    {data: 'total', class: 'text-bold text-right total'},
                    {data: 'revenue', class: 'text-bold text-right revenue'},
                    {data: 'tax', class: 'text-bold text-right tax'},
                    {data: 'col_com', class: 'text-bold text-right col_com'},
                    {data: 'inst_com', class: 'text-bold text-right inst_com'}
                ]
            });


            {{--$.ajax({--}}
            {{--    url: "{{url('getFilterReports')}}",--}}
            {{--    method: 'get',--}}
            {{--    data: {--}}
            {{--        zone: zone,--}}
            {{--        institution: institution,--}}
            {{--        branch: branch,--}}
            {{--        collector: collector,--}}
            {{--        date1: date1,--}}
            {{--        date2: date2,--}}
            {{--    },--}}
            {{--    success: function (collects) {--}}
            {{--        // console.log(collects);--}}
            {{--        let line = '';--}}
            {{--        $.each(collects, function (i, collect) {--}}
            {{--            let surname = '';--}}

            {{--            if (collect.surname !== null) {--}}
            {{--                surname = collect.surname;--}}
            {{--            }--}}

            {{--            line += '<tr>' +--}}
            {{--                '<td class="text-center">' + userDate(collect.accdate) + '</td>' +--}}
            {{--                '<td class="text-center">' + pad(collect.code, 6) + '</td>' +--}}
            {{--                '<td>' + collect.name + ' ' + surname + '</td>' +--}}
            {{--                '<td class="text-bold text-right total">' + money(collect.total) + '</td>' +--}}
            {{--                '<td class="text-bold text-right revenue">' + money(collect.revenue) + '</td>' +--}}
            {{--                '<td class="text-bold text-right tax">' + money(collect.tax) + '</td>' +--}}
            {{--                '<td class="text-bold text-right col_com">' + money(collect.col_com) + '</td>' +--}}
            {{--                '<td class="text-bold text-right col_com">' + money(collect.inst_com) + '</td>' +--}}
            {{--                '</tr>';--}}
            {{--        });--}}
            {{--        $('#collectTable').html(line);--}}
            {{--        // sumFields();--}}
            {{--    },--}}
            {{--    error: function (errors) {--}}
            {{--        console.log(errors);--}}
            {{--        $.each(errors, function (i, error) {--}}
            {{--            console.log(error.message)--}}
            {{--        });--}}
            {{--    }--}}
            {{--});--}}
        }
    </script>
@stop
