@extends("layouts.app",["title"=>"Penkom List"])
@section('section')
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Setting Konfigurasi</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Setting
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Konfigurasi</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
        </div>
        
    </div>
    @if(session()->has('respon'))
        <div class='alert {{session()->get('messagge')=="success" ? "alert-inverse-success" : "alert-inverse-danger"}} text-dark' >
            {{session()->get('message')}}
        </div><br>
    @endif
    {{$skoring_pendidikan=$bobot_ds=$bobot_dt=$bobot_rj=$skoring_pangkat='';}}
    @foreach($data as $key => $item)
        @php
            switch($item->jenis){
                case "skoring_pendidikan":
                    $skoring_pendidikan=$item->deskripsi;
                    break;
                case "bobot_rj":
                    $bobot_rj=$item->deskripsi;
                    break;
                case "bobot_ds":
                    $bobot_ds=$item->deskripsi;
                    break;
                case "bobot_dt":
                    $bobot_dt=$item->deskripsi;
                    break;
                case "skoring_pangkat":
                    $skoring_pangkat=$item->deskripsi;
                    break;
              
            }
        @endphp
        
    @endforeach
   
    <div class='row'>
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body">
                    <form action='{{route('konfigurasi-submit')}}' method='post'>
                        @csrf
                        <div class='row mb-4'>
                            <div class='col-sm-2'>
                                Skoring Pendidikan
                            </div>
                            <div class='col-sm-10'>
                                <div class="alert alert-inverse-primary text-dark" role="alert">
                                    Isikan dengan format "kriteria = value;"<br>
                                    Contoh : D.III=50;
                                </div>
                                <textarea class='form-control @error('skoring_pendidikan') is-invalid @enderror'  name='skoring_pendidikan' rows="10" >{{$skoring_pendidikan;}}</textarea>
                                @error('skoring_pendidikan') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                            </div>
                        </div>
                        <div class='row mb-4'>
                            <div class='col-sm-2'>
                                Bobot Riwayat Jabatan
                            </div>
                            <div class='col-sm-10'>
                                <div class="alert alert-inverse-primary text-dark" role="alert">
                                    Isikan dengan format "kriteria = value;"<br>
                                    Contoh :Jika Jumlah >= 7 valuenya 13 maka ketikkan 7 = 13;<br>
                                    Dari sistem akan selalu membaca >=
                                </div>
                                <textarea class='form-control @error('bobot_rj') is-invalid @enderror' name='bobot_rj' value="" rows="10">{{$bobot_rj;}}</textarea>
                                @error('bobot_rj') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                            </div>
                        </div>
                        <div class='row mb-4'>
                            <div class='col-sm-2'>
                            Bobot Diklat Struktural
                            </div>
                            <div class='col-sm-10'>
                                <div class="alert alert-inverse-primary text-dark" role="alert">
                                    Isikan dengan format "kriteria = value;"<br>
                                    Contoh : Sesuai=4;
                                </div>
                                <textarea class='form-control @error('bobot_ds') is-invalid @enderror' name='bobot_ds' value="" rows="10">{{$bobot_ds;}}</textarea>
                                 @error('bobot_ds') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                            </div>
                        </div>
                        <div class='row mb-4'>
                            <div class='col-sm-2'>
                            Bobot Diklat Teknis
                            </div>
                            <div class='col-sm-10'>
                                <div class="alert alert-inverse-primary text-dark" role="alert">
                                    Isikan dengan format "kriteria = value;"<br>
                                    Contoh :Jika Jumlah >= 7 valuenya 3 maka ketikkan 7 = 3<br>
                                    Dari sistem akan selalu membaca >=
                                </div>
                                <textarea class='form-control @error('bobot_dt') is-invalid @enderror' name='bobot_dt' value="" rows="10">{{$bobot_dt;}}</textarea>
                                @error('bobot_dt') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                            </div>
                        </div>
                        <div class='row mb-4'>
                            <div class='col-sm-2'>
                                Skoring Pangkat
                            </div>
                            <div class='col-sm-10'>
                                <div class="alert alert-inverse-primary text-dark" role="alert">
                                    Isikan dengan format "kriteria = value;"<br>
                                    Contoh : IV/a = 100;
                                </div>
                                <textarea class='form-control @error('skoring_pangkat') is-invalid @enderror' name='skoring_pangkat' value="" rows="10">{{$skoring_pangkat;}}</textarea>
                                @error('skoring_pangkat') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                            </div>
                        </div>
                        <div class='row mb-4 float-right'>
                            <div class='col-sm-12'>
                                
                                <input type='submit' class='btn btn-primary' name='submit' value='Submit'>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js-script')
@stop