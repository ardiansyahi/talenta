@extends('layouts.app', ['title' => 'Penkom List'])
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
                    <h1>Report Penkom</h1>
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
                            <li class="breadcrumb-item active text-primary" aria-current="page">Penkom</li>
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
                    <div style="@php echo (Session::get('id_akses') =='5') ? 'display:none':''; @endphp">
                        <form action='{{ route('report/penkom/cari') }}' method='POST'>
                            @csrf
                            <div class='row mb-4'>
                                <div class='col-lg-3 text-center'>NIP</div>
                                <div class='col-lg-2 text-center'>Tahun</div>
                                <div class='col-lg-2 text-center'>Jenis</div>
                                <div class='col-lg-5'></div>

                                <div class='col-lg-3 text-center'>
                                    <select name='nip' id='nip' class='form-control select2'>
                                        @php
                                            if (!empty($nip)) {
                                                echo "<option value='" . $nip->nip . "'>" . $nip->nip . '-' . $nip->nama_lengkap . '</option>';
                                            } else {
                                                echo "<option value=''>Pilih NIP</option>";
                                            }
                                        @endphp


                                    </select>
                                </div>
                                <div class='col-lg-2 text-center'>
                                    <input type='number' name='tahun' value="{{ @$tahun }}" class='form-control'>
                                </div>
                                <div class='col-lg-2 text-center'>
                                    <select name='jenis' id='jenis'
                                        class='form-control  @error('jenis') is-invalid @enderror'>
                                        <option value=''>Pilih Jenis</option>
                                        <option value='pelaksana' {{ @$jenis == 'pelaksana' ? 'selected' : '' }}>Penkom
                                            Pelaksana
                                        </option>
                                        <option value='pengawas' {{ @$jenis == 'pengawas' ? 'selected' : '' }}>Penkom
                                            Pengawas
                                        </option>
                                        <option value='administrator' {{ @$jenis == 'administrator' ? 'selected' : '' }}>
                                            Penkom
                                            Administrator</option>
                                    </select>
                                </div>
                                <div class='col-lg-5'>
                                    <input type='submit' class='btn btn-primary' value='Filter' name='submit'>
                                </div>
                        </form>
                    </div>
                </div>
                <div class="datatable-wrapper table-responsive">
                    <table id="datatable2" class="display compact table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">NIP</th>
                                <th width="15%">Nama</th>
                                <th width="15%">Pangkat</th>
                                <th width="10%">Golongan</th>
                                <th width="10%">Jenis</th>
                                <th width="5%">Tahun</th>
                                <th width="10%">Skoring Mansoskul</th>
                                <th width="10%">
                                    @if (@$pelaksana == 'pelaksana')
                                        Skoring Kompetensi Teknis Generik
                                    @elseif(@$pelaksana == 'pengawas')
                                        Skoring Kompetensi Teknis
                                    @else
                                        Skoring Kompetensi Teknis
                                    @endif
                                </th>
                                <th width="10%">Persentase Kompetensi Teknis Spesifik</th>
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
                    url: '{{ route('ajx-getPenkom') }}',
                    type:'post',
                    data: {
                        nip: $("#nip").val(),
                        tahun: $("#tahun").val(),
                        jenis: $("#jenis").val(),
                        _token: "{{ csrf_token() }}",
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nip',
                        name: 'nip'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'pangkat',
                        name: 'pangkat'
                    },
                    {
                        data: 'golongan',
                        name: 'golongan'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'mansoskul',
                        name: 'mansoskul'
                    },
                    {
                        data: 'teknis_generik',
                        name: 'teknis_generik'
                    },
                    {
                        data: 'teknis_spesifik',
                        name: 'teknis_spesifik'
                    },

                ],
                columnDefs: [{
                    className: 'text-center',
                    targets: [5, 6, 7, 8, 9]
                }, ],
                @if (@$pelaksana == 'jpt' || @$pelaksana == 'administrator')
                    "aoColumnDefs": [{
                        "bVisible": false,
                        "aTargets": [8, 9]
                    }]
                @elseif (@$pelaksana == 'pengawas')
                    "aoColumnDefs": [{
                        "bVisible": false,
                        "aTargets": [9]
                    }]
                @endif

            });
        })
        $(function() {
            $('#nip').select2({
                minimumInputLength: 3,
                allowClear: true,
                placeholder: 'masukkan NIP / Nama',
                ajax: {
                    dataType: 'json',
                    url: "{{ route('ajx-getNipPegawai') }}",
                    type:'post',
                    delay: 800,
                    data: function(params) {
                        return {
                            _token: "{{ csrf_token() }}",
                            search: params.term
                        }
                    },
                    processResults: function(data, page) {
                        return {
                            results: data
                        };
                    },
                }
            }).on('select2:select', function(evt) {
                var data = $("#nip option:selected").text();

            });
        });
    </script>
@stop
