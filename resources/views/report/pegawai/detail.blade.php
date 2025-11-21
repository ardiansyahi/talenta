@extends("layouts.app",["title"=>"Pegawai"])
@section('section')
<style>
    .table>thead>tr>th {
        vertical-align: middle;
        white-space: wrap;
    }
    .table>tbody>tr>td {
        vertical-align: middle;
        white-space: wrap;
    }
    .bgtable{
        background-color:#8e54e9;color:#fff;font-size:24px;
    }
    .bgbold{
        text-align:center;font-weight:bold;
    }
</style>
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Data Pegawai - Detail Talent Mapping</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Report</li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">
                                <a href="{{route('report/pegawai')}}">Pegawai</a>
                            </li>
                            <li class="breadcrumb-item">Detail Talent Mapping</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
        </div>

    </div>

    @php
        $jsonP=json_decode($dataHeader->potensial);
        $jsonIP=json_decode($data->potensial);
        $jsonK=json_decode($dataHeader->kinerja);
        $jsonIK=json_decode($data->kinerja);
        
        $jsonNilai=json_decode($data->nilai);
    @endphp
     <div class='row'>
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class='row mb-3 mt-3'>
                        <div class='col-lg-2'>NIP</div>
                        <div class='col-lg-10'>{{$dataPegawai->nip}}</div>
                    </div>
                    <div class='row mb-3 mt-3'>
                        <div class='col-lg-2'>Nama</div>
                        <div class='col-lg-10'>{{$dataPegawai->nama_lengkap}}</div>
                    </div>
                    <div class='row mb-3 mt-3'>
                        <div class='col-lg-2'>Talent Mapping Tahun</div>
                        <div class='col-lg-10'>{{$dataKRS->tahun}}</div>
                    </div>
                    <div class='row mb-3'>
                        <div class='col-lg-2'>Talent Mapping Jenis</div>
                        <div class='col-lg-10'>{{str_ireplace("_"," ",$dataKRS->jenis)}}</div>
                    </div>
                    <div class='row mb-3'>
                        <div class='col-lg-2'>Batch</div>
                        <div class='col-lg-10'>{{$dataKRS->batch}}</div>
                    </div>
                   
                    <div class='row mb-3'>
                        <div class='col-lg-2'>Deskripsi</div>
                        <div class='col-lg-10'>{{$dataKRS->deskripsi}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body">
                    <h2>{{$jsonNilai[2]}}</h2>
                    <table class='table table-striped table-bordered' width="100%">
                        <tr>
                            <td  class='bgtable' colspan='2'><b>Potensial {{$jsonNilai[0]}}</b></td>
                        </tr>
                        @php
                            
                            for($i=0; $i < count($jsonP); $i++){
                                $dt=explode("^",$jsonP[$i]);
                                $isi=(count($dt) > 1) ? $dt[1] : $jsonP[$i];
                                echo 
                                "<tr>
                                    <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                    <td width='80%'>".$jsonIP[$i]."</td>
                                </tr>";
                            }
                        @endphp
                        
                        <tr>
                            <td  class='bgtable' colspan='2'><b>Kinerja {{$jsonNilai[1]}}</b></td>
                        </tr>
                        @php
                            
                            for($i=0; $i < count($jsonK); $i++){
                                $dt=explode("^",$jsonK[$i]);
                                $isi=(count($dt) > 1) ? $dt[1] : $jsonK[$i];
                                echo 
                                "<tr>
                                    <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                    <td width='80%'>".$jsonIK[$i]."</td>
                                </tr>";
                            }
                        @endphp
                        

                    </table>
                    
                </div>
            </div>
        </div>
    </div>
    

@endsection

@section('page-js-script')

<script type="text/javascript">
  
</script>
@stop
