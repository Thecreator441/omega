<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.backup'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.backup') </h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-sm bg-blue btn-sm pull-right" id="bacBtn">
                    <i class="fa fa-save"></i>&nbsp;@lang('label.newbac')
                </button>
                <form action="{{url('admin/backup/store')}}" method="post" role="form" id="bacForm" style="display: none">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
        <div class="box-body">
            <table id="billet-data-table" class="table table-bordered table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th>@lang('label.file')</th>
                    <th>@lang('label.size')</th>
                    <th>@lang('label.date')</th>
                    <th>@lang('label.age')</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($backups as $backup)
                    <tr>
                        <td>{{$backup['file_name'] }}</td>
                        <td>{{round((int)$backup['file_size']/1048576, 2).' MB'}}</td>
                        <td>{{\Carbon\Carbon::createFromTimeStamp($backup['last_modified'])->formatLocalized('%d %B %Y, %H:%M')}}</td>
                        <td>{{\Carbon\Carbon::createFromTimeStamp($backup['age'])->formatLocalized('%d %B %Y, %H:%M')}}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm bg-gray fa fa-download" onclick="down('{{$backup['disk']}}', '{{urlencode($backup['file_name'])}}')"></button>
                            <button type="button" class="btn btn-sm bg-red fa fa-trash" onclick="remove('{{$backup['file_name']}}', '{{$backup['disk']}}')"></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <form action="{{url('admin/backup/delete')}}" method="post" role="form" id="delForm" style="display: none">
                {{ csrf_field() }}
                <input type="hidden" name="file_name" id="file_name" value="">
                <input type="hidden" name="disk" id="disk" value="">
            </form>
            <form action="{{url('admin/backup/download')}}" method="post" role="form" id="dowForm" style="display: none">
                {{ csrf_field() }}
                <input type="hidden" name="disk" id="down_disk" value="">
                <input type="hidden" name="file_path" id="file_path" value="">
                <input type="hidden" name="file_name" id="down_file_name" value="">
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('#bacBtn').click(function () {
            swal({
                icon: 'warning',
                title: '@lang('sidebar.backup')',
                text: '@lang('confirm.backup_text')',
                closeOnClickOutside: false,
                allowOutsideClick: false,
                closeOnEsc: false,
                buttons: {
                    cancel: {
                        text: ' @lang('confirm.no')',
                        value: false,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-red fa fa-close"
                    },
                    confirm: {
                        text: ' @lang('confirm.yes')',
                        value: true,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-green fa fa-check"
                    },
                },
            }).then(function (isConfirm) {
                if (isConfirm) {
                    $('#bacForm').submit();
                }
            });
        });

        function down(disk, file_name) {
            swal({
                icon: 'warning',
                title: '@lang('sidebar.backup')',
                text: '@lang('confirm.backupdow_text')',
                closeOnClickOutside: false,
                allowOutsideClick: false,
                closeOnEsc: false,
                buttons: {
                    cancel: {
                        text: ' @lang('confirm.no')',
                        value: false,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-red fa fa-close"
                    },
                    confirm: {
                        text: ' @lang('confirm.yes')',
                        value: true,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-green fa fa-check"
                    },
                },
            }).then(function (isConfirm) {
                if (isConfirm) {
                    $('#down_disk').val(disk);
                    $('#down_file_name').val(file_name);

                    $('#dowForm').submit();
                }
            });
        }

        function remove(file_name, disk) {
            swal({
                icon: 'warning',
                title: '@lang('sidebar.backup')',
                text: '@lang('confirm.backupdel_text')',
                closeOnClickOutside: false,
                allowOutsideClick: false,
                closeOnEsc: false,
                buttons: {
                    cancel: {
                        text: ' @lang('confirm.no')',
                        value: false,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-red fa fa-close"
                    },
                    confirm: {
                        text: ' @lang('confirm.yes')',
                        value: true,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-green fa fa-check"
                    },
                },
            }).then(function (isConfirm) {
                if (isConfirm) {
                    $('#file_name').val(file_name);
                    $('#disk').val(disk);
                    $('#delForm').submit();
                }
            });
        }
    </script>
@stop
