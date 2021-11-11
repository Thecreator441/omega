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
            @if($emp->level === 'P')
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="network" class="col-md-3 control-label">@lang('label.network')</label>
                            <div class="col-md-9">
                                <select name="network" id="network" class="from-control select2">
                                    <option value=""></option>
                                    {{-- @foreach ($networks as $network)
                                        <option value="{{$network->idnetwork}}">{{$network->name}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="zone" class="col-md-3 control-label">@lang('label.zone')</label>
                            <div class="col-md-9">
                                <select name="zone" id="zone" class="from-control select2">
                                    <option value=""></option>
                                    {{-- @foreach ($zones as $zone)
                                        <option value="{{$zone->idzone}}">{{$zone->name}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="institution" class="col-md-3 control-label">@lang('label.institution')</label>
                            <div class="col-md-9">
                                <select name="institution" id="institution" class="from-control select2">
                                    <option value=""></option>
                                    {{-- @foreach ($institutions as $institution)
                                        <option value="{{$institution->idinst}}">{{$institution->abbr}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="branch" class="col-md-3 control-label">@lang('label.branch')</label>
                            <div class="col-md-9">
                                <select name="branch" id="branch" class="from-control select2">
                                    <option value=""></option>
                                    {{-- @foreach ($branchs as $branch)
                                        <option value="{{$branch->idbranch}}">{{$branch->name}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            @if($emp->level === 'N')
                <div class="row">
                    <input type="hidden" id="network" value="{{ $emp->network }}">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="zone" class="col-md-3 control-label">@lang('label.zone')</label>
                            <div class="col-md-9">
                                <select name="zone" id="zone" class="from-control select2">
                                    <option value=""></option>
                                    {{-- @foreach ($zones as $zone)
                                        <option value="{{$zone->idzone}}">{{$zone->name}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="institution" class="col-md-3 control-label">@lang('label.institution')</label>
                            <div class="col-md-9">
                                <select name="institution" id="institution" class="from-control select2">
                                    <option value=""></option>
                                    {{-- @foreach ($institutions as $institution)
                                        <option value="{{$institution->idinst}}">{{$institution->abbr}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="branch" class="col-md-3 control-label">@lang('label.branch')</label>
                            <div class="col-md-9">
                                <select name="branch" id="branch" class="from-control select2">
                                    <option value=""></option>
                                    {{-- @foreach ($branchs as $branch)
                                        <option value="{{$branch->idbranch}}">{{$branch->name}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($emp->level === 'Z')
                <div class="row">
                    <input type="hidden" id="network" value="{{ $emp->network }}">
                    <input type="hidden" id="zone" value="{{ $emp->zone }}">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="institution" class="col-md-3 control-label">@lang('label.institution')</label>
                            <div class="col-md-9">
                                <select name="institution" id="institution" class="from-control select2">
                                    <option value=""></option>
                                    {{-- @foreach ($institutions as $institution)
                                        <option value="{{$institution->idinst}}">{{$institution->abbr}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="branch" class="col-md-3 control-label">@lang('label.branch')</label>
                            <div class="col-md-9">
                                <select name="branch" id="branch" class="from-control select2">
                                    <option value=""></option>
                                    {{-- @foreach ($branchs as $branch)
                                        <option value="{{$branch->idbranch}}">{{$branch->name}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($emp->level === 'I')
                <div class="row">
                    <input type="hidden" id="network" value="{{ $emp->network }}">
                    <input type="hidden" id="zone" value="{{ $emp->zone }}">
                    <input type="hidden" id="institution" value="{{ $emp->institution }}">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="branch" class="col-md-3 control-label">@lang('label.branch')</label>
                            <div class="col-md-9">
                                <select name="branch" id="branch" class="from-control select2">
                                    <option value=""></option>
                                    {{-- @foreach ($employees as $employee)
                                        <option value="{{$employee->iduser}}">{{$employee->username}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            @if($emp->level === 'B')
                <div class="row">
                    <input type="hidden" id="network" value="{{ $emp->network }}">
                    <input type="hidden" id="zone" value="{{ $emp->zone }}">
                    <input type="hidden" id="institution" value="{{ $emp->institution }}">
                    <input type="hidden" id="branch" value="{{ $emp->branch }}">
                </div>
            @endif

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
                @endif
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="button" id="search" class="btn btn-sm pull-right bg-green btn-raised fa fa-search"></button>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
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
                                    <th>@lang('label.opera') @lang('label.date')</th>
                                    <th>@lang('label.time')</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{-- @foreach ($writings as $writing)
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
                                @endforeach --}}
                                </tbody>
                                <tfoot id="tableInput" class="bg-antiquewhite">
                                <tr class="text-right text-blue text-bold">
                                    <th colspan="4"></th>
                                    <th id="debit" class="text-right">0</th>
                                    <th id="credit" class="text-right">0</th>
                                    <th class="text-black text-center">@lang('label.balance')</th>
                                    <th colspan="2" id="tot_bal" class="text-center text-black">0</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button type="button" id="print" class="btn btn-sm bg-default pull-right btn-raised fa fa-print"></button>
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
            filterValidJournal($('#network').val(), $('#zone').val(), $('#institution').val(), $('#branch').val(), $('#user').val(), $('input[name="state"]:checked').val(), $('#date1').val(), $('#date2').val());
        });

        function filterValidJournal(network = null, zone = null, institution = null, branch = null, user = null, state = null, date1 = null, date2 = null) {
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
                    url: "{{url('getValidJournals')}}",
                    data: {
                        network: network,
                        zone: zone,
                        institution: institution,
                        branch: branch,
                        user: user,
                        state: state,
                        from: date1,
                        to: date2,
                        lang: "{{ $emp->lang }}"
                    },
                    datatype: 'json'
                },
                columns: [
                    {data: 'refs', class: 'text-center'},
                    {data: 'account', class: 'text-center'},
                    {data: 'aux'},
                    {data: 'operation'},
                    {data: 'debit', class: 'text-bold text-right debit'},
                    {data: 'credit', class: 'text-bold text-right credit'},
                    {data: 'accdate', class: 'text-center'},
                    {data: 'aperdate', class: 'text-center'},
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
            $.ajax({
                url: "{{ url('transaction/print') }}",
                method: 'GET',
                data: {
                    level: 4,
                    menu: "{{ $menu->idmenus_4 }}",
                    operation: "{{ $title }}",
                    network: $('#network').val(),
                    zone: $('#zone').val(),
                    institution: $('#institution').val(),
                    branch: $('#branch').val(),
                    user: $('#user').val(),
                    state: $('input[name="state"]:checked').val(),
                    from: $('#date1').val(),
                    to: $('#date2').val(),
                    lang: "{{ $emp->lang }}"
                },
                success: function (file) {
                    console.log(file);
                }
            });
        });

        /**
         * Get the zones based on the network
         */
        $('#network').change(function () {
            $.ajax({
                url: "{{ url('getZones') }}",
                method: 'get',
                data: {
                    network: $('#network').val()
                },
                success: function (zones) {
                    let option = "<option value=''></option>";
                    $.each(zones, function (i, zone) {
                        option += "<option " +
                            "value=" + zone.idzone + ">" + zone.name + "</option>";
                    });
                    $('#zone').html(option);
                }
            });
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
                    let option = "<option value=''></option>";
                    $.each(institutions, function (i, institution) {
                        option += "<option " +
                            "value=" + institution.idinst + ">" + institution.abbr + "</option>";
                    });
                    $('#institution').html(option);
                }
            });
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
        });        
    </script>
@stop
