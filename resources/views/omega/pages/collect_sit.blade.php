<?php
use App\Models\Branch;use App\Models\Institution;use App\Models\Zone;$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.collect_sit'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.collect_sit') </h3>
        </div>
        <div class="box-body">
            <form action="{{ url('collect_sit/store') }}" method="post" role="form" id="cinForm">
                {{ csrf_field() }}

                <div class="row">
                    @if ($emp->level === 'N')
                        <?php $zones = Zone::getZones(['network' => $emp->network]); ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="zone" class="col-md-4 control-label">@lang('label.zone')</label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="zone" name="zone">
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="month" class="col-md-4 control-label">@lang('label.month')</label>
                                <div class="col-md-8">
                                    <select name="month" id="month" class="from-control select2">
                                        <option value=""></option>
                                        <option value="1" @if($month===1) selected @endif>@lang('label.jan')</option>
                                        <option value="2" @if($month===2) selected @endif>@lang('label.feb')</option>
                                        <option value="3" @if($month===3) selected @endif>@lang('label.mar')</option>
                                        <option value="4" @if($month===4) selected @endif>@lang('label.apr')</option>
                                        <option value="5" @if($month===5) selected @endif>@lang('label.may')</option>
                                        <option value="6" @if($month===6) selected @endif>@lang('label.jun')</option>
                                        <option value="7" @if($month===7) selected @endif>@lang('label.jul')</option>
                                        <option value="8" @if($month===8) selected @endif>@lang('label.aug')</option>
                                        <option value="9" @if($month===9) selected @endif>@lang('label.sep')</option>
                                        <option value="10" @if($month===10) selected @endif>@lang('label.oct')</option>
                                        <option value="11" @if($month===11) selected @endif>@lang('label.nov')</option>
                                        <option value="12" @if($month===12) selected @endif>@lang('label.dec')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="month" class="col-md-4 control-label">@lang('label.month')</label>
                                <div class="col-md-8">
                                    <select name="month" id="month" class="from-control select2">
                                        <option value=""></option>
                                        <option value="1" @if($month===1) selected @endif>@lang('label.jan')</option>
                                        <option value="2" @if($month===2) selected @endif>@lang('label.feb')</option>
                                        <option value="3" @if($month===3) selected @endif>@lang('label.mar')</option>
                                        <option value="4" @if($month===4) selected @endif>@lang('label.apr')</option>
                                        <option value="5" @if($month===5) selected @endif>@lang('label.may')</option>
                                        <option value="6" @if($month===6) selected @endif>@lang('label.jun')</option>
                                        <option value="7" @if($month===7) selected @endif>@lang('label.jul')</option>
                                        <option value="8" @if($month===8) selected @endif>@lang('label.aug')</option>
                                        <option value="9" @if($month===9) selected @endif>@lang('label.sep')</option>
                                        <option value="10" @if($month===10) selected @endif>@lang('label.oct')</option>
                                        <option value="11" @if($month===11) selected @endif>@lang('label.nov')</option>
                                        <option value="12" @if($month===12) selected @endif>@lang('label.dec')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="month" class="col-md-3 control-label">@lang('label.month')</label>
                                <div class="col-md-9">
                                    <select name="month" id="month" class="from-control select2">
                                        <option value=""></option>
                                        <option value="1" @if($month===1) selected @endif>@lang('label.jan')</option>
                                        <option value="2" @if($month===2) selected @endif>@lang('label.feb')</option>
                                        <option value="3" @if($month===3) selected @endif>@lang('label.mar')</option>
                                        <option value="4" @if($month===4) selected @endif>@lang('label.apr')</option>
                                        <option value="5" @if($month===5) selected @endif>@lang('label.may')</option>
                                        <option value="6" @if($month===6) selected @endif>@lang('label.jun')</option>
                                        <option value="7" @if($month===7) selected @endif>@lang('label.jul')</option>
                                        <option value="8" @if($month===8) selected @endif>@lang('label.aug')</option>
                                        <option value="9" @if($month===9) selected @endif>@lang('label.sep')</option>
                                        <option value="10" @if($month===10) selected @endif>@lang('label.oct')</option>
                                        <option value="11" @if($month===11) selected @endif>@lang('label.nov')</option>
                                        <option value="12" @if($month===12) selected @endif>@lang('label.dec')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($emp->level === 'B')
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="month" class="col-md-3 control-label">@lang('label.month')</label>
                                <div class="col-md-9">
                                    <select name="month" id="month" class="from-control select2">
                                        <option value=""></option>
                                        <option value="1" @if($month===1) selected @endif>@lang('label.jan')</option>
                                        <option value="2" @if($month===2) selected @endif>@lang('label.feb')</option>
                                        <option value="3" @if($month===3) selected @endif>@lang('label.mar')</option>
                                        <option value="4" @if($month===4) selected @endif>@lang('label.apr')</option>
                                        <option value="5" @if($month===5) selected @endif>@lang('label.may')</option>
                                        <option value="6" @if($month===6) selected @endif>@lang('label.jun')</option>
                                        <option value="7" @if($month===7) selected @endif>@lang('label.jul')</option>
                                        <option value="8" @if($month===8) selected @endif>@lang('label.aug')</option>
                                        <option value="9" @if($month===9) selected @endif>@lang('label.sep')</option>
                                        <option value="10" @if($month===10) selected @endif>@lang('label.oct')</option>
                                        <option value="11" @if($month===11) selected @endif>@lang('label.nov')</option>
                                        <option value="12" @if($month===12) selected @endif>@lang('label.dec')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-1">
                        <div class="form-group">
                            <button type="button" id="search" class="btn btn-sm bg-green btn-raised fa fa-search"></button>
                        </div>
                    </div>
                    <div class="form-group"></div>
                </div>

                <div class="row">
                    <div class="col-md-12" id="tableInput">
                        {{--                        @if ($emp->privilege !== 4) id="bootstrap-data-table" @else id="simul-data-table" @endif--}}
                        <table id="admin-data-table" class="table table-striped table-hover table-bordered table-condensed table-responsive">
                            <thead>
                            <tr>
                                <th>@lang('label.code')</th>
                                <th>@lang('label.collector')</th>
                                <th>@lang('label.commis')</th>
                            </tr>
                            </thead>
                            <tbody id="collectTable">
                            @foreach ($collectors as $collector)
                                <tr>
                                    <td class="text-center">{{pad($collector->code, 6)}}</td>
                                    <td>{{$collector->name}} {{$collector->surname}}</td>
                                    <td class="text-bold text-right col_com">{{money($collector->col_com)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            @if ($emp->collector === null && $emp->coll_mem === null)
                                <tfoot class="bg-antiquewhite">
                                <tr>
                                    <th colspan="2" class="text-center">@lang('label.total')</th>
                                    <th class="text-right">
                                        <input type="text" name="total_col" id="totcol_com" class="text-right text-bold" readonly>
                                    </th>
                                </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </form>
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

        $('#search').click(function () {
            getFilterCollectBals($('#institution').val(), $('#branch').val(), $('#month').val());
        });

        function getFilterCollectBals(institution = null, branch = null, month = null) {
            $.ajax({
                url: "{{url('getFilterCollectBals')}}",
                method: 'get',
                data: {
                    institution: institution,
                    branch: branch,
                    month: month
                },
                success: function (collectors) {
                    console.log(collectors);
                    let line = '';
                    $.each(collectors, function (i, collector) {
                        let surname = '';

                        if (collector.surname !== null) {
                            surname = collector.surname;
                        }

                        line += '<tr>' +
                            '<td class="text-center">' + pad(collector.code, 6) + '</td>' +
                            '<td>' + collector.name + ' ' + surname + '</td>' +
                            '<td class="text-bold text-right col_com">' + money(collector.col_com) + '</td>' +
                            '</tr>';
                    });
                    $('#collectTable').html(line);
                    sumFields();
                }
            });
        }
    </script>
@stop
