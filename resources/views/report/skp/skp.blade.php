@extends('layouts.app', ['title' => 'SKP'])
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
                    <h1>Report SKP</h1>
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
                            <li class="breadcrumb-item active text-primary" aria-current="page">SKP</li>
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
                        <form action='{{ route('report/skp/cari') }}' method='POST'>
                            @csrf
                            <div class='row mb-4'>
                                <div class='col-lg-2 text-center'>NIP</div>
                                <div class='col-lg-2'>Tahun</div>
                                <div class='col-lg-2'></div>
                                <div class='col-lg-6'></div>

                                <div class='col-lg-2 text-center'>
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
                                <div class='col-lg-2'>
                                    <input type='number' class='form-control' id='tahun' name='tahun'
                                        value="{{ @$tahun }}">
                                </div>
                                <div class='col-lg-2'>
                                    <input type='submit' class='btn btn-primary' value='Filter' name='submit'>
                                </div>
                                <div class='col-lg-6 mr-auto float-right'>
                                    @php
                                        $np = '-';
                                        $th = '-';
                                        if (!empty($nip->nip)) {
                                            $np = $nip->nip;
                                        }
                                        if (!empty($tahun)) {
                                            $th = $tahun;
                                        }

                                    @endphp
                                    <a href="/report/skp/export/{{ $np }}/{{ $th }}"
                                        class="btn btn-success float-right">Export Data</a>

                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="datatable-wrapper table-responsive">
                        <table id="datatable2" class="display compact table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Pegawai ID</th>
                                    <th width="10%">NIP</th>
                                    <th width="35%">Nama</th>
                                    <th width="10%">Tahun</th>
                                    <th width="10%">TGL Penilaian</th>
                                    <th width="10%">Nilai</th>
                                    <th width="10%">Ranking</th>

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
                    <h5 class="modal-title" id="popUpUploadTitle">Tarik Data SKP</h5>
                </div>
                <div class="modal-body" align='center'>
                    <img src="{{ asset('assets/img/loader/loader.svg') }}" id='img1'><br />
                    <label id='lbl1'>Mohon Menuggu</label><br>
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
                "ordering": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('ajx-getSkpJson') }}',
                    data: {
                        nip: $("#nip").val(),
                        tahun: $("#tahun").val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'pegawaiID',
                        name: 'pegawaiID'
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
                        data: 'tahunPenilaian',
                        name: 'tahunPenilaian'
                    },
                    {
                        data: 'tglPenilaian',
                        name: 'tglPenilaian'
                    },
                    {
                        data: 'nilai_angka',
                        name: 'nilai_angka'
                    },
                    {
                        data: 'rangking',
                        name: 'rangking'
                    },


                ],
                columnDefs: [{
                    className: 'text-center',
                    targets: [1, 3]
                }, ]

            });
        })

        $(function() {
            $('#nip').select2({
                minimumInputLength: 3,
                allowClear: true,
                placeholder: 'masukkan NIP / Nama',
                ajax: {
                    dataType: 'json',
                    url: "{{ route('ajx-getNIPRW') }}",
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

        function getSkp() {
            if (confirm("Yakin akan menarik data SKP ?") == true) {
                $('#popUpUpload').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                $('#btn-close').hide();
                $.ajax({
                    url: '{{ route('ajx-getSkp') }}',
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

        function showGlobalModal(nip, jenis) {
            $("#modal-body-detail").empty();
            $("#modalGlobalTitle").html('Detail SKP');
            $("#modal-body-detail").append(`
                <table id='tablex1' class='display compact table table-striped table-bordered table-hovered' width='100%' border='1'>
                    <thead>
                    <tr>
                        <th width='20%'>NIP </th>
                        <th width='40%'>Nama </th>
                        <th width='10%'>Tahun  </th>
                        <th width='10%'>TGL Penilaian</th>
                        <th width='10%'>Nilai</th>
                        <th width='10%'>Rangking </th>

                    </tr>
                    </thead>
                    <tbody></tbody>
                    </table>

        `);

            $.ajax({
                url: "{{ route('ajx-getSkpDetail') }}",
                type: "GET",
                dataType: "JSON",
                data: {
                    nip: nip,
                    jenis: jenis
                },
                cache: false,
                async: false,
                success: function(result) {

                    $.each(result, function(i, item) {
                        $('#tablex1 > tbody:last-child').append(`
                    <tr>
                        <td align='center'>` + item.nip + `</td>
                        <td>` + item.nama + `</td>
                        <td>` + item.tahunPenilaian + `</td>
                        <td align='center' >` + item.tglPenilaian + `</td>
                        <td align='center'>` + item.nilai_angka + `</td>
                        <td align='center''>` + item.rangking + `</td>
                    </tr>

                `);
                    })

                    $("#modalGlobal").modal('show');
                },
                error: function() {

                }
            })


        }
    </script>
@stop
