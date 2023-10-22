@extends('layouts.app', ['title' => 'RW Jabatan'])
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
                    <h1>Report Riwayat Jabatan</h1>
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
                            <li class="breadcrumb-item active text-primary" aria-current="page">RW Jabatan</li>
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
                        <form action='{{ route('report/rw-jabatan/cari') }}' method='POST'>
                            @csrf
                            <div class='row mb-4'>
                                <div class='col-lg-3 text-center'>NIP</div>
                                <div class='col-lg-2'></div>
                                <div class='col-lg-7'></div>

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

                                <div class='col-lg-2'>
                                    <input type='submit' class='btn btn-primary' value='Filter' name='submit'>
                                </div>
                                <div class='col-lg-7 mr-auto float-right'>
                                    @php
                                        $np = '-';
                                        if (!empty($nip->nip)) {
                                            $np = $nip->nip;
                                        }

                                    @endphp
                                    <a href="/report/rw-jabatan/export/{{ $np }}"
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
                                    <th width="50%">Nama</th>
                                    <th width="25%">Total</th>

                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vertical Center Modal -->

@endsection

@section('page-js-script')

    <script type="text/javascript">
        $(document).ready(function() {

            $('#datatable2').dataTable({
                "searching": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('ajx-getRwJabatanJson') }}',
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
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    }


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
                    url: "{{ route('ajx-getNIPRWJ') }}",
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


        function showGlobalModal(nip, jenis) {
            $("#modal-body-detail").empty();
            $("#modalGlobalTitle").html('Detail Riwayat Jabatan');
            $("#modal-body-detail").append(`
                <table id='tablex1' class='display compact table table-striped table-bordered table-hovered' width='100%' border='1'>
                    <thead>
                    <tr>
                        <th width='20%'>NIP </th>
                        <th width='20%'>Nama </th>
                        <th width='30%'>Satker  </th>
                        <th width='10%'>Tgl SK</th>
                        <th width='10%'>TMT Jabatan</th>
                        <th width='10%'>TMT Eselon </th>

                    </tr>
                    </thead>
                    <tbody></tbody>
                    </table>

        `);

            $.ajax({
                url: "{{ route('ajx-getRwJabatanDetail') }}",
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
                        <td>` + item.satker + `</td>
                        <td align='center' >` + item.tglsk + `</td>
                        <td align='center'>` + item.tmtjabatan + `</td>
                        <td align='center''>` + item.tmteselon + `</td>
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
