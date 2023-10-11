
@extends("layouts.app",["title"=>"Konfigurasi KRS"])
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
    .fa-times{
        font-size:20px;
    }
    .span-danger{
        font-size:15px;
    }
</style>
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Talent Mapping Konfigurasi Bobot</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i></a>
                            </li>

                            <li class="breadcrumb-item " aria-current="page">
                                <a href="{{route('talent-mapping')}}">Talent Mapping</a>
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Konfigurasi Bobot</li>
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
                <div class="card-body">
                    <form action='{{route('talent-mapping/calculate')}}' method='post' >
                        @csrf
                        <input type='hidden' name='id' value='{{$id}}'>
                        <div class='row mb-3 mt-3'>
                            <div class='col-lg-2'>KRS Tahun</div>
                            <div class='col-lg-10'>{{$data->tahun}}</div>
                        </div>
                        <div class='row mb-3'>
                            <div class='col-lg-2'>Jenis KRS</div>
                            <div class='col-lg-10'>{{$data->jenis}}</div>
                        </div>
                        <div class='row mb-3'>
                            <div class='col-lg-2'>Batch</div>
                            <div class='col-lg-10'>{{$data->batch}}</div>
                        </div>
                        <div class='row mb-3'>
                            <div class='col-lg-2'>Deskripsi</div>
                            <div class='col-lg-10'>{{$data->deskripsi}}</div>
                        </div>

                        <div class='row'>
                            <div class='col-sm-12'>
                                @php
                                    $totalBP= count(json_decode($dtBobot->potensial));
                                    $totalBK= count(json_decode($dtBobot->kinerja));
                                @endphp
                                <table class='table table-bordered mt-3'>
                                    <tr>
                                        <td style='background-color:#b3e6ff;font-weight:bold' colspan="{{$totalBP}}" align='center'>Total Potensial</td>
                                        <td style='background-color:#ffccff;font-weight:bold'  colspan="{{$totalBK}}" align='center'>Total Kinerja</td>
                                    </tr>
                                    <tr>
                                        @php $json=json_decode($dtBobot->potensial); @endphp
                                        @for ($i = 0; $i < count($json); $i++)
                                            <td style='background-color:#b3e6ff;font-weight:bold' align='center'>
                                                @php
                                                    $tp=explode("^",$json[$i]);
                                                    echo str_ireplace("_"," ",$tp[1]);
                                                @endphp
                                            </td>
                                        @endfor
                                        @php $json=json_decode($dtBobot->kinerja); @endphp
                                        @for ($i = 0; $i < count($json); $i++)
                                            <td style='background-color:#ffccff;font-weight:bold' align='center'>
                                                @php
                                                    $tp=explode("^",$json[$i]);
                                                    echo str_ireplace("_"," ",$tp[1]);
                                                @endphp
                                            </td>
                                        @endfor

                                    </tr>

                                    <tr>
                                        @php $json=json_decode($dtBobotIsi->potensial); @endphp
                                        @for ($i = 0; $i < count($json); $i++)
                                            <td style='background-color:#b3e6ff' align='center'>
                                               <input type='number' class='form-control' name='potensial[]' id='potensial[]' value='{{$json[$i]}}' onkeyup='hitung()'>
                                            </td>
                                        @endfor
                                        @php $json=json_decode($dtBobotIsi->kinerja); @endphp
                                        @for ($i = 0; $i < count($json); $i++)
                                            <td style='background-color:#ffccff' align='center'>
                                                <input type='number' class='form-control' name='kinerja[]' id='kinerja[]' value='{{$json[$i]}}' onkeyup='hitung()'>
                                            </td>
                                        @endfor

                                    </tr>

                                </table>
                            </div>
                        </div>

                        <div class='row mb-3'>
                            <div class='col-lg-12'>
                                <input type='submit' class='btn btn-primary float-right' id='submit' name='submit' value='Submit' >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class="col-lg-12">

        </div>


    </div>


    <!-- Vertical Center Modal -->
    <div class="modal fade" id="popUpUpload" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="popUpUploadTitle"></h5>
                    </div>
                    <div class="modal-body" align='center'>
                        <img src="{{asset('assets/img/loader/loader.svg')}}" id='img1'><br/>
                        <label id='lbl1' class='text-dark'>Mohon Menuggu</label><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id='btn-close' onclick='closeModal()'>Close</button>
                    </div>


            </div>
        </div>
    </div>

@endsection

@section('page-js-script')

<script type="text/javascript">
    var totalPotensial=0;var totalKinerja=0;
    var totalBobot=0;
    function closeModal(){
         $('#popUpUpload').modal('hide');
    }
    $(document).ready(function() {
        hitung()
    });

function hitung(){
    totalPotensial=0;  totalKinerja=0;
    $("input[name='potensial[]']").each(function (index, element) {
        totalPotensial = totalPotensial + parseFloat($(element).val());
        
    });
     $("input[name='kinerja[]']").each(function (index, element) {
        totalKinerja = totalKinerja + parseFloat($(element).val());
    });

    totalBobot=totalPotensial+totalKinerja;
    if(totalBobot === 200){
       $("#submit").show()
    }else{
      $("#submit").hide()
    } 
    
}


</script>
@stop
