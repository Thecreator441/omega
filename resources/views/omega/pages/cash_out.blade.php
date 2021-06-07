<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.cout'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.cout') </h3>
        </div>
        <div class="box-body">
            <form action="{{ url('cash_out/store') }}" method="post" id="coutForm" role="form"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="col-md-3 col-xs-12">
                    <h2 class="bg-antiquewhite text-blue text-bold text-center">@lang('label.break')</h2>
                    <table id="tableInput"
                           class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                        <thead class="text-bold">
                        <tr>
                            <th colspan="3" class="bg-purples">@lang('label.notes')</th>
                            <th class="bilSum"></th>
                        </tr>
                        </thead>
                        <tbody class="text-bold">
                        @foreach ($moneys as $money)
                            @if ($money->format == 'B')
                                @if ($money->format == 'B')
                                    <tr>
                                        <td id="mon{{$money->idmoney}} billet" class="input text-right">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                        <td id="billet">{{money($money->value)}}</td>
                                        <td id="billeting"><input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                                  oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                        </td>
                                        <td class="sum text-right" id="{{$money->moncode}}Sum"></td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                        </tbody>
                        <thead class="text-bold">
                        <tr>
                            <th colspan="3" class="bg-purples">@lang('label.coins')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="text-bold">
                        @foreach ($moneys as $money)
                            @if ($money->format == 'C')
                                <tr>
                                    <td id="mon{{$money->idmoney}} billet" class="input text-right">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                    <td id="billet">{{$money->value}}</td>
                                    <td id="billeting"><input type="text" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                              oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                    </td>
                                    <td class="sum text-right" id="{{$money->moncode}}Sum"></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot class="text-bold">
                        <tr>
                            <th class="bg-purples" colspan="3"
                                style="text-align: center !important;">@lang('label.tobreak')</th>
                            <th class="bg-blue">
                                <input type="text" class="bg-blue pull-right text-bold" name="totbil" id="totbil"
                                       disabled style="text-align: right !important;">
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-9 col-xs-12">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="member"
                                               class="col-md-2 control-label">@lang('label.member')</label>
                                        <div class="col-md-3">
                                            <select class="form-control select2" name="member" id="member">
                                                <option></option>
                                                @foreach($members as $member)
                                                    <option
                                                        value="{{$member->idmember}}">{{pad($member->memnumb, 6)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" name="mem_name" id="mem_name" class="form-control"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nic"
                                               class="col-md-2 control-label">@lang('label.idcard')</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="nic" id="nic"
                                                   disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="benef"
                                               class="col-md-2 control-label">@lang('label.benef')</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="benef" id="benef">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="loan_info"
                                               class="col-md-2 control-label">@lang('label.loaninf')</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="loan_info" id="loan_info">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <img id="pic" alt="@lang('label.mempic')" class="img-bordered-sm"
                                             style="height: 150px; width: 100%;"/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <img id="sign" alt="@lang('label.memsign')" class="img-bordered-sm"
                                             style="height: 70px; width: 100%;"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" id="tableInput">
                        <div class="row">
                            <div class="row">
                                <table id="simul-data-table"
                                       class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                                    <thead>
                                    <tr class="text-bold">
                                        <th class="cout">@lang('label.account')</th>
                                        <th style="width: 25%">@lang('label.entitle')</th>
                                        <th>@lang('label.opera')</th>
                                        <th class="cout">@lang('label.available')</th>
                                        <th class="cout">@lang('label.amount')</th>
                                        <th class="cout">@lang('label.fees')</th>
                                    </tr>
                                    </thead>
                                    <tbody id="mem_table">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-11">
                        <div class="row">
                            <div class="row">
                                <table class="table table-responsive" id="tableInput">
                                    <thead>
                                    <tr class="text-bold text-blue bg-antiquewhite text-left">
                                        @foreach($accounts as $account)
                                            @if ($cash->cashacc == $account->idaccount)
                                                <td style="width: 25%">
                                                    @if($emp->lang == 'fr') {{$account->labelfr }} @else {{$account->labeleng }} @endif
                                                </td>
                                                <td>{{$account->accnumb }}</td>
                                            @endif
                                        @endforeach
                                        <td>@lang('label.totrans')</td>
                                        <td style="width: 15%">
                                            <input type="text" style="text-align: left" name="totrans" id="totrans"
                                                   readonly></td>
                                        <td>@lang('label.diff')</td>
                                        <td id="diff" class="text-right" style="width: 15%"></td>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="row">
                            <div class="row">
                                <button type="button" id="save"
                                        class="btn btn-sm bg-blue pull-right btn-raised fa fa-save">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('#member').change(function () {
            $.ajax({
                url: "{{ url('getMember') }}",
                method: 'get',
                data: {member: $(this).val()},
                success: function (member) {
                    if (member.surname === null) {
                        $('#mem_name').val(member.name);
                        $('#benef').val(member.name);
                    } else {
                        $('#mem_name').val(member.name + ' ' + member.surname);
                        $('#benef').val(member.name + ' ' + member.surname);
                    }

                    $('#nic').val(member.nic);

                    $.ajax({
                        url: "{{url('getProfile')}}",
                        method: 'get',
                        data: {
                            owner: 'members',
                            file: member.pic
                        },
                        success: function (filePath) {
                            $('#pic').attr('src', filePath);
                        }
                    });

                    $.ajax({
                        url: "{{url('getSignature')}}",
                        method: 'get',
                        data: {
                            owner: 'members',
                            file: member.signature
                        },
                        success: function (filePath) {
                            $('#sign').attr('src', filePath);
                        }
                    });

                    @if($emp->collector === null)
                    async function memAccs() {
                        const coms = await getData('getMemComakers?member=' + member.idmember);
                        const demComs = await getData('getMemDemComakers?member=' + member.idmember);
                        const accBals = await getData('getAccBalance?member=' + member.idmember);

                        let block = 0;
                        let acc = 0;
                        let memAccLine = '';

                        $.each(coms, function (i, com) {
                            block += (parseInt(com.guaramt) - parseInt(com.paidguar));
                            acc = com.account;
                        });

                        $.each(demComs, function (i, demCom) {
                            block += (parseInt(demCom.guaramt) - parseInt(demCom.paidguar));
                            acc = demCom.account;
                        });

                        $.each(accBals, function (i, accBal) {
                            let ava = parseInt(accBal.available);
                            let evebal = parseInt(accBal.evebal);
                            if (ava === 0) {
                                ava = evebal;
                            }

                            if (accBal.accabbr === 'O' || accBal.accabbr === 'E') {
                                memAccLine += '<tr>' +
                                    '<td class="cout"><input type="hidden" name="accounts[]" value="' + accBal.account + '">' + accBal.accnumb + '</td>' +
                                    '<td style="width: 25%">@if ($emp->lang == 'fr')' + accBal.labelfr + ' @else ' + accBal.labeleng + '@endif</td>' +
                                    '<td><input type="hidden" name="operations[]" value="' + accBal.operation + '">' +
                                    '@if ($emp->lang == 'fr')' + accBal.debtfr + ' @else ' + accBal.debteng + '@endif</td>';
                                if (accBal.account === acc) {
                                    memAccLine += '<td class="text-right cout text-bold">' + money(ava - block) + '</td>';
                                } else {
                                    memAccLine += '<td class="text-right cout text-bold">' + money(ava) + '</td>';
                                }
                                memAccLine += '<td class="cout"><input type="text" class="amount" name="amounts[]"></td>' +
                                    '<td class="cout"><input type="text" class="fee" name="fees[]"></td>' +
                                    '</tr>';
                            }
                        });

                        $('#mem_table').html(memAccLine);
                    }

                    memAccs();
                    @endif
                }
            });
        });

        function sum(amount, valueId, sumId) {
            $(valueId).val(money($(valueId).val()));
            $(sumId).text(money(amount * trimOver($(valueId).val(), null)));

            let sum = 0;

            $('.sum').each(function () {
                let numb = trimOver($(this).text(), null);
                if (parseInt(numb))
                    sum += parseInt(numb);
            });
            $('#totbil').val(money(sum));

            sumAmount();
        }

        $(document).on('input', '.amount, .fee', function () {
            $(this).val(money($(this).val()));

            sumAmount();
        });

        function sumAmount() {
            let sumAmt = 0;

            $('.amount, .fee').each(function () {
                let amount = trimOver($(this).val(), null);
                if (parseInt(amount)) {
                    sumAmt += parseInt(amount);
                }
            });

            $('#totrans').val(money(sumAmt));

            let dif = parseInt(trimOver($('#totbil').val(), null)) - sumAmt;
            let diff = $('#diff');

            if (dif < 0) {
                diff.attr('class', 'text-red');
            } else if (dif > 0) {
                diff.attr('class', 'text-green');
            } else {
                diff.attr('class', 'text-blue');
            }
            diff.text(money(dif));
        }

        $('#save').click(function () {
            if ((parseInt(trimOver($('#diff').text(), null)) === 0) && (parseInt(trimOver($('#totrans').val(), null)) === parseInt(trimOver($('#totbil').val(), null)))) {
                mySwal('@lang('sidebar.cout')', '@lang('confirm.cout_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#coutForm');
            } else {
                myOSwal('@lang('sidebar.cout')', '@lang('confirm.couterror_text')', 'error');
            }
        });

        {{--function getMemAccs(member, date = null) {--}}
        {{--    $('#simul-data-table').DataTable({--}}
        {{--        destroy: true,--}}
        {{--        paging: false,--}}
        {{--        info: false,--}}
        {{--        searching: false,--}}
        {{--        responsive: true,--}}
        {{--        ordering: false,--}}
        {{--        FixedHeader: true,--}}
        {{--        language: {--}}
        {{--            url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",--}}
        {{--        },--}}
        {{--        processing: true,--}}
        {{--        serverSide: false,--}}
        {{--        serverMethod: 'GET',--}}
        {{--        ajax: {--}}
        {{--            url: "{{url('getFilterMemAccs')}}",--}}
        {{--            data: {--}}
        {{--                member: member,--}}
        {{--                date: date,--}}
        {{--            },--}}
        {{--            datatype: 'json'--}}
        {{--        },--}}
        {{--        columns: [--}}
        {{--            {data: 'account', class: 'text-center'},--}}
        {{--            {data: 'description'},--}}
        {{--            {data: 'amount', class: 'text-bold text-right debit'},--}}
        {{--            {data: 'blocked', class: 'text-bold text-right debit'},--}}
        {{--            {data: 'available', class: 'text-bold text-right debit'}--}}
        {{--        ]--}}
        {{--    });--}}
        {{--}--}}
    </script>
@stop
