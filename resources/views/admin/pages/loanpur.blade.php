<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr') {
    App::setLocale('fr');
    $title = 'Bût Pret';
} else {
    $title = 'Loan Purpose';
}
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
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
                        <input type="hidden" id="idloanpur" name="idloanpur">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="loancode" class="col-md-6 control-label">@lang('label.loanpur')</label>
                                    <div class="col-md-6">
                                        <input type="text" name="purcode" id="purcode" class="form-control"
                                               placeholder="@lang('label.code')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="pureng" id="pureng" class="form-control"
                                               placeholder="@lang('label.labeleng')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="purfr" id="purfr" class="form-control"
                                               placeholder="@lang('label.labelfr')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
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
                    @else
                        @foreach ($loanpurs as $loanpur)
                            <input type="hidden" id="idloantype" name="idloantype" value="{{$loanpur->idloanpur}}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="purcode" class="col-md-6 control-label">@lang('label.loanty')</label>
                                        <div class="col-md-6">
                                            <input type="text" name="purcode" id="purcode" class="form-control"
                                                   value="{{pad($loanpur->purcode, 3)}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="pureng" id="pureng" class="form-control" readonly
                                                   placeholder="@lang('label.labeleng')" value="{{$loanpur->labeleng}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="purfr" id="purfr" class="form-control" readonly
                                                   placeholder="@lang('label.labelfr')" value="{{$loanpur->labelfr}}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
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
                        @endforeach
                    @endif
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            $("#purcode").verifNumber();
        });

        $('#purfr, #pureng').on('input', function () {
            $(this).val($(this).val().toUpperCase())
        });

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
                    title: '@lang('confirm.lpur_header')',
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
                    title: '@lang('confirm.lpur_header')',
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
