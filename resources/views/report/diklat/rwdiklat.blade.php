@extends('layouts.app', ['title' => 'RW Diklat'])
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
                    <h1>Report Riwayat Diklat</h1>
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
                            <li class="breadcrumb-item active text-primary" aria-current="page">RW Diklat</li>
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
                        <form action='{{ route('report/rw-diklat/cari') }}' method='POST'>
                            @csrf
                            <div class='row mb-4'>
                                <div class='col-lg-3 text-center'>NIP</div>
                                <div class='col-lg-2 text-center'>Diklat Struktural</div>
                                <div class='col-lg-2'></div>
                                <div class='col-lg-5'></div>

                                <div class='col-lg-3 text-center'>
                                    <select name='nip' id='nip' class='form-control select2'>
                                        @php

                                            if (!empty($nip)) {
                                                echo "<option value='" . $nip->nip . "'>" . $nip->nip . '-' . $nip->nama . '</option>';
                                            } else {
                                                echo "<option value=''>Pilih NIP</option>";
                                            }
                                        @endphp


                                    </select>
                                </div>

                                <div class='col-lg-2 text-center'>
                                    <select name='jenis' id='jenis'
                                        class='form-control  @error('jenis') is-invalid @enderror'>
                                        <option value=''>Pilih Diklat Struktural</option>
                                        <option value='Sesuai' {{ @$jenis == 'Sesuai' ? 'selected' : '' }}>Sesuai</option>
                                        <option value='Tidak Sesuai' {{ @$jenis == 'Tidak Sesuai' ? 'selected' : '' }}>Tidak
                                            Sesuai</option>
                                    </select>
                                </div>
                                <div class='col-lg-2'>
                                    <input type='submit' class='btn btn-primary' value='Filter' name='submit'>
                                </div>
                                <div class='col-lg-5 mr-auto float-right'>
                                    @php
                                        $np = '-';
                                        $jn = '-';
                                        if (!empty($nip->nip)) {
                                            $np = $nip->nip;
                                        }
                                        if (!empty($jenis)) {
                                            $jn = $jenis;
                                        }

                                    @endphp
                                    <a href="{{url('/report/rw-diklat/export/'.$np.'/'. $jn.'')}}"
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
                                    <th width="20%">NIP</th>
                                    <th width="25%">Nama</th>
                                    <th width="25%">Diklat Teknis</th>
                                    <th width="25%">Diklat Struktural</th>
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
                    <h5 class="modal-title" id="popUpUploadTitle">Tarik Data Riwayat Diklat</h5>
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

    <!-- Vertical Center Modal -->
    <div class="modal fade" id="popUpKonfig" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl " role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="popUpKonfigTitle">Konfigurasi RW Diklat</h5>
                </div>
                <div class="modal-body">
                    <div class='row'>
                        <div class='col-sm-12'>Nama Diklat</div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-9'>
                            <input type='text' class='form-control' id='nama'>
                            <label class='text-danger' id='lblnotif'></label>
                        </div>
                        <div class='col-sm-3'>
                            <a href='#nama' class='btn btn-primary float-right' onclick="postKonfig('add')"
                                style='width:100%'>Input</a>
                        </div>
                    </div>
                    <div class="alert alert-success" role="alert" id='alertkonfigsuccess'></div>
                    <div class="alert alert-danger" role="alert" id='alertkonfigfailed'></div>
                    <div class='row mt-3'>

                        <div class='col-sm-12' id='rwkonfigData'>
                            <table id='tablex2' class='display compact table table-striped table-bordered table-hovered'
                                width='100%' border='1'>
                                <thead>
                                    <tr>
                                        <th width='10%'>No </th>
                                        <th width='80%'>Nama </th>
                                        <th width='10%'>Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dt as $key => $item)
                                        <tr>
                                            <td align='center'>{{ $key + 1 }}</td>
                                            <td>{{ urldecode($item->nama) }}</td>
                                            <td align='center'>
                                                <a href='#nama' onclick="deleteKonfig('{{ $item->id }}')"
                                                    class='text-danger' title='Hapus Data'><i class='fa fa-times'></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='btn-close' data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('page-js-script')

    <script type="text/javascript">
        function deleteKonfig(id) {
            if (confirm("Yakin Data mau dihapus ?") == true) {
                postKonfig('delete', id)
            }
        }

        $(document).ready(function() {
            $("#alertkonfigsuccess").hide();
            $("#alertkonfigfailed").hide();
            $('#datatable2').dataTable({
                "searching": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('ajx-getRWjson') }}',
                    type:'POST',
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
                        data: 'diklat_teknis',
                        name: 'diklat_teknis'
                    },
                    {
                        data: 'diklat_struktural',
                        name: 'diklat_struktural'
                    },


                ],
                columnDefs: [{
                    className: 'text-center',
                    targets: [3, 4]
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
                    type:'POST',
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

        function getKonfig() {
            $('#popUpKonfig').modal({
                backdrop: 'static',
                keyboard: false
            })

        }


        function showGlobalModal(nip, jenis) {
            $("#modal-body-detail").empty();
            $("#modalGlobalTitle").html('Detail Riwayat Diklat');
            $("#modal-body-detail").append(`
                <table id='tablex1' class='display compact table table-striped table-bordered table-hovered' width='100%' border='1'>
                    <thead>
                    <tr>
                        <th width='10%'>Pegawai ID </th>
                        <th width='10%'>NIP </th>
                        <th width='20%'>Nama  </th>
                        <th width='10%'>Jenis</th>
                        <th width='10%'>Tanggal</th>
                        <th width='30%'>Nama Diklat </th>
                        <th width='10%'>Diklat Struktural </th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                    </table>

        `);

            $.ajax({
                url: "{{ route('ajx-getRwDetail') }}",
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
                        <td width='10%' align='center'>` + item.pegawaiID + `</td>
                        <td width='10%' align='center'>` + item.nip + `</td>
                        <td width='20%'>` + item.nama + `</td>
                        <td width='10%' align='center'>` + item.jenis + `</td>
                        <td width='10%' align='center'>` + item.tgl + `</td>
                        <td width='30%'>` + item.nama_diklat + `</td>
                        <td width='10%' align='center'>` + item.diklat_struktural + `</td>
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
