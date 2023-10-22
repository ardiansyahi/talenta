@extends('layouts.app', ['title' => 'Pegawai'])
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
                    <h1>Master Data Pegawai</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Master
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Pegawai</li>
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
                    <form action='{{ route('master/pegawai/cari') }}' method='POST'>
                        @csrf
                        <div class='row mb-4'>
                            <div class='col-lg-3 text-center'>NIP</div>
                            <div class='col-lg-2'></div>
                            <div class='col-lg-7'></div>

                            <div class='col-lg-3 text-center'>
                                <select name='nip' id='nip' class='form-control select2'>
                                    @php

                                        if (!empty($nip)) {
                                            echo "<option value='" . $nip->nip . "' selected>" . $nip->nama_lengkap . '-' . $nip->nama_lengkap . '</option>';
                                        } else {
                                            echo "<option value=''>Pilih NIP</option>";
                                        }
                                    @endphp


                                </select>
                            </div>

                            <div class='col-lg-2'>
                                <input type='submit' class='btn btn-primary' value='Filter' name='submit'>
                            </div>
                            <div class='col-lg-7 mr-auto float-right'>
                                <a href='#' onclick='getPegawai()' class='btn btn-dark  mr-auto float-right'>Tarik
                                    Data Pegawai</a>
                            </div>
                    </form>
                </div>
                <div class="datatable-wrapper table-responsive">
                    <table id="datatable2" class="display compact table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">NIP</th>
                                <th width="20%">Nama</th>
                                <th width="15%">Kedudukan</th>
                                <th width="15%">Jabatan</th>
                                <th width="15%">Golongan</th>
                                <th width="15%">Eselon</th>

                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Vertical Center Modal -->
    <div class="modal fade" id="popUpUpload" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="popUpUploadTitle">Tarik Data Pegawai</h5>
                </div>
                <div class="modal-body" align='center'>
                    <img src="{{ asset('assets/img/loader/loader.svg') }}" id='img1'><br />
                    <label id='lbl1'>Mohon Menuggu <br> Proses membutuhkan waktu yang lama, sekitar 10-25
                        menit</label><br>

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
        $(document).ready(function() {

            $('#datatable2').dataTable({
                "searching": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('ajx-getPegawaiJson') }}',
                    data: {
                        nip: $("#nip").val()
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
                        data: 'nama_lengkap',
                        name: 'nama'
                    },
                    {
                        data: 'statuspegawai',
                        name: 'status'
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
                        data: 'eselon',
                        name: 'eselon'
                    },

                ],
                columnDefs: [{
                    className: 'text-center',
                    targets: [1, 3]
                }, ]

            });
        })

        function showGlobalModal(nip) {
            $("#modal-body-detail").empty();
            $("#modalGlobalTitle").html('Detail Pegawai');
            $.getJSON("{{ route('ajx-getPegawaiDetail') }}", {
                    nip: nip
                })
                .done(function(result) {
                    $("#modal-body-detail").append(`
                <table class='table table-bordered table-striped' width='100%'>
                    <tr>
                        <td width='20%'>Pegawai ID </td>
                        <td width='80%'>` + result.pegawaiID + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>NIP </td>
                        <td width='80%'>` + result.nip + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Nama  </td>
                        <td width='80%'>` + result.nama_lengkap + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Tanggal Lahir</td>
                        <td width='80%'>` + result.tgl_lahir + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Pendidikan</td>
                        <td width='80%'>` + result.pendidikan + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Eselon </td>
                        <td width='80%'>` + result.eselon + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>TMT Eselon </td>
                        <td width='80%'>` + result.tmteselon + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Pangkat </td>
                        <td width='80%'>` + result.pangkat + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Golongan </td>
                        <td width='80%'>` + result.golongan + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>TMT Pangkat</td>
                        <td width='80%'>` + result.tmtpangkat + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Level Jabatan </td>
                        <td width='80%'>` + result.level_jabatan + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Nama Jabatan </td>
                        <td width='80%'>` + result.nama_jabatan + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>TMT Jabatan</td>
                        <td width='80%'>` + result.tmt_jabatan + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Satker</td>
                        <td width='80%'>` + result.satker + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Tipe </td>
                        <td width='80%'>` + result.tipepegawai + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Status</td>
                        <td width='80%'>` + result.statuspegawai + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Kedudukan </td>
                        <td width='80%'>` + result.kedudukan + `</td>
                    </tr>



                </table>
            `);
                    $("#modalGlobal").modal('show');
                });
        }
        $(function() {
            $('#nip').select2({
                minimumInputLength: 3,
                allowClear: true,
                placeholder: 'masukkan NIP / Nama',
                ajax: {
                    dataType: 'json',
                    url: "{{ route('ajx-getNipPegawai') }}",
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

        function closeModal() {
            $('#popUpUpload').modal('hide');
            location.reload();
        }

        function getPegawai() {
            if (confirm("Yakin akan menarik data pegawai ?") == true) {
                $('#popUpUpload').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                $('#btn-close').hide();
                $.ajax({
                    url: '{{ route('ajx-getPegawai') }}',
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(result) {
                        if (result.respon == 'success') {
                            $('#img1').hide();
                            $('#lbl1').html('Sukses Ambil Data');
                            $('#btn-close').show();
                        } else {
                            $('#img1').hide();
                            $('#lbl1').html('Gagal Ambil Data');
                            $('#btn-close').show();
                        }
                    },
                    error: function() {
                        $('#img1').hide();
                        $('#lbl1').html('Gagal Ambil Data');
                        $('#btn-close').show();
                    }
                })
            }
        }
    </script>
@stop
