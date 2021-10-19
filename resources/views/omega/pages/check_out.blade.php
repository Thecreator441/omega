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
            <form action="{{ url('check_out/store') }}" method="post" role="form" id="cheoutForm" class="needs-validation">
                {{ csrf_field() }}

                <div class="row">
                    <div class="row">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-12">
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
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-12">
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
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-group">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" class="form-control text-right text-bold" name="bank_bal" id="bank_bal" placeholder="@lang('label.balance')" required disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="checkno" class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-2 control-label">@lang('label.checkno')<span class="text-red text-bold">*</span></label>
                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-10">
                                    <input type="text" class="form-control" name="checkno" id="checkno" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label for="checkamt" class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-2 control-label">@lang('label.amount')</label>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-xs-10">
                                    <input type="text" class="form-control text-right text-bold" name="checkamt" id="checkamt" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <div class="form-group">
                                <label for="represent" class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">@lang('label.carrier')</label>
                                <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <input type="text" class="form-control" name="represent" id="represent">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                </div>

                <div class="row" id="tableInput">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table id="billet-data-table" class="table table-striped table-hover table-condensed table-bordered no-padding">
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
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row" id="tableInput3">
                    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-xs-12 ">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr class="text-bold text-blue bg-antiquewhite text-right">
                                    <td>@lang('label.totrans')</td>
                                    <td><input type="text" style="text-align: left" name="totrans" id="totrans" readonly></td>
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
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
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

                        $('#billet-data-table').DataTable({
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

        $('#bank').change(function () {
            if (!isNaN($(this).val())) {
                $.ajax({
                    url: "{{ url('getBank') }}",
                    method: 'get',
                    data: {
                        id: $(this).val()
                    },
                    success: function (bank) {
                        $.ajax({
                            url: "{{ url('getAccBalance') }}",
                            method: 'get',
                            data: {
                                account: bank.theiracc
                            },
                            success: function (bankBal) {
                                $("#bank_bal").val(money(parseInt(bankBal)));
                            }
                        });
                    }
                });
            }
        });

        $(document).on('input', '#checkamt', function () {
            $('#checkamt').val(money($('#checkamt').val()));
            let bank_bal = parseInt(trimOver($('#bank_bal').val(), null));

            if(bank_bal < parseInt(trimOver($('#checkamt').val(), null))) {
                $('#checkamt').val(money($('#checkamt').val().slice(0, $('#checkamt').val().length -1)));
                window.alert("Sorry you can't withdraw more what you have");
            }
        });

        $(document).on('input', '#checkamt, .amount, .fee', function () {
            $(this).val(money($(this).val()));

            let sumAmt = 0;

            $('.amount, .fee').each(function () {
                let amount = trimOver($(this).val(), null);
                if (parseInt(amount)) {
                    sumAmt += parseInt(amount);
                }
            });
            
            $('#totrans').val(money(sumAmt));

            let dif = parseInt(trimOver($('#checkamt').val(), null)) - sumAmt;
            let diff = $('#diff');

            if (dif < 0) {
                diff.attr('class', 'text-red');
                diff.text(money(dif));
            } else if (diff > 0) {
                diff.attr('class', 'text-green');
                diff.text(money(dif));
            } else {
                diff.attr('class', 'text-blue');
                diff.text(money(dif));
            }
        });

        function submitForm() {
            let tot = parseInt(trimOver($('#totrans').val(), null));
            let amt = parseInt(trimOver($('#checkamt').val(), null));
            let dif = parseInt(trimOver($('#diff').text(), null));

            if ((tot === amt) && (dif === 0)) {
                mySwal("{{ $title }}", '@lang('confirm.check_out_text')', '@lang('confirm.no')', '@lang('confirm.yes')', '#cheoutForm');
            } else {
                myOSwal("{{ $title }}", '@lang('confirm.check_out_error_text')', 'error');
            }
        }
    </script>
@stop
