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
            <h3 class="box-title text-bold"> {{$title}}</h3>
        </div>
        <div class="box-body">
            @if ($cashes->count() != 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            {{ $cashes->links('layouts.includes.pagination') }}
                        </div>
                    </div>
                </div>
            @endif
            <form action="{{ url('cash/store') }}" method="post" role="form" id="cashForm" class="needs-validation">
                {{csrf_field()}}
                @if ($cashes->count() === 0)
                    <div class="box-header" id="form">
                        <input type="hidden" id="idcash" name="idcash" value="">

                        <div class="row">
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="cashcode" class="col-md-6 control-label">@lang('label.cash')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="cashcode" id="cashcode" value="PC" placeholder="@lang('label.code')" readonly required>
                                        <span class="help-block">@lang('placeholder.code')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="col-md-12">
                                    <div class="form-group has-error">
                                        <input type="text" class="form-control" name="casheng" id="casheng" value="MAIN TILL" placeholder="@lang('label.labeleng')" readonly required>
                                        <span class="help-block">@lang('placeholder.nameeng')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="col-md-12">
                                    <div class="form-group has-error">
                                        <input type="text" class="form-control" name="cashfr" id="cashfr" value="CAISSE PRINCIPALE" placeholder="@lang('label.labelfr')" readonly required>
                                        <span class="help-block">@lang('placeholder.namefr')</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="cashacc" class="col-md-3 control-label">@lang('label.account')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-control select2" name="cashacc" id="cashacc" required>
                                            <option value=""></option>
                                            @foreach($accounts as $account)
                                                @if (substrWords($account->accnumb, 2) === '57')
                                                    <option value="{{$account->idaccount}}">{{ pad($account->plan_code, 9, 'right') }} : @if($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <span class="help-block">@lang('placeholder.accnumb')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group has-error">
                                    <div class="col-md-12">
                                        <input type="hidden" name="employee" value="{{$emp->iduser}}">
                                        <select class="form-control select2" disabled required>
                                            <option
                                                value="{{$emp->iduser}}">{{$emp->name}} {{$emp->surname}}</option>
                                        </select>
                                        <span class="help-block">@lang('placeholder.employee')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" id="tableInput">
                        <table id="billet-data-table"
                               class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                            <caption class="text-blue">@lang('label.break')</caption>
                            <thead>
                            <tr class="text-blue">
                                <th>@lang('label.value')</th>
                                <th>@lang('label.label')</th>
                                <th>@lang('label.in')</th>
                                <th>@lang('label.amount')</th>
                                <th>@lang('label.letters')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($moneys as $money)
                                @if ($money->format == 'B')
                                    <tr>
                                        <td id="bil">{{money($money->value)}}</td>
                                        <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                        <td class="input">
                                            <input type="text" class="tot" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                   oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                        </td>
                                        <td class="sum text-right" id="{{$money->moncode}}Sum"></td>
                                        <td class="text-light-blue word"></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                            <thead>
                            <tr>
                                <th colspan="5" class="bg-gray"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($moneys as $money)
                                @if ($money->format == 'C')
                                    <tr>
                                        <td id="bil">{{money($money->value)}}</td>
                                        <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                        <td class="input">
                                            <input type="text" class="tot" name="{{$money->moncode}}" id="{{$money->moncode}}"
                                                   oninput="sum('{{$money->value}}', '#{{$money->moncode}}', '#{{$money->moncode}}Sum')">
                                        </td>
                                        <td class="sum text-right" id="{{$money->moncode}}Sum"></td>
                                        <td class="text-light-blue word"></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr class="bg-green-active">
                                <td colspan="3"
                                    style="text-align: center !important;">@lang('label.tobreak')</td>
                                <td class="text-right text-bold" id="totbil"></td>
                                <td class="text-left text-bold" id="totopera"></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="col-md-12">
{{--                        <button type="button" id="delete" class="btn btn-sm bg-red pull-right btn-raised fa fa-trash" disabled></button>--}}
{{--                        <button type="submit" id="update" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle" disabled></button>--}}
                        <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                    </div>
                @else
                    @foreach ($cashes as $cash)
                        <div class="box-header" id="form">
                            <input type="hidden" id="idcash" name="idcash" value="{{$cash->idcash}}">

                            <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group has-error">
                                        <label for="cashcode" class="col-md-6 control-label">@lang('label.cash')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="cashcode" id="cashcode" value="{{$cash->cashcode}}" placeholder="@lang('label.code')" readonly required>
                                            <span class="help-block">@lang('placeholder.code')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="col-md-12">
                                        <div class="form-group has-error">
                                            <input type="text" class="form-control" name="casheng" id="casheng" value="{{$cash->labeleng}}" placeholder="@lang('label.labeleng')" readonly required>
                                            <span class="help-block">@lang('placeholder.nameeng')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="col-md-12">
                                        <div class="form-group has-error">
                                            <input type="text" class="form-control" name="cashfr" id="cashfr" value="{{$cash->labelfr}}" placeholder="@lang('label.labelfr')" readonly required>
                                            <span class="help-block">@lang('placeholder.namefr')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 col-xs-12">
                                    <div class="form-group">
                                        <label for="cashacc has-error"
                                               class="col-md-3 control-label">@lang('label.idplan')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-9">
                                            <select class="form-control select2" name="cashacc" id="cashacc" disabled required>
                                                <option value=""></option>
                                                @foreach($accounts as $account)
                                                  @if ((int)$account->class === 5)
                                                    @if ($cash->cashacc == $account->idaccount)
                                                        <option value="{{$account->idaccount}}" selected>{{ $account->accnumb }} : @if($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif</option>
                                                    @else
                                                        <option value="{{$account->idaccount}}">{{ $account->accnumb }} : @if($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif</option>
                                                    @endif
                                                  @endif
                                                @endforeach
                                            </select>
                                            <span class="help-block">@lang('placeholder.accnumb')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="col-md-12">
                                        <div class="form-group has-error">
                                            <select name="employee" id="employee" class="form-control select2" disabled required>
                                              <option value="">@lang('placeholder.emp&col')</option>
                                                @foreach($employees as $employee)
                                                    @if ($cash->employee === $employee->iduser)
                                                        <option value="{{$employee->iduser}}" selected>{{$employee->name}} {{$employee->surname}}</option>
                                                    @else
                                                        <option value="{{$employee->iduser}}">{{$employee->name}} {{$employee->surname}}
{{--                                                            @if ($employee->collector === null) @lang('label.employee') @else @lang('label.collector') @endif--}}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <span class="help-block">@lang('placeholder.employee')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group has-error">
                                        <label for="misacc" class="col-md-4 control-label">@lang('label.misacc')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" name="misacc" id="misacc" disabled required>
                                                <option value=""></option>
                                                @foreach($accounts as $account)
                                                  @if ((int)$account->class === 4)
                                                    @if ($cash->misacc == $account->idaccount)
                                                      <option value="{{$account->idaccount}}" selected>{{ $account->accnumb }} : @if($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif</option>
                                                    @else
                                                      <option value="{{$account->idaccount}}">{{ $account->accnumb }} : @if($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif</option>
                                                    @endif
                                                  @endif
                                                @endforeach
                                            </select>
                                            <span class="help-block">@lang('placeholder.misacc')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group has-error">
                                        <label for="excacc" class="col-md-4 control-label">@lang('label.excacc')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" name="excacc" id="excacc" disabled required>
                                                <option value=""></option>
                                                @foreach($accounts as $account)
                                                  @if ((int)$account->class === 4)
                                                    @if ($cash->excacc == $account->idaccount)
                                                      <option value="{{$account->idaccount}}" selected>{{ $account->accnumb }} : @if($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif</option>
                                                    @else
                                                      <option value="{{$account->idaccount}}">{{ $account->accnumb }} : @if($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif</option>
                                                    @endif
                                                  @endif
                                                @endforeach
                                            </select>
                                            <span class="help-block">@lang('placeholder.exacc')</span>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>

                        <div class="col-md-12 col-xs-12">
                            <table id="tableInput billet-data-table"
                                   class="table table-striped table-hover table-condensed table-bordered table-responsive no-padding">
                                <caption class="text-blue text-bold">@lang('label.break')</caption>
                                <thead>
                                <tr class="text-blue">
                                    <th>@lang('label.value')</th>
                                    <th>@lang('label.label')</th>
                                    <th>@lang('label.in')</th>
                                    <th>@lang('label.amount')</th>
                                    <th>@lang('label.letters')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($moneys as $money)
                                    @if ($money->format == 'B')
                                        <tr>
                                            <td id="bil">{{money($money->value)}}</td>
                                            <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                            <td id="mon{{$money->idmoney}}"
                                                class="input">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                            <td class="sum text-right" id="{{$money->moncode}}Sum">
                                                {{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                            {{--                                            <td class="text-light-blue word"></td>--}}
                                            {{--                                            <td class="text-light-blue word">{{digitToWord($money->value * $cash->{'mon'.$money->idmoney}) }}</td>--}}
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                                <thead>
                                <tr>
                                    <th colspan="5" class="bg-gray"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($moneys as $money)
                                    @if ($money->format == 'C')
                                        <tr>
                                            <td id="bil">{{$money->value}}</td>
                                            <td id="bill">@if($emp->lang == 'fr') {{$money->labelfr}} @else {{$money->labeleng}} @endif</td>
                                            <td id="mon{{$money->idmoney}}"
                                                class="input">{{money($cash->{'mon'.$money->idmoney}) }}</td>
                                            <td class="sum text-right" id="{{$money->moncode}}Sum">
                                                {{money($money->value * $cash->{'mon'.$money->idmoney} )}}</td>
                                            {{--                                            <td class="text-light-blue word"></td>--}}
                                            {{--                                            <td class="text-light-blue word">{{digitToWord($money->value * $cash->{'mon'.$money->idmoney}) }}</td>--}}
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr class="bg-green-active">
                                    <td colspan="3"
                                        style="text-align: center !important;">@lang('label.tobreak')</td>
                                    <td class="text-right text-bold" id="totbil"></td>
                                    <td class="text-left text-bold" id="totopera"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <button type="button" id="delete" class="btn btn-sm bg-red pull-right btn-raised fa fa-trash"></button>
                            <button type="button" id="update" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle"></button>
                            <button type="button" id="insert" class="btn btn-sm bg-blue pull-right btn-raised fa fa-file-o"></button>
                        </div>
                    @endforeach
                @endif
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            sumAmount();
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
            $('#totbil').text(money(sum));

            sumAmount();
        }

        $(document).on('input', '.amount', function () {
            $(this).val(money($(this).val()));

            sumAmount();
        });

        function sumAmount() {
            let sumIn = 0;

            $('.sum').each(function () {
                let input = trimOver($(this).text(), null);
                if (parseInt(input)) {
                    // $(this).after("<td class='text-light-blue text-bold word'></td>");
                    $(this).after("<td class='text-light-blue text-bold word'>" + toWord(input, '{{$emp->lang}}') + "</td>");
                    sumIn += parseInt(input);
                }
            });

            $('#totbil').text(money(sumIn));
            $('#totopera').text(toWord(sumIn, '{{$emp->lang}}'));
        }

        $('#insert').click(function () {
            setEditable();
            $('#cashcode').removeAttr('readonly');
            $('#form :input').val('');
            $('.input, .sum, .word').each(function () {
                $(this).text('');
            });
            $('#totbil').text('');
            $('#totopera').text('');
            $('.select2').val('').select2();
            $(this).replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
            $('.bg-aqua, .fa-trash').attr('disabled', true);


        });

        $('#update').click(function () {
            setEditable();
            $(this).replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>');
        });

        function submitForm() {
            let text = "@lang('confirm.cassave_text')";
            if ($('#idcash').val() !== '') {
                text = "@lang('confirm.casedit_text')";
            }

            mySwal('@lang('sidebar.cash')', text, '@lang('confirm.no')', '@lang('confirm.yes')', '#cashForm');
        }

        $('#delete').click(function () {
            swal({
                icon: 'warning',
                title: '@lang('sidebar.cash')',
                text: '@lang('confirm.casdel_text')',
                closeOnClickOutside: false,
                allowOutsideClick: false,
                closeOnEsc: false,
                buttons: {
                    cancel: {
                        text: ' @lang('confirm.no')',
                        value: false,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-red fa fa-close"
                    },
                    confirm: {
                        text: ' @lang('confirm.yes')',
                        value: true,
                        visible: true,
                        closeModal: true,
                        className: "btn bg-green fa fa-check"
                    },
                },
            }).then(function (isConfirm) {
                if (isConfirm) {
                    let form = $('#cashForm');
                    form.attr('action', 'cash/delete');
                    form.submit();
                }
            });
        });

        function setEditable() {
            $('#cashfr, #casheng').removeAttr('readonly');
            $('.modif').each(function () {
                $(this).removeAttr('readonly');
            });
            $('.select2').removeAttr('disabled');
        }
    </script>
@stop
