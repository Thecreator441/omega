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
    <div class="box box-info" id="form" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title text-bold" id="title"> @lang('label.newmem')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url('registration/store') }}" id="regForm" method="post" role="form" enctype="multipart/form-data" class="needs-validation">
                {{ csrf_field() }}
                <input type="hidden" name="idregister" id="idregister">

                <div id="fillform">
                    <div class="row">
                        <div class="col-md-8 col-xs-12">
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                    <div class="form-group has-error">
                                        <label for="gender" class="col-md-4 control-label">@lang('label.gender')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <select name="gender" id="gender" class="form-control select2" required>
                                                <option value="M">@lang('label.male')</option>
                                                <option value="F">@lang('label.female')</option>
                                                <option value="G">@lang('label.group')</option>
                                            </select>
                                            <span class="help-block">@lang('placeholder.gender')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6 physical">
                                    <div class="form-group has-error">
                                        <label for="group" class="col-md-4 control-label">@lang('label.group')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <select name="group" id="group" class="form-control select2" required>
                                                @foreach ($groups as $group)
                                                    <option value="{{$group->idgroup}}">{{pad($group->code, 3)}} : @if($emp->lang == 'fr') {{ $group->labelfr }} @else {{ $group->labeleng }} @endif</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">@lang('placeholder.group')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6 moral" style="display: none">
                                    <div class="form-group has-error">
                                        <label for="grptype" class="col-md-4 control-label">@lang('label.grptype')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <select name="grptype" id="grptype" class="form-control select2" required>
                                                <option value="A">@lang('label.assoc')</option>
                                                <option value="E">@lang('label.enterp')</option>
                                            </select>
                                            <span class="help-block">@lang('placeholder.grptype')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-xs-12 physical">
                                    <div class="form-group has-error">
                                        <label for="name" class="col-md-4 control-label">@lang('label.name')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="name" id="name" required>
                                            <span class="help-block">@lang('placeholder.name')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 physical">
                                    <div class="form-group has-error">
                                        <label for="surname" class="col-md-4 control-label">@lang('label.surname')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="surname" id="surname" required>
                                            <span class="help-block">@lang('placeholder.surname')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 moral assoc" style="display: none">
                                    <div class="form-group has-error">
                                        <label for="assno" class="col-md-4 col-xs-3 control-label">@lang('label.assnumb') <span class="text-bold text-red">*</span></label>
                                        <div class="col-md-8 col-xs-9">
                                            <input type="text" class="form-control" name="assno" id="assno" required>
                                            <span class="help-block">@lang('placeholder.assno')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 moral assoc" style="display: none">
                                    <div class="form-group has-error">
                                        <label for="name" class="col-md-4 control-label">@lang('label.name')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="assoc_name" id="moral_assoc_name" required>
                                            <span class="help-block">@lang('placeholder.name')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 moral enter" style="display: none">
                                    <div class="form-group has-error">
                                        <label for="name" class="col-md-2 control-label">@lang('label.name')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="moral_name" id="moral_enter_name" required>
                                            <span class="help-block">@lang('placeholder.name')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-xs-12 physical">
                                    <div class="form-group has-error">
                                        <label for="date" class="col-md-2 col-xs-5 control-label">@lang('label.dob')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-3 col-xs-7">
                                            <input type="date" class="form-control" name="dob" id="date" required>
                                            <span class="help-block">@lang('placeholder.dob')</span>
                                        </div>
                                        <label for="pob" class="col-md-1 col-xs-3 control-label">@lang('label.at')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-6 col-xs-9">
                                            <input type="text" class="form-control" name="pob" id="pob" required>
                                            <span class="help-block">@lang('placeholder.pob')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 moral" style="display: none">
                                    <div class="form-group has-error">
                                        <label for="date" class="col-md-2 col-xs-5 control-label">@lang('label.creadate')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-3 col-xs-7">
                                            <input type="date" class="form-control" name="moral_dob" id="date creadate" required>
                                            <span class="help-block">@lang('placeholder.dob')</span>
                                        </div>
                                        <label for="pob" class="col-md-1 col-xs-3 control-label">@lang('label.at')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-6 col-xs-9">
                                            <input type="text" class="form-control" name="moral_pob" id="moral_pob" required>
                                            <span class="help-block">@lang('placeholder.pob')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-xs-6 physical">
                                    <div class="form-group has-error">
                                        <label for="status" class="col-md-4 control-label">@lang('label.marstatus')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" id="status" name="status" required>
                                                <option value=""></option>
                                                <option value="S">@lang('label.single')</option>
                                                <option value="M">@lang('label.married')</option>
                                                <option value="D">@lang('label.divorced')</option>
                                                <option value="W">@lang('label.widow')</option>
                                                <option value="O">@lang('label.others')</option>
                                            </select>
                                            <span class="help-block">@lang('placeholder.status')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6 physical">
                                    <div class="form-group">
                                        <label for="profession" class="col-md-4 control-label">@lang('label.prof')</label>
                                        <div class="col-md-8" id="profes">
                                            <select class="form-control select2" name="profession" id="profession">
                                                <option value=""></option>
                                                @foreach($profs as $prof)
                                                    <option value="{{$prof->idprof}}">@if ($emp->lang === 'fr') {{$prof->labelfr}} @else {{$prof->labeleng}} @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">@lang('placeholder.prof')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6 moral assoc" style="display: none">
                                    <div class="form-group has-error">
                                        <label for="liveper" class="col-md-4 control-label">@lang('label.liveper')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="liveper" id="moral_assoc_liveper" required>
                                            <span class="help-block">@lang('placeholder.liveper')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 moral enter" style="display: none">
                                    <div class="form-group has-error">
                                        <label for="liveper" class="col-md-2 col-xs-2 control-label">@lang('label.liveper')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-10 col-xs-10">
                                            <input type="text" class="form-control" name="liveper" id="moral_enter_liveper" required>
                                            <span class="help-block">@lang('placeholder.liveper')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6 moral assoc" style="display: none">
                                    <div class="form-group has-error">
                                        <label for="assmemno" class="col-md-4 control-label">@lang('label.assmemno') <span class="text-bold text-red">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="assmemno" name="assmemno" required>
                                            <span class="help-block">@lang('placeholder.assmemno')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-group" style="height: 120px; width: 100%;">
                                    <a><img id="pic" onclick="chooseFile('pic')" src="" alt="@lang('placeholder.uppic')" style="height: 120px; width: 100%;" class="img-bordered-sm img-responsive"/></a>
                                    <div style="height: 0; overflow: hidden"><input type="file" name="profile" accept='image/*' id="inpic"/></div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 enter">
                                <div class="form-group" style="height: 100px; width: 100%;">
                                    <a><img id="sign" onclick="chooseFile('sign')" src="" alt="@lang('placeholder.upsign')" style="height: 100px; width: 100%;" class="img-bordered-sm img-responsive"/></a>
                                    <div style="height: 0; overflow: hidden"><input type="file" name="signature" accept='image/*' id="insign"/></div>
                                </div>
                            </div>
                            <div class="moral assoc" style="display: none">
                                <div class="col-md-4 col-xs-12 assoc" style="display: none">
                                    <div class="form-group" style="height: 100px; width: 100%;">
                                        <a><img id="sign1" onclick="chooseFile('sign1')" src="" alt="@lang('placeholder.upsign')" style="height: 100px; width: 100%;" class="img-bordered-sm img-responsive"/></a>
                                        <div style="height: 0; overflow: hidden"><input type="file" name="signature" accept="image/*" id="insign1"/></div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 assoc" style="display: none">
                                    <div class="form-group" style="height: 100px; width: 100%;">
                                        <a><img id="sign2" onclick="chooseFile('sign2')" src="" alt="@lang('placeholder.upsign')" style="height: 100px; width: 100%;" class="img-bordered-sm img-responsive"/></a>
                                        <div style="height: 0; overflow: hidden"><input type="file" name="signature2" accept="image/*" id="insign2"/></div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 assoc" style="display: none">
                                    <div class="form-group" style="height: 100px; width: 100%;">
                                        <a><img id="sign3" onclick="chooseFile('sign3')" src="" alt="@lang('placeholder.upsign')" style="height: 100px; width: 100%;" class="img-bordered-sm img-responsive"/></a>
                                        <div style="height: 0; overflow: hidden"><input type="file" name="signature3" accept="image/*" id="insign3"/></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="physical">
                        <div class="row">
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group">
                                    <label for="cnpsnumb" class="col-md-4 control-label">@lang('label.cnps')</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="cnpsnumb" id="cnpsnumb">
                                        <span class="help-block">@lang('placeholder.cnps')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group has-error">
                                    <label for="nic_type" class="col-md-4 control-label">@lang('label.idtype')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-8">
                                        <select name="nic_type" id="nic_type" class="form-control select2" required>
                                            <option value=""></option>
                                            <option value="C">@lang('label.idcard')</option>
                                            <option value="P">@lang('label.passport')</option>
                                        </select>
                                        <span class="help-block">@lang('placeholder.idtype')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group has-error">
                                    <label for="nic" class="col-md-4 control-label">@lang('label.idnumb')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="nic" id="nic" required>
                                        <span class="help-block">@lang('placeholder.nic')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group has-error">
                                    <label for="idate" class="col-md-4 control-label">@lang('label.deliver')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-8">
                                        <input type="date" class="form-control" name="issuedate" id="idate" required>
                                        <span class="help-block">@lang('placeholder.issuedate')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="issueplace" class="col-md-4 control-label">@lang('label.at')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="issueplace" id="issueplace" required>
                                        <span class="help-block">@lang('placeholder.issueplace')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="moral enter" style="display: none" style="display: none">
                        <div class="row">
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group has-error">
                                    <label for="comregis" class="col-md-4 control-label">@lang('label.regist')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="comregis" name="comregis" required>
                                        <span class="help-block">@lang('placeholder.comregis')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group has-error">
                                    <label for="regime" class="col-md-4 control-label">@lang('label.regim')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="regime" id="regime" required>
                                        <span class="help-block">@lang('placeholder.regime')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group has-error">
                                    <label for="taxpaynumb" class="col-md-4 control-label">@lang('label.taxpayno')<span class="text-red text-bold">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="taxpaynumb" id="taxpaynumb" required>
                                        <span class="help-block">@lang('placeholder.taxpaynumb')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="phone1" class="col-md-4 control-label">@lang('label.phone')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="phone1" id="phone1" min="0" required>
                                    <span class="help-block">@lang('placeholder.phone')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-6">
                            <div class="form-group">
                                <label for="phone2" class="col-md-4 control-label">@lang('label.fax')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="phone2" id="phone2" min="0">
                                    <span class="help-block">@lang('placeholder.fax')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <div class="form-group has-error">
                                <label for="email" class="col-md-4 control-label">@lang('label.@')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="email" class="form-control" name="email" id="email" required>
                                    <span class="help-block">@lang('placeholder.@')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="country" class="col-md-4 control-label">@lang('label.country')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="country" name="country" required>
                                        <option></option>
                                        @foreach($countries as $country)
                                            <option
                                                value="{{ $country->idcountry }}">@if($emp->lang == 'fr') {{ $country->labelfr }} @else {{ $country->labeleng }} @endif</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.country')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="regorigin" class="col-md-4 control-label">@lang('label.regorigin')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="regorigin" name="regorigin" required>
                                        <option value=""></option>
                                        @foreach($regions as $region)
                                            <option
                                                value="{{ $region->idregi }}">@if($emp->lang == 'fr') {{ $region->labelfr }} @else {{ $region->labeleng }} @endif</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.regorigin')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <div class="form-group has-error">
                                <label for="region" class="col-md-4 control-label">@lang('label.region')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="region" name="region" required>
                                        <option value=""></option>
                                        @foreach ($regions as $region)
                                            <option value="{{$region->idregi}}">@if ($emp->lang === 'fr') {{$region->labelfr}} @else {{$region->labeleng}} @endif</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.region')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="division"
                                        class="col-md-4 control-label">@lang('label.division')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="division" name="division" required>
                                        <option value=""></option>
                                        @foreach ($divisions as $division)
                                            <option value="{{$division->iddiv}}">{{$division->label}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.division')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="subdiv" class="col-md-4 control-label">@lang('label.subdiv')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="subdiv" name="subdiv" required>
                                        <option value=""></option>
                                        @foreach ($subdivs as $subdiv)
                                            <option value="{{$subdiv->idsub}}">{{$subdiv->label}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.subdiv')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group has-error">
                                <label for="town" class="col-md-4 control-label">@lang('label.town')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="town" name="town" required>
                                        <option value=""></option>
                                        @foreach ($towns as $town)
                                            <option value="{{$town->idtown}}">{{$town->label}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.town')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="address" class="col-md-4 control-label">@lang('label.address')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="address" name="address" required>
                                    <span class="help-block">@lang('placeholder.address')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="quarter" class="col-md-4 control-label">@lang('label.quarter')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="quarter" name="quarter" required>
                                    <span class="help-block">@lang('placeholder.quarter')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-header with-border">
                        <h4 class="box-title text-bold">@lang('label.nxtofkin')</h4>
                        <table class="table table-hover table-bordered table-condensed table-responsive" id="registerInput">
                            <thead>
                            <tr>
                                <th colspan="2">@lang('label.nam&sur')<span class="text-red text-bold">*</span></th>
                                <th>@lang('label.relation')<span class="text-red text-bold">*</span></th>
                                <th>@lang('label.phone')<span class="text-red text-bold">*</span></th>
                                <th>@lang('label.ratio')<span class="text-red text-bold">*</span></th>
                            </tr>
                            </thead>
                            <tbody id="bene_body">
                            <tr>
                                <td><input type="checkbox" class="check" disabled></td>
                                <td><input type="text" name="bene_name[]" class="reg" required></td>
                                <td><input type="text" name="bene_relate[]" class="reg" required></td>
                                <td><input type="number" name="bene_phone[]" class="reg" required></td>
                                <td><input type="number" name="bene_ratio[]" class="reg bene_reg text-right text-bold" required></td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">@lang('label.remain')</th>
                                <th><input type="text" name="rem" class="reg" id="rem" disabled></th>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <button type="button" id="new_bene" class="btn btn-sm bg-green pull-right btn-raised fa fa-plus"></button>
                                    <button type="button" id="del_bene" class="btn btn-sm bg-red pull-right btn-raised fa fa-minus" disabled></button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="box-header with-border">
                        <h4 class="box-title text-bold">@lang('label.witnes')</h4>
                        <div class="row">
                            <div class="row">
                                <div class="col-md-5 col-xs-12">
                                    <div class="form-group has-error">
                                        <label for="witnes_name" class="col-md-3 col-xs-3 control-label">@lang('label.nam&sur')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-9 col-xs-9">
                                            <input type="text" class="form-control" name="witnes_name" id="witnes_name" required>
                                            <span class="help-block">@lang('placeholder.name')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-6">
                                    <div class="form-group has-error">
                                        <label for="witnes_phone" class="col-md-3 control-label">@lang('label.phone')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="witnes_phone" id="witnes_phone" required>
                                            <span class="help-block">@lang('placeholder.phone')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <div class="form-group has-error">
                                        <label for="witnes_nic" class="col-md-4 control-label">@lang('label.idnumb')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="witnes_nic" id="witnes_nic" required>
                                            <span class="help-block">@lang('placeholder.nic')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> {{ $title }} </h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="newInst">
                    <i class="fa fa-plus"></i>&nbsp;@lang('label.newmem')
                </button>
            </div>
        </div>
        <div class="box-body">
            <table id="admin-data-table" class="table table-bordered table-striped table-hover table-responsive-xl">
                <thead>
                <tr>
                    <th> @lang('label.number') </th>
                    <th> @lang('label.nam&sur') </th>
                    <th> @lang('label.phone') </th>
                    <th> @lang('label.@') </th>
                    <th> Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($registers as $register)
                    <tr>
                        <td class="text-center">{{pad($register->regnumb, 6)}}</td>
                        <td>{{$register->name . ' ' . $register->surname}}</td>
                        <td>{{$register->phone1}}</td>
                        <td>{{$register->email}}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info bg-aqua btn-sm fa fa-edit" onclick="edit('{{$register->idregister}}')"></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('.physical').each(function () {
                $(this).show();
                $('.' + $(this).prop('class') + ' :input').prop('required', true);
                $('.' + $(this).prop('class') + ' .select').prop('required', true);
                $('.moral :input').prop('required', false);
                $('.moral .select').prop('required', false);
            });
            $('.moral').each(function () {
                $(this).hide();
                $('.' + $(this).prop('class') + ' :input').prop('required', false);
                $('.' + $(this).prop('class') + ' .select').prop('required', false);
                $('.physical :input').prop('required', true);
                $('.physical .select').prop('required', true);
            });
        });

        $('#gender').change(function () {
            var value = $(this).val();
            if (value === 'M' || value === 'F') {
                $('.physical').each(function () {
                    $(this).show();
                    $('.' + $(this).prop('class') + ' :input').prop('required', true);
                    $('.' + $(this).prop('class') + ' .select').prop('required', true);
                    $('.moral :input').prop('required', false);
                    $('.moral .select').prop('required', false);
                });
                $('.moral').each(function () {
                    $(this).hide();
                    $('.' + $(this).prop('class') + ' :input').prop('required', false);
                    $('.' + $(this).prop('class') + ' .select').prop('required', false);
                    $('.physical :input').prop('required', true);
                    $('.physical .select').prop('required', true);
                });
            } else if (value === 'G') {
                $('.physical').each(function () {
                    $(this).hide();
                    $('.' + $(this).prop('class') + ' :input').prop('required', false);
                    $('.' + $(this).prop('class') + ' .select').prop('required', false);
                    $('.moral :input').prop('required', true);
                    $('.moral .select').prop('required', true);
                });
                $('.moral').each(function () {
                    $(this).show();
                    $('.' + $(this).prop('class') + ' :input').prop('required', true);
                    $('.' + $(this).prop('class') + ' .select').prop('required', true);
                    $('.physical :input').prop('required', false);
                    $('.physical .select').prop('required', false);
                });

                if ($('#grptype').val() === 'A') {
                    $('.assoc').each(function () {
                        $(this).show();
                        $('.' + $(this).prop('class') + ' :input').prop('required', true);
                        $('.' + $(this).prop('class') + ' .select').prop('required', true);
                        $('.enter :input').prop('required', false);
                        $('.enter .select').prop('required', false);
                    });
                    $('.enter').each(function () {
                        $(this).hide();
                        $('.' + $(this).prop('class') + ' :input').prop('required', false);
                        $('.' + $(this).prop('class') + ' .select').prop('required', false);
                        $('.assoc :input').prop('required', true);
                        $('.assoc .select').prop('required', true);
                    });
                } else if ($('#grptype').val() === 'E') {
                    $('.assoc').each(function () {
                        $(this).hide();
                        $('.' + $(this).prop('class') + ' :input').prop('required', false);
                        $('.' + $(this).prop('class') + ' .select').prop('required', false);
                        $('.enter :input').prop('required', true);
                        $('.enter .select').prop('required', true);
                    });
                    $('.enter').each(function () {
                        $(this).show();
                        $('.' + $(this).prop('class') + ' :input').prop('required', true);
                        $('.' + $(this).prop('class') + ' .select').prop('required', true);
                        $('.assoc :input').prop('required', false);
                        $('.assoc .select').prop('required', false);
                    });
                }
            }
        });

        $('#grptype').change(function () {
            if ($(this).val() === 'A') {
                $('.assoc').each(function () {
                    $(this).show();
                    $('.' + $(this).prop('class') + ' :input').prop('required', true);
                    $('.' + $(this).prop('class') + ' .select').prop('required', true);
                    $('.enter :input').prop('required', false);
                    $('.enter .select').prop('required', false);
                });
                $('.enter').each(function () {
                    $(this).hide();
                    $('.' + $(this).prop('class') + ' :input').prop('required', false);
                    $('.' + $(this).prop('class') + ' .select').prop('required', false);
                    $('.assoc :input').prop('required', true);
                    $('.assoc .select').prop('required', true);
                });
            } else if ($(this).val() === 'E') {
                $('.assoc').each(function () {
                    $(this).hide();
                    $('.' + $(this).prop('class') + ' :input').prop('required', false);
                    $('.' + $(this).prop('class') + ' .select').prop('required', false);
                    $('.enter :input').prop('required', true);
                    $('.enter .select').prop('required', true);
                });
                $('.enter').each(function () {
                    $(this).show();
                    $('.' + $(this).prop('class') + ' :input').prop('required', true);
                    $('.' + $(this).prop('class') + ' .select').prop('required', true);
                    $('.assoc :input').prop('required', false);
                    $('.assoc .select').prop('required', false);
                });
            }
        });

        $('#newInst').click(function () {
            in_out_form();
            $('#form').show();
        });

        $('#exitForm').click(function () {
            $('#form').hide();
            in_out_form();
        });

        function in_out_form() {
            $('#title').text('@lang('label.newmem')');
            $('#idregister').val('');
            $('#fillform :input').val('');
            $('#pic, #sign').attr('src', '');
            $('.select2').trigger('change');

            let tr = '<tr>' +
                '<td><input type="checkbox" class="check" disabled></td>' +
                '<td><input type="text" name="bene_name[]" class="reg" required></td>' +
                '<td><input type="text" name="bene_relate[]" class="reg" required></td>' +
                '<td><input type="number" name="bene_phone[]" class="reg" required></td>' +
                '<td><input type="number" name="bene_ratio[]" class="reg bene_reg text-right text-bold" required></td>' +
                '</tr>';
            $('#registerInput tbody').html(tr);

            $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }

        $('#credate').on('input', function () {
            const dateInterval = 86400000;
            let credate = new Date($(this).val());
            let today = new Date();
            let dif = Math.abs(Math.floor((today.getTime() - credate.getTime()) / dateInterval));
            $('#liveper').val(dif);
        });

        $('#new_bene').click(function () {
            let tr = '<tr>' +
                '<td><input type="checkbox" class="check"></td>' +
                '<td><input type="text" name="bene_name[]" id="name_sur" class="reg"></td>' +
                '<td><input type="text" name="bene_relate[]" id="rela" class="reg"></td>' +
                '<td><input type="number" name="bene_phone[]" id="phone" class="reg"></td>' +
                '<td><input type="number" name="bene_ratio[]" class="reg bene_reg"></td>' +
                '</tr>';
            $('#registerInput tbody').append(tr);
            $('#del_bene').removeAttr('disabled');
        });

        $('#del_bene').hover(function () {
            if ($('#bene_body tr').length === 1)
                $(this).attr('disabled', 'disabled');
        });

        $('#del_bene').click(function () {
            $('.check').each(function () {
                if ($(this).is(':checked'))
                    $(this).closest('tr').remove();
            });
            sumBenef();
        });

        function edit(idcustomer) {
            $.ajax({
                url: "{{ url('getRegister') }}",
                method: 'get',
                data: {
                    register: idcustomer
                },
                success: function (register) {
                    $('#title').text('@lang('label.edit') ' + register.name + ' ' + register.surname);

                    $('#idregister').val(register.idregister);

                    $('#gender').val(register.gender).select2();
                    $('#name').val(register.name);
                    $('#surname').val(register.surname);
                    $('#dob').val(register.dob);
                    $('#pob').val(register.pob);
                    $('#phone1').val(register.phone1);
                    $('#phone2').val(register.phone2);
                    $('#mem_group').val(register.memgroup).select2();
                    $('#status').val(register.status).select2();
                    $('#cnpsnumb').val(register.cnpsnumb);
                    $('#profession').val(register.profession).select2();
                    $('#nic_type').val(register.nic_type).select2();
                    $('#nic').val(register.nic);
                    $('#idate').val(register.issuedate);
                    $('#issueplace').val(register.issueplace);
                    $('#email').val(register.email);
                    $('#country').val(register.country).select2();
                    $('#region').val(register.region).select2();
                    $('#regorigin').val(register.regorigin).select2();
                    $('#division').val(register.division).select2();
                    $('#subdiv').val(register.subdivision).select2();
                    $('#town').val(register.town).select2();
                    $('#address').val(register.address);
                    $('#quarter').val(register.quarter);
                    $('#witnes_name').val(register.witnes_name);
                    $('#witnes_phone').val(register.witnes_phone);
                    $('#witnes_nic').val(register.witnes_nic);

                    $('#grptype').val(register.grptype).select2();
                    $('#moral_dob').val(register.dob);
                    $('#moral_pob').val(register.pob);
                    $('#assno').val(register.assno);
                    $('#assmemno').val(register.assmemno);
                    $('#comregis').val(register.comregis);
                    $('#regime').val(register.regime);
                    $('#taxpaynumb').val(register.taxpaynumb);

                    if (register.pic !== null) {
                        $.ajax({
                            url: "{{url('getProfile')}}",
                            method: 'get',
                            data: {
                                owner: 'registers',
                                file: register.pic
                            },
                            success: function (filePath) {
                                $('#pic').attr('src', filePath);
                            }
                        });
                    }

                    if (register.signature !== null) {
                        $.ajax({
                            url: "{{url('getSignature')}}",
                            method: 'get',
                            data: {
                                owner: 'registers',
                                file: register.signature
                            },
                            success: function (filePath) {
                                $('#sign').attr('src', filePath);
                            }
                        });
                    }

                    if (register.grptype === 'A') {
                        $.ajax({
                            url: "{{url('getSignature')}}",
                            method: 'get',
                            data: {
                                owner: 'registers',
                                file: register.signature
                            },
                            success: function (filePath) {
                                $('#sign1').attr('src', filePath);
                            }
                        });

                        $.ajax({
                            url: "{{url('getSignature')}}",
                            method: 'get',
                            data: {
                                owner: 'registers',
                                file: register.sign2
                            },
                            success: function (filePath) {
                                $('#sign2').attr('src', filePath);
                            }
                        });

                        $.ajax({
                            url: "{{url('getSignature')}}",
                            method: 'get',
                            data: {
                                owner: 'registers',
                                file: register.sign3
                            },
                            success: function (filePath) {
                                $('#sign3').attr('src', filePath);
                            }
                        });
                    }

                    $.ajax({
                        url: "{{url('getRegBenef')}}",
                        method: 'get',
                        data: {
                            register: idcustomer
                        },
                        success: function (benefs) {
                            let tr = '';
                            let totrat = 0;
                            $.each(benefs, function (i, benef) {
                                tr += "<tr>" +
                                    "<td><input type='checkbox' class='check'>" +
                                    "<input type='hidden' value='" + benef.idmem_collect_bene + "' name='bene_id[]'></td>" +
                                    "<td><input type='text' value='" + benef.fullname + "' name='bene_name[]' class='reg' required></td>" +
                                    "<td><input type='text' value='" + benef.relation + "' name='bene_relate[]' class='reg' required></td>" +
                                    "<td><input type='number' value='" + benef.phone1 + "' name='bene_phone[]' class='reg' required></td>" +
                                    "<td><input type='text' value='" + benef.ratio + "' name='bene_ratio[]' class='reg bene_reg text-right text-bold' required></td>" +
                                    "</tr>";
                                i++;
                                totrat += parseInt(benef.ratio);
                            });

                            $('#bene_body').html(tr);

                            sumBenef();
                        }
                    });

                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit edit"></button>');

                    $('#form').show();
                }
            });
        }

        $(document).on('input', '.bene_reg', function () {
            sumBenef();
        });

        function sumBenef() {
            let sumBene = 0;

            $('#registerInput tbody .bene_reg').each(function () {
                if (parseInt($('.bene_reg').val())) {
                    sumBene += parseInt($(this).val());
                }
            });

            $('#rem').val(100 - parseInt(sumBene));

            if ($('#bene_body tr').length === 1) {
                $('#new_bene').attr('disabled', false);
                $('#del_bene').attr('disabled', true);
            }
            if ($('#bene_body tr').length === 2) {
                $('#new_bene').attr('disabled', true);
                $('#del_bene').attr('disabled', false);
            }
        }

        /**
         * Get the regions based on the country
         */
        $('#country').change(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('getRegions') }}",
                method: 'get',
                data: {
                    country: $('#country').val()
                },
                success: function (result) {
                    let option = "<option></option>";
                    $.each(result, function (i, region) {
                        option += "<option " +
                            "value=" + region.idregi + ">@if($emp->lang == 'fr') " + region.labelfr + " @else " + region.labeleng + " @endif</option>";
                    });
                    $('#region').html(option);
                }
            });
        });

        /**
         * Get the Divisions based on the Region
         */
        $('#region').change(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('getDivisions') }}",
                method: 'get',
                data: {
                    region: $('#region').val()
                },
                success: function (result) {
                    let option = "<option value=''></option>";
                    $.each(result, function (i, division) {
                        option += "<option value=" + division.iddiv + ">" + division.label + "</option>";
                    });
                    $('#division').html(option);
                }
            });
        });

        /**
         * Get the Sub-Divisions based on the Division
         */
        $('#division').change(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('getSubDivs') }}",
                method: 'get',
                data: {
                    division: $('#division').val()
                },
                success: function (result) {
                    let option = "<option value=''></option>";
                    $.each(result, function (i, subdiv) {
                        option += "<option value=" + subdiv.idsub + ">" + subdiv.label + "</option>";
                    });
                    $('#subdiv').html(option);
                }
            });
        });

        /**
         * Get the Towns based on the Sub Division
         */
        $('#subdiv').change(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('getTowns') }}",
                method: 'get',
                data: {
                    subdivision: $('#subdiv').val()
                },
                success: function (result) {
                    let option = "<option value=''></option>";
                    $.each(result, function (i, town) {
                        option += "<option value=" + town.idtown + ">" + town.label + "</option>";
                    });
                    $('#town').html(option);
                }
            });
        });

        function submitForm() {
            let id = parseInt($('#idregister').val());
            let text = '@lang('confirm.memreg_text')';
            let sum = 0;

            $('.bene_reg').each(function () {
                if (parseInt($(this).val()))
                    sum += parseInt($(this).val());
            });

            if (!isNaN(id)) {
                text = '@lang('confirm.memregedit_text')'
            }

            if (sum === 100) {
                mySwal("{{ $title }}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#regForm');
            } else {
                myOSwal("{{ $title }}", text, 'error');
            }
        }

        function chooseFile(label) {
            if (label === 'pic') {
                $('#inpic').click()
            } else if (label === 'sign') {
                $('#insign').click()
            }

            if (label === 'pic1') {
                $('#inpic1').click()
            } else if (label === 'entsign1') {
                $('#entinsign1').click()
            }

            if (label === 'sign1') {
                $('#insign1').click()
            }

            if (label === 'sign2') {
                $('#insign2').click()
            }

            if (label === 'sign3') {
                $('#insign3').click()
            }
        }

        $('#inpic').change(function () {
            readURL(this, 'pic');
        });
        $('#insign').change(function () {
            readURL(this, 'sign');
        });

        $('#inpic1').change(function () {
            readURL(this, 'pic1');
        });
        $('#entinsign1').change(function () {
            readURL(this, 'entsign1');
        });

        $('#insign1').change(function () {
            readURL(this, 'sign1');
        });

        $('#insign2').change(function () {
            readURL(this, 'sign2');
        });

        $('#insign3').change(function () {
            readURL(this, 'sign3');
        });

        function readURL(input, label) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    if (label === 'pic') {
                        $('#pic').attr('src', e.target.result);
                    } else if (label === 'sign') {
                        $('#sign').attr('src', e.target.result);
                    }

                    if (label === 'pic1') {
                        $('#pic1').attr('src', e.target.result);
                    } else if (label === 'entsign1') {
                        $('#entsign1').attr('src', e.target.result);
                    }

                    if (label === 'sign1') {
                        $('#sign1').attr('src', e.target.result);
                    }

                    if (label === 'sign2') {
                        $('#sign2').attr('src', e.target.result);
                    }

                    if (label === 'sign3') {
                        $('#sign3').attr('src', e.target.result);
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@stop
