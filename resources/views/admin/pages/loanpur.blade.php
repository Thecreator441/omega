<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.lpur'))

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close home" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        {{ $loanpurs->links('layouts.includes.pagination') }}
                    </div>
                </div>
            </div>
            <form action="{{ route('admin/loanpur/store') }}" method="post" role="form" id="loanPurForm">
                {{ csrf_field() }}
                <div id="form">
                    @if ($loanpurs->count() == 0)
                        <div class="box-header with-border">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="loaneng"
                                               class="col-md-3 control-label">@lang('label.labeleng')</label>
                                        <div class="col-md-9">
                                            <input type="text" name="loaneng" id="loaneng" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="loanfr"
                                               class="col-md-3 control-label">@lang('label.labelfr')</label>
                                        <div class="col-md-9">
                                            <input type="text" name="loanfr" id="loanfr" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" id="delete" disabled
                                                class="btn btn-sm bg-red pull-right btn-raised fa fa-trash">
                                        </button>
                                        <button type="button" id="update" disabled
                                                class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle">
                                        </button>
                                        <button type="button" id="save"
                                                class="btn btn-sm bg-blue pull-right btn-raised fa fa-save">
                                        </button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach ($loanpurs as $loanpur)
                            <input type="hidden" id="idloantype" name="idloantype" value="{{$loanpur->idloanpur}}">
                            <div class="box-header with-border">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="loaneng"
                                                   class="col-md-3 control-label">@lang('label.labeleng')</label>
                                            <div class="col-md-9">
                                                <input type="text" name="loaneng" id="loaneng" class="form-control" readonly value="{{$loanpur->labeleng}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="loanfr"
                                                   class="col-md-3 control-label">@lang('label.labelfr')</label>
                                            <div class="col-md-9">
                                                <input type="text" name="loanfr" id="loanfr" class="form-control" readonly value="{{$loanpur->labelfr}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                    <div class="col-md-12">
                                        <button type="button" id="delete"
                                                class="btn btn-sm bg-red pull-right btn-raised fa fa-trash">
                                        </button>
                                        <button type="button" id="update"
                                                class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle">
                                        </button>
                                        <button type="button" id="insert"
                                                class="btn btn-sm bg-blue pull-right btn-raised fa fa-file-o">
                                        </button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('#insert').click(function () {
            setEditable();
            $('#form :input').val('');
            $(this).replaceWith('<button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
            $('.bg-aqua').replaceWith('<button type="button" id="update" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle" disabled></button>');
            $('#form .bg-red').attr('disabled', true);
        });

        $('#update').click(function () {
            setEditable();
            $(this).replaceWith('<button type="button" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>');
        });

        $(document).on('click', '#save, #edit', function () {
            let text = '';
            if ($('#idloanpur').val() === '')
                text = '@lang('confirm.lpursave_text')';
            else
                text = '@lang('confirm.lpuredit_text')';

            swal({
                    title: '@lang('sidebar.lpur')',
                    text: text,
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
                        $('#loanPurForm').submit();
                    }
                }
            );
        });

        $('#delete').click(function () {
            swal({
                    title: '@lang('sidebar.lpur')',
                    text: '@lang('confirm.lpurdel_text')',
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
                        let form = $('#loanPurForm');
                        form.attr('action', 'admin/loanpur/delete');
                        form.submit();
                    }
                }
            );
        });

        function setEditable() {
            $('#form :input').removeAttr('readonly');
        }
    </script>
@stop
