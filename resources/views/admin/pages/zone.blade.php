<?php $emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.zone'))

@section('content')
    <div class="box box-info" id="form" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('label.newzone') </h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ route('admin/zone/store') }}" method="post" role="form" id="zoneForm" class="needs-validation">
                {{ csrf_field() }}

                <div id="fillform">
                    <input type="hidden" name="idzone" id="idzone">

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group has-error">
                                <label for="network" class="col-md-4 control-label">@lang('label.network')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="network" name="network" required>
                                        <option value=""></option>
                                        @foreach($networks as $network)
                                            <option
                                                value="{{$network->idnetwork}}">{{$network->abbr}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.network')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="form-group has-error">
                                <label for="name" class="col-md-2 control-label">@lang('label.zone')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="name" id="name" required>
                                    <span class="help-block">@lang('placeholder.name')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="phone1" class="col-md-4 control-label">@lang('label.phone')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="phone1" id="phone1" min="0" required>
                                    <span class="help-block">@lang('placeholder.phone')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group">
                                <label for="phone2" class="col-md-4 control-label">@lang('label.fax')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="phone2" id="phone2" min="0">
                                    <span class="help-block">@lang('placeholder.fax')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group has-error">
                                <label for="email" class="col-md-4 control-label">@lang('label.@')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="email" class="form-control" name="email" id="email" required>
                                    <span class="help-block">@lang('placeholder.@')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="country" class="col-md-4 control-label">@lang('label.country')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="country" name="country" required>
                                        <option></option>
                                        @foreach($countries as $country)
                                            <option
                                                value="{{ $country->idcountry }}">@if($emp->lang == 'fr') {{ $country->labelfr }} @else {{ $country->labeleng }} @endif</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.country')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
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
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group has-error">
                                <label for="division" class="col-md-4 control-label">@lang('label.division')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="division" name="division" required>
                                        <option value=""></option>
                                        @foreach ($divisions as $division)
                                            <option value="{{$division->iddiv}}">{{$division->label}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.division')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="subdiv" class="col-md-4 control-label">@lang('label.subdiv')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="subdiv" name="subdiv" required>
                                        <option value=""></option>
                                        @foreach ($subdivs as $subdiv)
                                            <option value="{{$subdiv->idsub}}">{{$subdiv->label}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.subdiv')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="town" class="col-md-4 control-label">@lang('label.town')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="town" name="town" required>
                                        <option value=""></option>
                                        @foreach ($towns as $town)
                                            <option value="{{$town->idtown}}">{{$town->label}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.town')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group has-error">
                                <label for="postal" class="col-md-4 control-label">@lang('label.postal')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="postal" name="postal" required>
                                    <span class="help-block">@lang('placeholder.postal')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group has-error">
                                <label for="address" class="col-md-4 control-label">@lang('label.address')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="address" name="address" required>
                                    <span class="help-block">@lang('placeholder.address')</span>
                                </div>
                            </div>
                        </div>
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
            <h3 class="box-title text-bold"> @lang('sidebar.zone') </h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="newZone">
                    <i class="fa fa-plus"></i>&nbsp;@lang('label.newzone')
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
                                <th> @lang('label.name') </th>
                                <th> @lang('label.phone') </th>
                                <th> @lang('label.@') </th>
                                <th> @lang('label.network') </th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($zones as $zone)
                                <tr>
                                    <td>{{$zone->name}}</td>
                                    <td>{{$zone->phone1}}</td>
                                    <td>{{$zone->email}}</td>
                                    <td>{{$zone->net}}</td>
                                    <td class="text-center">
                                        <button class="btn btn-info bg-aqua btn-sm" onclick="edit('{{$zone->idzone}}')">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn bg-red btn-sm delete" onclick="remove('{{$zone->idzone}}')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form action="{{route('admin/zone/delete')}}" method="post" role="form" id="delForm" style="display: none">
                            {{ csrf_field() }}
                            <input type="hidden" name="zone" id="zone" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('#newZone').click(function () {
            in_out_form();
            $('#form').show();
        });

        function edit(idzone) {
            $.ajax({
                url: "{{ url('getZone') }}",
                method: 'get',
                data: {
                    id: idzone
                },
                success: function (zone) {
                    $('#title').text('@lang('label.edit') ' + zone.name);

                    $('#idzone').val(zone.idzone);
                    $('#network').val(zone.network).select2();
                    $('#name').val(zone.name);
                    $('#phone1').val(zone.phone1);
                    $('#phone2').val(zone.phone2);
                    $('#email').val(zone.email);
                    $('#country').val(zone.country).select2();
                    $('#region').val(zone.region).select2();
                    $('#division').val(zone.division).select2();
                    $('#subdiv').val(zone.subdivision).select2();
                    $('#town').val(zone.town).select2();
                    $('#address').val(zone.address);
                    $('#postal').val(zone.postcode);

                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>');

                    $('#form').show();
                }
            });
        }

        function remove(idzone) {
            swal({
                icon: 'warning',
                title: '@lang('sidebar.zone')',
                text: '@lang('confirm.zonedel_text')',
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
                    $('#zone').val(idzone);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#form').hide();
            in_out_form();
        });

        /**
         * Get the regions based on the country
         */
        $('#country').change(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('getRegions') }}",
                method: 'get',
                data: {
                    country: $('#country').val()
                },
                success: function (result) {
                    let option = "<option></option>";
                    $.each(result, function (i, region) {
                        option += "<option " +
                            "value=" + region.idregi + ">@if($emp->lang == 'fr') " + region.labelfr + " @else " + region.labeleng + " @endif</option>";
                    });
                    $('#region').html(option);
                }
            });
        });

        /**
         * Get the Divisions based on the Region
         */
        $('#region').change(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('getDivisions') }}",
                method: 'get',
                data: {
                    region: $('#region').val()
                },
                success: function (result) {
                    let option = "<option></option>";
                    $.each(result, function (i, division) {
                        option += "<option value=" + division.iddiv + ">" + division.label + "</option>";
                    });
                    $('#division').html(option);
                }
            });
        });

        /**
         * Get the Sub-Divisions based on the Division
         */
        $('#division').change(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('getSubDivs') }}",
                method: 'get',
                data: {
                    division: $('#division').val()
                },
                success: function (result) {
                    let option = "<option></option>";
                    $.each(result, function (i, subdiv) {
                        option += "<option value=" + subdiv.idsub + ">" + subdiv.label + "</option>";
                        $('#subdiv').html(option);
                    });
                }
            });
        });

        /**
         * Get the Towns based on the Sub Division
         */
        $('#subdiv').change(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('getTowns') }}",
                method: 'get',
                data: {
                    subdivision: $('#subdiv').val()
                },
                success: function (result) {
                    let option = "<option></option>";
                    $.each(result, function (i, town) {
                        option += "<option value=" + town.idtown + ">" + town.label + "</option>";
                        $('#town').html(option);
                    });
                }
            });
        });

        function submitForm() {
            let text = '@lang('confirm.zonesave_text')';
            if ($('#idzone').val() !== '') {
                text = '@lang('confirm.zoneedit_text')';
            }

            mySwal('@lang('sidebar.zone')', text, '@lang('confirm.no')', '@lang('confirm.yes')', '#zoneForm');
        }

        function in_out_form() {
            $('#title').text('@lang('label.newzone')');
            $('#idzone').val('');
            $('#fillform :input').val('');
            $('.select2').select2().trigger('change');
            $('#edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }
    </script>
@stop
