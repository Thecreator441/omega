<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Adjustement Journée Comptable';
else
    $title = 'Accounting Day Adjustment';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    <div class="box">
        <div class="box-body">
            <form action="{{ url('acc_day_adj/store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date" class="col-md-4 control-label">@if($emp->lang == 'fr')
                                    Date Comptable @else Accounting Date @endif</label>
                            <div class="col-md-8">
                                <input type="text" name="date" id="date" class="form-control">
                            </div>
                        </div>
                    </div>



                </div>

                <div class="col-md-12">
                    <button type="submit" id="edit" class="btn btn-sm bg-blue pull-right btn-raised">
                        <i class="fa fa-edit"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
