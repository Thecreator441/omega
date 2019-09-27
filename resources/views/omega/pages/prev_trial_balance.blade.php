<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Balance Général';
else
    $title = 'Trial Balance';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('trial_balance/store') }}" method="POST" role="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-2"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="opening_bal">@if($emp->lang == 'fr') Ouverture Solde @else Opening Balance @endif
                                    <input type="radio" name="columns" id="opening_bal">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="radio">
                                <label for="4columns">@if($emp->lang == 'fr') Quatre Colons @else Four Columns @endif
                                    <input type="radio" name="columns" id="4columns">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="radio">
                                <label for="6columns">@if($emp->lang == 'fr') Six Colons @else Six Columns @endif
                                    <input type="radio" name="columns" id="6columns">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="date1" class="col-md-2 control-label">Date</label>
                            <div class="col-md-10">
                                <input type="text" name="date1" id="date1" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="acc_from" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                    Compte @else Account @endif</label>
                            <div class="col-md-10">
                                <select type="text" name="acc1" id="acc1" class="form-control select2">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="date2" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                    Au @else To @endif</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="acc2" class="col-md-2 control-label">@if($emp->lang == 'fr')
                                    Au @else To @endif</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="date2" id="date2" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <select type="text" name="acc2" id="acc2" class="form-control select2">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" name="save" id="save" class="btn btn-success bg-blue pull-right btn-raised">
                        <i class="fa fa-save"></i>&nbsp;@if ($emp->lang == 'fr') SAUVEGARDER @else BACKUP @endif
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop
