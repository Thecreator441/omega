<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr') {
    App::setLocale('fr');
    $title = 'Type Prêt';
} else {
    $title = 'Loan Type';
}
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-tools">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right fa fa-close" id="home"></button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        {{ $loantypes->links('layouts.includes.pagination') }}
                    </div>
                </div>
            </div>
            <form action="{{ route('admin/loantype/store') }}" method="post" role="form" id="loanTypeForm">
                {{ csrf_field() }}
                <div id="form">
                    @if ($loantypes->count() == 0)
                        <input type="hidden" id="idloantype" name="idloantype">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="loancode" class="col-md-6 control-label">@lang('label.loanty')</label>
                                    <div class="col-md-6">
                                        <input type="text" name="loancode" id="loancode" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="loaneng" id="loaneng" class="form-control"
                                               placeholder="@lang('label.labeleng')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="loanfr" id="loanfr" class="form-control"
                                               placeholder="@lang('label.labelfr')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="loanper" class="col-md-6 control-label">@lang('label.loanpe')</label>
                                    <div class="col-md-6">
                                        <select name="loanper" id="loanper" class="form-control select2">
                                            <option></option>
                                            <option value="A">All Period</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="maxdur" class="col-md-6 control-label">@lang('label.maxdur')</label>
                                    <div class="col-md-6">
                                        <input type="text" name="maxdur" id="maxdur" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="maxamt" class="col-md-6 control-label">@lang('label.maxamt')</label>
                                    <div class="col-md-6">
                                        <input type="text" name="maxamt" id="maxamt" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inst&pen" class="col-md-6 control-label">@lang('label.inst&pen')</label>
                                    <div class="col-md-6">
                                        <input type="text" name="inst&pen" id="inst&pen" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="intpayacc" class="col-md-7 control-label">@lang('label.intpayacc')</label>
                                    <div class="col-md-5">
                                        <select name="intpayacc" id="intpayacc" class="form-control select2">
                                            <option></option>
                                            @foreach ($accounts as $account)
                                                <option value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="intacc_name" id="intacc_name" class="form-control"
                                               disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="loanacc" class="col-md-7 control-label">@lang('label.loanacc')</label>
                                    <div class="col-md-5">
                                        <select name="loanacc" id="loanacc" class="form-control select2">
                                            <option></option>
                                            @foreach ($accounts as $account)
                                                <option value="{{$account->idaccount}}">{{$account->accplan}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 text-right text-bold">
                                    @lang('label.seicomaker')
                                </label>
                                <div class="col-md-2">
                                    <div class="radio">
                                        <label for="yes">@lang('label.yes')
                                            <input type="radio" name="accCom" id="yes" value="Y"></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="radio">
                                        <label for="no">@lang('label.no')
                                            <input type="radio" name="accCom" id="no" value="N"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 text-right text-bold">
                                    @lang('label.accblock')
                                </label>
                                <div class="col-md-2">
                                    <div class="radio">
                                        <label for="none">@lang('label.none')
                                            <input type="radio" name="accBlock" id="none" value="N"></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="radio">
                                        <label for="memacc">@lang('label.memacc')
                                            <input type="radio" name="accBlock" id="memacc" value="M"></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="radio">
                                        <label for="mem&co">@lang('label.mem&co')
                                            <input type="radio" name="accBlock" id="mem&co" value="Mc"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label for="taxpay"><input type="checkbox" name="taxpay" id="taxpay" value="Y">&nbsp;&nbsp;
                                                @lang('label.taxpay')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="taxPayInfo" style="display: none">
                                <div class="col-md-12">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="taxrate"
                                                   class="col-md-6 control-label">@lang('label.taxrate')</label>
                                            <div class="col-md-6">
                                                <input type="text" name="taxrate" id="taxrate"
                                                       class="form-control text-right">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="taxacc"
                                                   class="col-md-5 control-label">@lang('label.taxacc')</label>
                                            <div class="col-md-7">
                                                <select name="taxacc" id="taxacc" class="form-control select2">
                                                    <option></option>
                                                    @foreach ($accounts as $account)
                                                        <option
                                                            value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="taxacc_name" id="taxacc_name"
                                                       class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label for="quod"><input type="checkbox" name="quod" id="quod" value="Y">&nbsp;&nbsp;
                                                @lang('label.quod')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="quodInfo" style="display: none">
                                <div class="col-md-12">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="quodrate"
                                                   class="col-md-6 control-label">@lang('label.quodrate')</label>
                                            <div class="col-md-6">
                                                <input type="text" name="quodrate" id="quodrate"
                                                       class="form-control text-right">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="accplanquod"
                                                   class="col-md-7 control-label">@lang('label.accplanquod')</label>
                                            <div class="col-md-5">
                                                <select name="accplanquod" id="accplanquod" class="form-control select2">
                                                    <option></option>
                                                    @foreach ($accounts as $account)
                                                        <option
                                                            value="{{$account->idaccount}}">{{$account->accplan}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label for="penreg"><input type="checkbox" name="penreg" id="penreg" value="Y">&nbsp;&nbsp;
                                                @lang('label.penreg')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="penRegInfo" style="display: none">
                                <div class="col-md-12">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="taxpen"
                                                   class="col-md-6 control-label">@lang('label.taxpen')</label>
                                            <div class="col-md-6">
                                                <input type="text" name="taxpen" id="taxpen"
                                                       class="form-control text-right">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="penacc"
                                                   class="col-md-5 control-label">@lang('label.penacc')</label>
                                            <div class="col-md-7">
                                                <select name="penacc" id="penacc" class="form-control select2">
                                                    <option></option>
                                                    @foreach ($accounts as $account)
                                                        <option
                                                            value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="penacc_name" id="penacc_name"
                                                       class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <button type="button" id="delete" disabled
                                            class="btn btn-sm bg-red pull-right btn-raised fa fa-trash">
                                    </button>
                                    <button type="button" id="update" disabled
                                            class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle">
                                    </button>
                                    <button type="button" id="save"
                                            class="btn btn-sm bg-blue pull-right btn-raised fa fa-save">
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach ($loantypes as $loantype)
                            <input type="hidden" id="idloantype" name="idloantype" value="{{$loantype->idltype}}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loancode" class="col-md-6 control-label">@lang('label.loanty')</label>
                                        <div class="col-md-6">
                                            <input type="text" name="loancode" id="loancode" class="form-control"
                                                   value="{{$loantype->lcode}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="loaneng" id="loaneng" class="form-control" readonly
                                                   placeholder="@lang('label.labeleng')" value="{{$loantype->labeleng}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="loanfr" id="loanfr" class="form-control" readonly
                                                   placeholder="@lang('label.labelfr')" value="{{$loantype->labelfr}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loanper" class="col-md-6 control-label">@lang('label.loanpe')</label>
                                        <div class="col-md-6">
                                            <select name="loanper" id="loanper" class="form-control select2" disabled>
                                                <option></option>
                                                <option value="A">All Period</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="maxdur" class="col-md-6 control-label">@lang('label.maxdur')</label>
                                        <div class="col-md-6">
                                            <input type="text" name="maxdur" id="maxdur" class="form-control" readonly
                                                   value="{{$loantype->maxdur}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="maxamt" class="col-md-6 control-label">@lang('label.maxamt')</label>
                                        <div class="col-md-6">
                                            <input type="text" name="maxamt" id="maxamt"
                                                   class="form-control text-right text-bold" readonly
                                                   value="{{money((int)$loantype->maxamt)}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inst&pen" class="col-md-6 control-label">@lang('label.inst&pen')</label>
                                        <div class="col-md-6">
                                            <input type="text" name="inst&pen" id="inst&pen" class="form-control" readonly
                                                   value="{{$loantype->datescapepen}}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="intpayacc"
                                               class="col-md-7 control-label">@lang('label.intpayacc')</label>
                                        <div class="col-md-5">
                                            <select name="intpayacc" id="intpayacc" class="form-control select2" disabled>
                                                <option></option>
                                                @foreach ($accounts as $account)
                                                    @if ($account->idaccount == $loantype->intacc)
                                                        <option value="{{$account->idaccount}}"
                                                                selected>{{$account->accnumb}}</option>
                                                    @else
                                                        <option
                                                            value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            @foreach ($accounts as $account)
                                                @if ($account->idaccount == $loantype->intacc)
                                                    <input type="text" name="intacc_name" id="intacc_name"
                                                           class="form-control" disabled
                                                           value="@if ($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif">
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loanacc" class="col-md-7 control-label">@lang('label.loanacc')</label>
                                        <div class="col-md-5">
                                            <select name="loanacc" id="loanacc" class="form-control select2" disabled>
                                                <option></option>
                                                @foreach ($accounts as $account)
                                                    @if ($account->idaccount == $loantype->loanaccart)
                                                        <option value="{{$account->idaccount}}"
                                                                selected>{{$account->accplan}}</option>
                                                    @else
                                                        <option
                                                            value="{{$account->idaccount}}">{{$account->accplan}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label class="col-md-3 text-right text-bold">
                                        @lang('label.seicomaker')
                                    </label>
                                    <div class="col-md-2">
                                        <div class="radio">
                                            <label for="yes">@lang('label.yes')
                                                <input type="radio" name="accCom" id="yes" value="Y"
                                                       @if ($loantype->getcomaker == 'Y') checked @endif disabled></label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="radio">
                                            <label for="no">@lang('label.no')
                                                <input type="radio" name="accCom" id="no" value="N"
                                                       @if ($loantype->getcomaker == 'N') checked @endif disabled></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label class="col-md-3 text-right text-bold">
                                        @lang('label.accblock')
                                    </label>
                                    <div class="col-md-2">
                                        <div class="radio">
                                            <label for="none">@lang('label.none')
                                                <input type="radio" name="accBlock" id="none" value="N"
                                                       @if ($loantype->blockacc == 'N') checked @endif disabled></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="radio">
                                            <label for="memacc">@lang('label.memacc')
                                                <input type="radio" name="accBlock" id="memacc" value="M"
                                                       @if ($loantype->blockacc == 'M') checked @endif disabled></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="radio">
                                            <label for="mem&co">@lang('label.mem&co')
                                                <input type="radio" name="accBlock" id="mem&co" value="Mc"
                                                       @if ($loantype->blockacc == 'Mc') checked @endif disabled></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label for="taxpay">
                                                    <input type="checkbox" name="taxpay" id="taxpay" value="Y"
                                                           @if ($loantype->paytax == 'Y') checked @endif disabled>&nbsp;&nbsp;
                                                    @lang('label.taxpay')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="taxPayInfo" style="display: none">
                                    <div class="col-md-12">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="taxrate"
                                                       class="col-md-6 control-label">@lang('label.taxrate')</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="taxrate" id="taxrate"
                                                           value="{{round($loantype->taxrate)}}"
                                                           class="form-control text-right">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="taxacc"
                                                       class="col-md-5 control-label">@lang('label.taxacc')</label>
                                                <div class="col-md-7">
                                                    <select name="taxacc" id="taxacc" class="form-control select2">
                                                        <option></option>
                                                        @foreach ($accounts as $account)
                                                            @if ($account->idaccount == $loantype->taxacc)
                                                                <option value="{{$account->idaccount}}"
                                                                        selected>{{$account->accnumb}}</option>
                                                            @else
                                                                <option
                                                                    value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    @foreach ($accounts as $account)
                                                        @if ($account->idaccount == $loantype->taxacc)
                                                            <input type="text" name="taxacc_name" id="taxacc_name"
                                                                   class="form-control" disabled
                                                                   value="@if ($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif">
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="checkbox">
                                                <label for="quod">
                                                    <input type="checkbox" name="quod" id="quod" value="Y"
                                                           @if ($loantype->usequote == 'Y') checked @endif disabled>&nbsp;&nbsp;
                                                    @lang('label.quod')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="quodInfo" style="display: none">
                                    <div class="col-md-12">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="quodrate"
                                                       class="col-md-6 control-label">@lang('label.quodrate')</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="quodrate" id="quodrate"
                                                           value="{{round($loantype->quoterate)}}"
                                                           class="form-control text-right">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="accplanquod"
                                                       class="col-md-7 control-label">@lang('label.accplanquod')</label>
                                                <div class="col-md-5">
                                                    <select name="accplanquod" id="accplanquod"
                                                            class="form-control select2">
                                                        <option></option>
                                                        @foreach ($accounts as $account)
                                                            @if ($account->idaccount == $loantype->quoteaccplan)
                                                                <option value="{{$account->idaccount}}"
                                                                        selected>{{$account->accplan}}</option>
                                                            @else
                                                                <option
                                                                    value="{{$account->idaccount}}">{{$account->accplan}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="checkbox">
                                                <label for="penreg">
                                                    <input type="checkbox" name="penreg" id="penreg" value="Y"
                                                           @if ($loantype->penreq == 'Y') checked @endif disabled>&nbsp;&nbsp;
                                                    @lang('label.penreg')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="penRegInfo" style="display: none">
                                    <div class="col-md-12">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="taxpen"
                                                       class="col-md-6 control-label">@lang('label.taxpen')</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="taxpen" id="taxpen" readonly
                                                           value="{{round($loantype->pentax)}}"
                                                           class="form-control text-right">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="penacc"
                                                       class="col-md-5 control-label">@lang('label.penacc')</label>
                                                <div class="col-md-7">
                                                    <select name="penacc" id="penacc" class="form-control select2" disabled>
                                                        <option></option>
                                                        @foreach ($accounts as $account)
                                                            @if ($account->idaccount == $loantype->penacc)
                                                                <option value="{{$account->idaccount}}"
                                                                        selected>{{$account->accnumb}}</option>
                                                            @else
                                                                <option
                                                                    value="{{$account->idaccount}}">{{$account->accnumb}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    @foreach ($accounts as $account)
                                                        @if ($account->idaccount == $loantype->penacc)
                                                            <input type="text" name="penacc_name" id="penacc_name"
                                                                   class="form-control" disabled
                                                                   value="@if ($emp->lang == 'fr') {{$account->labelfr}} @else {{$account->labeleng}} @endif">
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <button type="button" id="delete"
                                                class="btn btn-sm bg-red pull-right btn-raised fa fa-trash">
                                        </button>
                                        <button type="button" id="update"
                                                class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle">
                                        </button>
                                        <button type="button" id="insert"
                                                class="btn btn-sm bg-blue pull-right btn-raised fa fa-file-o">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            verifCheckbox();
        });

        $('#insert').click(function () {
            setEditable();
            $('#form :input').val('');
            $('#form input[type="radio"], #loanTypeForm input[type="checkbox"]').removeAttr('checked');
            $('.select2').select2().trigger('change');
            $(this).replaceWith('<button type="button" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
            $('.bg-aqua').replaceWith('<button type="button" id="update" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-recycle" disabled></button>');
            $('#form .bg-red').attr('disabled', true);
            verifCheckbox();
        });

        $('#update').click(function () {
            setEditable();
            $(this).replaceWith('<button type="button" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>');
        });

        $('input[type="checkbox"]').each(function () {
            $(this).click(function () {
                verifCheckbox();
            })
        });

        $('#intpayacc').change(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    account: $(this).val()
                },
                success: function (account) {
                    $('#intacc_name').val("@if($emp->lang == 'fr') " + account.labelfr + " @else " + account.labeleng + " @endif ");
                }
            });
        });

        $('#taxacc').change(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    account: $(this).val()
                },
                success: function (account) {
                    $('#taxacc_name').val("@if($emp->lang == 'fr') " + account.labelfr + " @else " + account.labeleng + " @endif ");
                }
            });
        });

        $('#penacc').change(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('getAccount') }}",
                method: 'get',
                data: {
                    account: $(this).val()
                },
                success: function (account) {
                    $('#penacc_name').val("@if($emp->lang == 'fr') " + account.labelfr + " @else " + account.labeleng + " @endif ");
                }
            });
        });

        $(document).on('click', '#save, #edit', function () {
            let text = '';
            if ($('#idloantype').val() === '')
                text = '@lang('confirm.ltypesave_text')';
            else
                text = '@lang('confirm.ltypeedit_text')';

            swal({
                    title: '@lang('confirm.ltype_header')',
                    text: text,
                    type: 'info',
                    showCancelButton: true,
                    cancelButtonClass: 'bg-red',
                    confirmButtonClass: 'bg-green',
                    confirmButtonText: '@lang('confirm.yes')',
                    cancelButtonText: '@lang('confirm.no')',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $('#loanTypeForm').submit();
                    }
                }
            );
        });

        $('#delete').click(function () {
            swal({
                    title: '@lang('confirm.ltype_header')',
                    text: '@lang('confirm.ltypedel_text')',
                    type: 'info',
                    showCancelButton: true,
                    cancelButtonClass: 'bg-red',
                    confirmButtonClass: 'bg-green',
                    confirmButtonText: '@lang('confirm.yes')',
                    cancelButtonText: '@lang('confirm.no')',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        let form = $('#loanTypeForm');
                        form.attr('action', 'admin/loantype/delete');
                        form.submit();
                    }
                }
            );
        });

        function setEditable() {
            $('#form :input').removeAttr('readonly');
            $('select, #form input[type="radio"], #form input[type="checkbox"]').removeAttr('disabled');
        }

        function verifCheckbox() {
            if ($('#taxpay').is(':checked')) {
                $('#taxPayInfo').css('display', 'block');
            } else {
                $('#taxPayInfo').css('display', 'none');
            }

            if ($('#quod').is(':checked')) {
                $('#quodInfo').css('display', 'block');
            } else {
                $('#quodInfo').css('display', 'none');
            }

            if ($('#penreg').is(':checked')) {
                $('#penRegInfo').css('display', 'block');
            } else {
                $('#penRegInfo').css('display', 'none');
            }
        }
    </script>
@stop
