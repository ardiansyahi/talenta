@extends("layouts.app",["title"=>"Tambah Titik Potong"])
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
    .box{
        width:10px;
        height:10px;
        padding: 10px;
        float:left;
        margin-right:10px;
    }
    .boxdetail{
        padding:25px;
        border:1px #000 solid;
    }
</style>
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>{{$act}} Titik Potong</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Master</li>
                            <li class="breadcrumb-item " aria-current="page">
                                <a href="{{route('master/tikpot')}}">Titik Potong</a>
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">{{$act}} Titik Potong</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
        </div>

    </div>

    @if(session()->has('result'))
        <div class='alert alert-inverse-{{session()->get('restype')}} text-dark'>
            {{session()->get('result')}}
        </div><br>
    @endif

    <div class='row'>
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body">
                    <form action='{{route('master/tikpot/simpan')}}' method='POST' >
                        @csrf
                        <div class='row mb-3 mt-3'>
                            <div class='col-lg-2'>Nama</div>
                            <div class='col-lg-10'>
                                <input type='hidden' name='id' value='{{@$id;}}'>
                                <input type='hidden' name='act' value='{{@$act;}}'>
                                <input type='text' name='nama' class='form-control' value="{{@$data->nama}}" @error('nama') is-invalid @enderror'>
                                @error('nama') <span class='invalid-feedback' style='font-size:15px;'>{{$message}}</span>  @enderror
                            </div>
                        </div>

                        <div class='row mb-3'>
                            <div class='col-lg-12 '>
                                <input type='submit' name='submit' value='submit' class='btn btn-primary float-right'>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Detail Tikpot-->
    @if($act=='Ubah')
        <div class='row'>
            <div class="col-lg-12">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class='row mb-3'>
                            <div class='col-sm-6'><h4>Konfigurasi Titik Potong</h4></div>
                            <div class='col-sm-6'>
                                <a href="#" class='btn btn-primary float-right' onclick='showModal()'>Ubah Konfigurasi</a>
                            </div>
                        </div>
                        <table class='table table-bordered table-hover'>
                            <tr>
                                <td rowspan="2" align="center">No</td>
                                <td rowspan="2" align="center">Nama Talent Pool</td>
                                <td colspan="2" align="center">Potensial</td>
                                <td colspan="2" align="center">Kinerja</td>
                            </tr>
                            <tr>
                                <td align="center">Nilai Batas Bawah</td>
                                <td align="center">Nilai Batas Atas</td>
                                <td align="center">Nilai Batas Bawah</td>
                                <td align="center">Nilai Batas Atas</td>
                            </tr>
                            @foreach($dtDet as $key => $item)
                                <tr>
                                    <td align="center">{{$key+1}}</td>
                                    <td valign='top'>
                                        <div class='box' style='background-color:{{$item->warna}}'></div>
                                        {{$item->nama}}
                                    </td>
                                    <td align="center">{{$item->min_potensial}}</td>
                                    <td align="center">{{$item->max_potensial}}</td>
                                    <td align="center">{{$item->min_kinerja}}</td>
                                    <td align="center">{{$item->max_kinerja}}</td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="popUpUpload" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog  modal-lg " role="document">
                <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="popUpUploadTitle">Klasifikasi Peta Talenta</h5>
                        </div>
                        <div class="modal-body" >
                            <div class='alert alert-inverse-success mb-3' style='display:hidden' id='divsuc'>
                                <label id="lbldivsuc" class='text-dark'></label>
                            </div>
                            <div class='alert alert-inverse-danger mb-3' style='display:hidden' id='divfail'>
                                <label id="lbldivfail" class='text-dark'></label>
                            </div>
                            <div class='row'>
                                <div class='col-6'>
                                    <div class='row'>
                                        <div class='col-sm-12 mb-3'>
                                            Nama<br>
                                            <input type='text' class='form-control' id='namakotak'>
                                            <input type='hidden' class='form-control' id='idkotak'>
                                        </div>
                                        <div class='col-sm-12 mb-3'>
                                            Warna<br>
                                            <input type='color' class='form-control' id='warna'>
                                        </div>

                                        <div class='col-sm-12 mb-3'>
                                            Nilai batas bawah potensial<br>
                                            <div class="input-group  input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"> > = </span>
                                                </div>
                                                <input type='text' class='form-control' id='min_potensial'>
                                            </div>
                                        </div>
                                        <div class='col-sm-12 mb-3'>
                                            Nilai batas atas potensial<br>
                                            <div class="input-group  input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"> < = </span>
                                                </div>
                                                 <input type='text' class='form-control' id='max_potensial'>
                                            </div>

                                        </div>
                                        <div class='col-sm-12 mb-3'>
                                            Nilai batas bawah kinerja<br>
                                            <div class="input-group  input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"> > = </span>
                                                </div>
                                               <input type='text' class='form-control' id='min_kinerja'>
                                            </div>

                                        </div>
                                        <div class='col-sm-12 mb-3'>
                                            Nilai batas atas kinerja<br>
                                            <div class="input-group  input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"> < = </span>
                                                </div>
                                               <input type='text' class='form-control' id='max_kinerja'>
                                            </div>

                                        </div>
                                        <div class='col-sm-12 mb-3'>
                                            <a href='#' onclick="simpan()" class='btn btn-primary float-right'>Update</a>
                                        </div>


                                    </div>
                                </div>
                                <div class='col-1' align='right'>
                                    <label style="margin-top:120px;transform: rotate(-90deg);margin-left:25px">Kinerja</label>
                                </div>
                                <div class='col-5'>
                                    <div class='container'>
                                    <div class='row mt-4'>
                                        @foreach($dtDet2 as $key => $value)
                                            <div class='col-sm-4 boxdetail' id="div_{{$value->id}}"style='background-color:{{$value->warna}}' onclick="getDataDet('{{$value->id}}')">
                                                {{$value->nama}}
                                            </div>
                                        @endforeach
                                    </div>
                                    <label class='mt-2'>Potensial</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id='btn-close' onclick='closeModal()'>Close</button>
                        </div>

                </div>
            </div>
        </div>
    @endif


