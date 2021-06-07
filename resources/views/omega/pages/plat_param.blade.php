<?php
$emp = Session::get('employee');

if ($emp->lang == 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.plat_param'))

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-bold"> @lang('sidebar.plat_param') </h3>
        </div>
        <div class="box-body">
            <form action="{{ url('admin/plat_param/store') }}" method="post" role="form" id="cinForm" class="needs-validation">
                {{ csrf_field() }}

                @if($param === null)
                  <input type="hidden" name="idparam" id="idparam" value="">

                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <div class="form-group has-error">
                              <label for="slogan" class="col-md-3 control-label">@lang('label.slogan')<span class="text-red text-bold">*</span> </label>
                              <div class="col-md-9">
                                  <input type="text" id="slogan" name="slogan" class="form-control">
                                  <span class="help-block">@lang('placeholder.slogan')</span>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-6">
                          <div class="form-group has-error">
                              <label for="tax_rate" class="col-md-6 control-label">@lang('label.tax_rate')<span class="text-red text-bold">*</span> </label>
                              <div class="col-md-6">
                                  <input type="text" id="tax_rate" name="tax_rate" class="form-control text-right text-bold">
                                  <span class="help-block">@lang('placeholder.tax_rate')</span>
                              </div>
                          </div>
                      </div>
                    {{--</div>--}}
                    
                    {{--<div class="row">--}}
                      <div class="col-md-4 col-sm-4 col-xs-6">
                          <div class="form-group has-error">
                              <label for="login_attempt" class="col-md-6 control-label">@lang('label.login_attempt')<span class="text-red text-bold">*</span> </label>
                              <div class="col-md-6">
                                  <input type="text" id="login_attempt" name="login_attempt" class="form-control text-right text-bold">
                                  <span class="help-block">@lang('placeholder.login_attempt')</span>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-6">
                          <div class="form-group has-error">
                              <label for="block_duration" class="col-md-6 control-label">@lang('label.block_duration')<span class="text-red text-bold">*</span> </label>
                              <div class="col-md-6">
                                  <input type="text" id="block_duration" name="block_duration" class="form-control text-right text-bold">
                                  <span class="help-block">@lang('placeholder.block_duration')</span>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-6">
                          <div class="form-group has-error">
                              <label for="inactive_duration" class="col-md-6 control-label">@lang('label.inactive_duration')<span class="text-red text-bold">*</span> </label>
                              <div class="col-md-6">
                                  <input type="text" id="inactive_duration" name="inactive_duration" class="form-control text-right text-bold">
                                  <span class="help-block">@lang('placeholder.inactive_duration')</span>
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
                @else
                    <input type="hidden" name="idparam" id="idparam" value="{{$param->id_plat_param}}">

                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <div class="form-group has-error">
                              <label for="slogan" class="col-md-3 control-label">@lang('label.slogan')<span class="text-red text-bold">*</span> </label>
                              <div class="col-md-9">
                                  <input type="text" id="slogan" name="slogan" class="form-control" value="{{$param->slogan}}">
                                  <span class="help-block">@lang('placeholder.slogan')</span>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-6">
                          <div class="form-group has-error">
                              <label for="tax_rate" class="col-md-6 control-label">@lang('label.tax_rate')<span class="text-red text-bold">*</span> </label>
                              <div class="col-md-6">
                                  <input type="text" id="tax_rate" name="tax_rate" class="form-control text-right text-bold" value="{{$param->tax_rate}}">
                                  <span class="help-block">@lang('placeholder.tax_rate')</span>
                              </div>
                          </div>
                      </div>
                    {{--</div>--}}
                    
                    {{--<div class="row">--}}
                      <div class="col-md-4 col-sm-4 col-xs-6">
                          <div class="form-group has-error">
                              <label for="login_attempt" class="col-md-6 control-label">@lang('label.login_attempt')<span class="text-red text-bold">*</span> </label>
                              <div class="col-md-6">
                                  <input type="text" id="login_attempt" name="login_attempt" class="form-control text-right text-bold" value="{{$param->login_attempt}}">
                                  <span class="help-block">@lang('placeholder.login_attempt')</span>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-6">
                          <div class="form-group has-error">
                              <label for="block_duration" class="col-md-6 control-label">@lang('label.block_duration')<span class="text-red text-bold">*</span> </label>
                              <div class="col-md-6">
                                  <input type="text" id="block_duration" name="block_duration" class="form-control text-right text-bold" value="{{$param->block_duration}}">
                                  <span class="help-block">@lang('placeholder.block_duration')</span>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-6">
                          <div class="form-group has-error">
                              <label for="inactive_duration" class="col-md-6 control-label">@lang('label.inactive_duration')<span class="text-red text-bold">*</span> </label>
                              <div class="col-md-6">
                                  <input type="text" id="inactive_duration" name="inactive_duration" class="form-control text-right text-bold" value="{{$param->inactive_duration}}">
                                  <span class="help-block">@lang('placeholder.inactive_duration')</span>
                              </div>
                          </div>
                      </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <button type="submit" id="edit" class="btn btn-sm bg-aqua pull-right btn-raised fa fa-edit"></button>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        function submitForm() {
            let text = '@lang('confirm.plat_param_save_text')';
            if ($('#idparam').val() !== '') {
                text = '@lang('confirm.plat_param_edit_text')';
            }

            mySwal('@lang('sidebar.plat_param')', text, '@lang('confirm.no')', '@lang('confirm.yes')', '#cinForm');
        }
    </script>
@stop
