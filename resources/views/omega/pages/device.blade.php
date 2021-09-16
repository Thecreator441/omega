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
    <div class="box box-info" id="form" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title text-bold" id="title"> @lang('label.newdevice')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ route('device/store') }}" method="post" class="needs-validation" role="form" id="instForm" enctype="multipart/form-data">
                {{ csrf_field() }}
                @if ($emp->level !== 'P')
                    <input type="hidden" name="network" value="{{ $emp->network }}">
                    <input type="hidden" name="zone" value="{{ $emp->zone }}">
                    <input type="hidden" name="institution" value="{{ $emp->institution }}">
                    <input type="hidden" name="branch" value="{{ $emp->branch }}">
                @endif

                <div id="fillform">
                    <input type="hidden" name="idinstitute" id="idinstitute">

                    @if ($emp->level === 'P')
                        <div class="row">
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group has-error">
                                            <label for="network" class="col-xl-4 col-lg-4 col-md-4 control-label">@lang('label.network')</label>
                                            <div class="col-xl-8 col-lg-8 col-md-8">
                                                <select class="form-control select2" id="network" name="network">
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
                                            <label for="zone" class="col-md-4 control-label">@lang('label.zone')</label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="zone" name="zone">
                                                    <option value=""></option>
                                                    @foreach($zones as $zone)
                                                        <option
                                                            value="{{$zone->idzone}}">{{$zone->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="help-block">@lang('placeholder.zone')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group has-error">
                                            <label for="institution" class="col-md-4 control-label">@lang('label.institution')</label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="institution" name="institution">
                                                    <option value=""></option>
                                                    @foreach($institutions as $institution)
                                                        <option
                                                            value="{{$institution->idinst}}">{{$institution->abbr}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="help-block">@lang('placeholder.institution')</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group has-error">
                                            <label for="branch" class="col-md-4 control-label">@lang('label.branch')</label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="branch" name="branch">
                                                    <option value=""></option>
                                                    @foreach($branches as $branch)
                                                        <option
                                                            value="{{$branch->idbranch}}">{{$branch->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="help-block">@lang('placeholder.branch')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group has-error">
                                            <label for="dev_type" class="col-md-4 control-label">@lang('label.dev_type')<span class="text-red text-bold">*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-control" id="dev_type" name="dev_type" required>
                                                    <option value=""></option>
                                                    <option value="C">@lang('label.computer')</option>
                                                    <option value="M">@lang('label.mobile')</option>
                                                    <option value="T">@lang('label.tablet')</option>
                                                </select>
                                                <span class="help-block">@lang('placeholder.type')</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group has-error">
                                            <label for="name" class="col-md-4 control-label">@lang('label.name')<span class="text-red text-bold">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="name" name="name" required>
                                                <span class="help-block">@lang('placeholder.dev_name')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="col-md-12">
                                    <div class="form-group" style="height: 160px; width: 100%; border: 1px solid grey">
                                        <img id="pic" onclick="chooseFile()" src="" alt="@lang('placeholder.uppic')" style="height: 160px; width: 100%;"/>
                                        <div style="height: 0; overflow: hidden"><input type="file" name="profile" accept='image/*' id="inpic"/></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-6">
                                <div class="form-group has-error">
                                    <label for="os_name" class="col-md-4 control-label">@lang('label.os_name')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-8">
                                        <select class="form-control" id="os_name" name="os_name" required>
                                            <option value=""></option>
                                            <option value="Android">Android</option>
                                            <option value="iOS">iOS</option>
                                            <option value="Linux">Linux</option>
                                            <option value="Mac OS">Mac OS</option>
                                            <option value="Ubuntu">Ubuntu</option>
                                            <option value="Unix">Unix</option>
                                            <option value="Windows">Windows</option>
                                        </select>
                                        <span class="help-block">@lang('placeholder.os_name')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-6">
                                <div class="form-group has-error">
                                    <label for="os_version" class="col-md-4 control-label">@lang('label.os_version')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="version" name="os_version" required>
                                        <span class="help-block">@lang('placeholder.os_version')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group has-info">
                                    <label for="dev_model" class="col-md-4 control-label">@lang('label.dev_model')</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="dev_model" name="dev_model">
                                        <span class="help-block">@lang('placeholder.dev_model')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group has-error">
                                            <label for="dev_type" class="col-md-4 control-label">@lang('label.dev_type')<span class="text-red text-bold">*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-control" id="dev_type" name="dev_type" required>
                                                    <option value=""></option>
                                                    <option value="C">@lang('label.computer')</option>
                                                    <option value="M">@lang('label.mobile')</option>
                                                    <option value="T">@lang('label.tablet')</option>
                                                </select>
                                                <span class="help-block">@lang('placeholder.type')</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group has-error">
                                            <label for="name" class="col-md-4 control-label">@lang('label.name')<span class="text-red text-bold">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="name" name="name" required>
                                                <span class="help-block">@lang('placeholder.dev_name')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group has-error">
                                            <label for="os_name" class="col-md-4 control-label">@lang('label.os_name')<span class="text-red text-bold">*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-control" id="os_name" name="os_name" required>
                                                    <option value=""></option>
                                                    <option value="Android">Android</option>
                                                    <option value="iOS">iOS</option>
                                                    <option value="Linux">Linux</option>
                                                    <option value="Mac OS">Mac OS</option>
                                                    <option value="Ubuntu">Ubuntu</option>
                                                    <option value="Unix">Unix</option>
                                                    <option value="Windows">Windows</option>
                                                </select>
                                                <span class="help-block">@lang('placeholder.os_name')</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group has-error">
                                            <label for="os_version" class="col-md-4 control-label">@lang('label.os_version')<span class="text-red text-bold">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="version" name="os_version" required>
                                                <span class="help-block">@lang('placeholder.os_version')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group has-info">
                                            <label for="dev_model" class="col-md-4 control-label">@lang('label.dev_model')</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="dev_model" name="dev_model">
                                                <span class="help-block">@lang('placeholder.dev_model')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="col-md-12">
                                    <div class="form-group" style="height: 160px; width: 100%; border: 1px solid grey">
                                        <img id="pic" onclick="chooseFile()" src="" alt="@lang('placeholder.uppic')" style="height: 160px; width: 100%;"/>
                                        <div style="height: 0; overflow: hidden"><input type="file" name="profile" accept='image/*' id="inpic"/></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save">
                                </button>
                            </div>
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
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="newInst">
                    <i class="fa fa-plus"></i>&nbsp;@lang('label.newdevice')
                </button>
            </div>
        </div>
        <div class="box-body">
            @if($emp->level === 'P')
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="network2" class="col-md-4 control-label">@lang('label.network')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="network2">
                                    <option value=""></option>
                                    @foreach($networks as $network)
                                        <option
                                            value="{{$network->idnetwork}}">{{$network->abbr}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="zone2" class="col-md-4 control-label">@lang('label.zone')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="zone2">
                                    <option value=""></option>
                                    @foreach($zones as $zone)
                                        <option
                                            value="{{$zone->idzone}}">{{$zone->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="institution2" class="col-md-4 control-label">@lang('label.institution')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="institution2">
                                    <option value=""></option>
                                    @foreach($institutions as $institution)
                                        <option
                                            value="{{$institution->idinst}}">{{$institution->abbr}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="branch2" class="col-md-4 control-label">@lang('label.branch')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="branch2">
                                    <option value=""></option>
                                    @foreach($branches as $branch)
                                        <option
                                            value="{{$branch->idbranch}}">{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="col-md-12 col-sm-12">
                            <button type="button" id="search" class="btn btn-sm bg-green btn-raised pull-right fa fa-search"></button>
                        </div>
                    </div>
                </div>
            @endif

            <table id="admin-data-table" class="table table-bordered table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th> @lang('label.dev_name') </th>
                    <th> @lang('label.dev_type') </th>
                    <th> @lang('label.dev_model') </th>
                    <th> @lang('label.os_name_vers') </th>
                    <th> @lang('label.status') </th>
                    <th> @lang('label.date') </th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($devices as $device)
                    <tr>
                        <td>{{$device->dev_name}}</td>
                        <td>{{$device->dev_type}}</td>
                        <td>{{$device->dev_model}}</td>
                        <td>{{$device->os_name_vers}}</td>
                        <td class="text-center">
                            <span class="badge @if ($device->status === 'B') bg-red @else bg-green @endif">@if ($device->status === 'B') @lang('label.blocked') @else @lang('label.free') @endif</span>
                        </td>
                        <td class="text-center">{{changeFormat($device->created_at)}}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm @if ($device->status === 'B') bg-green fa fa-check @else bg-red fa fa-close @endif"
                                    onclick="blun('{{$device->iddevice}}')" @if ($device->network === null) disabled @endif></button>
                            <button type="button" class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit('{{$device->iddevice}}')"></button>
                            <button type="button" class="btn bg-red btn-sm delete fa fa-trash" onclick="remove('{{$device->iddevice}}')"></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <form action="{{route('device/delete')}}" method="post" role="form" id="delForm" style="display: none">
                {{ csrf_field() }}
                <input type="hidden" name="institute" id="institute" value="">
            </form>
            <form action="{{route('device/blun')}}" method="post" role="form" id="blunForm" style="display: none">
                {{ csrf_field() }}
                <input type="hidden" name="userBlun" id="userBlun" value="">
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('#newInst').click(function () {
            in_out_form();
            $('#form').show();
        });

        function blun(idcollector) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.deviceblun_text')',
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
                    $('#userBlun').val(idcollector);
                    $('#blunForm').submit();
                }
            });
        }

        function edit(iddevice) {
            $.ajax({
                url: "{{ url('getDevice') }}",
                method: 'get',
                data: {
                    id: iddevice
                },
                success: function (device) {
                    $('#title').text('@lang('label.edit') ' + device.dev_name);

                    $('#idinstitute').val(device.iddevice);
                    $('#network').val(device.network).select2();
                    $('#zone').val(device.zone).select2();
                    $('#institution').val(device.institution).select2();
                    $('#branch').val(device.branch).select2();
                    $('#dev_type').val(device.dev_type).select2();
                    $('#os_name').val(device.os_name).select2();
                    $('#version').val(device.os_version);
                    $('#dev_model').val(device.dev_model);
                    $('#name').val(device.dev_name);

                    if (device.pic !== null) {
                      $.ajax({
                          url: "{{url('getProfile')}}",
                          method: 'get',
                          data: {
                              owner: 'device',
                              file: device.pic
                          },
                          success: function (filePath) {
                              $('#pic').attr('src', filePath);
                          }
                      });
                    }

                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit edit"></button>');

                    $('#form').show();
                }
            });
        }

        function remove(idinstitute) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.devicedel_text')',
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
         * Get the zones based on the network
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
                        option += "<option " +
                            "value=" + zone.idzone + ">" + zone.name + "</option>";
                    });
                    $('#zone').html(option);
                }
            });
        });

        /**
         * Get the institution based on the zone
         */
        $('#zone').change(function () {
            $.ajax({
                url: "{{ url('getInstitutions') }}",
                method: 'get',
                data: {
                    zone: $('#zone').val()
                },
                success: function (institutions) {
                    let option = "<option value=''></option>";
                    $.each(institutions, function (i, institution) {
                        option += "<option " +
                            "value=" + institution.idinst + ">" + institution.abbr + "</option>";
                    });
                    $('#institution').html(option);
                }
            });
        });

        /**
         * Get the institution based on the zone
         */
        $('#institution').change(function () {
            $.ajax({
                url: "{{ url('getBranches') }}",
                method: 'get',
                data: {
                    institution: $('#institution').val()
                },
                success: function (branchs) {
                    let option = "<option value=''></option>";
                    $.each(branchs, function (i, branch) {
                        option += "<option " +
                            "value=" + branch.idbranch + ">" + branch.name + "</option>";
                    });
                    $('#branch').html(option);
                }
            });
        });

        /**
         * Get the zones based on the network
         */
        $('#network2').change(function () {
            $.ajax({
                url: "{{ url('getZones') }}",
                method: 'get',
                data: {
                    network: $('#network2').val()
                },
                success: function (zones) {
                    let option = "<option value=''></option>";
                    $.each(zones, function (i, zone) {
                        option += "<option " +
                            "value=" + zone.idzone + ">" + zone.name + "</option>";
                    });
                    $('#zone2').html(option);
                }
            });
        });

        /**
         * Get the institution based on the zone
         */
        $('#zone2').change(function () {
            $.ajax({
                url: "{{ url('getInstitutions') }}",
                method: 'get',
                data: {
                    zone: $('#zone2').val()
                },
                success: function (institutions) {
                    let option = "<option value=''></option>";
                    $.each(institutions, function (i, institution) {
                        option += "<option " +
                            "value=" + institution.idinst + ">" + institution.abbr + "</option>";
                    });
                    $('#institution2').html(option);
                }
            });
        });

        /**
         * Get the institution based on the zone
         */
        $('#institution2').change(function () {
            $.ajax({
                url: "{{ url('getBranches') }}",
                method: 'get',
                data: {
                    institution: $('#institution2').val()
                },
                success: function (branchs) {
                    let option = "<option value=''></option>";
                    $.each(branchs, function (i, branch) {
                        option += "<option " +
                            "value=" + branch.idbranch + ">" + branch.name + "</option>";
                    });
                    $('#branch2').html(option);
                }
            });
        });

        function submitForm() {
            let text = '@lang('confirm.devicesave_text')';
            if ($('#idinstitute').val() !== '') {
                text = '@lang('confirm.deviceedit_text')';
            }

            mySwal("{{$title}}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#instForm');
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
            $('#title').text('@lang('label.newdevice')');
            $('#idinstitute').val('');
            $('#fillform :input').val('');
            $('#fillform select').val('');
            $('#pic').attr('src', '');
            $('.select2').val('').select2();

            $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }

        $('#search').click(function () {
            getFilterDevices($('#network2').val(), $('#zone2').val(), $('#institution2').val(), $('#branch2').val());
        });

        function getFilterDevices(network = null, zone = null, institution = null, branch = null) {
            $('#admin-data-table').DataTable({
                destroy: true,
                paging: true,
                info: true,
                responsive: true,
                ordering: true,
                FixedHeader: true,
                language: {
                    url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
                },
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: '',
                        className: 'buttons-copy btn btn-sm bg-blue btn-raised fa fa-copy',
                        titleAttr: '@lang('label.copy')',
                    },
                    {
                        extend: 'excel',
                        text: '',
                        className: 'buttons-excel btn btn-sm bg-blue btn-raised fa fa-file-excel-o',
                        titleAttr: '@lang('label.excel')',
                    },
                    {
                        extend: 'pdf',
                        text: '',
                        className: 'buttons-pdf btn btn-sm bg-blue btn-raised fa fa-file-pdf-o',
                        titleAttr: '@lang('label.pdf')',
                    },
                    {
                        extend: 'print',
                        text: '',
                        className: 'buttons-print btn btn-sm bg-blue btn-raised fa fa-print',
                        titleAttr: '@lang('label.print')',
                    }
                ],
                dom:
                    "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: false,
                serverMethod: 'GET',
                ajax: {
                    url: "{{url('getFilterDevices')}}",
                    data: {
                        network: network,
                        zone: zone,
                        institution: institution,
                        branch: branch
                    },
                    datatype: 'json'
                },
                error: function (jqXHR, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + jqXHR.statusText + "\r\n" + jqXHR.responseText + "\r\n" + ajaxOptions.responseText);
                },
                columns: [
                    {data: 'dev_name', class: 'text-center'},
                    {data: 'dev_type'},
                    {data: 'dev_model'},
                    {data: 'os_name_vers'},
                    {
                        data: null, class: 'text-ceter', render: function (data, type, row) {
                            let newClass = 'bg-red';
                            let newText = "@lang('label.blocked')";
                            if (data.status === 'F') {
                                newClass = 'bg-green';
                                newText = "@lang('label.free')";
                            }

                            return '<span class="badge ' + newClass + '">' + newText + '</span>';
                        }
                    },
                    {data: 'date', class: 'text-ceter'},
                    {
                        data: null, class: 'text-center', render: function (data, type, row) {
                            let newClass = 'bg-green fa fa-check';
                            let newDisab = 'disabled';

                            if (data.status === 'F') {
                                newClass = 'bg-red fa fa-close';
                            }

                            return '<button type="button" class="btn btn-sm ' + newClass + '" onclick="blun(' + data.iddevice + ')" ' + newDisab + '>' +
                                '<button type="button" class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit(' + data.iddevice + ')"></button>' +
                                '<button type="button" class="btn bg-red btn-sm delete fa fa-trash" onclick="remove(' + data.iddevice + ')"></button>';
                        }
                    }
                ]
            });
        }
    </script>
@stop
