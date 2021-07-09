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
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> {{ $title }} </h3>
        </div>
        <div class="box-body">
            <form action="{{ url('other_check_in/store') }}" method="post" role="form" id="ocheinForm" class="needs-validation">
                {{ csrf_field() }}

                <div class="row">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="bank" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">@lang('label.bank')<span class="text-red text-bold">*</span></label>
                                        <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <select class="form-control select2" name="bank" id="bank" required>
                                                <option value=""></option>
                                                @foreach($banks as $bank)
                                                    <option value="{{$bank->idbank}}"> {{pad($bank->bankcode, 3)}} : @if($emp->lang === 'fr')
                                                            {{ $bank->labelfr}}
                                                        @else
                                                            {{ $bank->labeleng}}
                                                        @endif</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="checkno" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">@lang('label.checkno')<span class="text-red text-bold">*</span></label>
                                        <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <input type="text" name="checkno" id="checkno" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="represent" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">@lang('label.carrier')</label>
                                        <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <input type="text" class="form-control" name="represent" id="represent">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="account" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">@lang('label.account')</label>
                                        <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <select class="form-control select2" id="account">
                                                <option value=""></option>
                                                @foreach($accounts as $account)
                                                    <option value="{{$account->idaccount}}">{{$account->accnumb}} : @if($emp->lang === 'fr')
                                                            {{ $account->labelfr}}
                                                        @else
                                                            {{ $account->labeleng}}
                                                        @endif</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="desc" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">@lang('label.desc')</label>
                                        <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <input type="text" class="form-control" id="desc">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-9 col-lg-8 col-md-7 col-sm-7 col-xs-7">
                                    <div class="form-group">
                                        <label for="amount" class="col-xl-2 col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">@lang('label.amount')</label>
                                        <div class="col-xl-10 col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                            <input type="text" class="form-control text-right text-bold" id="amount">
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-5 col-xs-5">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <button type="button" id="minus" class="btn btn-sm bg-red pull-right btn-raised fa fa-minus"></button>
                                            <button type="button" id="plus" class="btn btn-sm bg-green pull-right btn-raised fa fa-plus"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="tableInput">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table id="billet-data-table" class="table table-striped table-hover table-condensed table-bordered no-padding">
                                <thead>
                                <tr class="bg-purples">
                                    <th></th>
                                    <th>@lang('label.account')</th>
                                    <th>@lang('label.entitle')</th>
                                    <th>@lang('label.amount')</th>
                                </tr>
                                </thead>
                                <tbody id="cont">
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right">@lang('label.totdist')</td>
                                    <td class="bg-blue text-right" style="width: 25%"><input type="text" name="totdist" id="totdist"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            if ($('#cont tr').length === 0)
                $('#minus').attr('disabled', true);
        });

        $('#account').change(function (e) {
            if (!isNaN($(this).val())) {
                $.ajax({
                    url: "{{ url('getAccount') }}",
                    method: 'get',
                    data: {
                        id: $(this).val()
                    },
                    success: function (account) {
                        $('#desc').val("@if($emp->lang == 'fr')" + account.labelfr + " @else" + account.labeleng + " @endif");
                    }
                });
            }
        });

        $('#amount').on('input', function () {
            $(this).val(money($(this).val()));
        });

        $('#plus').click(function () {
            let acc = $('#account');
            let opera = $('#desc');
            let amount = $('#amount');

            let accId = acc.select2('data')[0]['id'];
            let accText = acc.select2('data')[0]['text'];

            var accNumb = accText.split(':')[0];

            let line = '<tr>' +
                '<td style="text-align: center; width: 5%"><input type="checkbox" class="check"></td>' +
                '<td><input type="hidden" name="accounts[]" value="' + accId + '">' + accNumb + '</td>' +
                '<td><input type="hidden" name="operations[]" value="' + opera.val() + '">' + opera.val() + '</td>' +
                '<td class="text-right text-bold amount"><input type="hidden" name="amounts[]" value="' + amount.val() + '">' + money(amount.val()) + '</td>' +
                '</tr>';

            $('#billet-data-table').DataTable().destroy()

            $('#cont').append(line);
            $('#minus').removeAttr('disabled');

            sumAmount();

            acc.val('').select2();
            opera.val('');
            amount.val('');
        });

        $('#minus').click(function () {
            $('.check').each(function () {
                if ($(this).is(':checked'))
                    $(this).closest('tr').remove();
            });
            sumAmount();
        });

        $('#minus').hover(function () {
            if ($('#cont tr').length === 0)
                $(this).attr('disabled', true);
        });

        function sumAmount() {
            let sum = 0;
            $('.amount').each(function () {
                let numb = trimOver($(this).text(), null);
                if (parseInt(numb))
                    sum += parseInt(numb);
            });
            $('#totdist').val(money(sum));
        }

        function submitForm() {
            let tot = parseInt(trimOver($('#totdist').val(), null));

            if (!isNaN(tot)) {
                mySwal("{{ $title }}", '@lang('confirm.other_check_in_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#ocheinForm');
            } else {
                myOSwal("{{ $title }}", '@lang('confirm.other_check_in_error_text')', 'error');
            }
        }
    </script>
@stop
