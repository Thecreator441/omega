<?php
$lang = Session::get('lang');
$backURL = null;

if (isset($backURI))
    $backURL = $backURI;

if ($lang === 'fr')
    App::setLocale('fr')
?>

@extends('layouts.default')

@section('title', trans('sidebar.login'))

@section('content')
    <div id="wrapper" style="margin-top: 129px;">
        <div class="login-box-body">
            <img src="{{ asset('images/loginLogo.png') }}" class="avatar" alt="logo">
            <h1 style="margin-top: 75px;" id="headText">OMEGA</h1>
            <form action="{{url('login')}}" method="POST" role="form">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12">
                            @if ($message = Session::get('danger'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h4><i class="icon fa fa-warning"></i>@lang('label.alert')</h4>
                                    {{ $message }}
                                </div>
                            @endif
                            @if (Session::get('errors'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h4><i class="icon fa fa-warning"></i>@lang('label.alert')</h4>
                                    @error('name')
                                    {{$message}}
                                    @enderror
                                    <br>
                                    @error('password')
                                    {{$message}}
                                    @enderror
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <div class="form-group @error('name') has-error @enderror">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" name="name" id="name"
                                       placeholder="@lang('label.name')" required>
                                <i class="fa fa-user form-control-feedback"></i>
                                @error('name')<span class="invalid-feedback text-red" id="name_text"
                                                    role="alert"></span>@enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group @error('password') has-error @enderror">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" id="password" placeholder="@lang('label.password')"
                                       autocomplete="off" required>
                                <i class="fa fa-key form-control-feedback"></i>
                                @error('password')<span class="invalid-feedback text-red" id="password_text"
                                                        role="alert"></span>@enderror
                            </div>
                        </div>

                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control select2" id="lang" name="lang">
                                    <option id="eng" value="eng" @if($lang=='eng') selected @endif> @lang('label.eng')</option>
                                    <option id="fr" value="fr" @if($lang=='fr') selected @endif> @lang('label.fr')</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="device_type" id="device_type">
                        <input type="hidden" name="device_name" id="device_name">
                        <input type="hidden" name="device_version" id="device_version">
                        <input type="hidden" name="device_model" id="device_model">
                        <input type="hidden" name="time" id="time">
                        <input type="hidden" name="backURL" value="{{ $backURL }}">

                        <div class="col-md-12">
                            <button type="submit" id="login" class="btn btn-primary bg-blue-gradient btn-raised pull-right">
                                <i class="fa fa-sign-in"></i>&nbsp; 
                                <span id="loginText">
                                    @if ($backURL === null)
                                        @lang('label.login')
                                    @else
                                        @lang('label.reconnect')
                                    @endif
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            let parser = new UAParser();
            let dev_type = '';
            let dev_model = '';
            let dev_name = parser.getOS().name;
            let dev_version = parser.getOS().version;

            if (parser.getDevice().type === 'tablet' || parser.getDevice().type === 'mobile') {
                dev_type = parser.getDevice().type.toString().substring(0, 1).toUpperCase();
                dev_model = parser.getDevice().model;
            } else {
                dev_type = 'C';
                dev_model = parser.getCPU().architecture;
            }

            $('#device_type').val(dev_type);
            $('#device_model').val(dev_model);
            $('#device_name').val(dev_name);
            $('#device_version').val(dev_version);

            let time_off_mins = new Date().getTimezoneOffset();
            time_off_mins = time_off_mins == 0 ? 0 : -time_off_mins;

            $('#time').val(time_off_mins);

        //    console.log(parser.getResult());
        //    console.log(time_off_mins);

            $('form').attr('autocomplete', 'off');

            $('select').select2();

            // Used to set alerts automatic dismissal
            $(function () {
                setTimeout(function () {
                    $('.alert').alert('close');
                }, 5000);
            });
        });

        let name = $('#name');
        let password = $('#password');

        name.on('keyup', function () {
            $('#name_text').text('');
        });
        password.on('keyup', function () {
            $('#password_text').text('');
        });

        $('#lang').change(function () {
            if ($(this).val() === 'fr') {
                name.prop('placeholder', "Noms");
                password.prop('placeholder', "Mot de Passe");
                $('#eng').text('Anglais');
                $('#fr').text('Français');
                $('#loginText').text("S'identifier");
            } else {
                name.prop('placeholder', "Name");
                password.prop('placeholder', "Password");
                $('#eng').text('English');
                $('#fr').text('French');
                $('#loginText').text("Login");
            }
        });

        // $(document).on('change', '#lang', function () {
        // location.href = 'lang/' + $(this).val();
        // if ($(this).val() === 'fr') {
        //     $('#headText').text('S\'identifier');
        //     name.attr('placeholder', 'Noms');
        //     password.attr('placeholder', 'Mot de passe');
        //     $('#engText').text('Anglais');
        //     $('#frText').text('Français');
        //     $('#loginText').text('Connexion');
        // } else {
        //     $('#headText').text('Login');
        //     name.attr('placeholder', 'Names');
        //     password.attr('placeholder', 'Password');
        //     $('#engText').text('English');
        //     $('#frText').text('French');
        //     $('#loginText').text('Sign In');
        // }
        // });
    </script>
@stop
