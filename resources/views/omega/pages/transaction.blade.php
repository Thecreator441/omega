<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.transaction'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.transaction') </h3>
        </div>
        <div class="box-body">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="date1" class="col-md-1 control-label">@lang('label.from')</label>
                            <div class="col-md-5">
                                <input type="date" name="date1" id="date1" class="form-control">
                            </div>
                            <label for="date2"
                                   class="col-md-1 control-label text-center">@lang('label.to')</label>
                            <div class="col-md-5">
                                <input type="date" name="date2" id="date2" class="form-control">
                            </div>
                        </div>
                    </div>
                    @if ($emp->collector === null && ((int)$emp->code !== 1 && (int)$emp->code !== 2))
                        <div class="col-md-5">
                            <div class="form-group">
                                @if ($emp->collector === null && ((int)$emp->code !== 1 && (int)$emp->code !== 2))
                                    <label for="user" class="col-md-3 control-label">@lang('label.user')</label>
                                    <div class="col-md-9">
                                        <select name="user" id="user" class="from-control select2">
                                            <option value=""></option>
                                            @foreach ($employees as $employee)
                                                <option value="{{$employee->iduser}}">{{$employee->username}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="user" id="user" value="{{$emp->iduser}}">
                                @endif
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="user" id="user" value="{{$emp->iduser}}">
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" id="search" class="btn btn-sm pull-right bg-green btn-raised fa fa-search"></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table id="admin-data-table" class="table display table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>@lang('label.refer')</th>
                            <th>@lang('label.account')</th>
                            <th>@lang('label.aux')</th>
                            <th>@lang('label.opera')</th>
                            <th>@lang('label.debt')</th>
                            <th>@lang('label.credt')</th>
                            <th>@lang('label.date')</th>
                            <th>@lang('label.opera') @lang('label.date')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($writings as $writing)
                            <tr>
                                <td class="text-center">{{formWriting($writing->accdate, $writing->network, $writing->zone, $writing->institution, $writing->branch, $writing->writnumb)}}</td>
                                <td class="text-center">
                                    @foreach ($accounts as $account)
                                        @if ($account->idaccount === $writing->account)
                                            {{$account->accnumb}}
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    @if ($writing->aux !== null)
                                        @foreach ($members as $member)
                                            @if ($member->idmember === $writing->aux)
                                                {{pad($member->memnumb, 6)}}
                                            @endif
                                        @endforeach
                                    @endif
                                    @if ($writing->collector !== null)
                                        @foreach($collectors as $collector)
                                            @if ($collector->idcoll === $writing->collector)
                                                {{pad($collector->code, 6)}}
                                            @endif
                                        @endforeach
                                    @endif
                                    @if ($writing->coll_aux !== null)
                                        @foreach ($coll_members as $coll_member)
                                            @if ($coll_member->idcollect_mem === $writing->coll_aux)
                                                {{pad($coll_member->coll_memnumb, 6)}}
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if (is_numeric($writing->operation))
                                        @foreach ($operas as $opera)
                                            @if ($opera->idoper == $writing->operation)
                                                @if($emp->lang == 'fr') {{$opera->labelfr}} @else {{$opera->labeleng}} @endif
                                            @endif
                                        @endforeach
                                    @else
                                        {{$writing->operation}}
                                    @endif
                                </td>
                                <td class="debit text-right text-bold">{{money((int)$writing->debitamt)}}</td>
                                <td class="credit text-right text-bold">{{money((int)$writing->creditamt)}}</td>
                                <td class="text-center">{{changeFormat($writing->accdate)}}</td>
                                <td class="text-center">{{getsDateTime($writing->created_at)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot id="tableInput" class="bg-antiquewhite">
                        <tr class="text-right text-blue text-bold">
                            <th colspan="4"></th>
                            <th id="debit" class="text-right">{{money((int)$debit)}}</th>
                            <th id="credit" class="text-right">{{money((int)$credit)}}</th>
                            <th class="text-black text-center">@lang('label.balance')</th>
                            <th id="tot_bal" class="text-center text-black">{{money((int)$debit - (int)$credit)}}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <input type="hidden" id="net">
                <input type="hidden" id="netTel">
                <input type="hidden" id="zon">
                <input type="hidden" id="zonTel">
                <input type="hidden" id="ins">
                <input type="hidden" id="insTel">
                <input type="hidden" id="bra">
                <input type="hidden" id="braTel">

                <div class="col-md-12">
                    <button type="button" id="print" class="btn btn-sm bg-default pull-right btn-raised fa fa-print">
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            let balance = parseInt(trimOver($('#tot_bal').text(), null));
            let tot_bal = $('#tot_balance');
            if (balance < 0 || balance > 0) {
                tot_bal.attr('class', 'text-red');
                tot_bal.text(money(balance));
            } else {
                tot_bal.attr('class', 'text-blue');
                tot_bal.text(money(balance));
            }

            $.ajax({
                url: "{{ url('getUserInfos') }}",
                method: 'get',
                data: {
                    id: '{{$emp->iduser}}'
                },
                success: function (user) {
                    fillHidden(user);
                }
            });
        });

        $('#search').click(function () {
            fillTempJournalByUser($('#user').val(), $('#date1').val(), $('#date2').val());
        });

        function fillTempJournalByUser(iduser = null, date1 = null, date2 = null) {
            $('#admin-data-table').DataTable({
                destroy: true,
                paging: true,
                info: true,
                searching: true,
                responsive: true,
                ordering: true,
                FixedHeader: true,
                processing: true,
                serverSide: false,
                language: {
                    url: "{{asset('plugins/datatables/lang/'.$emp->lang.'.json')}}"
                },
                serverMethod: 'GET',
                ajax: {
                    url: "{{url('getFilterTransactionsByColl')}}",
                    data: {
                        network: "{{$emp->network}}",
                        collector: iduser,
                        idcollect: iduser,
                        languange: "{{$emp->lang}}",
                        date1: date1,
                        date2: date2
                    },
                    datatype: 'json'
                },
                columns: [
                    {data: 'refs', class: 'text-center'},
                    {data: 'acc', class: 'text-center'},
                    {data: 'aux', class: 'text-center'},
                    {data: 'operation'},
                    {data: 'debit', class: 'text-bold text-right debit'},
                    {data: 'credit', class: 'text-bold text-right credit'},
                    {data: 'accdate', class: 'text-center'},
                    {data: 'datetime', class: 'text-center'}
                ]
            });
        }

        $('#print').click(function () {

        })
    </script>
@stop
