@extends("layouts.app",["title"=>"Penkom List"])
@section('section')
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Penkom</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Hitung KRS
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('master/penkom')}}">Upload Penkom</a>
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Result</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
        </div>

    </div>
    @if(session()->has('response'))
        <div class='{{(session()->get("response")=="success") ? "alert alert-success":"alert alert-danger"}}'>
            {{session()->get('messageUpload')}}
        </div><br>
    @endif

    <div class='row'>
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body">
                     <div class='float-right'>
                        <a href='{{route('master/penkom')}}' class='btn btn-primary'>Upload Kembali Penkom</a>
                    </div>
                    <div class="datatable-wrapper table-responsive">
                        <table id="datatable" class="display compact table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Pangkat</th>
                                    <th>Golongan</th>
                                    <th>Jabatan</th>
                                    <th>Unit Kerja</th>
                                    @if($jenis=="pelaksana")
                                        <th>Skoring Mansoskul</th>
                                        <th>Skoring Kompetensi Teknis Generik</th>
                                        <th>Persentase Kompetensi Teknis Spesifik</th>
                                    @elseif ($jenis=="pengawas")
                                        <th>Skoring Mansoskul</th>
                                        <th>Skoring Teknis</th>
                                    @elseif ($jenis=="administrator"||$jenis=="jpt_pratama"||$jenis=="jpt_madya")
                                        <th>Skoring Mansoskul</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($data))
                                     @foreach($data as $key => $item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->nip}}</td>
                                            <td>{{$item->nama}}</td>
                                            <td>{{$item->pangkat}}</td>
                                            <td>{{$item->golongan}}</td>
                                            <td>{{$item->jabatan}}</td>
                                            <td>{{$item->unit_kerja}}</td>
                                            @if($jenis=="pelaksana")
                                                <td>{{$item->mansoskul}}</td>
                                                <td>{{$item->teknis_generik}}</td>
                                                <td>{{$item->teknis_spesifik}}</td>
                                            @elseif ($jenis=="pengawas")
                                                <td>{{$item->mansoskul}}</td>
                                                <td>{{$item->teknis_generik}}</td>
                                            @elseif ($jenis=="administrator"||$jenis=="jpt_pratama"||$jenis=="jpt_madya")
                                                <td>{{$item->mansoskul}}</td>
                                            @endif



                                        </tr>

                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js-script')
@stop
