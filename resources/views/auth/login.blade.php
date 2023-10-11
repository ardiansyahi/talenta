<!DOCTYPE html>
<html lang="en">


<head>
    <title>Login - Manajemen Talenta Kementerian ATRBPN</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Manajemen Talenta Kementerian ATRBPN" />
    <meta name="author" content="Manajemen Talenta Kementerian ATRBPN" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- app favicon -->
    <link rel="shortcut icon" href="{{asset('assets/img/icon/logo_app.png')}}">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- plugin stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors.css')}}" />
    <!-- app style -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}" />
</head>

<body class="bg-white">
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap">
            <!-- begin pre-loader -->
            <div class="loader">
                <div class="h-100 d-flex justify-content-center">
                    <div class="align-self-center">
                        <img src="{{asset('assets/img/loader/loader.svg')}}" alt="loader">
                    </div>
                </div>
            </div>
            <!-- end pre-loader -->

            <!--start login contant-->
            <div class="app-contant">
                <div class="bg-white">
                    <div class="container-fluid p-0">
                        <div class="row no-gutters">
                            <div class="col-sm-6 col-lg-5 col-xxl-3  align-self-center order-2 order-sm-1">
                                <div class="d-flex align-items-center h-100-vh">
                                    <div class="login p-50">
                                        <h1 class="mb-2">Manajemen Talenta Banget</h1>
                                        <p>Welcome back, please login to your account.</p><br/>
                                        <form action="{{route('login')}}" method="post">
                                        @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">NIP*</label>
                                                        <input type='text' class='form-control @error('nip') is-invalid @enderror' name='nip' value='{{old('nip')}}'>
                                                        @error('nip') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Password*</label>
                                                        <input type='password' class='form-control @error('password') is-invalid @enderror' name='password' value='{{old('password')}}'>
                                                        @error('password') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                                                        <br>
                                                        @if(session()->has('respon'))
                                                            <span  style='color:red'>{{session()->get('respon')}}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 mt-3">
                                                    <input type='submit' name='submit' value='Sign In' class="btn btn-primary text-uppercase">
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-9 col-lg-7 bg-gradient o-hidden order-1 order-sm-2">
                                <div class="row align-items-center h-100">
                                    <div class="col-7 mx-auto ">
                                        <img class="img-fluid" src="assets/img/bg/login.svg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end login contant-->
        </div>
        <!-- end app-wrap -->
    </div>
    <!-- end app -->



    <!-- plugins -->
    <script src="{{asset('assets/js/vendors.js')}}"></script>

    <!-- custom app -->
    <script src="{{asset('assets/js/app.js')}}"></script>
</body>


</html>
