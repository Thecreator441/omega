<?php

use App\Models\AccDate;
use Illuminate\Support\Facades\Session;

$emp = Session::get('employee');

$date = null;
if (Session::has('accdate')) {
    $accdate = Session::get('accdate');
    $date = $accdate->accdate;
}

$acc_date = AccDate::getOpenAccDate();

if ($emp->lang === 'fr')
    App::setLocale('fr');
?>

@extends('layouts.dashboard')

@section('title', trans('sidebar.home'))

@section('content')
    <input type="hidden" id="edit" value="{{$emp->edit}}">

    {{--    @if ($emp->level==='B')--}}
    @lang('label.accdate') : @if ($acc_date !== null) {{changeFormat($acc_date->accdate)}} @else @lang('alertDanger.opendate') @endif

    <input type="hidden" id="date" value="{{$date}}">
    {{--    @endif--}}

@stop()

@section('script')
    <script>
        // $(document).ready(function () {
        //     if ($('#edit').val() !== 'null') {
        //         swal({
        //             title: '@lang('label.editpass')',
        //             icon: 'info',
        //             closeOnClickOutside: false,
        //             allowOutsideClick: false,
        //             closeOnEsc: false,
        //             content: {
        //                 element: 'input',
        //                 attributes: {
        //                     placeholder: '@lang('placeholder.newpass')',
        //                     type: 'password',
        //                     autocapitalize: 'off',
        //                 }
        //             },
        //             buttons: {
        //                 confirm: {
        //                     text: ' @lang('label.edit')',
        //                     visible: true,
        //                     closeModal: false,
        //                     className: "btn bg-aqua fa fa-edit"
        //                 },
        //             },
        //         }).then(function (result) {
        //             if (result) {
        //                 post('{{url('user/change')}}', {user: '{{$emp->iduser}}', password: result, _token: '{{csrf_token()}}'});
        //             } else {
        //                 swal({
        //                     title: '@lang('label.editpass')',
        //                     icon: 'warning',
        //                     closeOnClickOutside: false,
        //                     allowOutsideClick: false,
        //                     closeOnEsc: false,
        //                     content: {
        //                         element: 'input',
        //                         attributes: {
        //                             placeholder: '@lang('placeholder.newpass')',
        //                             type: 'password',
        //                             autocapitalize: 'off',
        //                         }
        //                     },
        //                     buttons: {
        //                         confirm: {
        //                             text: ' @lang('label.edit')',
        //                             visible: true,
        //                             closeModal: false,
        //                             className: "btn bg-aqua fa fa-edit"
        //                         },
        //                     },
        //                 }).then(function (result) {
        //                     if (result) {
        //                         post('{{url('user/change')}}', {user: '{{$emp->iduser}}', password: result, _token: '{{csrf_token()}}'});
        //                     } else {
        //                         swal({
        //                             title: '@lang('label.editpass')',
        //                             icon: 'error',
        //                             closeOnClickOutside: false,
        //                             allowOutsideClick: false,
        //                             closeOnEsc: false,
        //                             content: {
        //                                 element: 'input',
        //                                 attributes: {
        //                                     placeholder: '@lang('placeholder.newpass')',
        //                                     type: 'password',
        //                                     autocapitalize: 'off',
        //                                 }
        //                             },
        //                             buttons: {
        //                                 confirm: {
        //                                     text: ' @lang('label.edit')',
        //                                     visible: true,
        //                                     closeModal: true,
        //                                     className: "btn bg-aqua fa fa-edit"
        //                                 },
        //                             },
        //                         }).then(function (result) {
        //                             if (result) {
        //                                 post('{{url('user/change')}}', {user: '{{$emp->iduser}}', password: result, _token: '{{csrf_token()}}'});
        //                             } else {
        //                                 location.href = '{{url('edit_logout')}}'
        //                             }
        //                         });
        //                     }
        //                 });
        //             }
        //         });
        //     }

        //     @if($emp->level === 'B')
        //     if ($('#date').val() !== null) {
        //         let date = sysDate(new Date($('#date').val()).getTime());
        //         let date2 = sysDate(new Date().getTime());

        //         let date3 = new Date(date);
        //         let date4 = new Date(date2);

        //         if (date3.getTime() < date4.getTime()) {
        //             swal({
        //                 icon: 'warning',
        //                 title: '@lang('sidebar.open_acc_date')',
        //                 text: 'The date is not equal \nAccount Date = ' + date + '\nPresent Date = ' + date2 + '\n Do you want to continuo using this date?',
        //                 closeOnClickOutside: false,
        //                 allowOutsideClick: false,
        //                 closeOnEsc: false,
        //                 buttons: {
        //                     cancel: {
        //                         text: ' @lang('confirm.no')',
        //                         value: false,
        //                         visible: true,
        //                         closeModal: true,
        //                         className: "btn bg-red fa fa-close"
        //                     },
        //                     confirm: {
        //                         text: ' @lang('confirm.yes')',
        //                         value: true,
        //                         visible: true,
        //                         closeModal: true,
        //                         className: "btn bg-green fa fa-check"
        //                     },
        //                 },
        //             }).then(function (isConfirm) {
        //                 if (isConfirm === true) {
        //                     $.ajax({
        //                         url: "{{url('delDate')}}",
        //                         method: 'get',
        //                         success: function (response) {
        //                             if (response === 'true') {
        //                                 location.href = "{{url('to_home')}}";
        //                             }
        //                         }
        //                     });
        //                 }

        //                 if (isConfirm === false) {
        //                     @if($emp->collector !== null)
        //                     post('{{url('user/logout')}}', {user: '{{$emp->iduser}}', _token: '{{csrf_token()}}'});
        //                     @else
        //                         location.href = "{{url('acc_day_close')}}";
        //                     @endif
        //                 }
        //             });
        //         }
        //     }
        //     @endif
        // });
    </script>
@stop
