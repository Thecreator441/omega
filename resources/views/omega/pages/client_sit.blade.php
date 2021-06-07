<?php
use App\Models\Branch;use App\Models\Institution;use App\Models\Zone;$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.client_sit'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.client_sit') </h3>
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
                    <?php $zbranchs = Branch::getBranches(['institution' => $emp->institution]); ?>
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
{{--                @if ($emp->privilege !== 4)--}}
{{--                    <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="collector" class="col-md-4 control-label">@lang('label.collector')</label>--}}
{{--                            <div class="col-md-8">--}}
{{--                                <select class="form-control select2" id="collector" name="collector">--}}
{{--                                    <option value=""></option>--}}
{{--                                    @foreach($collectors as $collector)--}}
{{--                                        <option value="{{$collector->idcoll}}">{{$collector->name}} {{$collector->surname}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-1">--}}
{{--                        <div class="form-group">--}}
{{--                            <button type="button" id="search" class="btn btn-sm bg-green btn-raised fa fa-search"></button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="form-group"></div>--}}
{{--                @endif--}}
            </div>

            <div class="row">
                <div class="col-md-12" id="tableInput">
{{--                    id="bootstrap-data-table"--}}
<table id="admin-data-table" class="table table-bordered table-striped table-hover table-responsive-xl">
                <thead>
                        <tr>
                            <th>@lang('label.number')</th>
                            <th>@lang('label.member')</th>
                            <th>@lang('label.amount')</th>
                        </tr>
                        </thead>
                        <tbody id="collectTable">
                        @foreach($members as $member)
                            <tr>
                                <td class="text-center">{{pad($member->coll_memnumb, 6)}}</td>
                                <td>{{$member->name}} {{$member->surname}}</td>
                                <td class="text-right text-bold cus_com">
                                    @if ((int)$member->available === 0)
                                        {{money((int)$member->evebal)}}
                                    @else
                                        {{money((int)$member->available)}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
{{--                        <tfoot class="bg-antiquewhite">--}}
{{--                        <tr>--}}
{{--                            <th colspan="2" class="text-center">@lang('label.total')</th>--}}
{{--                            <th class="text-right">--}}
{{--                                <input type="text" name="total_cus" id="totcus_com" class="text-right text-bold" readonly>--}}
{{--                            </th>--}}
{{--                        </tr>--}}
{{--                        </tfoot>--}}
                    </table>
                </div>
            </div>

{{--            <div class="col-md-12">--}}
{{--                <button type="button" id="print" class="btn btn-sm bg-default pull-right btn-raised fa fa-print">--}}
{{--                </button>--}}
{{--            </div>--}}
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            // fillCustBals($('#institution').val(), $('#branch').val(), $('#collector').val());

            sumFields();
        });

        function sumFields() {
            let totCus = 0;

            $('.cus_com').each(function () {
                let numb = trimOver($(this).text(), null);
                if (parseInt(numb))
                    totCus += parseInt(numb);
            });
            $('#totcus_com').val(money(totCus));
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
            fillCustBals($('#institution').val(), $('#branch').val(), $('#collector').val());
        });

        function fillCustBals(institution = null, branch = null, collector = null) {
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
                    url: "{{url('getFilterCustBals')}}",
                    data: {
                        institution: institution,
                        branch: branch,
                        collector: collector
                    },
                    datatype: 'json'
                },
                columns: [
                    {data: 'code', class: 'text-center'},
                    {data: 'name'},
                    {data: 'amount', class: 'text-bold text-right amount'}
                ]
            });

            {{--$.ajax({--}}
            {{--    url: "{{url('getFilterCustBals')}}",--}}
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
            {{--            let available = parseInt(customer.available);--}}
            {{--            if (customer.surname !== null) {--}}
            {{--                surname = customer.surname;--}}
            {{--            }--}}

            {{--            if (parseInt(customer.available) === 0) {--}}
            {{--                available = parseInt(customer.evebal);--}}
            {{--            }--}}

            {{--            line += '<tr>' +--}}
            {{--                '<td class="text-center">' + pad(customer.coll_memnumb, 6) + '</td>' +--}}
            {{--                '<td>' + customer.name + ' ' + surname + '</td>' +--}}
            {{--                '<td class="text-bold text-right cus_com">' + money(available) + '</td>' +--}}
            {{--                '</tr>';--}}
            {{--        });--}}
            {{--        $('#collectTable').html(line);--}}
            {{--        sumFields();--}}
            {{--    }--}}
            {{--});--}}
        }
    </script>
@stop
