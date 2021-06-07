<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.division'))

@section('content')
    <div class="box box-info" id="newForm" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title text-bold" id="title">@lang('label.newdiv')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ route('admin/division/store') }}" method="post" role="form" class="needs-validation" id="divForm">
                {{ csrf_field() }}

                <div id="fillform">
                    <input type="hidden" name="iddivision" id="iddivision">

                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="form-group has-error">
                                <label for="country" class="col-md-4 control-label">@lang('label.country')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="country" name="country" required>
                                        <option value=""></option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->idcountry }}">@if($emp->lang == 'fr') {{ $country->labelfr }} @else {{ $country->labeleng }} @endif</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.country')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="form-group has-error">
                                <label for="region" class="col-md-4 control-label">@lang('label.region')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="region" name="region" required>
                                        <option value=""></option>
                                        @foreach ($regions as $region)
                                            <option value="{{$region->idregi}}">@if ($emp->lang === 'fr') {{$region->labelfr}} @else {{$region->labeleng}} @endif</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group has-error">
                                <label for="label" class="col-md-2 control-label">@lang('label.division')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="label" id="label" required>
                                    <span class="help-block">@lang('placeholder.name')</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                </div>
            </form>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">@lang('sidebar.division')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="oin ion-plus"></i>&nbsp;@lang('label.newdiv')
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <table id="admin-data-table" class="table table-bordered table-striped table-condensed table-responsive-xl">
                            <thead>
                            <tr>
                                <th>@lang('label.label')</th>
                                <th>@lang('label.region')</th>
                                <th>@lang('label.country')</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($divisions as $division)
                                <tr>
                                    <td>{{$division->label}}</td>
                                    <td>
                                        @if($emp->lang === 'fr') {{ $division->reg_fr }} @else {{ $division->reg_en }} @endif
                                    </td>
                                    <td>
                                        @if($emp->lang === 'fr') {{ $division->cou_fr }} @else {{ $division->cou_en }} @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit('{{$division->iddiv}}')"></button>
                                        <button type="button" class="btn bg-red btn-sm delete fa fa-trash" onclick="remove('{{$division->iddiv}}')"></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form action="{{route('admin/division/delete')}}" method="post" role="form" id="delForm" style="display: none">
                            {{ csrf_field() }}
                            <input type="hidden" name="division" id="division" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        /**
         * Get the regions based on the country
         */
        $('#country').change(function (e) {
            e.preventDefault();

            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getRegions') }}",
                    method: 'get',
                    data: {
                        country: $('#country').val()
                    },
                    success: function (result) {
                        let option = "<option value=''></option>";
                        $.each(result, function (i, region) {
                            option += "<option " +
                                "value=" + region.idregi + ">@if($emp->lang == 'fr') " + region.labelfr + " @else " + region.labeleng + " @endif</option>";
                        });
                        $('#region').html(option);
                    }
                });
            }
        });

        $('#insertForm').click(function () {
            in_out_form();
            $('#newForm').show();
        });

        function edit(iddivision) {
            $.ajax({
                url: "{{ url('getDivision') }}",
                method: 'get',
                data: {
                    id: iddivision
                },
                success: function (division) {
                    $('#title').text('@lang('label.edit') ' + division.label);
                    $('#iddivision').val(division.iddiv);

                    $.ajax({
                        url: "{{ url('getRegion') }}",
                        method: 'get',
                        data: {
                            id: division.region
                        },
                        success: function (region) {
                            $('#country').val(region.country).select2();
                        }
                    });
                    $('#region').val(division.region).select2();
                    $('#label').val(division.label);

                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>');

                    $('#newForm').show();
                }
            });
        }

        function remove(iddivision) {
            swal({
                icon: 'warning',
                title: '@lang('sidebar.division')',
                text: '@lang('confirm.divdel_text')',
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
                    $('#division').val(iddivision);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#newForm').hide();
            in_out_form();
        });

        function submitForm() {
            let text = '@lang('confirm.divsave_text')';
            if ($('#iddivision').val() !== '') {
                text = '@lang('confirm.divedit_text')';
            }

            mySwal('@lang('sidebar.division')', text, '@lang('confirm.no')', '@lang('confirm.yes')', '#divForm');
        }

        function in_out_form() {
            $('#title').text('@lang('label.newdiv')');
            $('#idregion').val('');
            $('#fillform :input').val('');
            $('.select2').trigger('change');
            $('#edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }

    </script>
@stop
