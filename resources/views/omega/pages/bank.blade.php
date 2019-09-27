<?php $emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.bank'))

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close home"></button>
            </div>
        </div>
        <div class="box-body">
            @if ($banks->count() != 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            {{ $banks->links('layouts.includes.pagination') }}
                        </div>
                    </div>
                </div>
            @endif
            <form action="{{ url('bank/store') }}" method="POST" role="form" id="bankForm">
                {{ csrf_field() }}
                @if ($banks->count() == 0)
                    <div class="box-header with-border" id="form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bankcode" class="col-md-4 control-label">@lang('label.code')</label>
                                    <div class="col-md-8">
                                        <input type="text" name="bankcode" id="bankcode" class="form-control"
                                               value="1" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="bankname" id="bankname" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="theiracc" class="col-md-4 control-label">@lang('label.theiracc')</label>
                                    <div class="col-md-8">
                                        <select name="theiracc" id="theiracc" class="form-control select2">
                                            <option></option>
                                            @foreach($accounts as $account)
                                                @if (substrWords($account->accnumb, 2) =='56')
                                                    <option
                                                        value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="partBank">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ouracc"
                                               class="col-md-4 control-label">@lang('label.ouracc')</label>
                                        <div class="col-md-8">
                                            <input type="text" name="ouracc" id="ouracc" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="manager"
                                               class="col-md-4 control-label">@lang('label.manager')</label>
                                        <div class="col-md-8">
                                            <input type="text" name="manager" id="manager" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="phone1"
                                               class="col-md-4 control-label">@lang('label.phone')</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="phone1" id="phone1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="phone2" class="col-md-4 control-label">@lang('label.fax')</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="phone2" id="phone2">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email" class="col-md-4 control-label">@lang('label.@')</label>
                                        <div class="col-md-8">
                                            <input type="email" class="form-control" name="email" id="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country"
                                               class="col-md-4 control-label">@lang('label.country')</label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" id="country" name="country" disabled>
                                                <option></option>
                                                @foreach($countries as $country)
                                                    <option
                                                        value="{{ $country->idcountry }}">@if($emp->lang == 'fr') {{ $country->labelfr }} @else {{ $country->labeleng }} @endif</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="region" class="col-md-4 control-label">@lang('label.region')</label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" id="region" name="region" disabled>
                                                <option></option>
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
                                        <label for="division"
                                               class="col-md-4 control-label">@lang('label.division')</label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" id="division" name="division" disabled>
                                                <option></option>
                                                @foreach($divisions as $division)
                                                    <option
                                                        value="{{ $division->iddiv }}">{{ $division->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subdiv"
                                               class="col-md-4 control-label">@lang('label.subdiv')</label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" id="subdiv" name="subdiv" disabled>
                                                <option></option>
                                                @foreach($subdivs as $subdiv)
                                                    <option
                                                        value="{{ $subdiv->idsub }}">{{ $subdiv->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="town" class="col-md-4 control-label">@lang('label.town')</label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" id="town" name="town" disabled>
                                                <option></option>
                                                @foreach($towns as $town)
                                                    <option
                                                        value="{{ $town->idtown }}">{{ $town->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address"
                                               class="col-md-4 control-label">@lang('label.address')</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="address" name="address">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="postal" class="col-md-4 control-label">@lang('label.postal')</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="postal" name="postal">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <button type="button" id="delete"
                                            class="btn btn-sm bg-red pull-right btn-raised fa fa-trash"
                                            disabled></button>
                                    <button type="button" id="update"
                                            class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle"
                                            disabled></button>
                                    <button type="button" id="save"
                                            class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="box-header with-border" id="form">
                        @foreach($banks as $bank)
                            <input type="hidden" id="idbank" name="idbank" value="{{$bank->idbank}}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bankcode" class="col-md-4 control-label">@lang('label.code')</label>
                                        <div class="col-md-8">
                                            <input type="text" name="bankcode" id="bankcode" class="form-control"
                                                   value="{{pad($bank->bankcode,3)}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="bankname" id="bankname" class="form-control"
                                                   value="{{$bank->name}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="theiracc"
                                               class="col-md-4 control-label">@lang('label.theiracc')</label>
                                        <div class="col-md-8">
                                            <select name="theiracc" id="theiracc" class="form-control select2"
                                                    disabled>
                                                <option></option>
                                                @foreach($accounts as $account)
                                                    @if ($bank->theiracc == $account->idaccount)
                                                        <option value="{{$account->idaccount}}"
                                                                selected>{{$account->accnumb}}</option>
                                                    @else
                                                        <option
                                                            value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="partBank">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="ouracc"
                                                   class="col-md-4 control-label">@lang('label.ouracc')</label>
                                            <div class="col-md-8">
                                                <input type="text" name="ouracc" id="ouracc" class="form-control"
                                                       value="{{$bank->ouracc}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="manager"
                                                   class="col-md-4 control-label">@lang('label.manager')</label>
                                            <div class="col-md-8">
                                                <input type="text" name="manager" id="manager" class="form-control"
                                                       value="{{$bank->member}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phone1"
                                                   class="col-md-4 control-label">@lang('label.phone')</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="phone1" id="phone1"
                                                       value="{{$bank->phone1}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phone2"
                                                   class="col-md-4 control-label">@lang('label.fax')</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="phone2" id="phone2"
                                                       data-inputmask='"mask": "+(999)999999999"' data-mask
                                                       value="{{$bank->phone2}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="email" class="col-md-4 control-label">@lang('label.@')</label>
                                            <div class="col-md-8">
                                                <input type="email" class="form-control" name="email" id="email"
                                                       value="{{$bank->email}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="country"
                                                   class="col-md-4 control-label">@lang('label.country')</label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="country" name="country"
                                                        disabled>
                                                    <option></option>
                                                    @foreach($countries as $country)
                                                        @if ($bank->country == $country->idcountry)
                                                            <option
                                                                value="{{ $country->idcountry }}"
                                                                selected>@if($emp->lang == 'fr') {{ $country->labelfr }} @else {{ $country->labeleng }} @endif</option>
                                                        @else
                                                            <option
                                                                value="{{ $country->idcountry }}">@if($emp->lang == 'fr') {{ $country->labelfr }} @else {{ $country->labeleng }} @endif</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="region"
                                                   class="col-md-4 control-label">@lang('label.region')</label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="region" name="region" disabled>
                                                    <option></option>
                                                    @foreach($regions as $region)
                                                        @if ($bank->region == $region->idregi)
                                                            <option
                                                                value="{{ $region->idregi }}"
                                                                selected>@if($emp->lang == 'fr') {{ $region->labelfr }} @else {{ $region->labeleng }} @endif</option>
                                                        @else
                                                            <option
                                                                value="{{ $region->idregi }}">@if($emp->lang == 'fr') {{ $region->labelfr }} @else {{ $region->labeleng }} @endif</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="division"
                                                   class="col-md-4 control-label">@lang('label.division')</label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="division" name="division"
                                                        disabled>
                                                    <option></option>
                                                    @foreach($divisions as $division)
                                                        @if ($bank->division == $division->iddiv)
                                                            <option value="{{ $division->iddiv }}"
                                                                    selected>{{ $division->label }}</option>
                                                        @else
                                                            <option
                                                                value="{{ $division->iddiv }}">{{ $division->label }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="subdiv"
                                                   class="col-md-4 control-label">@lang('label.subdiv')</label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="subdiv" name="subdiv" disabled>
                                                    <option></option>
                                                    @foreach($subdivs as $subdiv)
                                                        @if ($bank->division == $subdiv->idsub)
                                                            <option value="{{ $subdiv->idsub }}"
                                                                    selected>{{ $subdiv->label }}</option>
                                                        @else
                                                            <option
                                                                value="{{ $subdiv->idsub }}">{{ $subdiv->label }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="town" class="col-md-4 control-label">@lang('label.town')</label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="town" name="town" disabled>
                                                    <option></option>
                                                    @foreach($towns as $town)
                                                        @if ($bank->division == $town->idtown)
                                                            <option value="{{ $town->idtown }}"
                                                                    selected>{{ $town->label }}</option>
                                                        @else
                                                            <option
                                                                value="{{ $town->idtown }}">{{ $town->label }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="address"
                                                   class="col-md-4 control-label">@lang('label.address')</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="address" name="address"
                                                       value="{{$bank->address}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="postal"
                                                   class="col-md-4 control-label">@lang('label.postal')</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="postal" name="postal"
                                                       value="{{$bank->postcode}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <button type="button" id="delete"
                                            class="btn btn-sm bg-red pull-right btn-raised fa fa-trash"></button>
                                    <button type="button" id="update"
                                            class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle"></button>
                                    <button type="button" id="insert"
                                            class="btn btn-sm bg-blue pull-right btn-raised fa fa-file-o"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('#bankcode, #ouracc, #phone1, #phone2').verifNumber();
        });

        $('#insert').click(function () {
            setEditable();
            $('#bankcode').removeAttr('readonly');
            $('#form :input').val('');
            $('.select2').select2().trigger('change');
            $(this).replaceWith('<button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
            $('.bg-aqua').replaceWith('<button type="button" id="update" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle"></button>');
            $('.fa-trash').attr('disabled', true);
        });

        $('#update').click(function () {
            setEditable();
            $(this).replaceWith('<button type="button" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>');
        });

        $(document).on('click', '#save, #edit', function () {
            let text = '';
            if ($('#idbank').val() === '')
                text = '@lang('confirm.bansave_text')';
            else
                text = '@lang('confirm.banedit_text')';

            swal({
                    title: '@lang('sidebar.bank')',
                    text: text,
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
                        $('#bankForm').submit();
                    }
                }
            );
        });

        $('#delete').click(function () {
            swal({
                    title: '@lang('sidebar.bank')',
                    text: '@lang('confirm.bandel_text')',
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
                        let form = $('#bankForm');
                        form.attr('action', 'bank/delete');
                        form.submit();
                    }
                }
            );
        });

        function setEditable() {
            $('#bankname').removeAttr('readonly');
            $('#partBank input[type="text"], input[type="email"], #theiracc').removeAttr('readonly');
            $('select').removeAttr('disabled');
        }

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
    </script>
@stop
