@extends('layouts.app', ['title' => 'KRS'])
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
                    <h1>Talent Mapping</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Talent Mapping</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
        </div>

    </div>

    @if (session()->has('respon'))
        <div
            class='alert {{ session()->get('respon') == 'success' ? 'alert-inverse-success' : 'alert-inverse-danger' }} text-dark'>
            {{ session()->get('message') }}
        </div><br>
    @endif
    <div class='row'>
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body">
                    <form action='{{ route('talent-mapping/cari') }}' method='POST'>
                        @csrf
                        <div class='row mb-4'>
                            <div class='col-sm-2 text-center'>Tahun</div>
                            <div class='col-sm-2 text-center'>Jenis KRS</div>
                            <div class='col-sm-2 text-center'>Status</div>
                            <div class='col-sm-1 text-center'></div>
                            <div class='col-sm-5 mr-auto float-right'></div>
                        </div>
                        <div class='row mb-4'>
                            <div class='col-sm-2 text-center'>
                                <input type='number' class='form-control' name='tahun' id='tahun'
                                    value="{{ @$tahun }}">
                            </div>
                            <div class='col-sm-2 text-center'>
                                <select name='jenis' class='form-control' id='jenis'>
                                    <option value=''>Pilih Jenis KRS</option>
                                    <option value="pengawas" {{ @$jenis == 'pengawas' ? 'Selected' : '' }}>KRS Pengawas
                                    </option>
                                    <option value="administrator" {{ @$jenis == 'administrator' ? 'Selected' : '' }}>
                                        Administrator</option>
                                    <option value="jpt" {{ @$jenis == 'jpt' ? 'Selected' : '' }}>JPT</option>
                                </select>
                            </div>
                            <div class='col-sm-2 text-center'>
                                <select name='status' class='form-control' id='status'>
                                    <option value=''>Pilih Status</option>
                                    <option value="publish" {{ @$status == 'publish' ? 'Selected' : '' }}>Publish</option>
                                    <option value="non" {{ @$status == 'non' ? 'Selected' : '' }}>Non Publish</option>
                                    <option value="in_progress" {{ @$status == 'in_progress' ? 'Selected' : '' }}>In
                                        Progress</option>
                                </select>
                            </div>
                            <div class='col-sm-1 text-center'>
                                <input type='submit' name='submit' value='filter' class='btn btn-primary'
                                    style='width:100%'>
                            </div>
                            <div class='col-sm-5 mr-auto float-right'>
                                <a href="{{ route('talent-mapping/tambah') }}"
                                    class='btn btn-primary  mr-auto float-right'>Tambah Data</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="datatable-wrapper table-responsive">
                    <table id="datatable2" class="display compact table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Tahun</th>
                                <th width="5%">Batch</th>
                                <th width="10%">Jenis</th>
                                <th width="30%">Deskripsi</th>
                                <th width="10%">Status</th>
                                <th width="30%">Action</th>
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
                "order": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('ajx-getDataKrs') }}',
                    data: {
                        tahun: $("#tahun").val(),
                        jenis: $("#jenis").val(),
                        status: $("#status").val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'batch',
                        name: 'batch'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: ''
                    }

                ],
                columnDefs: [{
                    className: 'text-center',
                    targets: [0, 1, 2, 3, 5, 6]
                }, ]

            });
        })
    </script>
@stop
