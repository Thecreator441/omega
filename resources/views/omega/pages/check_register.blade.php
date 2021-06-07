<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>
@extends('layouts.dashboard')

@section('title', trans('sidebar.register'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.register') </h3>
        </div>
{{--        <div class="box-header">--}}
{{--            <div class="box-tools">--}}
{{--                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="box-body">
            <form action="{{ url('check_register/store') }}" method="POST" id="cheRegForm" role="form">
                {{ csrf_field() }}
                <div class="col-md-12">
                    <table id="bootstrap-data-table"
                           class="table table-hover table-bordered table-condensed table-responsive table-striped">
                        <thead>
                        <tr>
                            <th>@lang('label.checkno')</th>
                            <th>@lang('label.bank')</th>
                            <th>@lang('label.member')</th>
                            <th>@lang('label.opera')</th>
                            <th>@lang('label.amount')</th>
                            <th>@lang('label.status')</th>
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
                                    @foreach ($operas as $opera)
                                        @if ($opera->idoper == $check->operation)
                                            @if($emp->lang == 'fr') {{$opera->labelfr}} @else {{$opera->labeleng}} @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-right text-bold">{{money((int)$check->amount)}}</td>
                                <td class="text-center">
                                    <label for="prov">
                                        <input type="radio" id="prov" name="provisions[{{$check->idcheck}}]"
                                               value="P{{$check->idcheck}}" class="bg-green"></label>
                                    <label for="noprov" >
                                        <input type="radio" id="noprov" name="provisions[{{$check->idcheck}}]"
                                               value="U{{$check->idcheck}}" class="bg-red"></label>
                                </td>
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
                    title: '@lang('sidebar.register')',
                    text: '@lang('confirm.chereg_text')',
                    type: 'info',
                    showCancelButton: true,
                    cancelButtonClass: 'bg-red',
                    confirmButtonClass: 'bg-green',
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
