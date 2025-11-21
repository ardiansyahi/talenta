@extends('layouts.app', ['title' => 'Home'])
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

        .bgtable {
            background-color: #8e54e9;
            color: #fff;
            text-align: center;
        }

        .bgbold {
            text-align: center;
            font-weight: bold;
        }
    </style>

    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Home</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Home
                            </li>

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
                    <div id='divbody'></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js-script')
    <script type="text/javascript">
        $(document).ready(function() {
            $.post("{{ route('ajx-getPegawaiHistory') }}", {
                    nip: "{{$nip}}",
                    _token: "{{ csrf_token() }}",
                })
                .done(function(result) {
                    var response = jQuery.parseJSON(result);
                    $("#divbody").append(`
                    <table class='table table-bordered table-striped' width='100%'>
                    <tr>
                        <td width='20%'>Pegawai ID </td>
                        <td width='80%'>` + response.pegawai.pegawaiID + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>NIP </td>
                        <td width='80%'>` + response.pegawai.nip + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Nama  </td>
                        <td width='80%'>` + response.pegawai.nama_lengkap + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Tanggal Lahir</td>
                        <td width='80%'>` + response.pegawai.tgl_lahir + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Pendidikan</td>
                        <td width='80%'>` + response.pegawai.pendidikan + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Eselon </td>
                        <td width='80%'>` + response.pegawai.eselon + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>TMT Eselon </td>
                        <td width='80%'>` + response.pegawai.tmteselon + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Pangkat </td>
                        <td width='80%'>` + response.pegawai.pangkat + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Golongan </td>
                        <td width='80%'>` + response.pegawai.golongan + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>TMT Pangkat</td>
                        <td width='80%'>` + response.pegawai.tmtpangkat + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Level Jabatan </td>
                        <td width='80%'>` + response.pegawai.level_jabatan + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Nama Jabatan </td>
                        <td width='80%'>` + response.pegawai.nama_jabatan + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>TMT Jabatan</td>
                        <td width='80%'>` + response.pegawai.tmt_jabatan + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Satker</td>
                        <td width='80%'>` + response.pegawai.satker + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Tipe </td>
                        <td width='80%'>` + response.pegawai.tipepegawai + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Status</td>
                        <td width='80%'>` + response.pegawai.statuspegawai + `</td>
                    </tr>
                     <tr>
                        <td width='20%'>Kedudukan </td>
                        <td width='80%'>` + response.pegawai.kedudukan + `</td>
                    </tr>

                </table><br>
                <h2>History Talent Mapping</h2><hr>
                
                <table id='tbl-pengawas' class='table table-bordered table-striped' width='100%'>
                    <tr >
                        <td class="bgtable">Tahun</td>
                        <td class="bgtable">Level</td>
                        <td class="bgtable">Potensial</td>
                        <td class="bgtable">Kinerja</td>
                        <td class="bgtable">Kotak</td>
                        <td class="bgtable">View Detail</td>
                    </tr></table><br>
                `);

                    $.each(response.talentmapping, function(i, item) {
                        var str = item.jenis;
                        str = str.replace(/_/g, ' ');
                        var myArr = JSON.parse(item.nilai);
                        $('#tbl-pengawas tr:last').after(`
                    <tr >
                        <td class="bgbold">` + item.tahun + `</td>
                        <td class="bgbold">` + str + `</td>
                        <td class="bgbold">` + myArr[0] + `</td>
                        <td class="bgbold">` + myArr[1] + `</td>
                        <td class="bgbold">` + myArr[2] + `</td>
                        <td class="bgbold"><a href="{{url('/report/pegawai/detail-talent/pengawas/` + item.id + `/` + item
                            .id_krs + `/` + item.nip + `')}}" target="_BLANK" class="btn btn-primary">View Detail</a></td>
                    </tr>`);
                    })

                    $.each(response.administrator, function(i, item) {
                        var myArr = JSON.parse(item.nilai);
                        $('#tbl-admin tr:last').after(`
                    <tr >
                        <td class="bgbold">` + item.tahun + `</td>
                        <td class="bgbold">` + myArr[0] + `</td>
                        <td class="bgbold">` + myArr[1] + `</td>
                        <td class="bgbold">` + myArr[2] + `</td>
                        <td class="bgbold"><a href="{{url('/report/pegawai/detail-talent/administrator/` + item.id + `/` +
                            item.id_krs + `/` + item.nip + `')}}" target="_BLANK">View Detail</a></td>
                    </tr>`);
                    })
                });
        });
    
    </script>
@endsection
