<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>
@extends('layouts.dashboard')

@section('title', trans('sidebar.report'))

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="box-tools">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('check_report/store') }}" method="POST" id="cheRegForm" role="form">
                {{ csrf_field() }}
                {{--                <div class="box-header with-border">--}}
                {{--                    <div class="col-md-7">--}}
                {{--                        <div class="form-group">--}}
                {{--                            <label for="member" class="col-md-2 control-label">@lang('label.member')</label>--}}
                {{--                            <div class="col-md-3">--}}
                {{--                                <select class="form-control select2" name="member" id="member">--}}
                {{--                                    <option></option>--}}
                {{--                                    @foreach($members as $member)--}}
                {{--                                        <option--}}
                {{--                                            value="{{$member->idmember}}">{{pad($member->memnumb, 6)}}</option>--}}
                {{--                                    @endforeach--}}
                {{--                                </select>--}}
                {{--                            </div>--}}
                {{--                            <div class="col-md-7">--}}
                {{--                                <input type="text" class="form-control" name="mem_name" id="mem_name"--}}
                {{--                                       disabled>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="col-md-5">--}}
                {{--                        <div class="form-group">--}}
                {{--                            <label for="bank" class="col-md-2 control-label">@lang('label.bank')</label>--}}
                {{--                            <div class="col-md-10">--}}
                {{--                                <select class="form-control select2" name="bank" id="bank">--}}
                {{--                                    <option></option>--}}
                {{--                                    @foreach($banks as $bank)--}}
                {{--                                        <option value="{{ $bank->idbank }}">{{pad($bank->bankcode, 6)}}--}}
                {{--                                            : {{$bank->name}} </option>--}}
                {{--                                    @endforeach--}}
                {{--                                </select>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                {{--                <div class="box-header with-border">--}}
                {{--                    <div class="col-md-3">--}}
                {{--                        <div class="form-group">--}}
                {{--                            <div class="radio">--}}
                {{--                                <label for="unblocked" class="text-blue">--}}
                {{--                                    <input type="radio" name="blocked/unblocked" id="unblocked" class="flat-blue"--}}
                {{--                                           checked>&nbsp;--}}
                {{--                                    @if($emp->lang == 'fr') Tout les Chèques @else All Checks @endif</label>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="col-md-3">--}}
                {{--                        <div class="form-group">--}}
                {{--                            <label for="unblocked" class="text-green">--}}
                {{--                                <input type="radio" name="blocked/unblocked" id="unblocked" class="flat-green">&nbsp;--}}
                {{--                                @if($emp->lang == 'fr') Chèque Payé @else Paid Check @endif--}}
                {{--                            </label>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="col-md-3">--}}
                {{--                        <div class="form-group">--}}
                {{--                            <label for="blocked" class="text-yellow">--}}
                {{--                                <input type="radio" name="blocked/unblocked" id="blocked" class="flat-yellow">&nbsp;--}}
                {{--                                @if($emp->lang == 'fr') Chèque Impayé @else Unpaid Check @endif</label>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="col-md-3">--}}
                {{--                        <div class="form-group">--}}
                {{--                            <label for="not_used" class="text-red">--}}
                {{--                                <input type="radio" name="blocked/unblocked" id="not_used" class="flat-red">&nbsp;--}}
                {{--                                @if($emp->lang == 'fr') Chèque Déposés @else Drop Check @endif</label>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                <div class="col-md-12">
                    <table id="bootstrap-data-table"
                           class="table table-hover table-bordered table-condensed table-responsive table-striped">
                        <thead>
                        <tr>
                            <th>@lang('label.checkno')</th>
                            <th>@lang('label.bank')</th>
                            <th>@lang('label.member')</th>
                            <th>@lang('label.status')</th>
                            <th>@lang('label.opera')</th>
                            <th>@lang('label.amount')</th>
                            <th>@lang('label.date')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($checks as $check)
                            <tr>
                                <td>{{$check->checknumb}}</td>
                                <td>
                                    @foreach ($banks as $bank)
                                        @if ($bank->idbank == $check->bank)
                                            {{$bank->name}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($members as $member)
                                        @if ($member->idmember == $check->member)
                                            {{pad($member->memnumb, 6)}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if ($check->status == 'D')
                                        @if($emp->lang == 'fr') Non Traité @else Not Traited @endif
                                    @elseif ($check->status == 'P' || $check->status == null)
                                        @if($emp->lang == 'fr') Payé @else Paid @endif
                                    @elseif ($check->status == 'U')
                                        @if($emp->lang == 'fr') Impayé @else Unpaid @endif
                                    @endif
                                </td>
                                <td>
                                    @foreach ($operas as $opera)
                                        @if ($opera->idoper == $check->operation)
                                            @if($emp->lang == 'fr') {{$opera->labelfr}} @else {{$opera->labeleng}} @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-right text-bold">{{money((int)$check->amount)}}</td>
                                <td class="text-center">{{changeFormat($check->updated_at)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12">
                    <button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save">
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop

@section('script')
    <script>
        $('#save').click(function () {
            swal({
                    title: '@lang('confirm.chereg_header')',
                    text: '@lang('confirm.chereg_text')',
                    type: 'info',
                    showCancelButton: true,
                    cancelButtonClass: 'bg-red',
                    confirmButtonClass: 'bg-blue',
                    confirmButtonText: '@lang('confirm.yes')',
                    cancelButtonText: '@lang('confirm.no')',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $('#cheRegForm').submit();
                    }
                }
            );
        });
    </script>
@stop
