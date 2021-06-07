<?php
$emp = Session::get('employee');

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
        <h3 class="box-title text-bold" id="title"> @lang('label.new_bank')</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                <i class="fa fa-close"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <form action="{{ route('bank/store') }}" method="post" role="form" id="bankForm" class="needs-validation">
            {{ csrf_field() }}

            <div class="fillform">
                <input type="hidden" id="idbank" name="idbank" value="">

                <div class="row">
                    <div class="col-md-2 col=xs-12">
                        <div class="form-group has-error">
                            <label for="bank_code" class="col-md-4 col-xs-4 control-label">@lang('label.code')<span class="text-red text-bold">*</span></label>
                            <div class="col-md-8 col-xs-8">
                                <input type="text" name="bank_code" id="bank_code" class="form-control text-right code_" value="{{ (int)$banks->count() + 1 }}" readonly required>
                                <div class="help-block">@lang('placeholder.code')</div>
                            </div>
                        </div>
                    </div>
                    @if($emp->lang == 'fr')
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labelfr" class="col-md-3 control-label">@lang('label.bank_fr')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                    <div class="help-block">@lang('placeholder.bank_fr')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labeleng" class="col-md-3 control-label">@lang('label.bank_eng')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                    <div class="help-block">@lang('placeholder.bank_eng')</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labeleng" class="col-md-3 control-label">@lang('label.bank_eng')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="labeleng" id="labeleng" required>
                                    <div class="help-block">@lang('placeholder.bank_eng')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group has-error">
                                <label for="labelfr" class="col-md-3 control-label">@lang('label.bank_fr')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="labelfr" id="labelfr" required>
                                    <div class="help-block">@lang('placeholder.bank_fr')</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="box-header with-border">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="col-md-12 col-xs-12">
                                    <h3 class="row text-bold text-muted">@lang('label.partner_bank_infos')</h3>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group has-error">
                                    <label for="ouracc" class="col-md-4 control-label">@lang('label.ouracc')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="ouracc" id="ouracc" class="form-control" required>
                                        <div class="help-block">@lang('placeholder.ouracc')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group has-error">
                                    <label for="manager" class="col-md-4 control-label">@lang('label.manager')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="manager" id="manager" class="form-control" required>
                                        <div class="help-block">@lang('placeholder.manager')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group has-info">
                                    <label for="email" class="col-md-4 col-xs-4 control-label">@lang('label.@')</label>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="email" class="form-control" name="email" id="email">
                                        <div class="help-block">@lang('placeholder.@')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group has-info">
                                    <label for="phone1" class="col-md-4 control-label">@lang('label.phone')</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="phone1" id="phone1">
                                        <div class="help-block">@lang('placeholder.phone')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group has-info">
                                    <label for="phone2" class="col-md-4 control-label">@lang('label.fax')</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="phone2" id="phone2">
                                        <div class="help-block">@lang('placeholder.fax')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group has-info">
                                    <label for="postal" class="col-md-4 col-xs-4 control-label">@lang('label.postal')</label>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" id="postal" name="postal">
                                        <div class="help-block">@lang('placeholder.postal')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group has-info">
                                    <label for="country" class="col-md-4 control-label">@lang('label.country')</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" id="country" name="country">
                                            <option value=""></option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->idcountry }}">@if($emp->lang == 'fr') {{ $country->labelfr }} @else {{ $country->labeleng }} @endif</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block">@lang('placeholder.country')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group has-info">
                                    <label for="region" class="col-md-4 control-label">@lang('label.region')</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" id="region" name="region">
                                            <option value=""></option>
                                            @foreach($regions as $region)
                                                <option value="{{ $region->idregi }}">@if($emp->lang == 'fr') {{ $region->labelfr }} @else {{ $region->labeleng }} @endif</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block">@lang('placeholder.region')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label for="division" class="col-md-4 col-xs-4 control-label">@lang('label.division')</label>
                                    <div class="col-md-8 col-xs-8">
                                        <select class="form-control select2" id="division" name="division" >
                                            <option value=""></option>
                                            @foreach($divisions as $division)
                                                <option value="{{ $division->iddiv }}">{{ $division->label }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block">@lang('placeholder.division')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group">
                                    <label for="subdiv" class="col-md-4 control-label">@lang('label.subdiv')</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" id="subdiv" name="subdiv" >
                                            <option value=""></option>
                                            @foreach($subdivs as $subdiv)
                                                <option value="{{ $subdiv->idsub }}">{{ $subdiv->label }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block">@lang('placeholder.subdiv')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group">
                                    <label for="town" class="col-md-4 control-label">@lang('label.town')</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" id="town" name="town">
                                            <option value=""></option>
                                            @foreach($towns as $town)
                                                <option value="{{ $town->idtown }}">{{ $town->label }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block">@lang('placeholder.town')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label for="address" class="col-md-4 col-xs-4 control-label">@lang('label.address')</label>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" id="address" name="address">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-header with-border">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="col-md-12 col-xs-12">
                                    <h3 class="row text-bold text-muted">@lang('label.internal_manage_infos')</h3>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="theiracc" class="col-md-3 control-label">@lang('label.theiracc')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9">
                                        <select name="theiracc" id="theiracc" class="select2" required>
                                            <option value=""></option>
                                            @foreach ($accplans as $accplan)
                                                @if (substrWords($accplan->plan_code, 2) === '56'))
                                                    <option value="{{ $accplan->idaccplan }}">{{ substrWords($accplan->plan_code, 3) }} : @if($emp->lang == 'fr') {{ $accplan->labelfr }} @else {{ $accplan->labeleng }} @endif </option>        
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="help-block">@lang('placeholder.theiracc')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group has-info">
                                    <label for="cash_check_acc" class="col-md-3 control-label">@lang('label.cash_check_acc')</label>
                                    <div class="col-md-9">
                                        <select name="cash_check_acc" id="cash_check_acc" class="select2">
                                            <option value=""></option>
                                            @foreach ($accplans as $accplan)
                                                @if (substrWords($accplan->plan_code, 2) === '56'))
                                                    <option value="{{ $accplan->idaccplan }}">{{ substrWords($accplan->plan_code, 3) }} : @if($emp->lang == 'fr') {{ $accplan->labelfr }} @else {{ $accplan->labeleng }} @endif </option>        
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="help-block">@lang('placeholder.cash_check_acc')</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group has-info">
                                    <label for="credit_check_acc" class="col-md-3 control-label">@lang('label.credit_check_acc')</label>
                                    <div class="col-md-9">
                                        <select name="credit_check_acc" id="credit_check_acc" class="select2">
                                            <option value=""></option>
                                            @foreach ($accplans as $accplan)
                                                @if (substrWords($accplan->plan_code, 2) === '56'))
                                                    <option value="{{ $accplan->idaccplan }}">{{ substrWords($accplan->plan_code, 3) }} : @if($emp->lang == 'fr') {{ $accplan->labelfr }} @else {{ $accplan->labeleng }} @endif </option>        
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="help-block">@lang('placeholder.credit_check_acc')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group has-info">
                                    <label for="cash_corresp_check_acc" class="col-md-3 control-label">@lang('label.cash_corresp_check_acc')</label>
                                    <div class="col-md-9">
                                        <select name="cash_corresp_check_acc" id="cash_corresp_check_acc" class="select2">
                                            <option value=""></option>
                                            @foreach ($accplans as $accplan)
                                                @if (substrWords($accplan->plan_code, 2) === '56'))
                                                    <option value="{{ $accplan->idaccplan }}">{{ substrWords($accplan->plan_code, 3) }} : @if($emp->lang == 'fr') {{ $accplan->labelfr }} @else {{ $accplan->labeleng }} @endif </option>        
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="help-block">@lang('placeholder.cash_corresp_check_acc')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <button type="button" id="save" class="btn btn-sm bg-blue pull-right fa fa-save btn-raised"></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title text-bold">{{ $title }}</h3>
        @if ($emp->level === 'B')
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="new_bank">
                    <i class="fa fa-plus"></i>&nbsp;@lang('label.new_bank')
                </button>
            </div>
        @endif
    </div>
    <div class="box-body">
        <table id="admin-data-table" class="table table-condensed table-striped table-responsive table-hover table-responsive-xl table-bordered">
            <thead>
            <tr>
                <th>@lang('label.code')</th>
                <th>{{ $title }}</th>
                <th>@lang('label.theiracc')</th>
                <th>@lang('label.ouracc')</th>
                <th>@lang('label.manager')</th>
                <th>@lang('label.phone')</th>
                <th>@lang('label.date')</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($banks as $bank)
                <tr>
                    <td class="text-center">{{pad($bank->bankcode, 3)}}</td>
                    <td>@if($emp->lang == 'fr') {{ $bank->labelfr }} @else {{ $bank->labeleng }} @endif</td>
                    <td class="text-center">{{ $bank->accnumb }}</td>
                    <td class="text-center">{{ $bank->ouracc }}</td>
                    <td>{{ $bank->manager }}</td>
                    <td>{{ $bank->phone1 }}</td>
                    <td class="text-center">{{changeFormat($bank->created_at)}}</td>
                    <td class="text-center">
                        <button class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit('{{$bank->idbank}}')"></button>
                        <button type="button" class="btn bg-red btn-sm delete fa fa-trash-o" onclick="remove('{{$bank->idbank}}')"></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <form action="{{route('bank/delete')}}" method="post" role="form" id="delForm" style="display: none">
            {{ csrf_field() }}
            <input type="hidden" name="bank" id="bank" value="">
        </form>
    </div>
