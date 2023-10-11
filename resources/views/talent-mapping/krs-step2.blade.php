@extends("layouts.app",["title"=>"KRS Step 2"])
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
                    <h1>Talent Mapping Step 2</h1>
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
                            <li class="breadcrumb-item active text-primary" aria-current="page">Step 2</li>
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
                    <a href='/talent-mapping/step3/{{$id}}' class='btn btn-primary float-right ml-2 mb-3'>Lanjut ke Step 3</a>

                    <a href='/talent-mapping/konfigurasi/{{$id}}' class='btn btn-dark float-right mb-3'>Kembali ke Step 1</a>

                    <div class="datatable-wrapper table-responsive">
                        <table id="datatable2" class="display compact table table-striped table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">NIP</th>
                                    <th width="20%">Nama</th>
                                    <th width="10%">Eselon</th>
                                    <th width="10%">Golongan</th>
                                    <th width="10%">Pangkat</th>
                                    <th width="5%">Pendidikan</th>
                                    <th width="10%">Mansoskul</th>
                                    <th width="10%" >@if($jenis=="pelaksana")Teknis Generik @elseif($jenis=='pengawas') Teknis @endif </th>
                                    <th width="10%">Teknis spesifik</th>
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
                       url:'{{ route('talent-mapping/getdatastep2') }}',
                       data:{id_krs:'{{$id}}'}
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nip', name: 'tahun'},
                        {data: 'nama_lengkap', name: 'nama_lengkap'},
                        {data: 'eselon', name: 'eselon'},
                        {data: 'golongan', name: 'golongan'},
                        {data: 'pangkat', name: 'pangkat'},
                        {data: 'pendidikan', name: 'pendidikan'},
                        {data: 'mansoskul', name: 'mansoskul'},
                        {data: 'generik', name: 'generik'},
                        {data: 'spesifik', name: 'spesifik'},

                    ],
                    columnDefs: [
                        { className: 'text-center', targets: [1,4,6,7,8,9] },
                    ],
                    @if($jenis=="jpt"||$jenis=="administrator")
                        "aoColumnDefs": [{ "bVisible": false, "aTargets": [8,9] }]
                    @elseif($jenis=="pengawas")
                        "aoColumnDefs": [{ "bVisible": false, "aTargets": [9] }]

                    @endif

        });
    })


</script>
@stop
