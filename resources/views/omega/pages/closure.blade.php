<?php $emp = session()->get('employee');

if ($emp->lang == 'fr')
    $title = 'Clôture';
else
    $title = 'Closure';
?>

@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    {{--    <div class="box">--}}
    <form action="{{ url('account/closure/store') }}" method="POST" role="form">
        {{ csrf_field() }}
        <div class="callout callout-info">
            <div class="row">
                <i class="fa fa-info"></i>
                <p>@if($emp->lang == 'fr') VOUS ÊTES À LA CLÔTURE DE L'ANNÉE. VOULEZ-VOUS CONTINUER? @else YOU ARE
                    AT THE CLOSURE OF THE YEAR. DO YOU WANT TO CONTINUO ? @endif</p>
            </div>

            <div class="row">
                <button type="submit" name="save" id="save"
                        class="btn btn-success bg-blue pull-right btn-raised"><i
                        class="fa fa-save"></i>&nbsp; @if ($emp->lang == 'fr') ENREGISTRER @else
                        SAVE @endif
                </button>
            </div>

        </div>
    </form>
    {{--    </div>--}}

@stop
