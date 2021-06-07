<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.mem_sit'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.mem_sit') </h3>
        </div>
        <div class="box-body">
            <div class="row">
                @if ($emp->level === 'N')
                    <?php $zones = Zone::getZones(['network' => $emp->network]); ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="zone" class="col-md-4 control-label">@lang('label.zone')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="network" name="zone">
                                    <option value=""></option>
                                    @foreach($zones as $zone)
                                        <option value="{{$zone->idzone}}">{{$zone->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php $zinstitutes = Institution::getInstitutions(['zone' => $emp->zone]); ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="institution" class="col-md-4 control-label">@lang('label.institution')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="institution" name="institution">
                                    <option value=""></option>
                                    @foreach($zinstitutes as $zinstitute)
                                        <option value="{{$zinstitute->idinst}}">{{$zinstitute->abbr}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php $zbranchs = Branch::getBranches(['zone' => $emp->zone]); ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="branch" class="col-md-4 control-label">@lang('label.branch')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="branch" name="branch">
                                    <option value=""></option>
                                    @foreach($zbranchs as $zbranch)
                                        <option
                                            value="{{$zbranch->idbranch}}">{{$zbranch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @if ($emp->employee !== null)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="collector" class="col-md-4 control-label">@lang('label.collector')</label>
                                <div class="col-md-8">
                                    <select name="collector" id="collector" class="from-control select2">
                                        <option value=""></option>
                                        @foreach ($collectors as $collector)
                                            <option value="{{$collector->idcoll}}">{{pad($collector->code, 3)}} : {{$collector->name}} {{$collector->surname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if ($emp->level === 'Z')
                    <?php $institutes = Institution::getInstitutions(['zone' => $emp->zone]); ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="institution" class="col-md-4 control-label">@lang('label.institution')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="institution" name="institution">
                                    <option value=""></option>
                                    @foreach($institutes as $institute)
                                        <option value="{{$institute->idinst}}">{{$institute->abbr}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php $zbranchs = Branch::getBranches(['zone' => $emp->zone]); ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="branch" class="col-md-4 control-label">@lang('label.branch')</label>
                            <div class="col-md-8">
                                <select class="form-control select2" id="branch" name="branch">
                                    <option value=""></option>
                                    @foreach($zbranchs as $zbranch)
                                        <option
                                            value="{{$zbranch->idbranch}}">{{$zbranch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @if ($emp->employee !== null)
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="collector" class="col-md-4 control-label">@lang('label.collector')</label>
                                <div class="col-md-8">
                                    <select name="collector" id="collector" class="from-control select2">
                                        <option value=""></option>
                                        @foreach ($collectors as $collector)
                                            <option value="{{$collector->idcoll}}">{{pad($collector->code, 3)}} : {{$collector->name}} {{$collector->surname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if ($emp->level === 'I')
                    <?php $branchs = Branch::getBranches(['institution' => $emp->institution]); ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="branch" class="col-md-2 control-label">@lang('label.branch')</label>
                            <div class="col-md-10">
                                <select class="form-control select2" id="branch" name="branch">
                                    <option value=""></option>
                                    @foreach($branchs as $branch)
                                        <option
                                            value="{{$branch->idbranch}}">{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="date" class="col-md-3 col-sm-3 col-xs-2 control-label">@lang('label.date')</label>
                        <div class="col-md-9 col-sm-9 col-xs-10">
                            <input type="date" id="date" name="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-8 col-xs-12">
                    <div class="form-group">
                        <label for="member" class="col-md-1 col-xs-2 control-label">@lang('label.member')</label>
                        <div class="col-md-3 col-xs-3">
                            <select class="form-control select2" name="member" id="member">
                                <option></option>
                                @foreach($members as $member)
                                    <option
                                        value="{{$member->idmember}}">{{pad($member->memnumb, 6)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-7 col-xs-7">
                            <input type="text" name="mem_name" id="mem_name" class="form-control" disabled>
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-12">
                            <button type="button" id="search" class="btn btn-sm bg-green pull-right btn-raised fa fa-search"></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-5 bg-maroon-gradient"></div>
                            <div class="col-md-2 text-center text-blue text-bold">@lang('label.memaccs')</div>
                            <div class="col-md-5 bg-maroon-gradient"></div>
                        </div>
                    </div>

                    <table id="simul-data-table"
                           class="table table-striped table-hover table-bordered table-condensed table-responsive">
                        <thead>
                        <tr>
                            <th>@lang('label.account')</th>
                            <th>@lang('label.desc')</th>
                            <th>@lang('label.amount')</th>
                            <th>@lang('label.blocked')</th>
                            <th>@lang('label.available')</th>
                        </tr>
                        </thead>
                        <tbody id="memacc">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4 bg-maroon-gradient"></div>
                            <div class="col-md-4 text-center text-blue text-bold">@lang('label.memloanacc')</div>
                            <div class="col-md-4 bg-maroon-gradient"></div>
                        </div>
                    </div>

                    <table id="simul-data-table2"
                           class="table table-striped table-hover table-bordered table-condensed table-responsive">
                        <thead>
                        <tr>
                            <th style="width: 6%">@lang('label.loanno')</th>
                            <th style="width: 9%">@lang('label.account')</th>
                            <th class="cout">@lang('label.loanamt')</th>
                            <th class="cout">@lang('label.capital')</th>
                            <th style="width: 5%">@lang('label.late')</th>
                            <th class="cout">@lang('label.interest')</th>
                            <th class="cout">@lang('label.finint')</th>
                            <th class="cout">@lang('label.accint')</th>
                            <th class="cout">@lang('label.totint')</th>
                        </tr>
                        </thead>
                        <tbody id="loanacc">
                        </tbody>
                    </table>
                </div>
            </div>

            <input type="hidden" id="cusTel">

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
            $('#date').val(sysDate(new Date()));
        });

        $('#member').change(function () {
            $.ajax({
                url: "{{ url('getMember') }}",
                method: 'get',
                data: {
                    member: $(this).val()
                },
                success: function (member) {
                    if (member.surname === null) {
                        $('#mem_name').val(member.name);
                    } else {
                        $('#mem_name').val(member.name + ' ' + member.surname);
                    }

                    $('#cusTel').val(member.phone1)

                    getMemAccs(member.idmember, $('#date').val());

                    getMemLoans(member.idmember, $('#date').val());

                    fillHidden(member);
                }
            });
        });

        $('#search').click(function () {
            if (!isNaN($('#member').val())) {
                getMemAccs($('#member').val(), $('#date').val());

                getMemLoans($('#member').val(), $('#date').val());
            }
        })

        function getMemAccs(member, date = null) {
            $('#simul-data-table').DataTable({
                destroy: true,
                paging: false,
                info: false,
                searching: false,
                responsive: true,
                ordering: false,
                FixedHeader: true,
                language: {
                    url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
                },
                processing: true,
                serverSide: false,
                serverMethod: 'GET',
                ajax: {
                    url: "{{url('getFilterMemAccs')}}",
                    data: {
                        member: member,
                        date: date,
                    },
                    datatype: 'json'
                },
                columns: [
                    {data: 'account', class: 'text-center'},
                    {data: 'description'},
                    {data: 'amount', class: 'text-bold text-right debit'},
                    {data: 'blocked', class: 'text-bold text-right debit'},
                    {data: 'available', class: 'text-bold text-right debit'}
                ]
            });
        }

        function getMemLoans(member, date = null) {
            $('#simul-data-table2').DataTable({
                destroy: true,
                paging: false,
                info: false,
                searching: false,
                responsive: true,
                ordering: false,
                FixedHeader: true,
                language: {
                    url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
                },
                processing: true,
                serverSide: false,
                serverMethod: 'GET',
                ajax: {
                    url: "{{url('getFilterMemLoans')}}",
                    data: {
                        member: member,
                        date: date,
                    },
                    datatype: 'json'
                },
                columns: [
                    {data: 'loan_no', class: 'text-center'},
                    {data: 'account', class: 'text-center'},
                    {data: 'loan_amt', class: 'text-bold text-right debit'},
                    {data: 'capital', class: 'text-bold text-right debit'},
                    {data: 'delay', class: 'text-center'},
                    {data: 'interest', class: 'text-bold text-right debit'},
                    {data: 'fine_int', class: 'text-bold text-right debit'},
                    {data: 'accr_int', class: 'text-bold text-right debit'},
                    {data: 'total_int', class: 'text-bold text-right debit'}
                ]
            });
        }

        $('#print').click(function () {
            if (!isNaN($('#member').val())) {
                const print = new jsPDF();

                let text;
                let tel;
                let head = "@lang('sidebar.mem_sit')";
                head = head.toUpperCase();
                let date = userDate(new Date());
                let cust = $('#member').select2('data');

                print.setProperties({
                    title: $('#mem_name').val() + " Situation"
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
                print.text("@lang('label.custcode'): " + cust[0].text, 15, 45, 'justify');
                print.text("@lang('label.date'): " + date, 15, 50, 'justify');

                print.text($('#mem_name').val(), 125, 45, 'justify')
                print.text("Tel: " + $('#cusTel').val(), 125, 50, 'justify');

                {{--let thead = [["@lang('label.account')", "@lang('label.desc')", "@lang('label.amount')", "@lang('label.blocked')", --}}
                {{--    "@lang('label.available')"]];--}}
                let thead = [["@lang('label.account')", "@lang('label.desc')", "@lang('label.available')"]];

                {{--let thead2 = [["@lang('label.loanno')", "@lang('label.account')", "@lang('label.loanamt')", "@lang('label.capital')",--}}
                {{--    "@lang('label.late')", "@lang('label.interest')", "@lang('label.finint')", "@lang('label.accint')", --}}
                {{--    "@lang('label.totint')"]];--}}
                let thead2 = [["@lang('label.account')", "@lang('label.loanty')", "@lang('label.noinst')",
                    "@lang('label.date')", "@lang('label.last_date')", "@lang('label.loanamt')", "@lang('label.loan_bal')",
                    "@lang('label.interest')"]];

                $.ajax({
                    url: "{{url('getMemSituation')}}",
                    method: 'get',
                    data: {
                        member: $('#member').val(),
                        date: $('#date').val()
                    },
                    success: function (statements) {
                        // console.log(statements);

                        let tbody = [];

                        $.each(statements.balances.data, function (i, statement) {
                            tbody.push([statement.account, statement.description, statement.available]);
                        });

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
                                2: {
                                    halign: 'right',
                                },
                                3: {
                                    halign: 'right',
                                },
                                4: {
                                    halign: 'right',
                                }
                            },
                            startY: 55,
                            showHead: 'firstPage'
                        });

                        print.setFontSize(9);
                        print.text("@lang('label.memloanacc')", 15, 110, 'justify');

                        let tbody2 = [];

                        $.each(statements.loans.data, function (i, statement) {
                            tbody2.push([statement.accnumb, statement.loan_type, statement.install_no,
                                statement.date, statement.last_date, statement.loan_amt, statement.capital, statement.total_int]);
                        });

                        print.autoTable({
                            head: thead2,
                            body: tbody2,
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
                                2: {
                                    halign: 'center',
                                },
                                3: {
                                    halign: 'center',
                                },
                                4: {
                                    halign: 'center',
                                },
                                5: {
                                    halign: 'right',
                                },
                                6: {
                                    halign: 'right',
                                },
                                7: {
                                    halign: 'right',
                                }
                            },
                            startY: 115,
                            showHead: 'firstPage'
                        });

                        print.setTextColor(100);

                        print.output('dataurlnewwindow');
                    }
                });


            } else {
                $('#member').focusin();
            }
        });

        /**
         * Get the institution based on the zone
         */
        $('#zone').change(function () {
            $.ajax({
                url: "{{ url('getInstitutions') }}",
                method: 'get',
                data: {
                    zone: $('#zone').val()
                },
                success: function (institutions) {
                    let option = '<option value=""></option>';
                    $.each(institutions, function (i, institution) {
                        option += "<option value='" + institution.idinst + "'>" + institution.abbr + " : " + institution.name + "</option>";
                    });
                    $('#institution').html(option);
                }
            });
            emptyFields();
        });

        /**
         * Get the institution based on the zone
         */
        $('#institution').change(function () {
            $.ajax({
                url: "{{ url('getBranches') }}",
                method: 'get',
                data: {
                    institution: $('#institution').val()
                },
                success: function (branchs) {
                    let option = "<option value=''></option>";
                    $.each(branchs, function (i, branch) {
                        option += "<option " +
                            "value=" + branch.idbranch + ">" + branch.name + "</option>";
                    });
                    $('#branch').html(option);
                }
            });
            emptyFields();
        });

        /**
         * Get the institution based on the zone
         */
        $('#branch').change(function () {
            $.ajax({
                url: "{{ url('getCollectorsCash') }}",
                method: 'get',
                data: {
                    branch: $('#branch').val()
                },
                success: function (collectors) {
                    let option = '<option value=""></option>';
                    $.each(collectors, function (i, collector) {
                        let surname = '';
                        if (collector.surname !== null) {
                            surname = collector.surname;
                        }
                        option += "<option value='" + collector.idcoll + "'>" + pad(collector.code, 3) + " : " + collector.name + " " + surname + "</option>";
                    });
                    $('#collector').html(option);
                },
                error: function (errors) {
                    console.log(errors);
                }
            });
            emptyFields();
        });

        function emptyFields() {
            $('#represent').val();
            $('#members').val().select2();
            $('#date').val(sysDate(new Date()));
        }
    </script>
@stop
