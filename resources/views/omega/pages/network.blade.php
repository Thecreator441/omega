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
    <div class="box" id="form" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title text-bold" id="title"> @lang('label.newnet') </h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ route('network/store') }}" method="post" role="form" id="netForm" class="needs-validation">
                {{ csrf_field() }}

                <div id="fillform">
                    <input type="hidden" name="idnetwork" id="idnetwork">

                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="form-group has-error">
                                <label for="name" class="col-md-2 control-label">@lang('label.network')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="name" id="name" required>
                                    <span class="help-block">@lang('placeholder.name')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="abbr" class="col-md-4 control-label">@lang('label.abbr')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="abbr" id="abbr" required>
                                    <span class="help-block">@lang('placeholder.abbr')</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="category" class="col-md-4 control-label">@lang('label.category')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="select2 form-control" name="category" id="category" required>
                                        <option value=""></option>
                                        <option value="I">@lang('label.mfi1')</option>
                                        <option value="II">@lang('label.mfi2')</option>
                                        <option value="III">@lang('label.mfi3')</option>
                                        <option value="IV">@lang('label.others')</option>
                                    </select>
                                    <span class="help-block">@lang('placeholder.category')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="form-group has-error">
                                <label for="slogan" class="col-md-2 control-label">@lang('label.slogan')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="slogan" id="slogan">
                                    <span class="help-block">@lang('placeholder.slogan')</span>
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

{{--                    <div class="row">--}}
{{--                        <div class="col-md-8">--}}
{{--                            <div class="form-group">--}}
{{--                                <label class="col-md-3 control-label">@lang('label.startdel')</label>--}}
{{--                                <div class="col-md-2">--}}
{{--                                    <div class="radio">--}}
{{--                                        <label for="par3">--}}
{{--                                            <input type="radio" name="startdel" id="par3" value="30" checked>&nbsp;@lang('label.par3')--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-2">--}}
{{--                                    <div class="radio">--}}
{{--                                        <label for="par6">--}}
{{--                                            <input type="radio" name="startdel" id="par6" value="60">&nbsp;@lang('label.par6')--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
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
            @if($emp->level === 'P')
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="newNet">
                        <i class="fa fa-plus"></i>&nbsp;@lang('label.newnet')
                    </button>
                </div>
            @endif
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="admin-data-table" class="table table-striped table-hover table-responsive-xl">
                            <thead>
                            <tr>
                                <th> @lang('label.abbr') </th>
                                <th> @lang('label.name') </th>
                                <th> @lang('label.category') </th>
                                <th> @lang('label.phone') </th>
                                <th> @lang('label.@') </th>
                                <th> @lang('label.country') </th>
                                @if($emp->level === 'P')
                                <th >Actions</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($networks as $net)
                                <tr>
                                    <td>{{$net->abbr}}</td>
                                    <td>{{$net->name}}</td>
                                    <td>
                                        @if ($net->category==='I')
                                            @lang('label.mfi1')
                                        @elseif ($net->category==='II')
                                            @lang('label.mfi2')
                                        @elseif ($net->category==='III')
                                            @lang('label.mfi3')
                                        @else
                                            @lang('label.others')
                                        @endif
                                    </td>
                                    <td>{{$net->phone1}}</td>
                                    <td>{{$net->email}}</td>
                                    <td>
                                        @foreach ($countries as $country)
                                            @if ($country->idcountry===$net->country)
                                                @if($emp->lang === 'fr') {{$country->labelfr}} @else {{$country->labeleng}} @endif
                                            @endif
                                        @endforeach
                                    </td>
                                    @if($emp->level === 'P')
                                        <td class="text-center">
                                            <button type="button" class="btn btn-info bg-aqua btn-sm" onclick="edit('{{$net->idnetwork}}')">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn bg-red btn-sm delete" onclick="remove('{{$net->idnetwork}}')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form action="{{route('network/delete')}}" method="post" role="form" id="delForm" style="display: none">
                            {{ csrf_field() }}
                            <input type="hidden" name="network" id="network" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('#newNet').click(function () {
            in_out_form();
            $('#form').show();
        });

        function edit(idnetwork) {
            $.ajax({
                url: "{{ url('getNetwork') }}",
                method: 'get',
                data: {
                    id: idnetwork
                },
                success: function (network) {
                    $('#title').text('@lang('label.edit') ' + network.abbr);
                    // $('#fillform').append('<input type="hidden" name="idnetwork" id="idnetwork" value="' + network.idnetwork + '">');
                    $('#idnetwork').val(network.idnetwork);
                    $('#name').val(network.name);
                    $('#abbr').val(network.abbr);
                    $('#slogan').val(network.slogan);
                    $('#category').val(network.category).select2();
                    $('#phone1').val(network.phone1);
                    $('#phone2').val(network.phone2);
                    $('#email').val(network.email);
                    $('#country').val(network.country).select2();
                    $('#region').val(network.region).select2();
                    $('#division').val(network.division).select2();
                    $('#subdiv').val(network.subdivision).select2();
                    $('#town').val(network.town).select2();
                    $('#address').val(network.address);
                    $('#postal').val(network.postcode);

                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit edit"></button>');

                    $('#form').show();
                }
            });
        }

        function remove(idnetwork) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.netdel_text')',
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
                    $('#network').val(idnetwork);
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
        $('#country').change(function () {

            if ($(this).val() !== '') {
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
                        let option = "<option></option>";
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
                        let option = "<option></option>";
                        $.each(result, function (i, subdiv) {
                            option += "<option value=" + subdiv.idsub + ">" + subdiv.label + "</option>";
                            $('#subdiv').html(option);
                        });
                    }
                });
            }
        });

        /**
         * Get the Towns based on the Sub Division
         */
        $('#subdiv').change(function (e) {
            e.preventDefault();

            if ($(this).val() !== '') {
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
            }
        });

        function submitForm() {
            let text = '@lang('confirm.netsave_text')';
            if ($('#idnetwork').val() !== '') {
                text = '@lang('confirm.netedit_text')';
            }

            mySwal("{{$title}}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#netForm');
        }

        function in_out_form() {
            $('#title').text('@lang('label.newnet')');
            $('#idnetwork').val('');
            $('#fillform :input').val('');
            $('.select2').trigger('change');
            $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');

        }
    </script>
@stop
