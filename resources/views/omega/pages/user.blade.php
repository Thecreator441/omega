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
            <h3 class="box-title text-bold"> @lang('label.newuser')</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-alert bg-red btn-sm pull-right" id="exitForm">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ route('user/store') }}" method="post" role="form" id="instForm" class="needs-validation" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div id="fillform">
                    <input type="hidden" name="idinstitute" id="idinstitute">
                    <input type="hidden" name="idemp" id="idemp">

                    <div class="row">
                        <div class="col-md-8">
                          <div class="row">
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  <div class="form-group has-error">
                                      <label for="name" class="col-md-4 control-label">@lang('label.name')<span class="text-red text-bold">*</span></label>
                                      <div class="col-md-8">
                                          <input type="text" class="form-control" name="name" id="name" required>
                                          <span class="help-block">@lang('placeholder.name')</span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  <div class="form-group has-error">
                                      <label for="surname" class="col-md-4 control-label">@lang('label.surname')<span class="text-red text-bold">*</span></label>
                                      <div class="col-md-8">
                                          <input type="text" class="form-control" name="surname" id="surname" required>
                                          <span class="help-block">@lang('placeholder.surname')</span>
                                      </div>
                                  </div>
                              </div>
                          </div>

                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="form-group has-error">
                                        <label for="date" class="col-md-2 col-sm-2 col-xs-5 control-label">@lang('label.dob')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-3 col-sm-3 col-xs-7">
                                            <input type="date" class="form-control" name="dob" id="date" required>
                                            <span class="help-block">@lang('placeholder.dob')</span>
                                        </div>
                                        <label for="pob" class="col-md-1 col-sm-1 col-xs-3 control-label">@lang('label.at')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-9">
                                            <input type="text" class="form-control" name="pob" id="pob" required>
                                            <span class="help-block">@lang('placeholder.pob')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group has-error">
                                        <label for="status" class="col-md-4 control-label">@lang('label.marstatus')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" id="status" name="status" required>
                                                <option value=""></option>
                                                <option value="S" selected>@lang('label.single')</option>
                                                <option value="M">@lang('label.married')</option>
                                                <option value="D">@lang('label.divorced')</option>
                                                <option value="W">@lang('label.widow')</option>
                                                <option value="O">@lang('label.others')</option>
                                            </select>
                                            <span class="help-block">@lang('placeholder.status')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group has-error">
                                        <label for="gender" class="col-md-4 control-label">@lang('label.gender')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <select name="gender" id="gender" class="form-control select2" required>
                                                <option value=""></option>
                                                <option value="M" selected>@lang('label.male')</option>
                                                <option value="F">@lang('label.female')</option>
                                            </select>
                                            <span class="help-block">@lang('placeholder.gender')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-5">
                                    <div class="form-group has-error">
                                        <label for="nic_type" class="col-md-4 control-label">@lang('label.idtype')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <select name="nic_type" id="nic_type" class="form-control select2" required>
                                                <option value=""></option>
                                                <option value="C" selected>@lang('label.idcard')</option>
                                                <option value="P">@lang('label.passport')</option>
                                            </select>
                                            <span class="help-block">@lang('placeholder.idtype')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-7">
                                    <div class="form-group has-error">
                                        <label for="nic" class="col-md-4 control-label">@lang('label.idnumb')<span class="text-red text-bold">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="nic" id="nic" required>
                                            <span class="help-block">@lang('placeholder.nic')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-6 col-xs-6">
                                <div class="form-group has-error" style="height: 100px; width: 100%; border: 1px solid grey">
                                    <a><img id="pic" onclick="chooseFile('pic')" src="" alt="@lang('placeholder.uppic')" style="height: 100px; width: 100%;"/></a>
                                    <div style="height: 0; overflow: hidden">
                                        <input type="file" name="profile" accept='image/*' id="inpic"/>
                                        <span class="help-block">@lang('placeholder.uppic')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-6 col-xs-6">
                                <div class="form-group has-error" style="height: 100px; width: 100%; border: 1px solid grey">
                                    <a><img id="sign" onclick="chooseFile('sign')" src="" alt="@lang('placeholder.upsign')" style="height: 100px; width: 100%;"/></a>
                                    <div style="height: 0; overflow: hidden">
                                        <input type="file" name="signature" accept='image/*' id="insign"/>
                                        <span class="help-block">@lang('placeholder.upsign')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-7">
                            <div class="form-group has-error">
                                <label for="idate" class="col-md-4 control-label">@lang('label.deliver')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control" name="issuedate" id="idate" required>
                                    <span class="help-block">@lang('placeholder.issuedate')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-5">
                            <div class="form-group has-error">
                                <label for="issueplace" class="col-md-4 control-label">@lang('label.at')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="issueplace" id="issueplace" required>
                                    <span class="help-block">@lang('placeholder.issueplace')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="post" class="col-md-4 control-label">@lang('label.post')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="post" name="post">
                                    <span class="help-block">@lang('placeholder.post')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="phone1" class="col-md-4 control-label">@lang('label.phone')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="phone1" id="phone1" min="0" required>
                                    <span class="help-block">@lang('placeholder.phone')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group">
                                <label for="phone2" class="col-md-4 control-label">@lang('label.fax')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="phone2" id="phone2" min="0">
                                    <span class="help-block">@lang('placeholder.fax')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group has-error">
                                <label for="email" class="col-md-4 control-label">@lang('label.@')</label>
                                <div class="col-md-8">
                                    <input type="email" class="form-control" name="email" id="email">
                                    <span class="help-block">@lang('placeholder.@')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="country" class="col-md-4 control-label">@lang('label.country')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="country" name="country" required>
                                        <option></option>
                                        @foreach($countries as $country)
                                            @if($country->idcountry === $emp->country)
                                                <option value="{{ $country->idcountry }}" selected>@if($emp->lang == 'fr') {{ $country->labelfr }} @else {{ $country->labeleng }} @endif</option>
                                            @else
                                                <option value="{{ $country->idcountry }}">@if($emp->lang == 'fr') {{ $country->labelfr }} @else {{ $country->labeleng }} @endif</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.country')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
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
                        <div class="col-md-4 col-sm-4 col-xs-12">
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
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="quarter" class="col-md-4 control-label">@lang('label.quarter')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="quarter" name="quarter" required>
                                    <span class="help-block">@lang('placeholder.quarter')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="address" class="col-md-4 control-label">@lang('label.address')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="address" name="address" required>
                                    <span class="help-block">@lang('placeholder.address')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="username" class="col-md-4 control-label">@lang('label.username')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="username" id="username" required>
                                    <span class="help-block">@lang('placeholder.username')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group has-error">
                                <label for="privilege" class="col-md-4 control-label">@lang('label.privilege')<span class="text-red text-bold">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control select2" id="privilege" name="privilege" required>
                                        <option value=""></option>
                                        @foreach($privileges as $privilege)
                                            @switch($emp->level)
                                                @case ('N')
                                                    @if ($privilege->level === 'N')
                                                        <option value="{{ $privilege->idpriv }}">{{pad($privilege->code, 3)}} :
                                                            @if ($emp->lang === 'fr') {{$privilege->labelfr}} @else {{$privilege->labeleng}} @endif 
                                                        </option>
                                                    @endif
                                                @break
                                                @case ('Z')
                                                    @if ($privilege->level === 'Z')
                                                        <option value="{{ $privilege->idpriv }}">{{pad($privilege->code, 3)}} :
                                                            @if ($emp->lang === 'fr') {{$privilege->labelfr}} @else {{$privilege->labeleng}} @endif 
                                                        </option>
                                                    @endif
                                                @break
                                                @case ('I')
                                                    @if ($privilege->level === 'I')
                                                        <option value="{{ $privilege->idpriv }}">{{pad($privilege->code, 3)}} :
                                                            @if ($emp->lang === 'fr') {{$privilege->labelfr}} @else {{$privilege->labeleng}} @endif
                                                        </option>
                                                    @endif
                                                @break
                                                @case ('B')
                                                    @if ($privilege->level === 'B')
                                                        <option value="{{ $privilege->idpriv }}">{{pad($privilege->code, 3)}} :
                                                            @if ($emp->lang === 'fr') {{$privilege->labelfr}} @else {{$privilege->labeleng}} @endif
                                                        </option>
                                                    @endif
                                                @break
                                                @default
                                                    <option value="{{ $privilege->idpriv }}">{{pad($privilege->code, 3)}} :
                                                        @if ($emp->lang === 'fr') {{$privilege->labelfr}} @else {{$privilege->labeleng}} @endif 
                                                        @if ($privilege->level === 'O')
                                                            - @lang('label.organ')
                                                        @elseif ($privilege->level === 'N')
                                                            - @lang('label.network')  
                                                        @elseif ($privilege->level === 'Z')
                                                            - @lang('label.zone')
                                                        @elseif ($privilege->level === 'I')
                                                            - @lang('label.institution')
                                                        @elseif ($privilege->level === 'B')
                                                            - @lang('label.branch')
                                                        @else
                                                            - @lang('label.platform')
                                                        @endif
                                                    </option>
                                                @break
                                            @endswitch
                                        @endforeach
                                    </select>
                                    <span class="help-block">@lang('placeholder.privilege')</span>
                                </div>
                            </div>
                        </div>
                      
                        @if($emp->level === 'P')
                            <div class="col-md-4 col-sm-4 col-xs-6" id="reseau" style="display: none">
                                <div class="form-group">
                                    <label for="network" class="col-md-4 control-label">@lang('label.network')</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" id="network" name="network">
                                            <option value=""></option>
                                            @foreach ($networks as $network)
                                                <option value="{{$network->idnetwork}}">{{$network->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">@lang('placeholder.network')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-6" id="zonne" style="display: none">
                                <div class="form-group">
                                    <label for="zone" class="col-md-4 control-label">@lang('label.zone')</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" id="zone" name="zone">
                                            <option value=""></option>
                                            @foreach ($zones as $zone)
                                                <option value="{{$zone->idzone}}">{{$zone->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">@lang('placeholder.zone')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-6" id="institut" style="display: none">
                                <div class="form-group">
                                    <label for="institution" class="col-md-4 control-label">@lang('label.institution')</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" id="institution" name="institution">
                                            <option value=""></option>
                                            @foreach ($institutions as $institution)
                                                <option value="{{$institution->idinst}}">{{$institution->abbr}}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">@lang('placeholder.institution')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-6" id="agence" style="display: none">
                                <div class="form-group">
                                    <label for="branch" class="col-md-4 control-label">@lang('label.branch')</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" id="branch" name="branch">
                                            <option value=""></option>
                                            @foreach ($branches as $branch)
                                                <option value="{{$branch->idbranch}}">{{$branch->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">@lang('placeholder.branch')</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">{{$title}}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-success bg-green btn-sm pull-right" id="newInst">
                    <i class="fa fa-plus"></i>&nbsp;@lang('label.newuser')
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="admin-data-table" class="table table-bordered table-striped table-hover table-responsive-xl">
                    <thead>
                    <tr>
                        <th> @lang('label.username') </th>
                        <th> @lang('label.@') </th>
                        <th> @lang('label.privilege') </th>
                        <th> @lang('label.level') </th>
                        <th> @lang('label.status') </th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            @switch($emp->level)
                                @case ('O')
                                        @if ($user->level === 'O')
                                            <tr>
                                                <td>{{$user->username}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>@if ($emp->lang === 'fr') {{$user->labelfr}} @else {{$user->labeleng}} @endif</td>
                                                <td>@lang('label.organ')</td>
                                                <td class="text-center">
                                                    <span class="badge @if ($user->login_status === 'B') bg-red @else bg-green @endif">@if ($user->login_status === 'B') @lang('label.blocked') @else @lang('label.freed') @endif</span>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm @if ($user->login_status === 'B') bg-green fa fa-check @else bg-red fa fa-close @endif"
                                                            onclick="blun('{{$user->iduser}}', '{{$user->login_status}}')"></button>
                                                    <button type="button" class="btn btn-sm bg-yellow fa fa-refresh" onclick="reset('{{$user->iduser}}')"></button>
                                                    <button type="button" class="btn btn-sm bg-aqua fa fa-edit" onclick="edit('{{$user->iduser}}')"></button>
                                                    <button type="button" class="btn btn-sm bg-red fa fa-trash" onclick="remove('{{$user->iduser}}')"></button>
                                                </td>
                                            </tr>
                                        @endif
                                    @break
                                @case ('N')
                                    @if ($user->level === 'N')
                                        <tr>
                                            <td>{{$user->username}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>@if ($emp->lang === 'fr') {{$user->labelfr}} @else {{$user->labeleng}} @endif</td>
                                            <td>@lang('label.network')</td>
                                            <td class="text-center">
                                                <span class="badge @if ($user->login_status === 'B') bg-red @else bg-green @endif">@if ($user->login_status === 'B') @lang('label.blocked') @else @lang('label.freed') @endif</span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm @if ($user->login_status === 'B') bg-green fa fa-check @else bg-red fa fa-close @endif"
                                                        onclick="blun('{{$user->iduser}}', '{{$user->login_status}}')"></button>
                                                <button type="button" class="btn btn-sm bg-yellow fa fa-refresh" onclick="reset('{{$user->iduser}}')"></button>
                                                <button type="button" class="btn btn-sm bg-aqua fa fa-edit" onclick="edit('{{$user->iduser}}')"></button>
                                                <button type="button" class="btn btn-sm bg-red fa fa-trash" onclick="remove('{{$user->iduser}}')"></button>
                                            </td>
                                        </tr>
                                    @endif
                                @break
                                @case ('Z')
                                    @if ($user->level === 'Z')
                                        <tr>
                                            <td>{{$user->username}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>@if ($emp->lang === 'fr') {{$user->labelfr}} @else {{$user->labeleng}} @endif</td>
                                            <td>@lang('label.zone')</td>
                                            <td class="text-center">
                                                <span class="badge @if ($user->login_status === 'B') bg-red @else bg-green @endif">@if ($user->login_status === 'B') @lang('label.blocked') @else @lang('label.freed') @endif</span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm @if ($user->login_status === 'B') bg-green fa fa-check @else bg-red fa fa-close @endif"
                                                        onclick="blun('{{$user->iduser}}', '{{$user->login_status}}')"></button>
                                                <button type="button" class="btn btn-sm bg-yellow fa fa-refresh" onclick="reset('{{$user->iduser}}')"></button>
                                                <button type="button" class="btn btn-sm bg-aqua fa fa-edit" onclick="edit('{{$user->iduser}}')"></button>
                                                <button type="button" class="btn btn-sm bg-red fa fa-trash" onclick="remove('{{$user->iduser}}')"></button>
                                            </td>
                                        </tr>
                                    @endif
                                @break
                                @case ('I')
                                    @if ($user->level === 'I')
                                        <tr>
                                            <td>{{$user->username}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>@if ($emp->lang === 'fr') {{$user->labelfr}} @else {{$user->labeleng}} @endif</td>
                                            <td>@lang('label.institution')</td>
                                            <td class="text-center">
                                                <span class="badge @if ($user->login_status === 'B') bg-red @else bg-green @endif">@if ($user->login_status === 'B') @lang('label.blocked') @else @lang('label.freed') @endif</span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm @if ($user->login_status === 'B') bg-green fa fa-check @else bg-red fa fa-close @endif"
                                                        onclick="blun('{{$user->iduser}}', '{{$user->login_status}}')"></button>
                                                <button type="button" class="btn btn-sm bg-yellow fa fa-refresh" onclick="reset('{{$user->iduser}}')"></button>
                                                <button type="button" class="btn btn-sm bg-aqua fa fa-edit" onclick="edit('{{$user->iduser}}')"></button>
                                                <button type="button" class="btn btn-sm bg-red fa fa-trash" onclick="remove('{{$user->iduser}}')"></button>
                                            </td>
                                        </tr>
                                    @endif
                                @break
                                @case ('B')
                                    @if ($user->level === 'B')
                                        <tr>
                                            <td>{{$user->username}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>@if ($emp->lang === 'fr') {{$user->labelfr}} @else {{$user->labeleng}} @endif</td>
                                            <td>@lang('label.branch')</td>
                                            <td class="text-center">
                                                <span class="badge @if ($user->login_status === 'B') bg-red @else bg-green @endif">@if ($user->login_status === 'B') @lang('label.blocked') @else @lang('label.freed') @endif</span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm @if ($user->login_status === 'B') bg-green fa fa-check @else bg-red fa fa-close @endif"
                                                        onclick="blun('{{$user->iduser}}', '{{$user->login_status}}')"></button>
                                                <button type="button" class="btn btn-sm bg-yellow fa fa-refresh" onclick="reset('{{$user->iduser}}')"></button>
                                                <button type="button" class="btn btn-sm bg-aqua fa fa-edit" onclick="edit('{{$user->iduser}}')"></button>
                                                <button type="button" class="btn btn-sm bg-red fa fa-trash" onclick="remove('{{$user->iduser}}')"></button>
                                            </td>
                                        </tr>
                                    @endif
                                @break
                                @default
                                    <tr>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>@if ($emp->lang === 'fr') {{$user->labelfr}} @else {{$user->labeleng}} @endif</td>
                                        <td>
                                            @if ($user->level === 'O')
                                                @lang('label.organ')  
                                            @elseif ($user->level === 'N')
                                                @lang('label.network')  
                                            @elseif ($user->level === 'Z')
                                                @lang('label.zone')
                                            @elseif ($user->level === 'I')
                                                @lang('label.institution')
                                            @elseif ($user->level === 'B')
                                                @lang('label.branch')
                                            @else
                                                @lang('label.platform')
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge @if ($user->login_status === 'B') bg-red @else bg-green @endif">@if ($user->login_status === 'B') @lang('label.blocked') @else @lang('label.free') @endif</span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm @if ($user->login_status === 'B') bg-green fa fa-check @else bg-red fa fa-close @endif"
                                                    onclick="blun('{{$user->iduser}}', '{{$user->login_status}}')"></button>
                                            <button type="button" class="btn btn-sm bg-yellow fa fa-refresh" onclick="reset('{{$user->iduser}}')"></button>
                                            <?php $disabled = ($emp->level !== $user->level) ? "disabled" : null; ?>
                                            <button type="button" class="btn btn-sm bg-aqua fa fa-edit" onclick="edit('{{$user->iduser}}')" ></button>
                                            <button type="button" class="btn btn-sm bg-red fa fa-trash" onclick="remove('{{$user->iduser}}')" ></button>
                                        </td>
                                    </tr>
                                @break
                            @endswitch
                        @endforeach
                    </tbody>
                </table>
                <form action="{{route('user/reset')}}" method="post" role="form" id="resForm" style="display: none">
                    {{ csrf_field() }}
                    <input type="hidden" name="userRes" id="userRes" value="">
                </form>
                <form action="{{route('user/delete')}}" method="post" role="form" id="delForm" style="display: none">
                    {{ csrf_field() }}
                    <input type="hidden" name="institute" id="institute" value="">
                </form>
                <form action="{{route('user/blun')}}" method="post" role="form" id="blunForm" style="display: none">
                    {{ csrf_field() }}
                    <input type="hidden" name="userBlun" id="userBlun" value="">
                </form>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('#newInst').click(function () {
            in_out_form();
            $('#form').show();
        });

        function reset(iduser) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.userres_text')',
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
                    $('#userRes').val(iduser);
                    $('#resForm').submit();
                }
            });
        }

        function blun(iduser, login_status) {
            let text = '@lang('confirm.userblock_text')';
            if (login_status === 'B') {
                text = '@lang('confirm.userfree_text')';
            }

            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: text,
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
                    $('#userBlun').val(iduser);
                    $('#blunForm').submit();
                }
            });
        }

        function edit(iduser) {
            $.ajax({
                url: "{{ url('getUserInfos') }}",
                method: 'get',
                data: {
                    id: iduser
                },
                success: function (user) {
                    $('#title').text('@lang('label.edit') ' + user.username);

                    $('#idinstitute').val(user.iduser);
                    $('#idemp').val(user.idemp);
                    $('#name').val(user.name);
                    $('#surname').val(user.surname);
                    $('#username').val(user.username);
                    $('#status').val(user.status).select2();
                    $('#gender').val(user.gender).select2();
                    $('#date').val(user.dob);
                    $('#pob').val(user.pob);
                    $('#post').val(user.post);
                    $('#phone1').val(user.phone1);
                    $('#phone2').val(user.phone2);
                    $('#email').val(user.email);
                    $('#nic_type').val(user.nic_type).select2();
                    $('#nic').val(user.nic);
                    $('#idate').val(user.issuedate);
                    $('#issueplace').val(user.issueplace);
                    $('#country').val(user.country).select2();
                    $('#region').val(user.region).select2();
                    $('#regorigin').val(user.regorigin).select2();
                    $('#division').val(user.division).select2();
                    $('#subdiv').val(user.subdivision).select2();
                    $('#town').val(user.town).select2();
                    $('#privilege').val(user.privilege).select2();
                    $('#address').val(user.address);
                    $('#quarter').val(user.quarter);

                    $.ajax({
                        url: "{{ url('getPrivilege') }}",
                        method: 'get',
                        data: {
                            priv: user.privilege
                        },
                        success: function (result) {
                            if ("{{$emp->level}}" === "P") {
                                switch (result.level) {
                                    case 'N':
                                        $('#reseau').show();
                                        $('#network').val(user.network).select2();
                                        $('#zonne').hide();
                                        $('#institut').hide();
                                        $('#agence').hide();
                                        break;
                                    case 'Z':
                                        $('#reseau').show();
                                        $('#network').val(user.network).select2();
                                        $('#zonne').show();
                                        $('#zone').val(user.zone).select2();
                                        $('#institut').hide();
                                        $('#agence').hide();
                                        break;
                                    case 'I':
                                        $('#reseau').show();
                                        $('#network').val(user.network).select2();
                                        $('#zonne').show();
                                        $('#zone').val(user.zone).select2();
                                        $('#institut').show();
                                        $('#institution').val(user.institution).select2();
                                        $('#agence').hide();
                                        break;
                                    case 'B':
                                        $('#reseau').show();
                                        $('#network').val(user.network).select2();
                                        $('#zonne').show();
                                        $('#zone').val(user.zone).select2();
                                        $('#institut').show();
                                        $('#institution').val(user.institution).select2();
                                        $('#agence').show();
                                        $('#branch').val(user.branch).select2();
                                        break;
                                    default:
                                        $('#idemp').val(user.idplat);
                                        break;
                                }
                            }
                        }
                    });

                    let imgOwner = 'platform';
                    if (user.level !== 'P') {
                        imgOwner = 'employee';
                    }
                    
                    if(user.pic !== null) {
                        $.ajax({
                            url: "{{url('getProfile')}}",
                            method: 'get',
                            data: {
                                owner: imgOwner,
                                file: user.pic
                            },
                            success: function (filePath) {
                                $('#pic').attr('src', filePath);
                            }
                        });
                    }

                    if(user.signature) {
                        $.ajax({
                            url: "{{url('getSignature')}}",
                            method: 'get',
                            data: {
                                owner: imgOwner,
                                file: user.signature
                            },
                            success: function (filePath) {
                                $('#sign').attr('src', filePath);
                            }
                        });
                    }

                    $('#save').replaceWith('<button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit edit"></button>');

                    $('#form').show();
                }
            });
        }

        function remove(iduser) {
            swal({
                icon: 'warning',
                title: "{{$title}}",
                text: '@lang('confirm.userdel_text')',
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
                    $('#institute').val(iduser);
                    $('#delForm').submit();
                }
            });
        }

        $('#exitForm').click(function () {
            $('#form').hide();
            in_out_form();
        });

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

        $('#privilege').change(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('getPrivilege') }}",
                method: 'get',
                data: {
                    priv: $('#privilege').val()
                },
                success: function (result) {
                    switch (result.level) {
                        case 'N':
                            $('#reseau').show();
                            $('#zonne').hide();
                            $('#institut').hide();
                            $('#agence').hide();
                            break;
                        case 'Z':
                            $('#reseau').show();
                            $('#zonne').show();
                            $('#institut').hide();
                            $('#agence').hide();
                            break;
                        case 'I':
                            $('#reseau').show();
                            $('#zonne').show();
                            $('#institut').show();
                            $('#agence').hide();
                            break;
                        case 'B':
                            $('#reseau').show();
                            $('#zonne').show();
                            $('#institut').show();
                            $('#agence').show();
                            break;
                        default:
                            $('#reseau').hide();
                            $('#zonne').hide();
                            $('#institut').hide();
                            $('#agence').hide();
                            break;
                    }
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
                    let option = "<option></option>";
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
                    let option = "<option></option>";
                    $.each(result, function (i, subdiv) {
                        option += "<option value=" + subdiv.idsub + ">" + subdiv.label + "</option>";
                        $('#subdiv').html(option);
                    });
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
                    let option = "<option></option>";
                    $.each(result, function (i, town) {
                        option += "<option value=" + town.idtown + ">" + town.label + "</option>";
                        $('#town').html(option);
                    });
                }
            });
        });

        /**
         * Get the Towns based on the Sub Division
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
                        option += "<option value=" + zone.idzone + ">" + zone.name + "</option>";
                        $('#zone').html(option);
                    });
                }
            });
        });

        function submitForm() {
            let text = '@lang('confirm.usersave_text')';
            if ($('#idinstitute').val() !== '') {
                text = '@lang('confirm.useredit_text')';
            }

            mySwal("{{$title}}", text, '@lang('confirm.no')', '@lang('confirm.yes')', '#instForm');
        }

        function chooseFile(label) {
            if (label === 'pic') {
                $('#inpic').click()
            } else if (label === 'sign') {
                $('#insign').click()
            }
        }

        $('#inpic').change(function () {
            readURL(this, 'pic');
        });
        $('#insign').change(function () {
            readURL(this, 'sign');
        });
        
        $(document).on('input', '.amount', function () {
            $(this).val(money($(this).val()));
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
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function in_out_form() {
            $('#title').text('@lang('label.newuser')');
            $('#idinstitute').val('');
            $('#fillform :input').val('');
            $('#pic, #sign').attr('src', '');
            $('.select2').val('').select2();
            $('#institut').hide();
            $('#agence').hide();
            $('.edit').replaceWith('<button type="submit" id="save" class="btn btn-sm bg-blue pull-right btn-raised fa fa-save"></button>');
        }
    </script>
@stop
