<?php $emp = Session::get('employee');

$title = $menu->labeleng;
if ($emp->lang == 'fr') {
    $title = $menu->labelfr;
    App::setLocale('fr');
}

$nxtOper = (int)$operations->last()->opercode + 1;
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="box box-info" id="newForm" style="display: none;">
        <div class="box-header">
            <h3 class="box-title text-bold" id="title">@lang('label.new_operation')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <form action="{{ route('operation/store') }}" method="post" role="form" id="operationForm" class="needs-validation">
                {{ csrf_field() }}

                <div id="fillform">
                    <input type="hidden" name="idoperation" id="idoperation">
                
                    <div class="row">
                        <div class="col-md-2 col-xs-12">
                            <div class="form-group has-error">
                                <label for="code_" class="col-md-4 col-xs-5 control-label">@lang('label.code')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8 col-xs-7">
                                    <input type="text" class="form-control text-right" name="code_" id="code_" value="{{$operations->count() + 1}}">
                                    <div class="help-block">@lang('placeholder.code')</div>
                                </div>
                            </div>
                        </div>

                        @if($emp->lang == 'fr')
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labelfr" class="col-md-3 col-xs-5 control-label">@lang('label.operation_fr')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                        <div class="help-block">@lang('placeholder.operation_fr')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labeleng" class="col-md-3 col-xs-5 control-label">@lang('label.operation_eng')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                        <div class="help-block">@lang('placeholder.operation_eng')</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labeleng" class="col-md-3 col-xs-5 control-label">@lang('label.operation_eng')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                        <div class="help-block">@lang('placeholder.operation_eng')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labelfr" class="col-md-3 col-xs-5 control-label">@lang('label.operation_fr')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                        <div class="help-block">@lang('placeholder.operation_fr')</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">{{$title}}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="fa fa-plus"></i>&nbsp; @lang('label.new_operation')
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <table id="admin-data-table" class="table table-striped table-hover table-responsive-xl">
                            <thead>
                            <tr>
                                <th>@lang('label.code')</th>
                                <th>{{$title}}</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($operations as $operation)
                                <tr>
                                    <!-- <?php $code = ucfirst(strtolower(substr($operation->labeleng, 0, 2))); ?>
                                    <td>{{$code}}</td> -->
                                    <td class="text-center">{{pad($operation->opercode, 3)}}</td>
                                    <td>@if($emp->lang == 'fr') {{ $operation->labelfr}} @else {{ $operation->labeleng}} @endif</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit('{{$operation->idoper}}')"></button>
                                        <button type="button" class="btn bg-red btn-sm delete fa fa-trash" onclick="remove('{{$operation->idoper}}')"></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form action="{{route('operation/delete')}}" method="post" role="form" id="delForm" style="display: none">
                            {{ csrf_field() }}
                            <input type="hidden" name="operation" id="operation" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('#insertForm').click(function () {
            $('#code_').val(pad(parseInt("{{$nxtOper}}"), 3));
            in_out_form();
            $('#newForm').show();
        });

        function edit(idoperation) {
            $('#code_').prop("readonly", true);

            $.ajax({
                url: "{{ url('getOperation') }}",
                method: 'get',
                data: {
                    operation: idoperation
                },
                success: function (operation) {
                    $('#title').text('@lang('label.edit') @if($emp->lang === 'fr')' + operation.labelfr + ' @else ' + operation.labeleng + '@endif');
                    $('#idoperation').val(operation.idoperation);
                    $('#code_').val(pad(operation.opercode, 3));
                    $('#labelfr').val(operation.labelfr);
                    $('#labeleng').val(operation.labeleng);
                    
                    $('#save').replaceWith('<button type="submit" id="edit" class="edit btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>');

                    $('#newForm').show();
                }
            });
        }

        function remove(idoperation) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.operation_del_text')',
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
                    $('#operation').val(idoperation);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#newForm').hide();
            in_out_form();
        });

        function submitForm() {
            let text = '@lang('confirm.operation_save_text')';
            if ($('#idoperation').val() !== '') {
                text = '@lang('confirm.operation_edit_text')';
            }

            mySwal("{{$title}}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#operationForm');
        }

        function in_out_form() {
            $('#title').text('@lang('label.new_operation')');
            $('#idoperation').val('');
            $('#fillform :input').val('');
            $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }
    </script>
@stop
