<?php $emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.member'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.members') </h3>
        </div>
        {{--        <div class="box-header">--}}
        {{--            <div class="box-tools">--}}
        {{--                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div class="box-body">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="all" class="text-blue">
                                <input type="radio" name="all" id="all" class="flat-blue">&nbsp;
                                @if($emp->lang == 'fr') Tous les Clients @else All Clients @endif</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="active" class="text-green">
                                <input type="radio" name="all" id="active" class="flat-green">&nbsp;
                                @if($emp->lang == 'fr') Clients Active @else Active Clients @endif</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="close" class="text-yellow">
                                <input type="radio" name="all" id="close" class="flat-yellow">&nbsp;
                                @if($emp->lang == 'fr') Clients Fermer @else Close Clients @endif</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="dead" class="text-red">
                                <input type="radio" name="all" id="dead" class="flat-red">&nbsp;
                                @if($emp->lang == 'fr') Clients Mort @else Dead Clients @endif</label>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date1" class="col-md-2 control-label">@lang('label.period')</label>
                            <label for="date1"
                                   class="col-md-1 control-label text-right"> @lang('label.from')</label>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <input type="date" name="date1" id="date1" class="form-control">
                                </div>
                            </div>
                            <label for="date2"
                                   class="col-md-1 control-label text-center">@lang('label.to')</label>
                            <div class="col-md-4">
                                <input type="date" name="date2" id="date2" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>

            <div class="col-md-12">
                <table id="bootstrap-data-table" class="table table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th>@lang('label.account')</th>
                        <th>@lang('label.nam&sur')</th>
                        <th>@lang('label.@')</th>
                    </tr>
                    </thead>
                    <tbody id="mem_list">
                    @foreach ($members as $member)
                        <tr>
                            <td>{{pad($member->memnumb, 6)}}</td>
                            <td>{{$member->name}} {{$member->surname}}</td>
                            <td>{{$member->email}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-md-12">
                <button type="button" id="print" class="btn btn-sm btn-raised pull-right fa fa-print"></button>
            </div>
        </div>
    </div>
@stop
