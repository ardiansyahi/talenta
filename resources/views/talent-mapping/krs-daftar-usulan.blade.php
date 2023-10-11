@extends("layouts.app",["title"=>"Talent Mapping Detail"])
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
</style>
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Talent Mapping Detail</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('talent-mapping')}}">Talent Mapping</a>
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Talent Mapping Daftar Usulan</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
        </div>

    </div>

    @if(session()->has('respon'))
        <div class='alert {{session()->get('respon')=="success" ? "alert-inverse-success" : "alert-inverse-danger"}} text-dark' >
            {{session()->get('message')}}
        </div><br>
    @endif
    <div class='row'>
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class='row mb-3 mt-3'>
                        <div class='col-lg-1'>KRS Tahun</div>
                        <div class='col-lg-11'>{{$data->tahun}}</div>
                    </div>
                    <div class='row mb-3'>
                        <div class='col-lg-1'>Jenis KRS</div>
                        <div class='col-lg-11'>{{$data->jenis}}</div>
                    </div>
                    <div class='row mb-3'>
                        <div class='col-lg-1'>Batch</div>
                        <div class='col-lg-11'>{{$data->batch}}</div>
                    </div>

                    <div class='row mb-3'>
                        <div class='col-lg-1'>Deskripsi</div>
                        <div class='col-lg-11'>{{$data->deskripsi}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body">

                    <div class="datatable-wrapper table-responsive">
                        <table id="datatable2" class="display compact table table-striped table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">NIP</th>
                                    <th width="35%">Nama</th>
                                    <th width="10%">Golongan</th>
                                    <th width="10%">Pangkat</th>
                                    <th width="10%">Potensial</th>
                                    <th width="10%">Kinerja</th>
                                    <th width="10%">Peta Talenta</th>

                                </tr>
                            </thead>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection

@section('page-js-script')

<script type="text/javascript">
    $(document).ready(function(){

         $('#datatable2').dataTable({
            searching: false, paging: true, info: true,
            processing: true,
            serverSide: true,
                    ajax: {
                       url:'{{ route('talent-mapping/getdaftar-usulan') }}',
                       data:{id_krs:'{{$id}}'}
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nip', name: 'nip'},
                        {data: 'nama_lengkap', name: 'nama_lengkap'},
                        {data: 'golongan', name: 'golongan'},
                        {data: 'pangkat', name: 'pangkat'},
                        {data: 'potensial', name: 'potensial'},
                        {data: 'kinerja', name: 'kinerja'},
                        {data: 'kotak', name: 'kotak'},

                    ],
                    columnDefs: [
                        { className: 'text-center', targets: [0,1,5,6,7] },
                    ]

        });
    })

    function showGlobalModal(id_krs,nip){
        $("#modal-body-detail").empty();
        $("#modalGlobalTitle").html('Detail Pegawai');
        $.getJSON( "{{route('talent-mapping/getdetail-daftar-usulan')}}", { id_krs: id_krs,nip:nip} )
        .done(function( result ) {

            $("#modal-body-detail").append(`<table id='tb-master' class='table table-bordered table-striped' width="100%">
                <tr>
                    <td colspan="2" style='background-color:#8e54e9;color:#fff;'> Data Usulan</td>
                </tr>
                <tr>
                    <td width="20%">Nomor Surat Usul</td>
                    <td width="80%">`+result.data.nomor_surat_usul+`</td>
                </tr>
                <tr>
                    <td width="20%">Tanggal Surat</td>
                    <td width="80%">`+result.data.tgl_surat+`</td>
                </tr>
                <tr>
                    <td width="20%">Gelombang 1</td>
                    <td width="80%">`+result.data.gelombang_1+`</td>
                </tr>
                <tr>
                    <td width="20%">Dicalonkan Gelombang 2</td>
                    <td width="80%">`+result.data.dicalonkan_gelombang_2+`</td>
                </tr>

                </table>`);

            $("#modal-body-detail").append(`<table id='tb-pegawai' class='table table-bordered table-striped' width="100%">
                <tr>
                    <td colspan="2" style='background-color:#8e54e9;color:#fff;'> Data Pegawai</td>
                </tr>
                </table>`);

            $("#modal-body-detail").append(`<table id='tb-potensial' class='table table-bordered table-striped' width="100%">
                <tr>
                    <td colspan="2" style='background-color:#8e54e9;color:#fff;'> Data Potensial</td>
                </tr>
                </table>`);
            $("#modal-body-detail").append(`<table id='tb-kinerja' class='table table-bordered table-striped' width="100%">
                <tr>
                    <td colspan="2" style='background-color:#8e54e9;color:#fff;'> Data Kinerja</td>
                </tr>
                </table>`);
            $("#modal-body-detail").append(`<table id='tb-nilai' class='table table-bordered table-striped' width="100%">
                <tr>
                    <td colspan="2" style='background-color:#8e54e9;color:#fff;'> Total Penilaian</td>
                </tr>
                </table>`);


            var dataPegawai=JSON.parse(result.header.pegawai);
            var isiPegawai=JSON.parse(result.data.pegawai);
            for(var i=0; i < dataPegawai.length; i++){
                var headerPegawai=dataPegawai[i].split("^");
                $('#tb-pegawai tr:last').after(`
                    <tr>
                        <td width="20%">`+headerPegawai[1]+`</td>
                        <td width="80%">`+isiPegawai[i]+`</td>
                    </tr>
                `);
            }

            var dataPotensial=JSON.parse(result.header.potensial);
            var isiPotensial=JSON.parse(result.data.potensial);
            for(var i=0; i < dataPotensial.length; i++){
                var headerPotensial=dataPotensial[i].split("^");
                $('#tb-potensial tr:last').after(`
                    <tr>
                        <td width="20%">`+headerPotensial[1]+`</td>
                        <td width="80%">`+isiPotensial[i]+`</td>
                    </tr>
                `);
            }

            var dataKinerja=JSON.parse(result.header.kinerja);
            var isiKinerja=JSON.parse(result.data.kinerja);
            for(var i=0; i < dataKinerja.length; i++){
                var headerKinerja=dataKinerja[i].split("^");
                $('#tb-kinerja tr:last').after(`
                    <tr>
                        <td width="20%">`+headerKinerja[1]+`</td>
                        <td width="80%">`+isiKinerja[i]+`</td>
                    </tr>
                `);
            }

            var dataNilai=JSON.parse(result.header.nilai);
            var isiNilai=JSON.parse(result.data.nilai);
            for(var i=0; i < dataNilai.length; i++){
                $('#tb-nilai tr:last').after(`
                    <tr>
                        <td width="20%">`+dataNilai[i]+`</td>
                        <td width="80%">`+isiNilai[i]+`</td>
                    </tr>
                `);
            }

            $("#modalGlobal").modal('show');
        });
    }


</script>
@stop
