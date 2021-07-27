<?php
$emp = Session::get('employee');

$title = $menu->labeleng;
if ($emp->lang == 'fr') {
    $title = $menu->labelfr;
    App::setLocale('fr');
};
?>
@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> {{ $title }} </h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="row">
                    <div class="col-xl-2 col-lg-2"></div>
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <div class="radio">
                                <label for="general" class="text-blue">
                                    <input type="radio" name="state" class="writ_type" id="general" value="" checked>&nbsp;@lang('label.gen')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <div class="radio">
                                <label for="cin" class="text-green">
                                    <input type="radio" name="state" class="writ_type" id="cin" value="I">&nbsp;@lang('sidebar.cin')</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <div class="radio">
                                <label for="cout" class="text-yellow">
                                    <input type="radio" name="state" class="writ_type" id="cout" value="O">&nbsp;@lang('sidebar.cout')</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <div class="radio">
                                <label for="forced" class="text-red">
                                    <input type="radio" name="state" class="writ_type" id="forced" value="F"> @lang('label.foroper')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2"></div>
                </div>

                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-10 col-xs-12">
                        <div class="form-group">
                            <label for="user" class="col-xl-2 col-lg-2 col-md-2 col-sm-2 control-label">@lang('label.user')</label>
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10">
                                <select name="user" id="user" class="from-control select2">
                                    <option value=""></option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->employee }}">{{ $employee->name }} {{ $employee->surname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-4 col-sm-2 col-xs-12">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="button" id="search" class="btn btn-sm bg-green pull-right btn-raised fa fa-search"></button>
                            </div>
                        </div>
                    </div>
                </div>
    
                <hr>
            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
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
                                        {{ $writing->accnumb }}
                                        @if($writing->code !== null)
                                            - {{ $writing->code }}
                                        @endif
                                    </td>
                                    <td class="text-center">{{ explode(' ', $writing->name)[0] }} {{ explode(' ', $writing->surname)[0] }} </td>
                                    <td>{{ $writing->operation }}</td>
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
            </div>

            <input type="hidden" id="net">
            <input type="hidden" id="netTel">
            <input type="hidden" id="zon">
            <input type="hidden" id="zonTel">
            <input type="hidden" id="ins">
            <input type="hidden" id="insTel">
            <input type="hidden" id="bra">
            <input type="hidden" id="braTel">

            {{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button type="button" id="print" class="btn btn-sm bg-default pull-right btn-raised fa fa-print"></button>
            </div> --}}
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
