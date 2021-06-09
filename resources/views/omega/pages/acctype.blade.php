<?php $emp = Session::get('employee');

$title = $menu->labeleng;
if ($emp->lang == 'fr') {
    $title = $menu->labelfr;
    App::setLocale('fr');
}
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box box-info" id="newForm" style="display: none;">
        <div class="box-header">
            <h3 class="box-title text-bold" id="title">@lang('label.new_acctype')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <form action="{{ route('acctype/store') }}" method="post" role="form" id="acctypeForm" class="needs-validation">
                {{ csrf_field() }}

                <div id="fillform">
                    <input type="hidden" name="idacctype" id="idacctype">

                    <div class="row">
                        <!-- <div class="col-md-2 col-xs-12">
                            <div class="form-group has-error">
                                <label for="code_abbr" class="col-md-4 col-xs-5 control-label">@lang('label.code')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8 col-xs-7">
                                    <input type="text" class="form-control" name="code_abbr" id="code_abbr" required>
                                    <div class="help-block">@lang('placeholder.code')</div>
                                </div>
                            </div>
                        </div> -->

                        @if($emp->lang == 'fr')
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labelfr" class="col-md-3 col-xs-5 control-label">@lang('label.acc_type_fr')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                        <div class="help-block">@lang('placeholder.acc_type_fr')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labeleng" class="col-md-3 col-xs-5 control-label">@lang('label.acc_type_eng')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                        <div class="help-block">@lang('placeholder.acc_type_eng')</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labeleng" class="col-md-3 col-xs-5 control-label">@lang('label.acc_type_eng')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                        <div class="help-block">@lang('placeholder.acc_type_eng')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="labelfr" class="col-md-3 col-xs-5 control-label">@lang('label.acc_type_fr')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9 col-xs-7">
                                        <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                        <div class="help-block">@lang('placeholder.acc_type_fr')</div>
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
                    <i class="fa fa-plus"></i>&nbsp; @lang('label.new_acctype')
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
                            @foreach($acctypes as $acctype)
                                <tr>
                                    <!-- <?php $code = ucfirst(strtolower(substr($acctype->labeleng, 0, 2))); ?>
                                    <td>{{$code}}</td> -->
                                    <td class="text-center">{{$acctype->accabbr}}</td>
                                    <td>@if($emp->lang == 'fr') {{ $acctype->labelfr}} @else {{ $acctype->labeleng}} @endif</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit('{{$acctype->idacctype}}')"></button>
                                        <button type="button" class="btn bg-red btn-sm delete fa fa-trash" onclick="remove('{{$acctype->idacctype}}')"></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form action="{{route('acctype/delete')}}" method="post" role="form" id="delForm" style="display: none">
                            {{ csrf_field() }}
                            <input type="hidden" name="acctype" id="acctype" value="">
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
            in_out_form();
            $('#newForm').show();
        });

        function edit(idacctype) {
            $.ajax({
                url: "{{ url('getAccType') }}",
                method: 'get',
                data: {
                    acctype: idacctype
                },
                success: function (acc_type) {
                    $('#title').text('@lang('label.edit') @if($emp->lang === 'fr')' + acc_type.labelfr + ' @else ' + acc_type.labeleng + '@endif');
                    $('#idacctype').val(acc_type.idacctype);
                    $('#labelfr').val(acc_type.labelfr);
                    $('#labeleng').val(acc_type.labeleng);

                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit edit"></button>');

                    $('#newForm').show();
                }
            });
        }

        function remove(idacctype) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.acctype_del_text')',
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
                    $('#acctype').val(idacctype);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#newForm').hide();
            in_out_form();
        });

        function submitForm() {
            let text = '@lang('confirm.acctype_save_text')';
            if ($('#idacctype').val() !== '') {
                text = '@lang('confirm.acctype_edit_text')';
            }

            mySwal("{{$title}}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#acctypeForm');
        }

        function in_out_form() {
            $('#title').text('@lang('label.new_acctype')');
            $('#idacctype').val('');
            $('#fillform :input').val('');
            $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }
    </script>
@stop
