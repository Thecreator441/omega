<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.com_sharing'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.com_sharing') </h3>
        </div>
        <div class="box-body">
            <form action="{{ url('com_sharing/store') }}" method="post" role="form" id="cinForm">
                {{ csrf_field() }}

                <div class="row">
                    @if ($emp->level !== 'B')
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="branch" class="col-md-3 control-label">@lang('label.branch')</label>
                                <div class="col-md-9">
                                    <select name="branch" id="branch" class="from-control select2">
                                        <option value=""></option>
                                        @foreach ($branchs as $branch)
                                            <option value="{{$branch->idbranch}}">{{$branch->code}} : {{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                    <input type="hidden" id="branch">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="month" class="col-md-3 control-label">@lang('label.month')</label>
                            <div class="col-md-9">
                                <select name="month" id="month" class="from-control select2">
                                    <option value=""></option>
                                    <option value="1" @if($month===1) selected @endif>@lang('label.jan')</option>
                                    <option value="2" @if($month===2) selected @endif>@lang('label.feb')</option>
                                    <option value="3" @if($month===3) selected @endif>@lang('label.mar')</option>
                                    <option value="4" @if($month===4) selected @endif>@lang('label.apr')</option>
                                    <option value="5" @if($month===5) selected @endif>@lang('label.may')</option>
                                    <option value="6" @if($month===6) selected @endif>@lang('label.jun')</option>
                                    <option value="7" @if($month===7) selected @endif>@lang('label.jul')</option>
                                    <option value="8" @if($month===8) selected @endif>@lang('label.aug')</option>
                                    <option value="9" @if($month===9) selected @endif>@lang('label.sep')</option>
                                    <option value="10" @if($month===10) selected @endif>@lang('label.oct')</option>
                                    <option value="11" @if($month===11) selected @endif>@lang('label.nov')</option>
                                    <option value="12" @if($month===12) selected @endif>@lang('label.dec')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <button type="button" id="search"
                                    class="btn btn-sm bg-green pull-right btn-raised fa fa-search">
                            </button>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="form-group"></div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="tableInput">
                            <thead>
                            <tr>
                                <th>@lang('label.code')</th>
                                <th>@lang('label.collector')</th>
                                <th>@lang('label.commis')</th>
                                <th>@lang('label.col_com')</th>
                                <th>@lang('label.inst_com')</th>
                            </tr>
                            </thead>
                            <tbody id="tabLine">
                            @foreach ($collectors as $collector)
                                <tr>
                                    <td class="text-center">{{pad($collector->code, 6)}}
                                        <input type="hidden" name="col_codes[]" value="{{$collector->idcoll}}">
                                    </td>
                                    <td>{{$collector->name}} {{$collector->surname}}</td>
                                    <?php
                                    $amount = 0;
                                    foreach ($writings as $writing):
                                        if ($writing->employee === $collector->iduser):
                                            $amount += (int)$writing->creditamt;
                                        endif;
                                    endforeach;
                                    $col_com = round(($param->col_com / 100) * $amount, 0);
                                    $inst_com = $amount - $col_com;
                                    ?>
                                    <td class="text-bold text-right amount">{{money($amount)}}</td>
                                    <td class="text-bold text-right"><input type="text" name="col_amts[]" id="{{$collector->idcoll}}" class="col_com" value="{{money($col_com)}}" readonly></td>
                                    <td class="text-bold text-right inst_com">{{money($inst_com)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="bg-antiquewhite">
                            <tr>
                                <th colspan="2" class="text-center">@lang('label.total')</th>
                                <th class="text-right">
                                    <input type="text" name="total_amt" id="totamt" readonly>
                                </th>
                                <th class="text-right">
                                    <input type="text" name="total_col" id="totcol_com" readonly>
                                </th>
                                <th class="text-right">
                                    <input type="text" name="total_inst" id="totinst_com" readonly>
                                </th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save" @if ($amount === 0) style="display: none" @endif></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            // fillSharings($('#branch').val(), $('#month').val());

            sumFields();
        });

        function sumFields() {
            let totAmt = 0;
            let totCol = 0;
            let totIns = 0;

            $('.amount').each(function () {
                let numb = trimOver($(this).text(), null);
                if (parseInt(numb))
                    totAmt += parseInt(numb);
            });

            $('.col_com').each(function () {
                let numb = trimOver($(this).val(), null);
                if (parseInt(numb))
                    totCol += parseInt(numb);
            });

            $('.inst_com').each(function () {
                let numb = trimOver($(this).text(), null);
                if (parseInt(numb))
                    totIns += parseInt(numb);
            });

            $('#totamt').val(money(totAmt));
            $('#totcol_com').val(money(totCol));
            $('#totinst_com').val(money(totIns));

            if (totAmt === 0) {
                $('#save').hide();
            } else {
                $('#save').show();
            }
        }

        $('#search').click(function () {
            fillSharings($('#branch').val(), $('#month').val());
        });

        function fillSharings(branch, month) {
            $.ajax({
                url: "{{url('getFilterSharings')}}",
                method: 'get',
                data: {
                    branch: branch,
                    month: month
                },
                success: function (sharings) {
                    let line = '';
                    let month = '';
                    let amount = '';
                    $.each(sharings, function (i, sharing) {
                        let surname = '';
                        if (sharing.surname !== null) {
                            surname = sharing.surname;
                        }
                        console.log(sharing.inst_com);
                        month = sharing.month + 1;
                        amount = sharing.amount;
                        line += '<tr>' +
                            '<td class="text-center"><input type="hidden" name="col_codes[]" value=' + sharing.idcoll + '>' + pad(sharing.code, 6) + '</td>' +
                            '<td>' + sharing.name + ' ' + surname + '</td>' +
                            '<td class="text-right text-bold amount">' + money(parseInt(sharing.amount)) + '</td>' +
                            '<td class="text-right text-bold"><input class="col_com" type="hidden" name="col_amts[]" value=' + sharing.col_com + '>' + money(parseInt(sharing.col_com)) + '</td>' +
                            '<td class="text-right text-bold inst_com">' + money(parseInt(sharing.inst_com)) + '</td>' +
                            '</tr>';
                    });
                    $('#tabLine').html(line);
                    sumFields();

                    if (month < parseInt($('#month').val()) || month > parseInt($('#month').val())) {
                        $('#save').hide()
                    }

                }
            });
        }

        $('#save').click(function () {
            mySwal('@lang('sidebar.com_sharing')', '@lang('confirm.com_share_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#cinForm');
        });
    </script>
@stop
