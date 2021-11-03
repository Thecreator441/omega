<?php 
$emp = Session::get('employee');

$cash_out = null;
if(Session::has('cash_out')) {
    $cash_out = asset(Session::get('cash_out'));
    // dd($cash_out);
}

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
            <form action="{{ url('cash_out/store') }}" method="post" id="coutForm" role="form" class="needs-validation" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <label for="member" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 control-label">@lang('label.member')<span class="text-red text-bold">*</span></label>
                                        <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10">
                                            <select class="form-control select2" name="member" id="member" required>
                                                <option value=""></option>
                                                @foreach($members as $member)
                                                    <option value="{{$member->idmember}}">{{pad($member->memnumb, 6)}} : {{ $member->name }} {{ $member->surname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="nic" class="col-xl-2 col-lg-3 col-md-4 col-sm-3 col-xs-4 control-label">@lang('label.idnumb')</label>
                                        <div class="col-xl-10 col-lg-9 col-md-8 col-sm-9 col-xs-8">
                                            <input type="text" class="form-control" name="nic" id="nic" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="benef" class="col-xl-1 col-lg-2 col-md-2 col-sm-3 col-xs-4 control-label">@lang('label.benef')</label>
                                        <div class="col-xl-11 col-lg-10 col-md-10 col-sm-9 col-xs-8">
                                            <input type="text" class="form-control" name="represent" id="represent">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="loan_info" class="col-xl-1 col-lg-2 col-md-2 col-sm-3 col-xs-4 control-label">@lang('label.loaninf')</label>
                                        <div class="col-xl-11 col-lg-10 col-md-10 col-sm-9 col-xs-8">
                                            <input type="text" class="form-control" name="loan_info" id="loan_info">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="row text-center">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <img id="pic" alt="@lang('label.mempic')" class="img-bordered-sm" style="height: 150px; width: 100%;"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <img id="sign" alt="@lang('label.memsign')" class="img-bordered-sm" style="height: 70px; width: 100%;"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="tableInput">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-xs-12">
                        <div class="table-responsive">
                            <table id="billet-data-table" class="table table-striped table-hover table-condensed table-bordered no-padding">
                                <thead class="text-bold">
                                <tr>
                                    <th colspan="3" class="bg-purples">@lang('label.notes')</th>
                                    <th class="bilSum"></th>
                                </tr>
                                </thead>
                                <tbody class="text-bold">
                                @foreach ($moneys as $money)
                                    @if ($money->format == 'B')
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
                                <tr>
                                    <th colspan="3" class="bg-purples">@lang('label.coins')</th>
                                    <th></th>
                                </tr>
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
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-7 col-xs-12">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table id="billet-data-table2" class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                                        <thead>
                                        <tr class="text-bold">
                                            <th>@lang('label.account')</th>
                                            <th>@lang('label.entitle')</th>
                                            <th>@lang('label.blocked')</th>
                                            <th>@lang('label.available')</th>
                                            <th>@lang('label.amount')</th>
                                            <th>@lang('label.fees')</th>
                                        </tr>
                                        </thead>
                                        <tbody id="mem_table">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-xs-12 ">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr class="text-bold text-blue bg-antiquewhite text-left">
                                            <td style="width: 25%">
                                                @if($emp->lang == 'fr') {{$cash->labelfr }} @else {{$cash->labeleng }} @endif
                                            </td>
                                            <td>{{$cash->casAcc_Numb }}</td>
                                            <td>@lang('label.totrans')</td>
                                            <td style="width: 15%">
                                                <input type="text" style="text-align: left" name="totrans" id="totrans" readonly></td>
                                            <td>@lang('label.diff')</td>
                                            <td id="diff" class="text-right" style="width: 15%"></td>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
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
        $(document).ready(function () {
            if ("{{$cash_out}}" !== '') {
                window.alert("{{$cash_out}}");
                //window.open("{{$cash_out}}");
                printJS("{{$cash_out}}");
            }
        });

        $('#member').change(function () {
            if (!isNaN($(this).val())) {
                $.ajax({
                    url: "{{ url('getMember') }}",
                    method: 'get',
                    data: {member: $(this).val()},
                    success: function (member) {
                        if (member.surname === null) {
                            $('#represent').val(member.name);
                        } else {
                            $('#represent').val(member.name + ' ' + member.surname);
                        }

                        $('#nic').val(member.nic);

                        if (member.pic !== null) {
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
                        }

                        if (member.signature) {
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
                        }

                        $('#billet-data-table2').DataTable({
                            destroy: true,
                            paging: false,
                            info: false,
                            responsive: true,
                            ordering: false,
                            searching: false,
                            FixedHeader: true,
                            processing: true,
                            serverSide: false,
                            language: {
                                url: "{{ asset("plugins/datatables/lang/$emp->lang.json") }}",
                            },
                            serverMethod: 'GET',
                            ajax: {
                                url: "{{ url('getMemCashOutBals') }}",
                                data: {
                                    member: member.idmember
                                },
                                datatype: 'json'
                            },
                            columns: [
                                {data: null, class: 'text-center',
                                    render: function (data, type, row) {
                                        return '<td><input type="hidden" name="accounts[]" value="' + data.account + '">' + data.accnumb + '</td>';
                                    }
                                },
                                {data: null, 
                                    render: function (data, type, row) {
                                        return '<td><input type="hidden" name="operations[]" value="' + data.operation + '">' +
                                            '@if ($emp->lang == "fr")' + data.acclabelfr + ' @else ' + data.acclabeleng + '@endif</td>';
                                    }
                                },
                                {data: null, class: 'text-right text-bold',
                                    render: function (data, type, row) {
                                        return money(parseInt(data.block_amt));
                                    }
                                },
                                {data: null, class: 'text-right text-bold',
                                    render: function (data, type, row) {
                                        return money(parseInt(data.available) + parseInt(data.block_amt));
                                    }
                                },
                                {data: null, 
                                    render: function (data, type, row) {
                                        return '<td><input type="text" name="amounts[]" class="amount"></td>';
                                    }
                                },
                                {data: null, 
                                    render: function (data, type, row) {
                                        return '<td><input type="text" name="fees[]" class="fee"></td>';
                                    }
                                }
                            ],
                        });
                    }
                });
            } else {
                $('#represent').val('');
            }
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

        function submitForm() {
            let cust = $('#member').val();
            let totbil = parseInt(trimOver($('#totbil').val(), null));
            let diff = parseInt(trimOver($('#diff').text(), null));

            if (diff === 0 && cust !== '' && !isNaN(totbil) && totbil !== 0) {
                mySwal("{{ $title }}", '@lang('confirm.cout_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#coutForm');
            } else {
                myOSwal("{{ $title }}", '@lang('confirm.couterror_text')', 'error');
            }
        }
    </script>
@stop
