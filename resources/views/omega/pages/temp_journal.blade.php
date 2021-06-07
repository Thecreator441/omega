<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.tempjour'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.tempjour') </h3>
        </div>
        <div class="box-body">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-md-6">
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
                </div>

                <div class="row">
                    <div class="col-md-1 col-sm-1"></div>
                    <div class="col-md-2 col-sm-2 col-xs-6">
                        <div class="form-group">
                            <div class="radio">
                                <label for="general" class="text-blue">
                                    <input type="radio" name="state" class="writ_type" id="general" value="" checked>&nbsp;@lang('label.gen')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="form-group">
                            <div class="radio">
                                <label for="cin" class="text-green">
                                    <input type="radio" name="state" class="writ_type" id="cin" value="I">&nbsp;@lang('sidebar.cin')</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="form-group">
                            <div class="radio">
                                <label for="cout" class="text-yellow">
                                    <input type="radio" name="state" class="writ_type" id="cout" value="O">&nbsp;@lang('sidebar.cout')</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="form-group">
                            <div class="radio">
                                <label for="forced" class="text-red">
                                    <input type="radio" name="state" class="writ_type" id="forced" value="F"> @lang('label.foroper')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-1"></div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" id="search" class="btn btn-sm bg-green pull-right btn-raised fa fa-search"></button>
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
                            <th>@lang('label.time')</th>
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
                                <td class="text-center">{{getsTime($writing->created_at)}}</td>
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
            fillTempJournalByUser($('input[name="state"]:checked').val(), $('#user').val());
        });

        function fillTempJournalByUser(state = null, iduser = null) {
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
                    url: "{{url('getJournals')}}",
                    data: {
                        state: state,
                        user: iduser
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
                    {data: 'time', class: 'text-center'}
                ],
                footerCallback: function (row, data, start, end, display) {
                    let response = this.api().ajax.json();
                    if (response) {
                        let $th = $('tfoot').find('th');

                        $th.eq(1).html(response['sumDebit']);
                        $th.eq(2).html(response['sumCredit']);
                        $th.eq(4).html(response['sumBal']);
                    }
                },
            });
        }

        $('#print').click(function () {
            const print = new jsPDF();

            let stateVal = $('input[name="state"]:checked').val();
            let text;
            let tel;
            let username;
            let date = userDate(new Date());
            let head = "@lang('sidebar.tempjour')";
            head = head.toUpperCase();
            if (stateVal === 'I') {
                head += " ( @lang('sidebar.cin') )";
            } else if (stateVal === 'O') {
                head += " ( @lang('sidebar.cout') )";
            } else if (stateVal === 'F') {
                head += " ( @lang('label.foroper') )";
            } else {
                head += " ( @lang('label.gen') )";
            }

                @if($emp->collector === null && ((int)$emp->code !== 1 && (int)$emp->code !== 2))
            let user = $('#user').select2('data');
            username = user[0].text;
            @else
                username = "{{$emp->name}} {{$emp->surname}}";
            @endif

            print.setProperties({
                title: head
            });

            print.setFontSize(10);
            print.text($('#net').val(), 100, 15, 'center');
            print.setFontSize(8);

            if ('{{$emp->level}}' === 'N') {
                tel = $('#netTel').val();
            } else if ('{{$emp->level}}' === 'Z') {
                text = $('#zon').val();
                tel = $('#zonTel').val();
            } else if ('{{$emp->level}}' === 'I') {
                text = $('#ins').val();
                tel = $('#insTel').val();
            } else if ('{{$emp->level}}' === 'B') {
                text = $('#bra').val();
                tel = $('#braTel').val();
            }
            print.text(text, 100, 20, 'center');
            print.text("Tel: " + tel, 100, 25, 'center');

            print.setFontSize(10);
            print.text(head, 100, 35, 'center');

            print.setFontSize(9);
            print.text("@lang('label.date'): " + date, 15, 45, 'justify');
            print.text("@lang('label.user'): " + username, 125, 45, 'justify');

            let thead = [["@lang('label.refer')", "@lang('label.account')", "@lang('label.aux')", "@lang('label.opera')",
                "@lang('label.debt')", "@lang('label.credt')", "@lang('label.date')"]];

            $.ajax({
                url: "{{url('getJournals')}}",
                method: 'get',
                data: {
                    state: $('input[name="state"]:checked').val(),
                    user: $('#user').val()
                },
                success: function (statements) {
                    let tbody = [];

                    $.each(statements.data, function (i, statement) {
                        tbody.push([statement.refs, statement.acc, statement.aux, statement.operation,
                            statement.debit, statement.credit, statement.accdate]);
                    });

                    tbody.push(['', '', '', '', statements.sumDebit, statements.sumCredit, statements.sumBal]);

                    print.autoTable({
                        head: thead,
                        body: tbody,
                        styles: {
                            lineColor: '#f7f7f7',
                            lineWidth: 0.1,
                        },
                        headStyles: {
                            halign: 'center',
                        },
                        columnStyles: {
                            0: {
                                halign: 'center',
                            },
                            1: {
                                halign: 'center',
                            },
                            2: {
                                halign: 'center',
                            },
                            4: {
                                halign: 'right',
                            },
                            5: {
                                halign: 'right',
                            },
                            6: {
                                halign: 'center',
                            },
                            7: {
                                halign: 'center',
                            }
                        },
                        startY: 50,
                        showHead: 'firstPage'
                    });

                    print.setTextColor(100);

                    print.output('dataurlnewwindow');
                }
            });

        });
    </script>
@stop