</div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('#bank_code, #ouracc, #phone1, #phone2').verifNumber();
        });

        $('#new_bank').click(function () {
            in_out_form();

            $.ajax({
                url: "{{ url('getBanks') }}",
                method: 'get',
                data: {
                    branch: "{{ $emp->branch }}"
                },
                success: function (banks) {
                    $('#bank_code').val(banks.length + 1);
                }
            });
653558723
            $('#form').show();
        });

        function edit(idbank) {
            $.ajax({
                url: "{{ url('getBank') }}",
                method: 'get',
                data: {
                    id: idbank
                },
                success: function (bank) {
                    $('#title').text("@lang('label.edit') @if($emp->lang === 'fr') " + bank.labelfr + " @else " + bank.labeleng + "@endif");

                    $('#idbank').val(bank.idbank);
                    $('#bank_code').val(bank.bankcode);
                    $('#labeleng').val(bank.labeleng);
                    $('#labelfr').val(bank.labelfr);
                    $('#ouracc').val(bank.ouracc);
                    $('#manager').val(bank.manager);
                    $('#email').val(bank.email);
                    $('#phone1').val(bank.phone1);
                    $('#phone2').val(bank.phone2);
                    $('#postal').val(bank.postcode);
                    $('#country').val(bank.country).select2();
                    $('#region').val(bank.region).select2();
                    $('#division').val(bank.division).select2();
                    $('#subdiv').val(bank.subdivision).select2();
                    $('#town').val(bank.town).select2();
                    $('#address').val(bank.address);

                    $.ajax({
                        url: "{{ url('getAccount') }}",
                        method: 'get',
                        data: {
                            id: bank.theiracc
                        },
                        success: function (theirAcc) {
                            $('#theiracc').val(theirAcc.idplan).select2();
                        }
                    });

                    if (bank.cash_check_acc !== null) {
                        $.ajax({
                            url: "{{ url('getAccount') }}",
                            method: 'get',
                            data: {
                                id: bank.cash_check_acc
                            },
                            success: function (theirAcc) {
                                $('#theiracc').val(theirAcc.idplan).select2();
                            }
                        });
                    }

                    if (bank.credit_check_acc !== null) {
                        $.ajax({
                            url: "{{ url('getAccount') }}",
                            method: 'get',
                            data: {
                                id: bank.credit_check_acc
                            },
                            success: function (creditCheckAcc) {
                                $('#credit_check_acc').val(creditCheckAcc.idplan).select2();
                            }
                        });
                    }

                    if (bank.cash_corresp_check_acc !== null) {
                        $.ajax({
                            url: "{{ url('getAccount') }}",
                            method: 'get',
                            data: {
                                id: bank.cash_corresp_check_acc
                            },
                            success: function (cashCorrespCheckAcc) {
                                $('#cash_corresp_check_acc').val(cashCorrespCheckAcc.idplan).select2();
                            }
                        });
                    }

                    $('#save').replaceWith('<button type="button" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit edit"></button>');

                    $('#form').show();
                }
            });
        }

        function remove(idbank) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.bank_del_text')',
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
                    $('#bank').val(idbank);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#form').hide();
            in_out_form();
        });

        $(document).on('click', '#save, #edit', function () {
            let text = '';
            if ($('#idbank').val() === '')
                text = '@lang('confirm.bank_save_text')';
            else
                text = '@lang('confirm.bank_edit_text')';

            mySwal("{{$title}}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#bankForm');
        });

        function in_out_form() {
            $('#title').text('@lang('label.new_bank')');
            $('#idbank').val('');
            $('.fillform :input').val('');
            $('.fillform :input[type="checkbox"]').prop('checked', false);
            $('.select2').val('').select2();
            $('.edit').replaceWith('<button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }

        /**
         * Get the regions based on the country
         */
         $('#country').change(function (e) {
            $.ajax({
                url: "{{ url('getRegions') }}",
                method: 'get',
                data: {
                    country: $('#country').val()
                },
                success: function (result) {
                    let option = "<option value=''></option>";
                    $.each(result, function (i, region) {
                        option += "<option value=" + region.idregi + ">@if($emp->lang == 'fr') " + region.labelfr + " @else " + region.labeleng + " @endif</option>";
                    });
                    $('#region').html(option);
                }
            });
        });

        /**
         * Get the Divisions based on the Region
         */
        $('#region').change(function (e) {
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
        });

        /**
         * Get the Sub-Divisions based on the Division
         */
        $('#division').change(function (e) {
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
        });

        /**
         * Get the Towns based on the Sub Division
         */
        $('#subdiv').change(function (e) {
            $.ajax({
                url: "{{ url('getTowns') }}",
                method: 'get',
                data: {
                    subdivision: $('#subdiv').val()
                },
                success: function (result) {
                    let option = "<option value=''></option>";
                    $.each(result, function (i, town) {
                        option += "<option value=" + town.idtown + ">" + town.label + "</option>";
                    });
                    $('#town').html(option);
                }
            });
        });
    </script>
@stop
