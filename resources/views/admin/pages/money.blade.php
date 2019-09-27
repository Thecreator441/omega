<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Monnaies';
else
    $title = 'Moneys';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="box">
        <form action="{{ url('admin/money/store') }}" method="post" role="form">
            <div class="box-header with-border">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="id">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="bilcode" class="col-md-6 control-label">@lang('label.code')</label>
                            <div class="col-md-6" id="monCode">
                                <select type="text" class="form-control select2" name=moncode" id="moncode">
                                    <option></option>
                                    @foreach($moneys as $money)
                                        <option value="{{$money->idmoney}}">{{$money->moncode}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="value" class="col-md-4 control-label">@lang('label.value')</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control text-right" name="value" id="value" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="format" class="col-md-6 control-label">@lang('label.format')</label>
                            <div class="col-md-6">
                                <select class="form-control select2" name="format" id="format" disabled>
                                    <option value=""></option>
                                    <option value="B">@if($emp->lang == 'fr') Billet @else Bank Note @endif</option>
                                    <option value="C">@if($emp->lang == 'fr') Pièce @else Coin @endif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="currency" class="col-md-4">@lang('label.currency')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="currency" name="currency" disabled>
                                    <option value=""></option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->idcurrency }}">{{ $currency->label }} ({{
                                            $currency->format }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="labelfr" class="col-md-3 control-label">@lang('label.labelfr')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="labelfr" id="labelfr" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="labeleng" class="col-md-3 control-label">@lang('label.labeleng')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="labeleng" id="labeleng" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <button type="button" id="delete" class="btn btn-sm bg-red pull-right btn-raised fa fa-trash">
                        </button>
                        <button type="button" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle">
                        </button>
                        <button type="button" id="new" class="btn btn-sm bg-blue pull-right btn-raised fa fa-file-o">
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
            let billCode = $('#billCode');
            let bilcode = $('#bilcode');
            let value = $('#value');
            let format = $('#format');
            let currency = $('#currency');
            let labelfr = $('#labelfr');
            let labeleng = $('#labeleng');

            bilcode.change(function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ url('getBilleting') }}",
                    method: 'get',
                    data: {
                        id: bilcode.val()
                    },
                    success: function (result) {
                        $.each(result, function (i, billet) {
                            value.val(billet.value);
                            format.val(billet.format);
                            currency.val(billet.idcurrency);
                            labelfr.val(billet.labelfr);
                            labeleng.val(billet.labeleng);
                            $('.select2').select2().trigger('change');
                        });
                    }
                });
            });

            /**
             * Set the form new mode
             */
            $('#new').click(function () {
                billCode.html('<input type="text" class="form-control" name="bilcode" id="bilcode">');
                setEditable();
                emptyFields();
                $(this).removeClass('fa-file-o');
                $(this).addClass('fa-save');
                $(this).attr('id', 'save')
            });

            $('#edit').click(function () {
                if (bilcode.val() !== '') {
                    billCode.html('<input type="text" class="form-control" name="bilcode" id="bilcode" value="' + bilcode.val() + '">');
                    setEditable();
                    $(this).removeClass('fa-recycle');
                    $(this).addClass('fa-edit');
                    $(this).attr('id', 'update');
                }
            });

            $('#update').click(function (e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ url('admin/billeting/store') }}",
                    method: 'post',
                    data: {
                        id: bilcode.val(),
                        value: value.val(),
                        format: format.val(),
                        currency: currency.val(),
                        labelfr: labelfr.val(),
                        labeleng: labeleng.val()
                    },
                    success: function (result) {
                        if (result === 'success') {

                        }
                    }
                });
            });

            $('#delete').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ url('admin/billeting/delete') }}",
                    method: 'post',
                    data: {
                        id: bilcode.val()
                    },
                    success: function (result) {
                        console.log(result);
                    }
                });
            });

            function setEditable() {
                value.removeAttr('readonly');
                format.removeAttr('disabled');
                currency.removeAttr('disabled');
                labelfr.removeAttr('readonly');
                labeleng.removeAttr('readonly');
            }

            function emptyFields() {
                bilcode.val('');
                value.val('');
                format.val('');
                currency.val('');
                labelfr.val('');
                labeleng.val('');
                $('.select2').select2().trigger('change');
            }
        });
    </script>
@stop
