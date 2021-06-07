<?php $emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.institute'))

@section('content')
    <div class="box box-info" id="form" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('label.newinst')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ route('admin/institution/store') }}" method="post" role="form" id="instForm" enctype="multipart/form-data" class="needs-validation">
                {{ csrf_field() }}

                <div id="fillform">
                    <input type="hidden" name="idinstitute" id="idinstitute">

                    <div class="row">
                        <div class="col-md-8 col-xs-12">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
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
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group has-error">
                                        <label for="zone" class="col-md-4 control-label">@lang('label.zone')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" id="zone" name="zone" required>
                                                <option value=""></option>
                                                @foreach($zones as $zone)
                                                    <option value="{{$zone->idzone}}">{{$zone->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">@lang('placeholder.zone')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <div class="form-group has-error">
                                        <label for="name" class="col-md-3 control-label">@lang('label.institution')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" required>
                                            <span class="help-block">@lang('placeholder.name')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group has-error">
                                        <label for="abbr" class="col-md-6 col-xs-5 control-label">@lang('label.abbr')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-6 col-xs-7">
                                            <input type="text" class="form-control" name="abbr" id="abbr" required>
                                            <span class="help-block">@lang('placeholder.abbr')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group has-error">
                                        <label for="slogan" class="col-md-2 control-label">@lang('label.slogan')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="slogan" id="slogan" required>
                                            <span class="help-block">@lang('placeholder.slogan')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-group has-error" style="height: 170px; width: 100%; border: 1px solid grey">
                                    <img id="pic" onclick="chooseFile()" src="" alt="@lang('placeholder.uplogo')" style="height: 170px; width: 100%;"/>
                                    <div style="height: 0; overflow: hidden">
                                        <input type="file" name="profile" accept='image/*' id="inpic"/>
                                        <span class="help-block">@lang('placeholder.uplogo')</span>
                                    </div>
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
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="address" class="col-md-4 control-label">@lang('label.address')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="address" name="address" required>
                                    <span class="help-block">@lang('placeholder.address')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="strategy" class="col-md-4 control-label">@lang('label.strategy')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="select2 form-control" name="strategy" id="strategy" required>
                                        <option value=""></option>
                                        <option value="I">@lang('label.cashman')</option>
                                        <option value="II">@lang('label.accrman')</option>
                                    </select>
                                    <span class="help-block">@lang('placeholder.strategy')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <button type="submit" id="save"
                                        class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.institute') </h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="newInst">
                    <i class="fa fa-plus"></i>&nbsp;@lang('label.newinst')
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <table id="admin-data-table" class="table table-striped table-bordered table-hover table-responsive-xl">
                            <thead>
                            <tr>
                                <th> @lang('label.name') </th>
                                <th> @lang('label.strategy') </th>
                                <th> @lang('label.phone') </th>
                                <th> @lang('label.@') </th>
                                <th> @lang('label.country') </th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($institutions as $inst)
                                <tr>
                                    <td>{{$inst->abbr}}</td>
                                    <td>
                                        @if ($inst->strategy==='I')
                                            @lang('label.cashman')
                                        @else
                                            @lang('label.accrman')
                                        @endif
                                    </td>
                                    <td>{{$inst->phone1}}</td>
                                    <td>{{$inst->email}}</td>
                                    <td>
                                        @foreach ($countries as $country)
                                            @if ($country->idcountry===$inst->country)
                                                @if($emp->lang === 'fr') {{$country->labelfr}} @else {{$country->labeleng}} @endif
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        <button class="btn bg-aqua btn-sm" onclick="edit('{{$inst->idinst}}')">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn bg-red btn-sm delete" onclick="remove('{{$inst->idinst}}')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form action="{{route('admin/institution/delete')}}" method="post" role="form" id="delForm" style="display: none">
                            {{ csrf_field() }}
                            <input type="hidden" name="institute" id="institute" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('#newInst').click(function () {
            in_out_form();
            $('#form').show();
        });

        function edit(idinstitute) {
            $.ajax({
                url: "{{ url('getInstitution') }}",
                method: 'get',
                data: {
                    id: idinstitute
                },
                success: function (inst) {
                    $('#title').text('@lang('label.edit') ' + inst.name);

                    $('#idinstitute').val(inst.idinst);
                    $('#network').val(inst.network).select2();
                    $('#zone').val(inst.zone).select2();
                    $('#name').val(inst.name);
                    $('#abbr').val(inst.abbr);
                    $('#slogan').val(inst.slogan);
                    $('#phone1').val(inst.phone1);
                    $('#phone2').val(inst.phone2);
                    $('#email').val(inst.email);
                    $('#country').val(inst.country).select2();
                    $('#region').val(inst.region).select2();
                    $('#division').val(inst.division).select2();
                    $('#subdiv').val(inst.subdivision).select2();
                    $('#town').val(inst.town).select2();
                    $('#address').val(inst.address);
                    $('#postal').val(inst.postcode);
                    $('#strategy').val(inst.strategy).select2();

                    $.ajax({
                        url: "{{url('getLogo')}}",
                        method: 'get',
                        data: {file: inst.logo},
                        success: function (filePath) {
                            $('#pic').attr('src', filePath);
                        }
                    });

                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>');

                    $('#form').show();
                }
            });
        }

        function remove(idinstitute) {
            swal({
                icon: 'warning',
                title: '@lang('sidebar.institute')',
                text: '@lang('confirm.instdel_text')',
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
                    $('#institute').val(idinstitute);
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

        /**
         * Get the Towns based on the Sub Division
         */
        $('#network').change(function () {
            $.ajax({
                url: "{{ url('getZones') }}",
                method: 'get',
                data: {
                    network: $('#network').val()
                },
                success: function (zones) {
                    let option = "<option value=''></option>";
                    $.each(zones, function (i, zone) {
                        option += "<option value=" + zone.idzone + ">" + zone.name + "</option>";
                        $('#zone').html(option);
                    });
                }
            });
        });

        function submitForm() {
            let text = '@lang('confirm.instsave_text')';
            if ($('#idinstitute').val() !== '') {
                text = '@lang('confirm.instedit_text')';
            }

            mySwal('@lang('sidebar.institute')', text, '@lang('confirm.no')', '@lang('confirm.yes')', '#instForm');
        }

        function chooseFile() {
            $("#inpic").click();
        }

        $("#inpic").change(function () {
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#pic').attr('src', e.target.result);
                    // $('#inpic').attr('value', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function in_out_form() {
            $('#title').text('@lang('label.newinst')');
            $('#idinstitute').val('');
            $('#fillform :input').val('');
            $('.select2').select2().trigger('change');
            $('#edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }
    </script>
@stop
