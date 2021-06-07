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
            <h3 class="box-title text-bold" id="title"> @lang('label.newcoun')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ route('country/store') }}" method="post" class="needs-validation" role="form" id="counForm" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div id="fillform">
                    <input type="hidden" name="idcountry" id="idcountry">

                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div class="form-group has-info">
                                <label for="code" class="col-md-4 col-sm-5 col-xs-5 control-label">@lang('label.code')</label>
                                <div class="col-md-8 col-sm-7 col-xs-7">
                                    <input type="text" class="form-control" name="code" id="code">
                                    <div class="help-block">@lang('placeholder.code')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labeleng" class="col-md-3 col-xs-5 control-label">@lang('label.countryeng')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-9 col-xs-7">
                                    <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                    <div class="help-block">@lang('placeholder.nameeng')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labelfr" class="col-md-3 col-xs-5 control-label">@lang('label.countryfr')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-9 col-xs-7">
                                    <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                    <div class="help-block">@lang('placeholder.namefr')</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="form-group has-error">
                                <label for="iso" class="col-md-4 control-label">@lang('label.iso')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="iso" id="iso" required>
                                    <div class="help-block">@lang('placeholder.iso')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="form-group has-error">
                                <label for="iso3" class="col-md-5 control-label">@lang('label.iso3')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="iso3" id="iso3" required>
                                    <div class="help-block">@lang('placeholder.iso3')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="form-group has-error">
                                <label for="phonecode" class="col-md-5 control-label">@lang('label.phonecode')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="phonecode" id="phonecode" required>
                                    <div class="help-block">@lang('placeholder.phonec')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="form-group has-error">
                                <label for="currency" class="col-md-4 control-label">@lang('label.currency')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control" id="currency" name="currency" required>
                                        <option value=""></option>
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->idcurrency }}">{{ $currency->label }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block">@lang('placeholder.currency')</div>
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
                </div>
            </form>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">{{$title}}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="newInst">
                    <i class="fa fa-plus"></i>&nbsp;@lang('label.newcoun')
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
                                <th>@lang('label.code')</th>
                                <th>@lang('label.iso')</th>
                                <th>@lang('label.iso3')</th>
                                <th>@lang('label.phonecode')</th>
                                <th>@lang('label.currency')</th>
                                <th>#</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($countries as $country)
                                <tr>
                                    <td>@if($emp->lang == 'fr') {{ $country->labelfr }} @else {{ $country->labeleng }} @endif</td>
                                    <td class="text-center">{{$country->code}}</td>
                                    <td class="text-center">{{$country->iso}}</td>
                                    <td class="text-center">{{$country->iso3}}</td>
                                    <td class="text-center">+{{$country->phonecode}}</td>
                                    <td>@foreach($currencies as $currency)
                                        @if($country->currency === $currency->idcurrency)
                                            {{$currency->symbol}} ({{$currency->format}})
                                        @endif
                                    @endforeach</td>
                                    <td class="text-center">{{$country->idcountry}}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit('{{$country->idcountry}}')"></button>
                                        <button type="button" class="btn bg-red btn-sm delete fa fa-trash" onclick="remove('{{$country->idcountry}}')"></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form action="{{route('country/delete')}}" method="post" role="form" id="delForm" style="display: none">
                            {{ csrf_field() }}
                            <input type="hidden" name="country" id="country" value="">
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

        function edit(idcountry) {
            $.ajax({
                url: "{{ url('getCountry') }}",
                method: 'get',
                data: {
                    id: idcountry
                },
                success: function (country) {
                    $('#title').text('@lang('label.edit') @if($emp->lang === 'fr')' + country.labelfr + ' @else ' + country.labeleng + '@endif');
                    $('#idcountry').val(country.idcountry);
                    $('#labelfr').val(country.labelfr);
                    $('#labeleng').val(country.labeleng);
                    $('#phonecode').val(country.phonecode);
                    $('#code').val(country.code);
                    $('#iso').val(country.iso);
                    $('#iso3').val(country.iso3);
                    $('#currency').val(country.currency).select2();

                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit edit"></button>');

                    $('#form').show();
                }
            });
        }

        function remove(idcountry) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.coundel_text')',
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
                    $('#country').val(idcountry);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#form').hide();
            in_out_form();
        });

        function submitForm() {
            let text = '@lang('confirm.counsave_text')';
            if ($('#idcountry').val() !== '') {
                text = '@lang('confirm.counedit_text')';
            }

            mySwal("{{$title}}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#counForm');
        }

        function in_out_form() {
            $('#title').text('@lang('label.newcoun')');
            $('#idcountry').val('');
            $('#fillform :input').val('');
            $('#currency').val('').trigger('change');
            $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }
    </script>
@stop
