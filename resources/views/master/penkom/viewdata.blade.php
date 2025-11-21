@extends("layouts.app",["title"=>"Penkom List"])
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
                    <h1>Penkom View</h1>
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
                            <li class="breadcrumb-item active text-primary" aria-current="page">View</li>
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
                     <div class="datatable-wrapper table-responsive">
                        <table style='font-size:20px'>
                            <tr>
                                <td>Tahun </td>
                                <td> : </td>
                                <td>{{$tahun}} </td>
                            </tr>
                            <tr>
                                <td>Jenis Penkom </td>
                                <td> : </td>
                                <td>{{str_ireplace("_"," ",$pelaksana)}} </td>
                            </tr>
                        </table><hr/>
                        <table id="datatable2" class="display compact table table-striped table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">NIP</th>
                                    <th width="15%">Nama</th>
                                    <th width="10%">Pangkat</th>
                                    <th width="5%">Golongan</th>
                                    <th width="10%">Jabatan</th>
                                    <th width="15%">Unit Kerja</th>
                                    <th  width="10%" >Skoring Mansoskul</th>
                                    <th width="10%" >@if($pelaksana=="pelaksana") Skoring Kompetensi Teknis Generik @elseif($pelaksana=='pengawas') Skoring Kompetensi Teknis @endif </th>
                                    <th width="10%" >Persentase Kompetensi Teknis Spesifik</th>

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
<script>
    $(document).ready(function(){

        $('#datatable2').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:'{{ route('ajx-getPenkomDetail') }}',
                data:{hashname:'{{$hashname}}',tahun:'{{$tahun}}',jenis:'{{$pelaksana}}',_token: "{{ csrf_token() }}",},
                type:'post'
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nip', name: 'nip'},
                {data: 'nama', name: 'nama'},
                {data: 'pangkat', name: 'pangkat'},
                {data: 'golongan', name: 'golongan'},
                {data: 'jabatan', name: 'jabatan'},
                {data: 'unit_kerja', name: 'unit_kerja'},
                {data: 'mansoskul', name: 'mansoskul'},
                {data: 'teknis_generik', name: 'teknis_generik'},
                {data: 'teknis_spesifik', name: 'teknis_spesifik'},
            ],
            columnDefs: [
                { className: 'text-center', targets: [7,8,9] },
            ],
            @if($pelaksana=="jpt"||$pelaksana=="administrator")
                "aoColumnDefs": [{ "bVisible": false, "aTargets": [8,9] }]
            @elseif($pelaksana=="pengawas")
                "aoColumnDefs": [{ "bVisible": false, "aTargets": [9] }]

            @endif
        });
    })
</script>
@stop
