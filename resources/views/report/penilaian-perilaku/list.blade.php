@extends('layouts.app', ['title' => 'Data Penilaian Perilaku'])
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
                    <h1>Report Penilaian Perilaku</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Report
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Penilaian Perilaku</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
        </div>

    </div>

    @if (session()->has('message'))
        <div class='alert alert-inverse-success text-dark'>
            {{ session()->get('message') }}
        </div><br>
    @endif
    <div class='row'>
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body">
                    <div style="@php echo (Session::get('id_akses') =='5') ? 'display:none':''; @endphp">
                        <form action='{{ route('report/penilaian-perilaku/cari') }}' method='POST'>
                            @csrf
                            <div class='row mb-4'>
                                <div class='col-lg-2 text-center'>NIP</div>
                                <div class='col-lg-2 text-center'>Nama</div>
                                <div class='col-lg-2 text-center'>Tahun</div>
                                <div class='col-lg-2'></div>
                                <div class='col-lg-4'></div>

                                <div class='col-lg-2 text-center'>
                                    <input type='text' class='form-control' name='pegawai_dinilai' id='pegawai_dinilai'
                                        value='{{ @$pegawai_dinilai }}'>
                                </div>
                                <div class='col-lg-2 text-center'>
                                    <input type='text' class='form-control' name='nama_dinilai' id='nama_dinilai'
                                        value='{{ @$nama_dinilai }}'>
                                </div>
                                <div class='col-lg-2 text-center'>
                                    <input type='text' class='form-control' name='tahun' id='tahun'
                                        value='{{ @$tahun }}'>
                                </div>

                                <div class='col-lg-2'>
                                    <input type='submit' class='btn btn-primary' value='Filter' name='submit'>
                                </div>
                                <div class='col-lg-4 mr-auto float-right'>
                                </div>
                        </form>
                    </div>
                    <div class="datatable-wrapper table-responsive">
                        <table id="datatable2" class="display compact table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Pegawai Dinilai</th>
                                    <th width="35%">Nama Dinilai</th>
                                    <th width="20%">Tahun</th>
                                    <th width="20%">Nilai Akhir</th>

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
        $(document).ready(function() {

            $('#datatable2').dataTable({
                "searching": false,
                "ordering": false,
                processing: true,
                serverSide: true,

                ajax: {
                    url: '{{ route('ajx-getPenilaianPerilaku') }}',
                    data: {
                        pegawai_dinilai: $("#pegawai_dinilai").val(),
                        nama_dinilai: $("#nama_dinilai").val(),
                        tahun: $("#tahun").val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'pegawai_dinilai',
                        name: 'userid'
                    },
                    {
                        data: 'nama_dinilai',
                        name: 'nama'
                    },
                    {
                        data: 'tahun',
                        name: 'akses'
                    },
                    {
                        data: 'nilai_akhir',
                        name: 'action'
                    }


                ],
                columnDefs: [{
                    className: 'text-center',
                    targets: [0, 3, 4]
                }, ]

            });
        })
    </script>
@stop
