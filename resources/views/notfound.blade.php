@extends("layouts.app",["title"=>"404 Not Found"])
@section('section')
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>404 Page Not Found</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">

                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i> Home</a>
                            </li>

                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
        </div>
    </div>

    <div class='row'>
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body" align='center'>
                    <img src="{{asset('assets/img/icon/404.jpg')}}" style='width:50%'><br>
                    <h2>Anda tidak memiliki akses untuk halaman ini</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
