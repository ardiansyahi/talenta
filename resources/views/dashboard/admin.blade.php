@extends('layouts.app', ['title' => 'Home'])
@section('section')
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Home</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="index.html"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Home
                            </li>

                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-statistics">
                <div class="row no-gutters">
                    <div class="col-xxl-4">
                        <div class="p-20 border-lg-right border-bottom border-xxl-bottom-0">
                            <div class="d-flex m-b-10">
                                <p class="mb-0 font-regular text-muted font-weight-bold">
                                <h4>Total KRS Pengawas
                                    {{ date('Y') }}</h4>
                                </p>
                                <a class="mb-0 ml-auto font-weight-bold" href="#"><i class="ti ti-more-alt"></i> </a>
                            </div>
                            <div class="d-block d-sm-flex h-100 align-items-center">
                                <div class="apexchart-wrapper">
                                    <div id="analytics7"></div>
                                </div>
                                <div class="statistics mt-3 mt-sm-0 ml-sm-auto text-center text-sm-right">
                                    <h3 class="mb-0"><i class="icon-arrow-up-circle"></i> {{ $tkrs_fp }}</h3>
                                    <p>KRS</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="p-20 border-xxl-right border-bottom border-xxl-bottom-0">
                            <div class="d-flex m-b-10">
                                <p class="mb-0 font-regular text-muted font-weight-bold">
                                <h4>Total KRS Administrator
                                    {{ date('Y') }}</h4>
                                </p>
                                <a class="mb-0 ml-auto font-weight-bold" href="#"><i class="ti ti-more-alt"></i> </a>
                            </div>
                            <div class="d-block d-sm-flex h-100 align-items-center">
                                <div class="apexchart-wrapper">
                                    <div id="analytics8"></div>
                                </div>
                                <div class="statistics mt-3 mt-sm-0 ml-sm-auto text-center text-sm-right">
                                    <h3 class="mb-0"><i class="icon-arrow-up-circle"></i> {{ $tkrs_fa }}</h3>
                                    <p>KRS</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="p-20 border-lg-right border-bottom border-lg-bottom-0">
                            <div class="d-flex m-b-10">
                                <p class="mb-0 font-regular text-muted font-weight-bold">
                                <h4>Total KRS JPT {{ date('Y') }}</h4>
                                </p>
                                <a class="mb-0 ml-auto font-weight-bold" href="#"><i class="ti ti-more-alt"></i> </a>
                            </div>
                            <div class="d-block d-sm-flex h-100 align-items-center">
                                <div class="apexchart-wrapper">
                                    <div id="analytics9"></div>
                                </div>
                                <div class="statistics mt-3 mt-sm-0 ml-sm-auto text-center text-sm-right">
                                    <h3 class="mb-0"><i class="icon-arrow-up-circle"></i>{{ $tkrs_fk }}</h3>
                                    <p>KRS</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-statistics">
                <div class="row no-gutters">
                    <div class="col-xxl-4">
                        <div class="p-20 border-lg-right border-bottom border-xxl-bottom-0">
                            <div class="d-flex m-b-10">
                                <p class="mb-0 font-regular text-muted font-weight-bold">
                                <h4>Total KRS Pengawas on progress
                                    {{ date('Y') }}</h4>
                                </p>
                                <a class="mb-0 ml-auto font-weight-bold" href="#"><i class="ti ti-more-alt"></i> </a>
                            </div>
                            <div class="d-block d-sm-flex h-100 align-items-center">
                                <div class="apexchart-wrapper">
                                    <div id="analytics7">
                                        <i class="fa fa-hourglass-2 text-primary font-36"></i>
                                    </div>
                                </div>
                                <div class="statistics mt-3 mt-sm-0 ml-sm-auto text-center text-sm-right">
                                    <h3 class="mb-0">{{ $tkrs_ip }}</h3>
                                    <p>KRS</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="p-20 border-xxl-right border-bottom border-xxl-bottom-0">
                            <div class="d-flex m-b-10">
                                <p class="mb-0 font-regular text-muted font-weight-bold">
                                <h4>Total KRS Administrator on progress
                                    {{ date('Y') }}</h4>
                                </p>
                                <a class="mb-0 ml-auto font-weight-bold" href="#"><i class="ti ti-more-alt"></i> </a>
                            </div>
                            <div class="d-block d-sm-flex h-100 align-items-center">
                                <div class="apexchart-wrapper">
                                    <div id="analytics8">
                                        <i class="fa fa-hourglass-2 text-cyan font-36"></i>
                                    </div>
                                </div>
                                <div class="statistics mt-3 mt-sm-0 ml-sm-auto text-center text-sm-right">
                                    <h3 class="mb-0"> {{ $tkrs_ia }}</h3>
                                    <p>KRS</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="p-20 border-lg-right border-bottom border-lg-bottom-0">
                            <div class="d-flex m-b-10">
                                <p class="mb-0 font-regular text-muted font-weight-bold">
                                <h4>Total KRS JPT on progress{{ date('Y') }}</h4>
                                </p>
                                <a class="mb-0 ml-auto font-weight-bold" href="#"><i class="ti ti-more-alt"></i> </a>
                            </div>
                            <div class="d-block d-sm-flex h-100 align-items-center">
                                <div class="apexchart-wrapper">
                                    <div id="analytics9">
                                        <i class="fa fa-hourglass-2 text-pink font-36"></i>
                                    </div>
                                </div>
                                <div class="statistics mt-3 mt-sm-0 ml-sm-auto text-center text-sm-right">
                                    <h3 class="mb-0">{{ $tkrs_ik }}</h3>
                                    <p>KRS</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