@endsection

@section('page-js-script')

<script type="text/javascript">
    $(document).ready(function(){


    })

function showModal(){
    $("#namakotak").val('');
    $("#warna").val('');
    $("#min_potensial").val('');
    $("#max_potensial").val('');
    $("#min_kinerja").val('');
    $("#max_kinerja").val('');
    $("#popUpUpload").modal('show');
    $("#divsuc").hide();
    $("#divfail").hide();
}

function closeModal(){
    location.reload();
}
function getDataDet(id){
    $("#divsuc").hide();
    $("#divfail").hide();
    $.get( "{{route('master/tikpot/getdatadetail')}}", { id: id} )
    .done(function( result ) {
        $("#namakotak").val(result.nama);
        $("#idkotak").val(result.id);
        $("#warna").val(result.warna);
        $("#min_potensial").val(result.min_potensial);
        $("#max_potensial").val(result.max_potensial);
        $("#min_kinerja").val(result.min_kinerja);
        $("#max_kinerja").val(result.max_kinerja);
    });
}

function simpan(){
    if($("#namakotak").val()=='' || $("#warna").val()==''|| $("#min_potensial").val()==''|| $("#max_potensial").val()==''
    || $("#min_kinerja").val()==''|| $("#max_kinerja").val()==''){
        $("#lbldivfail").html('Masih ada data yang belum terisi')
        $("#divsuc").hide();
        $("#divfail").show();
    }else{
        $.post( "{{route('master/tikpot/simpankonfig')}}", {
            id: $("#idkotak").val(),
            _token: "{{ csrf_token() }}",
            nama:$("#namakotak").val(),
            warna:$("#warna").val(),
            min_potensial:$("#min_potensial").val(),
            max_potensial:$("#max_potensial").val(),
            min_kinerja:$("#min_kinerja").val(),
            max_kinerja:$("#max_kinerja").val(),
        },"JSON")
        .done(function( result ) {
            $("#lbldivsuc").html(result.message)
            $('#div_'+$("#idkotak").val()).css({"background-color":$("#warna").val()});
            $("#divsuc").show();
            $("#divfail").hide();
        }).fail(function(){
            $("#lbldivfail").html('gagal update data')
            $("#divsuc").hide();
            $("#divfail").show();
        });
    }



}

</script>
@stop
