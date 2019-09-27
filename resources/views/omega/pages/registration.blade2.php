<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr') {
    App::setLocale('fr');
    $title = 'Enregistrement';
} else {
    $title = 'Registration';
}
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <form action="{{ url('registration/store') }}" id="regForm" method="post" role="form"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="regnumb" id="regnumb" value="{{$members->count() + 1}}">

            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-md-3 control-label">@lang('label.name')</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="surname" class="col-md-3 control-label">@lang('label.surname')</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="surname" id="surname">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="date" class="col-md-2 control-label">@lang('label.dob')</label>
                                <div class="col-md-3">
                                    <input type="date" class="form-control" name="dob" id="date">
                                </div>
                                <label for="pob" class="col-md-1 control-label">@lang('label.at')</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="pob" id="pob">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender" class="col-md-4 control-label">@lang('label.gender')</label>
                                <div class="col-md-8">
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="M">@lang('label.male')</option>
                                        <option value="F">@lang('label.female')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="col-md-5 control-label">@lang('label.marstatus')</label>
                                <div class="col-md-7">
                                    <select class="form-control" id="status" name="status">
                                        <option value="M">@lang('label.married')</option>
                                        <option value="S">@lang('label.single')</option>
                                        <option value="D">@lang('label.divorced')</option>
                                        <option value="W">@lang('label.widow')</option>
                                        <option value="O">@lang('label.others')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cnpsnumb" class="col-md-4 control-label">@lang('label.cnps')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="cnpsnumb" id="cnpsnumb"
                                           data-inputmask='"mask": "9999999-999999"' data-mask>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profession" class="col-md-3 control-label">@lang('label.prof')</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="profession" id="profession">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nic" class="col-md-2 control-label">@lang('label.idcard')</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="nic" id="nic">
                                </div>
                                <label for="idate" class="col-md-1 control-label">@lang('label.deliver')</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="issuedate" id="idate">
                                </div>
                                <label for="issueplace" class="col-md-1 control-label">@lang('label.at')</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="issueplace" id="issueplace">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <a><img id="pic" name="profile" onclick="chooseFile('pic')" src=""
                                    alt="@lang('label.mempic')"
                                    class="img-bordered-sm" style="height: 150px; width: 100%;"/></a>
                            <div style="height: 0; overflow: hidden"><input type="file" name="profile" id="inpic"/>
                            </div>
                            <div onclick="" class="col-md-offset-11 fa fa-upload"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <a><img id="sign" name="signature" onclick="chooseFile('sign')" src=""
                                    alt="@lang('label.memsign')"
                                    class="img-bordered-sm" style="height: 100px; width: 100%;"/></a>
                            <div style="height: 0; overflow: hidden"><input type="file" name="signature" id="insign"/>
                            </div>
                            <div onclick="" class="col-md-offset-11 fa fa-upload"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="phone1" class="col-md-4 control-label">@lang('label.phone')</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="phone1" id="phone1"
                                   data-inputmask='"mask": "+(999)999999999"' data-mask>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="phone2" class="col-md-3 control-label">@lang('label.fax')</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="phone2" id="phone2"
                                   data-inputmask='"mask": "+(999)999999999"' data-mask>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email" class="col-md-3 control-label">@lang('label.@')</label>
                        <div class="col-md-9">
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="country" class="col-md-4 control-label">@lang('label.country')</label>
                        <div class="col-md-8">
                            <select class="form-control select2" id="country" name="country">
                                <option value=""></option>
                                @foreach($countries as $country)
                                    <option
                                        value="{{ $country->idcountry }}">@if($emp->lang == 'fr') {{ $country->labelfr }} @else {{ $country->labeleng }} @endif</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="regorigin" class="col-md-3 control-label">@lang('label.regorigin')</label>
                        <div class="col-md-9">
                            <select class="form-control select2" id="regorigin" name="regorigin">
                                <option value=""></option>
                                @foreach($regions as $region)
                                    <option
                                        value="{{ $region->idregi }}">@if($emp->lang == 'fr') {{ $region->labelfr }} @else {{ $region->labeleng }} @endif</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="region" class="col-md-3 control-label">@lang('label.region')</label>
                        <div class="col-md-9">
                            <select class="form-control select2" id="region" name="region">
                                <option value=""></option>
                                @foreach($regions as $region)
                                    <option
                                        value="{{ $region->idregi }}">@if($emp->lang == 'fr') {{ $region->labelfr }} @else {{ $region->labeleng }} @endif</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="division" class="col-md-4 control-label">@lang('label.division')</label>
                        <div class="col-md-8">
                            <select class="form-control select2" id="division" name="division">
                                <option value=""></option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->iddiv }}">{{ $division->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="subdiv" class="col-md-3 control-label">@lang('label.subdiv')</label>
                        <div class="col-md-9">
                            <select class="form-control select2" id="subdiv" name="subdiv">
                                <option value=""></option>
                                @foreach($subdivs as $subdiv)
                                    <option value="{{ $subdiv->idsub }}">{{ $subdiv->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="town" class="col-md-3 control-label">@lang('label.town')</label>
                        <div class="col-md-9">
                            <select class="form-control select2" id="town" name="town">
                                <option value=""></option>
                                @foreach($towns as $town)
                                    <option value="{{ $town->idtown }}">{{ $town->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="address" class="col-md-4 control-label">@lang('label.address')</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="street" class="col-md-3 control-label">@lang('label.street')</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="street" name="street">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="quarter" class="col-md-3 control-label">@lang('label.quarter')</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="quarter" name="quarter">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="memtype" class="col-md-5 control-label">@lang('label.memtype')</label>
                        <div class="col-md-7">
                            <select class="form-control" id="memtype" name="memtype">
                                <option value="P" selected>@lang('label.physic')</option>
                                <option value="A">@lang('label.assoc')</option>
                                <option value="E">@lang('label.enterp')</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="" id="assoc" style="display: none">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="assno" class="col-md-5 control-label">@lang('label.assnumb')</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="assno" id="assno">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="asstype" class="col-md-6 control-label">@lang('label.assoctype')</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="asstype" id="asstype">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="assmemno" class="col-md-6 control-label">@lang('label.assmemno')</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="assmemno" name="assmemno">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="" id="enterp" style="display: none">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="taxpaynumb" class="col-md-5 control-label">@lang('label.taxpayno')</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="taxpaynumb" id="taxpaynumb">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="comregis" class="col-md-3 control-label">@lang('label.regist')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="comregis" name="comregis">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="regime" class="col-md-3 control-label">@lang('label.regim')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="regime" id="regime">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-header with-border">
                <h4 class="box-title text-bold">@lang('label.nxtofkin')</h4>
                <table class="table table-hover table-bordered table-condensed table-responsive" id="memberInput">
                    <thead>
                    <tr>
                        <th>@lang('label.nam&sur')</th>
                        <th>@lang('label.relation')</th>
                        <th>@lang('label.ratio')</th>
                    </tr>
                    </thead>
                    <tbody id="bene_body">
                    <tr>
                        <td><input type="text" name="bene_name[]" id="name_sur" class="reg"></td>
                        <td><input type="text" name="bene_relate[]" id="rela" class="reg"></td>
                        <td><input type="text" name="bene_ratio[]" class="reg bene_reg"></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="2" class="text-right">@lang('label.remain')</th>
                        <th><input type="text" name="rem" class="reg" id="rem" disabled></th>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <button type="button" id="new_bene"
                                    class="btn btn-sm bg-green pull-right btn-raised fa fa-plus"></button>
                            <button type="button" id="del_bene"
                                    class="btn btn-sm bg-red pull-right btn-raised fa fa-minus"
                                    disabled></button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="box-header with-border">
                <h6 class="box-title text-bold">@lang('label.witnes')</h6>
                <div class="col-md-12">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="witnes_name" class="col-md-4 control-label">@lang('label.nam&sur')</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="witnes_name" id="witnes_name">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="witnes_nic" class="col-md-4 control-label">@lang('label.idcard')</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="witnes_nic" id="witnes_nic">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save">
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('#nic, #witnes_nic, .bene_reg, #assno, #assmemno, #nic, #phone1, #phone2, #taxpaynumb, #comregis, #regime').verifNumber();
        });

        function readURL(input, label) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    if (label === 'pic') {
                        $('#pic').attr('src', e.target.result);
                    }
                    if (label === 'sign') {
                        $('#sign').attr('src', e.target.result);
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#inpic').change(function () {
            readURL(this, 'pic');
        });
        $('#insign').change(function () {
            readURL(this, 'sign');
        });

        // Member Type
        $('#memtype').change(function () {
            let value = $(this).val();
            if (value === 'A') {
                $('#assoc').css('display', 'block');
            } else if (value === 'E') {
                $('#enterp').css('display', 'block');
            } else {
                $('#assoc').css('display', 'none');
                $('#enterp').css('display', 'none');
            }
        });

        $('#new_bene').click(function () {
            let tr = '<tr>' +
                '<td><input type="text" name="bene_name[]" id="name_sur" class="reg"></td>' +
                '<td><input type="text" name="bene_relate[]" id="rela" class="reg"></td>' +
                '<td><input type="text" name="bene_ratio[]" class="reg bene_reg"></td>' +
                '</tr>';
            $('#memberInput tbody').append(tr);
            $('#del_bene').removeAttr('disabled');
        });

        $('#del_bene').hover(function () {
            if ($('#bene_body tr').length === 1)
                $(this).attr('disabled', 'disabled');
        });

        $('#del_bene').click(function () {
            $('#bene_body tr:last').remove();
        });

        $('#save').click(function () {
            let sum = 0;

            $('.bene_reg').each(function () {
                if (parseInt($(this).val()))
                    sum += parseInt($(this).val());
            });
            if (sum === 100) {
                swal({
                        title: '@lang('confirm.memreg_header')',
                        text: '@lang('confirm.memreg_text')',
                        type: 'info',
                        showCancelButton: true,
                        cancelButtonClass: 'bg-red',
                        confirmButtonClass: 'bg-blue',
                        confirmButtonText: '@lang('confirm.yes')',
                        cancelButtonText: '@lang('confirm.no')',
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('#regForm').submit();
                        }
                    }
                );
            }
        });

        function chooseFile(label) {
            if (label === 'pic') {
                $('#inpic').click();
            }
            if (label === 'sign') {
                $('#insign').click();
            }
        }

        $(document).ready(function () {
            $(document).on('input', '.bene_reg', function () {
                let sumBene = 0;
                $('#memberInput tbody .bene_reg').each(function () {
                    if (parseInt($('.bene_reg').val())) {
                        sumBene += parseInt($('.bene_reg').val());
                    }
                });
                $('#rem').val(100 - parseInt(sumBene));
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
                            $('#region').html(option);
                        });
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
                            $('#division').html(option);
                        });
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
        });
    </script>
@stop
