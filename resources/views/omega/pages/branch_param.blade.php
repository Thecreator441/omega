<?php

$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('label.bran_param'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('label.bran_param') </h3>
        </div>
        <div class="box-body">
            <form action="{{ url('branch/store') }}" method="post" role="form" id="cinForm" class="needs-validation">
                {{ csrf_field() }}

                @if($param === null)
                    <input type="hidden" name="idparam" value="">

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">@lang('label.commis') : </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="per">
                                        <input type="radio" name="commis" class="commis" id="per" value="P">@lang('label.per')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="tab">
                                        <input type="radio" name="commis" class="commis" id="tab" value="T">@lang('label.tab')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="row">
                        <div id="percent" style="display: none">
                            <div class="col-md-4"></div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="per_rate" class="col-md-7 col-xs-7 control-label">@lang('label.per_rate') <span class="text-red text-bold">*</span></label>
                                    <div class="col-md-5 col-xs-5">
                                        <input type="text" name="per_rate" id="per_rate" class="text-bold form-control text-right">
                                        <span class="help-block">@lang('placeholder.per')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>

                        <div id="tabular" style="display: none">
                            <div class="col-md-12">
                                <table class="table table-bordered" id="tableInput">
                                    <thead>
                                    <tr>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>@lang('label.amount') <span class="text-red text-bold">*</span></th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-bold text-center" id="tabLine">
                                    <tr>
                                        <td>500</td>
                                        <td>5 000</td>
                                        <td><input type="text" name="t50" class="amount"></td>
                                    </tr>
                                    <tr>
                                        <td>5 001</td>
                                        <td>20 000</td>
                                        <td><input type="text" name="t200" class="amount"></td>
                                    </tr>
                                    <tr>
                                        <td>20 001</td>
                                        <td>40 000</td>
                                        <td><input type="text" name="t400" class="amount"></td>
                                    </tr>
                                    <tr>
                                        <td>40 001</td>
                                        <td>50 000</td>
                                        <td><input type="text" name="t500" class="amount"></td>
                                    </tr>
                                    <tr>
                                        <td>50 001</td>
                                        <td>>></td>
                                        <td><input type="text" name="t" class="amount"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group has-error">
                                <label for="coll_limit" class="col-md-6 col-xs-8 control-label">@lang('label.coll_limit') <span class="text-red text-bold">*</span></label>
                                <div class="col-md-6 col-xs-4">
                                    <input type="text" name="coll_limit" id="coll_limit" class="text-bold form-control text-right" required>
                                    <span class="help-block">@lang('placeholder.coll_limit')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save" disabled></button>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="idparam" value="{{$param->idbranch_param}}">

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">@lang('label.commis') : </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="per">
                                        <input type="radio" name="commis" class="commis" id="per" value="P" @if($param->commis === 'P') checked @endif>
                                        @lang('label.per')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="radio">
                                    <label for="tab">
                                        <input type="radio" name="commis" class="commis" id="tab" value="T" @if($param->commis === 'T') checked @endif>
                                        @lang('label.tab')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="row">
                        <div id="percent" style="display: none">
                            <div class="col-md-4"></div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="per_rate" class="col-md-7 col-xs-7 control-label">@lang('label.per_rate') <span class="text-red text-bold">*</span></label>
                                    <div class="col-md-5 col-xs-5">
                                        <input type="text" name="per_rate" id="per_rate" class="text-bold form-control text-right" value="@if($param->commis === 'P'){{$param->com_perc}}@endif">
                                        <span class="help-block">@lang('placeholder.per')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>

                        <div id="tabular" style="display: none">
                            <div class="col-md-12">
                                <table class="table table-bordered" id="tableInput">
                                    <thead>
                                    <tr>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>@lang('label.amount') <span class="text-red text-bold">*</span></th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-bold text-center" id="tabLine">

                                    @if ($param_tab !== null)
                                        <tr>
                                            <td>500</td>
                                            <td>5 000</td>
                                            <td><input type="text" name="t50" class="amount" value="{{money((int) $param_tab->t50)}}"></td>
                                        </tr>
                                        <tr>
                                            <td>5 001</td>
                                            <td>20 000</td>
                                            <td><input type="text" name="t200" class="amount" value="{{money((int) $param_tab->t200)}}"></td>
                                        </tr>
                                        <tr>
                                            <td>20 001</td>
                                            <td>40 000</td>
                                            <td><input type="text" name="t400" class="amount" value="{{money((int) $param_tab->t400)}}"></td>
                                        </tr>
                                        <tr>
                                            <td>40 001</td>
                                            <td>50 000</td>
                                            <td><input type="text" name="t500" class="amount" value="{{money((int) $param_tab->t500)}}"></td>
                                        </tr>
                                        <tr>
                                            <td>50 001</td>
                                            <td>>></td>
                                            <td><input type="text" name="t" class="amount" value="{{money((int) $param_tab->t)}}"></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>500</td>
                                            <td>5 000</td>
                                            <td><input type="text" name="t50" class="amount"></td>
                                        </tr>
                                        <tr>
                                            <td>5 001</td>
                                            <td>20 000</td>
                                            <td><input type="text" name="t200" class="amount"></td>
                                        </tr>
                                        <tr>
                                            <td>20 001</td>
                                            <td>40 000</td>
                                            <td><input type="text" name="t400" class="amount"></td>
                                        </tr>
                                        <tr>
                                            <td>40 001</td>
                                            <td>50 000</td>
                                            <td><input type="text" name="t500" class="amount"></td>
                                        </tr>
                                        <tr>
                                            <td>50 001</td>
                                            <td>>></td>
                                            <td><input type="text" name="t" class="amount"></td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group has-error">
                                <label for="coll_limit" class="col-md-6 col-xs-8 control-label">@lang('label.coll_limit') <span class="text-red text-bold">*</span></label>
                                <div class="col-md-6 col-xs-4">
                                    <input type="text" name="coll_limit" id="coll_limit" class="text-bold form-control text-right" value="{{money((int)$param->coll_limit)}}" required>
                                    <span class="help-block">@lang('placeholder.coll_limit')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit" disabled></button>
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
            $('.commis').each(function () {
                if ($(this).is(':checked')) {
                    if ($(this).val() === 'P') {
                        $('#percent').show();
                        $('#per_rate').attr('required', true);
                        $('#tabular').hide();
                        $('#tabLine :input').removeAttr('required');
                        // $('.amount').val('');
                    } else if ($(this).val() === 'T') {
                        $('#percent').hide();
                        $('#per_rate').removeAttr('required');
                        $('#tabular').show();
                        $('#tabLine :input').attr('required', true);
                        // $('#per_rate').val('');
                    }
                    $('#edit').attr('disabled', false);
                }
            });
        });

        $('.commis').click(function () {
            if ($(this).is(':checked')) {
                if ($(this).val() === 'P') {
                    $('#percent').show();
                    $('#per_rate').attr('required', true);
                    $('#tabular').hide();
                    $('#tabLine :input').removeAttr('required');
                    // $('.amount').val('');
                } else if ($(this).val() === 'T') {
                    $('#percent').hide();
                    $('#per_rate').removeAttr('required');
                    $('#tabular').show();
                    $('#tabLine :input').attr('required', true);
                    // $('#per_rate').val('');
                }
                $('#save').attr('disabled', false);
            }
        });

        $(document).on('input', '.amount', function () {
            $(this).val(money($(this).val()));
        });

        function submitForm() {
            let text = '@lang('confirm.brpsave_text')';
            if ($('#idparam') !== '') {
                text = '@lang('confirm.brpedit_text')';
            }

            mySwal('@lang('label.bran_param')', text, '@lang('confirm.no')', '@lang('confirm.yes')', '#cinForm');
        }
    </script>
@stop
