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
                            <li class="breadcrumb-item active text-primary" aria-current="page">Talent Mapping Detail</li>
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
                        <div class='col-lg-1'>Status</div>
                        <div class='col-lg-11'>
                            {{str_ireplace("_"," ",$data->status)}}
                            <a href="/talent-mapping/update-status/{{$id}}/{{($data->status=='non_publish') ? 'publish' : 'non_publish'}}"
                            class="{{($data->status=='non_publish') ? 'btn btn-primary btn-sm' : 'btn btn-danger btn-sm'}} ml-4">
                            {{($data->status=='non_publish') ? 'Publish Talent Mapping' : 'Non Publish Talent Mapping'}}
                            </a>
                        </div>
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
                    <div class='row'>
                        <div class='col-sm-12 float-right'>
                            <a href="/talent-mapping/export-krs-v2/{{$id}}" class='btn btn-success float-right mb-3 ml-2'>Export Excel Kotak 7,8,9</a>
                            <a href="/talent-mapping/export-krs/{{$id}}" class='btn btn-success float-right mb-3 ml-2'>Export Excel (ALL)</a>

                        </div>
                    </div>
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
                    <br>
                    <hr>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <a href="/talent-mapping/konfigbobot/{{$id}}" class='btn btn-primary float-right mb-3' > Ubah Konfigurasi Bobot</a>
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
                                        <td style='background-color:#b3e6ff' align='center'>{{$json[$i]}}</td>
                                    @endfor
                                    @php $json=json_decode($dtBobotIsi->kinerja); @endphp
                                    @for ($i = 0; $i < count($json); $i++)
                                        <td style='background-color:#ffccff' align='center'>{{$json[$i]}} </td>
                                    @endfor
                                </tr>

                            </table>
                        </div>
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
                       url:'{{ route('talent-mapping/getdetailkrs') }}',
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


</script>
@stop
