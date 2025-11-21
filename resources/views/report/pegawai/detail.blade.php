@php
use App\Models\TalentaRekomTema; //TAMBAHAN ILHAM 19 Juni 2025
use App\Models\TalentaRekomKonsiderasi; //TAMBAHAN ILHAM 19 Juni 2025
use App\Models\TalentaRekomAktivitas; //TAMBAHAN ILHAM 19 Juni 2025
@endphp

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

$jsonPeg=json_decode($dataHeader->pegawai);
$jsonPegIP=json_decode($data->pegawai);

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
                @php $potensial='';
                if($jsonNilai[2]=="Kotak 1" || $jsonNilai[2]=="Kotak 2" || $jsonNilai[2]=="Kotak 4"){
                    $potensial='Rendah';
                } else if($jsonNilai[2]=="Kotak 3" || $jsonNilai[2]=="Kotak 5" || $jsonNilai[2]=="Kotak 7"){
                    $potensial='Menengah';
                }else{
                    $potensial='Tinggi';
                }
                $kinerja='';
                if($jsonNilai[2]=="Kotak 1" || $jsonNilai[2]=="Kotak 3" || $jsonNilai[2]=="Kotak 6"){
                    $kinerja='Dibawah Ekspektasi';
                } else if($jsonNilai[2]=="Kotak 2" || $jsonNilai[2]=="Kotak 5" || $jsonNilai[2]=="Kotak 8"){
                    $kinerja='Sesuai Ekspektasi';
                }else{
                    $kinerja='Diatas Ekspektasi';
                }
                @endphp
                <table class='table table-striped table-bordered' width="100%">
                    <tr>
                        <td  class='bgtable' colspan='2'><b>Potensial : {{$potensial}}</b></td>
                    </tr>
                    {{-- @php
                        
                        for($i=6; $i < count($jsonPeg); $i++){
                            $dt=explode("^",$jsonPeg[$i]);
                            $isi=(count($dt) > 1) ? $dt[1] : $jsonPeg[$i];
                            echo 
                            "<tr>
                                <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                <td width='80%'>".$jsonPegIP[$i]."</td>
                            </tr>";
                        }
                        @endphp --}}
                        
                        <!--KONDISI ADMINISTRATOR-->
                        @if($dataKRS->jenis == "administrator")
                        
                        <tr>
                            <td  style="background-color: #edb172;color: #fff;font-style: bold;font-size:24px;" colspan='2'><b>Profile Pegawai</b></td>
                        </tr>
                        @php
                        
                        for($i=6; $i < 11; $i++){
                            $dt=explode("^",$jsonPeg[$i]);
                            $isi=(count($dt) > 1) ? $dt[1] : $jsonPeg[$i];
                            echo 
                            "<tr>
                                <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                <td width='80%'>".$jsonPegIP[$i]."</td>
                            </tr>";
                        }
                        @endphp
                        
                        <tr>
                            <td  style="background-color: #edb172;color: #fff;font-style: bold;font-size:24px;"  colspan='2'><b>Kompetensi Manajerial Dan Sosial Kultural</b></td>
                        </tr>
                        @php
                        
                        for($i=11; $i < 12; $i++){
                            $dt=explode("^",$jsonPeg[$i]);
                            $isi=(count($dt) > 1) ? $dt[1] : $jsonPeg[$i];
                            echo 
                            "<tr>
                                <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                <td width='80%'>".$jsonPegIP[$i]."</td>
                            </tr>";
                        }
                        @endphp
                        
                        <tr>
                            <td  style="background-color: #edb172;color: #fff;font-style: bold;font-size:24px;"  colspan='2'><b>Kompetensi Teknis</b></td>
                        </tr>
                        @php
                        
                        for($i=12; $i < 14; $i++){
                            $dt=explode("^",$jsonPeg[$i]);
                            $isi=(count($dt) > 1) ? $dt[1] : $jsonPeg[$i];
                            echo 
                            "<tr>
                                <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                <td width='80%'>".$jsonPegIP[$i]."</td>
                            </tr>";
                        }
                        @endphp
                        
                        <tr>
                            <td  class='bgtable' colspan='2'><b>Kinerja : {{$kinerja}}</b></td>
                        </tr>
                        @php
                        
                        for($i=14; $i < count($jsonPeg); $i++){
                            $dt=explode("^",$jsonPeg[$i]);
                            $isi=(count($dt) > 1) ? $dt[1] : $jsonPeg[$i];
                            echo 
                            "<tr>
                                <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                <td width='80%'>".$jsonPegIP[$i]."</td>
                            </tr>";
                        }
                        @endphp
                        <!--KONDISI PENUTUP ADMINISTRATOR-->
                        
                        @elseif($dataKRS->jenis == "jpt_pratama") <!--KONDISI JPT PRATAMA-->
                        
                        <tr>
                            <td  style="background-color: #edb172;color: #fff;font-style: bold;font-size:24px;" colspan='2'><b>Profile Pegawai</b></td>
                        </tr>
                        @php
                        
                        for($i=5; $i < 14; $i++){
                            $dt=explode("^",$jsonPeg[$i]);
                            $isi=(count($dt) > 1) ? $dt[1] : $jsonPeg[$i];
                            echo 
                            "<tr>
                                <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                <td width='80%'>".$jsonPegIP[$i]."</td>
                            </tr>";
                        }
                        @endphp
                        
                        <tr>
                            <td  style="background-color: #edb172;color: #fff;font-style: bold;font-size:24px;"  colspan='2'><b>Kompetensi Manajerial Dan Sosial Kultural</b></td>
                        </tr>
                        @php
                        
                        for($i=14; $i < 15; $i++){
                            $dt=explode("^",$jsonPeg[$i]);
                            $isi=(count($dt) > 1) ? $dt[1] : $jsonPeg[$i];
                            echo 
                            "<tr>
                                <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                <td width='80%'>".$jsonPegIP[$i]."</td>
                            </tr>";
                        }
                        @endphp
                        
                        {{-- <tr>
                            <td  style="background-color: #edb172;color: #fff;font-style: bold;font-size:24px;"  colspan='2'><b>Kompetensi Teknis</b></td>
                        </tr>
                        @php
                        
                        for($i=15; $i < 17; $i++){
                            $dt=explode("^",$jsonPeg[$i]);
                            $isi=(count($dt) > 1) ? $dt[1] : $jsonPeg[$i];
                            echo 
                            "<tr>
                                <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                <td width='80%'>".$jsonPegIP[$i]."</td>
                            </tr>";
                        }
                        @endphp --}}
                        
                        <tr>
                            <td  class='bgtable' colspan='2'><b>Kinerja : {{$kinerja}}</b></td>
                        </tr>
                        @php
                        
                        for($i=15; $i < count($jsonPeg); $i++){
                            $dt=explode("^",$jsonPeg[$i]);
                            $isi=(count($dt) > 1) ? $dt[1] : $jsonPeg[$i];
                            echo 
                            "<tr>
                                <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                <td width='80%'>".$jsonPegIP[$i]."</td>
                            </tr>";
                        }
                        @endphp
                        
                        <!--PENUTUP KONDISI JPT PRATAMA-->
                        
                        <!--KONDISI PENGAWAS-->
                        @elseif($dataKRS->jenis == "pengawas")
                        
                        <tr>
                            <td  style="background-color: #edb172;color: #fff;font-style: bold;font-size:24px;" colspan='2'><b>Profile Pegawai</b></td>
                        </tr>
                        @php
                        
                        for($i=6; $i < 13; $i++){
                            $dt=explode("^",$jsonPeg[$i]);
                            $isi=(count($dt) > 1) ? $dt[1] : $jsonPeg[$i];
                            
                            if($isi == "Predikat Kompetensi Mansoskul"){
                                
                            }
                            else{
                                
                                echo 
                                "<tr>
                                    <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                    <td width='80%'>".$jsonPegIP[$i]."</td>
                                </tr>";
                                
                            }
                            
                        }
                        @endphp
                        
                        <tr>
                            <td  style="background-color: #edb172;color: #fff;font-style: bold;font-size:24px;"  colspan='2'><b>Kompetensi Manajerial Dan Sosial Kultural</b></td>
                        </tr>
                        @php
                        
                        for($i=6; $i < 13; $i++){
                            $dt=explode("^",$jsonPeg[$i]);
                            $isi=(count($dt) > 1) ? $dt[1] : $jsonPeg[$i];
                            
                            if($isi == "Predikat Kompetensi Mansoskul"){

                                echo 
                                "<tr>
                                    <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                    <td width='80%'>".$jsonPegIP[$i]."</td>
                                </tr>";
                                
                            }
                            else{
                                
                                
                                
                            }
                        }
                            
                        @endphp
                            
                            {{-- <tr>
                                <td  style="background-color: #edb172;color: #fff;font-style: bold;font-size:24px;"  colspan='2'><b>Kompetensi Teknis</b></td>
                            </tr>
                            @php
                            
                            for($i=12; $i < 14; $i++){
                                $dt=explode("^",$jsonPeg[$i]);
                                $isi=(count($dt) > 1) ? $dt[1] : $jsonPeg[$i];
                                echo 
                                "<tr>
                                    <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                    <td width='80%'>".$jsonPegIP[$i]."</td>
                                </tr>";
                            }
                            @endphp --}}
                            
                            <tr>
                                <td  class='bgtable' colspan='2'><b>Kinerja : {{$kinerja}}</b></td>
                            </tr>
                            @php
                            
                            for($i=13; $i < count($jsonPeg); $i++){
                                $dt=explode("^",$jsonPeg[$i]);
                                $isi=(count($dt) > 1) ? $dt[1] : $jsonPeg[$i];
                                echo 
                                "<tr>
                                    <td width='20%'>".str_ireplace("_"," ",$isi)."</td>
                                    <td width='80%'>".$jsonPegIP[$i]."</td>
                                </tr>";
                            }
                            @endphp
                            <!--KONDISI PENUTUP PENGAWAS-->
                            
                            @endif
                            
                            {{-- <tr>
                                <td  class='bgtable' colspan='2'><b>Kinerja : {{$kinerja}}</b></td>
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
                            @endphp --}}
                            
                            
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <!--TAMBAHAN BARU ILHAM 19 JUNI 2025-->
        
        <div class='row'>
            <div class="col-lg-12">
                <div class="card card-statistics">
                    <div class="card-body">
                        <h2 style="text-align: center">POSISI DALAM KOTAK MANAJEMEN TALENTA</h2>
                        
                        <table class='table table-striped table-bordered' width="100%">
                            <tr>
                                <td  class='bgtable' style="text-align: center" colspan='2'><b>{{$jsonNilai[2]}}</b></td>
                            </tr>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class='row'>
            <div class="col-lg-12">
                <div class="card card-statistics">
                    <div class="card-body">
                        <h2 style="text-align: center">KESIAPAN PROMOSI</h2>
                        
                        <table class='table table-striped table-bordered' width="100%">
                            <tr>
                                <td  class='bgtable' style="text-align: center" colspan='2'>
                                    
                                    @php
                                    $dataKesiapanPromosi=TalentaRekomTema::select("*")
                                    ->wherekotak_talenta($jsonNilai[2])->first();
                                    echo $dataKesiapanPromosi->kesiapan_promosi;
                                    @endphp
                                    
                                </td>
                            </tr>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class='row'>
            <div class="col-lg-12">
                <div class="card card-statistics">
                    <div class="card-body">
                        <h2 style="text-align: center">KONSIDERASI</h2>
                        
                        <table class='table table-striped table-bordered' width="100%">
                            <tr>
                                <td style="text-align: center" colspan='2'></td>
                            </tr>
                            <tr>
                                <td  class='bgtable' style="text-align: center" >Aspek Potensial & Kinerja</td>
                                <td  class='bgtable' style="text-align: center" >Aspek Kebutuhan Dasar</td>
                            </tr>
                            
                            @php
                            $dataKonsiderasi=TalentaRekomKonsiderasi::select("*")
                            ->wherekotak_talenta($jsonNilai[2])->get();
                            @endphp
                            
                            @foreach($dataKonsiderasi as $dK)
                            <tr>
                                <td  style="text-align: left" >{{$dK['aspek_potensial_kinerja']}}</td>   
                                <td  style="text-align: left" >{{$dK['aspek_kebutuhan_dasar']}}</td>
                            </tr>
                            @endforeach
                            
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class='row'>
            <div class="col-lg-12">
                <div class="card card-statistics">
                    <div class="card-body">
                        <h2 style="text-align: center">PROGRAM PENGEMBANGAN TALENTA</h2>
                        
                        <table class='table table-striped table-bordered' width="100%">
                            <tr>
                                <td style="text-align: center" colspan='9'></td>
                            </tr>
                            <tr>
                                <td  class='bgtable' style="text-align: center" rowspan="2">Persentase</td>
                                <td  class='bgtable' style="text-align: center" colspan="2">Exposure</td>
                                <td  class='bgtable' style="text-align: center" colspan="2">Experience</td>
                                <td  class='bgtable' style="text-align: center" colspan="2">Education</td>
                                <td  class='bgtable' style="text-align: center" colspan="2">Retensi</td>
                            </tr>
                            
                            <tr>
                                
                                <td  class='bgtable' style="text-align: center">Aktvitas</td>
                                <td  class='bgtable' style="text-align: center">JP</td>
                                <td  class='bgtable' style="text-align: center">Aktivitas</td>
                                <td  class='bgtable' style="text-align: center">JP</td>
                                <td  class='bgtable' style="text-align: center">Aktivitas</td>
                                <td  class='bgtable' style="text-align: center">JP</td>
                                <td  class='bgtable' style="text-align: center" colspan="2">Aktivitas</td>
                            </tr>
                            
                            {{-- <tr>
                                
                                <td  class='bgtable' style="text-align: center">1</td>
                                <td  class='bgtable' style="text-align: center">1</td>
                                <td  class='bgtable' style="text-align: center">2</td>
                                <td  class='bgtable' style="text-align: center">3</td>
                                <td  class='bgtable' style="text-align: center">4</td>
                                <td  class='bgtable' style="text-align: center">5</td>
                                <td  class='bgtable' style="text-align: center">6</td>
                                <td  class='bgtable' style="text-align: center" colspan="2">7</td>
                            </tr> --}}
                            
                            @php
                            $dataAktivitas=TalentaRekomAktivitas::select("*")
                            ->wherekotak_talenta($jsonNilai[2])->get();
                            $CountdataAktivitas=TalentaRekomAktivitas::select("*")
                            ->wherekotak_talenta($jsonNilai[2])->count();
                            @endphp
                            
                            <tr>
                                <td style="text-align: left" rowspan="{{$CountdataAktivitas+1}}">
                                    Exposure: {{$dataKesiapanPromosi->Exposure}}<br/>
                                    Experience: {{$dataKesiapanPromosi->Experience}}<br/>
                                    Education: {{$dataKesiapanPromosi->Education}}<br/>
                                </td>
                                <td   style="text-align: center"></td>
                                <td   style="text-align: center"></td>
                                <td   style="text-align: center"></td>
                                <td   style="text-align: center"></td>
                                <td   style="text-align: center"></td>
                                <td   style="text-align: center"></td>
                                <td   style="text-align: center" colspan="2"></td>
                            </tr>
                            
                            @foreach($dataAktivitas as $dA)
                            
                            <tr>
                                
                                
                                <td style="text-align: center">{{$dA['exposure']}}</td>
                                <td style="text-align: center">{{$dA['lama_exposure']}}</td>
                                <td style="text-align: center">{{$dA['exposure']}}</td>
                                <td style="text-align: center">{{$dA['lama_experience']}}</td>
                                <td style="text-align: center">{{$dA['education']}}</td>
                                <td style="text-align: center">{{$dA['lama_education']}}</td>
                                <td style="text-align: center" colspan="2">{{$dA['strategi_retensi']}}</td>
                            </tr>
                            @endforeach
                            
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <!--PENUTUP TAMBAHAN BARU ILHAM 19 JUNI 2025-->
        
        @endsection
        
        @section('page-js-script')
        
        <script type="text/javascript">
            
        </script>
        @stop
        