<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manajemen Talenta Kementerian ATR-BPN." />
    <meta name="author" content="Potenza Global Solutions" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>{{ $title }} | Manajemen Talenta ATR-BPN</title>
    <!-- app favicon -->

    <link rel="shortcut icon" href="{{asset('assets/img/icon/logo_app.png')}}">
    <!-- google fonts -->
    <link href="{{asset('assets/css/fonts/font.css')}}" rel="stylesheet">
    <!-- plugin stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors.css')}}" />
    <!-- app style -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/select2/select2.min.css')}}" />
    <style>
    thead, th {text-align: center;}

    /* OR */

    .table thead,
    .table th {text-align: center;}

    </style>

</head>
<body class='text-dark'>
    <div class="app">
        <div class="app-wrap">
            <div class="loader">
                <div class="h-100 d-flex justify-content-center">
                    <div class="align-self-center">
                        <img src="{{asset('assets/img/loader/loader.svg')}}" alt="loader">
                    </div>
                </div>
            </div>

            @include('layouts.header')
            <div class="app-container">
                @include('layouts.navbar')
                <div class="app-main" id="main">
                    <div class="container-fluid">
                         @yield('section')
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
    <!-- plugins -->


<script src="{{asset('assets/js/vendors.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('assets/js/select2/select2.min.js')}}"></script>
</body>
@yield('page-js-script')
</html>
