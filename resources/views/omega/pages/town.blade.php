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
        <div class="box-header with-border">
            <h3 class="box-title text-bold" id="title">@lang('label.newtown')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ route('town/store') }}" method="post" role="form" class="needs-validation" id="townForm">
                {{ csrf_field() }}

                <div id="fillform">
                    <input type="hidden" name="idtown" id="idtown">

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
                                    <span class="help-block">@lang('placeholder.region')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="form-group has-error">
                                <label for="division" class="col-md-4 control-label">@lang('label.division')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="division" name="division" required>
                                        @foreach ($divisions as $division)
                                            <option value="{{$division->iddiv}}">{{$division->label}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.division')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="subdiv" class="col-md-4 control-label">@lang('label.subdiv')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="subdiv" name="subdiv" required>
                                        @foreach ($subdivisions as $subdivision)
                                            <option value="{{$subdivision->idsub}}">{{$subdivision->label}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group has-error">
                                <label for="label" class="col-md-1 control-label">@lang('label.town')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-11">
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
            <h3 class="box-title text-bold">{{$title}}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="insertForm">
                    <i class="fa fa-plus"></i>&nbsp;@lang('label.newtown')
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <table id="admin-data-table" class="table table-bordered table-striped table-hover table-responsive-xl">
                            <thead>
                            <tr>
                                <th>{{$title}}</th>
                                <th>@lang('label.subdiv')</th>
                                <th>@lang('label.division')</th>
                                <th>@lang('label.region')</th>
                                <th>@lang('label.country')</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($towns as $town)
                                <tr>
                                    <td>{{$town->label}}</td>
                                    <td>{{$town->subdivision}}</td>
                                    <td>{{$town->division}}</td>
                                    <td>
                                        @if($emp->lang === 'fr') {{ $town->reg_fr }} @else {{ $town->reg_en }} @endif
                                    </td>
                                    <td>
                                        @if($emp->lang === 'fr') {{ $town->cou_fr }} @else {{ $town->cou_en }} @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit('{{$town->idtown}}')"></button>
                                        <button type="button" class="btn bg-red btn-sm delete fa fa-trash" onclick="remove('{{$town->idtown}}')"></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form action="{{route('town/delete')}}" method="post" role="form" id="delForm" style="display: none">
                            {{ csrf_field() }}
                            <input type="hidden" name="town" id="town" value="">
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

        /**
         * Get the Divisions based on the Region
         */
        $('#region').change(function (e) {
            e.preventDefault();

            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getDivisions') }}",
                    method: 'get',
                    data: {
                        region: $('#region').val()
                    },
                    success: function (result) {
                        let option = "<option value=''></option>";
                        $.each(result, function (i, division) {
                            option += "<option value=" + division.iddiv + ">" + division.label + "</option>";
                        });
                        $('#division').html(option);
                    }
                });
            }
        });

        /**
         * Get the Sub-Divisions based on the Division
         */
        $('#division').change(function (e) {
            e.preventDefault();

            if ($(this).val() !== '') {
                $.ajax({
                    url: "{{ url('getSubDivs') }}",
                    method: 'get',
                    data: {
                        division: $('#division').val()
                    },
                    success: function (result) {
                        let option = "<option value=''></option>";
                        $.each(result, function (i, subdiv) {
                            option += "<option value=" + subdiv.idsub + ">" + subdiv.label + "</option>";
                        });
                        $('#subdiv').html(option);
                    }
                });
            }
        });

        $('#insertForm').click(function () {
            in_out_form();
            $('#newForm').show();
        });

        function edit(idtown) {
            $.ajax({
                url: "{{ url('getTown') }}",
                method: 'get',
                data: {
                    id: idtown
                },
                success: function (town) {
                    $('#title').text('@lang('label.edit') ' + town.label);
                    $('#idtown').val(town.idtown);

                    $.ajax({
                        url: "{{ url('getSubDiv') }}",
                        method: 'get',
                        data: {
                            id: town.subdivision
                        },
                        success: function (subdiv) {
                            $('#division').val(subdiv.division).select2();

                            $.ajax({
                                url: "{{ url('getDivision') }}",
                                method: 'get',
                                data: {
                                    id: subdiv.division
                                },
                                success: function (division) {
                                    $('#region').val(division.region).select2();

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
                                }
                            });
                        }
                    });
                    $('#subdiv').val(town.subdivision).select2();
                    $('#label').val(town.label);

                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit edit"></button>');

                    $('#newForm').show();
                }
            });
        }

        function remove(idtown) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.towndel_text')',
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
                    $('#town').val(idtown);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#newForm').hide();
            in_out_form();
        });

        function submitForm() {
            let text = '@lang('confirm.townsave_text')';
            if ($('#idtown').val() !== '') {
                text = '@lang('confirm.townedit_text')';
            }

            mySwal("{{$title}}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#townForm');
        }

        function in_out_form() {
            $('#title').text('@lang('label.newtown')');
            $('#idtown').val('');
            $('#fillform :input').val('');
            $('.select2').trigger('change');
            $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }
    </script>
@stop
