@extends('layouts.app', ['title' => 'Konfigurasi KRS'])
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

        .fa-times {
            font-size: 20px;
        }
    </style>
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Konfigurasi Talent Mapping Step 1</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item " aria-current="page">
                                <a href="{{ route('talent-mapping') }}">Talent Mapping</a>
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Konfigurasi Step 1 </li>
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
                    <div class='row mb-3 mt-3'>
                        <div class='col-lg-1'>KRS Tahun</div>
                        <div class='col-lg-11'>{{ $data->tahun }}</div>
                    </div>
                    <div class='row mb-3'>
                        <div class='col-lg-1'>Jenis KRS</div>
                        <div class='col-lg-11'>{{ $data->jenis }}</div>
                    </div>
                    <div class='row mb-3'>
                        <div class='col-lg-1'>Deskripsi</div>
                        <div class='col-lg-11'>{{ $data->deskripsi }}</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @php
        $arrPendidikan = $arrEselon = $arrPangkat = $arrGolongan = $arrLvJabatan = $arrTpPegawai = $arrStatPegawai = [];
        if (!empty($dataKonfig)) {
            $json = json_decode($dataKonfig->isidata, true);
            for ($i = 0; $i < count($json); $i++) {
                switch ($json[$i]['jenis']) {
                    case 'umur':
                        $dtUmur = $json[$i]['detail'];
                        $valUmur = $json[$i]['value']['value'];
                        $pUmur = $json[$i]['param'];
                        break;
                    case 'pns':
                        $dtPns = $json[$i]['detail'];
                        $valPns = $json[$i]['value']['value'];
                        $pPns = $json[$i]['param'];
                        break;
                    case 'pendidikan':
                        $dtPendidikan = $json[$i]['detail'];
                        $valPendidikan = $json[$i]['value']['value'];
                        if ($valPendidikan != '') {
                            foreach ($valPendidikan as $k => $v) {
                                $arrPendidikan[] = $v;
                            }
                        }
                        $pPendidikan = $json[$i]['param'];
                        break;
                    case 'eselon':
                        $dtEselon = $json[$i]['detail'];
                        $valEselon = $json[$i]['value']['value'];
                        if ($valEselon != '') {
                            foreach ($valEselon as $k => $v) {
                                $arrEselon[] = $v;
                            }
                        }
                        $pEselon = $json[$i]['param'];
                        break;
                    case 'tmt_eselon':
                        $dtTmt_eselon = $json[$i]['detail'];
                        $valTmt_eselon = $json[$i]['value']['value'];
                        $pTmt_eselon = $json[$i]['param'];
                        break;
                    case 'pangkat':
                        $dtPangkat = $json[$i]['detail'];
                        $valPangkat = $json[$i]['value']['value'];
                        if ($valPangkat != '') {
                            foreach ($valPangkat as $k => $v) {
                                $arrPangkat[] = $v;
                            }
                        }
                        $pPangkat = $json[$i]['param'];
                        break;
                    case 'golongan':
                        $dtGolongan = $json[$i]['detail'];
                        $valGolongan = $json[$i]['value']['value'];
                        if ($valGolongan != '') {
                            foreach ($valGolongan as $k => $v) {
                                $arrGolongan[] = $v;
                            }
                        }
                        $pGolongan = $json[$i]['param'];
                        break;
                    case 'tmt_pangkat':
                        $dtTmt_pangkat = $json[$i]['detail'];
                        $valTmt_pangkat = $json[$i]['value']['value'];
                        $pTmt_pangkat = $json[$i]['param'];
                        break;
                    case 'level_jabatan':
                        $dtLvJabatan = $json[$i]['detail'];
                        $valLvJabatan = $json[$i]['value']['value'];
                        if ($valLvJabatan != '') {
                            foreach ($valLvJabatan as $k => $v) {
                                $arrLvJabatan[] = $v;
                            }
                        }

                        $pLvJabatan = $json[$i]['param'];
                        break;
                    case 'tmt_jabatan':
                        $dtTmt_jabatan = $json[$i]['detail'];
                        $valTmt_jabatan = $json[$i]['value']['value'];
                        $pTmt_jabatan = $json[$i]['param'];
                        break;
                    case 'satker':
                        $dtSatker = $json[$i]['detail'];
                        $valSatker = $json[$i]['value']['value'];
                        $pSatker = $json[$i]['param'];
                        break;
                    case 'tipe_pegawai':
                        $dtTpPegawai = $json[$i]['detail'];
                        $valTpPegawai = $json[$i]['value']['value'];
                        if ($valTpPegawai != '') {
                            foreach ($valTpPegawai as $k => $v) {
                                $arrTpPegawai[] = $v;
                            }
                        }
                        $pTpPegawai = $json[$i]['param'];
                        break;
                    case 'status_pegawai':
                        $dtStatPegawai = $json[$i]['detail'];
                        $valStatPegawai = $json[$i]['value']['value'];
                        if ($valStatPegawai != '') {
                            foreach ($valStatPegawai as $k => $v) {
                                $arrStatPegawai[] = $v;
                            }
                        }

                        $pStatPegawai = $json[$i]['param'];
                        break;
                }
            }
        }

    @endphp
    <div class='row'>
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body">
                    @if ($status == 'delete')
                        <div class='alert alert-inverse-danger mb-3 text-dark ' style='font-size:20px'>
                            <i class='fa fa-info-circle'></i> KRS ini sudah dihapus
                        </div>
                    @else
                        <div class='alert alert-inverse-primary mb-3 text-dark'>
                            <i class='fa fa-info-circle'></i> Pastikan sudah mengambil data pegawai terabaru dan upload
                            hasil
                            penkom
                        </div>
                        <form action="{{ route('talent-mapping/simpankonfig') }}" method='post'>
                            @csrf
                            <h4>Konfigurasi Data Pegawai</h4>
                            <hr>
                            <div class='row mb-3 mt-3'>
                                <div class='col-sm-4'>Jenis Penkom </div>
                                <div class='col-sm-8'>
                                    <input type='hidden' name='id' value='{{ $id }}'>
                                    <select name='jenis_penkom' id='jenis_penkom'
                                        class='form-control @error('jenis_penkom') is-invalid @enderror'>
                                        <option value=''>Pilih Ujian Penkom yang akan digunakan</option>
                                        <option value='pelaksana'
                                            {{ @$dataPenkom->kriteria == 'pelaksana' ? 'selected' : '' }}>
                                            Pelaksana</option>
                                        <option value='pengawas'
                                            {{ @$dataPenkom->kriteria == 'pengawas' ? 'selected' : '' }}>
                                            Pengawas</option>
                                        <option value='administrator'
                                            {{ @$dataPenkom->kriteria == 'administrator' ? 'selected' : '' }}>Administrator
                                        </option>
                                        <option value='jpt' {{ @$dataPenkom->kriteria == 'jpt' ? 'selected' : '' }}>JPT
                                        </option>
                                    </select>
                                    @error('jenis_penkom')
                                        <span class='invalid-feedback' style='font-size:15px;'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class='row mb-3 mt-3'>
                                <div class='col-sm-4'>Tahun batas ujian Penkom</div>
                                <div class='col-sm-8'>
                                    <select name='tahun_penkom' id='tahun_penkom' class='form-control'>
                                        @for ($a = date('Y'); $a >= date('Y') - 100; $a--)
                                            <option value={{ $a }}
                                                {{ @$dataPenkom->value == $a ? 'selected' : '' }}>{{ $a }}
                                            </option>
                                        @endfor


                                    </select>
                                </div>
                            </div>

                            <div class='row mb-3 mt-3'>
                                <div class='col-sm-4'>Bobot Riwayat Jabatan</div>
                                <div class='col-sm-8'>
                                    <input type='number' name='bobot_rwjabatan' class='form-control'
                                        value="{{ $bobot_rwjabatan }}">
                                </div>
                            </div>

                            <div class='row mb-3 mt-3'>
                                <div class='col-sm-4'>Bobot Diklat</div>
                                <div class='col-sm-8'>
                                    <input type='number' name='bobot_diklat' class='form-control'
                                        value="{{ $bobot_diklat }}">
                                </div>
                            </div>

                            <div class='row mb-3 mt-3'>
                                <div class='col-sm-4'>SKP Year -2</div>
                                <div class='col-sm-8'>
                                    <select name='skp2' class='form-control @error('skp2') is-invalid @enderror'>
                                        <option value="">Pilih Tahun SKP Year -2</option>
                                        @for ($a = date('Y'); $a >= date('Y') - 5; $a--)
                                            <option value={{ $a }} {{ @$skp2 == $a ? 'selected' : '' }}>
                                                {{ $a }}</option>
                                        @endfor
                                    </select>
                                    @error('skp2')
                                        <span class='invalid-feedback' style='font-size:15px;'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class='row mb-3 mt-3'>
                                <div class='col-sm-4'>SKP Year -1</div>
                                <div class='col-sm-8'>
                                    <select name='skp1' class='form-control @error('skp1') is-invalid @enderror'>
                                        <option value="">Pilih Tahun SKP Year -1</option>
                                        @for ($a = date('Y'); $a >= date('Y') - 5; $a--)
                                            <option value={{ $a }} {{ @$skp1 == $a ? 'selected' : '' }}>
                                                {{ $a }}</option>
                                        @endfor


                                    </select>
                                    @error('skp1')
                                        <span class='invalid-feedback' style='font-size:15px;'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <table class='table table-bordered table-striped' width='100%'>
                                <tr style='background-color:#8e54e9;color:#fff'>

                                    <td width='10%'>Kriteria</td>
                                    <td width='7%' align='center'>Param</td>
                                    <td width='60%' align='center'>Value</td>
                                    <td width='20%' align='center'>Detail Value</td>
                                </tr>

                                <tr>

                                    <td width='10%'>Umur</td>
                                    <td width='7%' align='center'>
                                        <input type='hidden' name='jenis[]' value='umur'>
                                        <select name='param[]' id='ck_umur_param' class='form-control'>
                                            <option value='=' {{ @$pUmur == '-' ? 'selected' : '' }}>=</option>
                                            <option value='>=' {{ @$pUmur == '>=' ? 'selected' : '' }}>Max</option>
                                            <option value='<=' {{ @$pUmur == '<=' ? 'selected' : '' }}>Min</option>

                                        </select>
                                    </td>
                                    <td width='60%' align='center'>
                                        <input type='number' class='form-control' name='isi[]'
                                            value="{{ @$valUmur }}" id='ck_umur_value'
                                            placeholder="Masukkan batasan umur">
                                    </td>
                                    <td width='20%' align='center'>
                                        <div class="input-group date display-years" data-date-format="dd-mm-yyyy"
                                            data-date="{{ '31-12-' . date('Y') }}">
                                            <input class="form-control" type="text" name="isi_det[]" id="ck_umur_dv"
                                                placeholder="{{ '31-12-' . date('Y') }}"
                                                value="{{ empty($dtUmur) ? '31-12-' . date('Y') : $dtUmur }}">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>

                                    <td width='10%'>Aktif PNS</td>
                                    <td width='7%' align='center'>
                                        <input type='hidden' name='jenis[]' value='pns'>
                                        <select name='param[]' id='ck_pns_param' class='form-control'>
                                            <option value='=' {{ @$pPns == '-' ? 'selected' : '' }}>=</option>
                                            <option value='>=' {{ @$pPns == '>=' ? 'selected' : '' }}>Max</option>
                                            <option value='<=' {{ @$pPns == '<=' ? 'selected' : '' }}>Min</option>

                                        </select>
                                    </td>
                                    <td width='60%' align='center'>
                                        <input type='number' class='form-control' name='isi[]' id='ck_umur_value'
                                            value="{{ @$valPns }}" placeholder="Masukkan PNS (Tahun)">
                                    </td>
                                    <td width='20%' align='center'>
                                        <div class="input-group date display-years" data-date-format="dd-mm-yyyy"
                                            data-date="{{ '31-12-' . date('Y') }}">
                                            <input class="form-control" type="text" name="isi_det[]" id="ck_pns_dv"
                                                placeholder="{{ '31-12-' . date('Y') }}"
                                                value="{{ empty($dtPns) ? '31-12-' . date('Y') : $dtPns }}">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>

                                    <td width='10%'>Pendidikan</td>
                                    <td width='7%' align='center'>
                                        <input type='hidden' name='jenis[]' value='pendidikan'>
                                        <select name='param[]' id='ck_pendidikan_param[]' class='form-control'>
                                            <option value='='>=</option>
                                        </select>
                                    </td>
                                    <td width='60%' align='center'>

                                        <input type='hidden' name='isi[]' id='isi_pendidikan'
                                            value='{{ @$arrPendidikan[0] }}'>
                                        <select name='ck_pendidikan_value[]' id='ck_pendidikan_value'
                                            class='form-control select2' multiple
                                            onchange="updateIsi('isi_pendidikan',this.value)">
                                            <option value=''>Pilih Pendidikan</option>
                                            @foreach ($getPendidikan as $key => $item)
                                                <option value='{{ $item->pendidikan }}'
                                                    {{ in_array($item->pendidikan, $arrPendidikan) ? 'selected' : '' }}>
                                                    {{ $item->pendidikan }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width='20%' align='center'><input type='hidden' name='isi_det[]'
                                            value=''></td>
                                </tr>

                                <tr>

                                    <td width='10%'>Eselon</td>
                                    <td width='7%' align='center'>
                                        <input type='hidden' name='jenis[]' value='eselon'>
                                        <select name='param[]' id='ck_eselon_param' class='form-control'>
                                            <option value='='>=</option>
                                        </select>
                                    </td>
                                    <td width='60%' align='center'>
                                        <input type='hidden' name='isi[]' id='isi_eselon'
                                            value="{{ @$arrEselon[0] }}">
                                        <select name='ck_eselon_value[]' id='ck_eselon_value'
                                            class='form-control select2' multiple
                                            onchange="updateIsi('isi_eselon   ',this.value)">
                                            <option value=''>Pilih Eselon</option>
                                            @foreach ($getEselon as $key => $item)
                                                <option value='{{ $item->eselon }}'
                                                    {{ in_array($item->eselon, $arrEselon) ? 'selected' : '' }}>
                                                    {{ $item->eselon }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width='20%' align='center'><input type='hidden' name='isi_det[]'
                                            value=''></td>
                                </tr>
                                <tr>

                                    <td width='10%'>TMT Eselon</td>
                                    <td width='7%' align='center'>
                                        <input type='hidden' name='jenis[]' value='tmt_eselon'>
                                        <select name='param[]' id='ck_tmt_eselon_param' class='form-control'>
                                            <option value='=' {{ @$pTmt_eselon == '-' ? 'selected' : '' }}>=</option>
                                            <option value='>=' {{ @$pTmt_eselon == '>=' ? 'selected' : '' }}>Max
                                            </option>
                                            <option value='<=' {{ @$pTmt_eselon == '<=' ? 'selected' : '' }}>Min
                                            </option>

                                        </select>
                                    </td>
                                    <td width='60%' align='center'>
                                        <input type='number' class='form-control' name='isi[]'
                                            id='ck_tmt_eselon_value' placeholder="Masukkan batasan TMT Eselon (Tahun)"
                                            value='{{ @$valTmt_eselon }}'>
                                    </td>
                                    <td width='20%' align='center'>
                                        <div class="input-group date display-years" data-date-format="dd-mm-yyyy"
                                            data-date="{{ '31-12-' . date('Y') }}">
                                            <input class="form-control" name='isi_det[]' id='ck_tmt_eselon_dv'
                                                type="text" placeholder="{{ '31-12-' . date('Y') }}"
                                                value="{{ empty($dtTmt_eselon) ? '31-12-' . date('Y') : $dtTmt_eselon }}">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </td>
                                </tr>

                                <tr style='display:none'>

                                    <td width='10%'>Pangkat</td>
                                    <td width='7%' align='center'>
                                        <input type='hidden' name='jenis[]' value='pangkat'>
                                        <select name='param[]' id='ck_pangkat_param' class='form-control'>
                                            <option value='='>=</option>
                                        </select>
                                    </td>
                                    <td width='60%' align='center'>
                                        <input type='hidden' name='isi[]' id='isi_pangkat'
                                            value="{{ @$valPangkat[0] }}">
                                        <select name='ck_pangkat_value[]' id='ck_pangkat_value'
                                            class='form-control select2' multiple
                                            onchange="updateIsi('isi_pangkat',this.value)">
                                            <option value=''>Pilih Pangkat</option>
                                            @foreach ($getPangkat as $key => $item)
                                                <option value='{{ $item->pangkat }}'
                                                    {{ in_array($item->pangkat, $arrPangkat) ? 'selected' : '' }}>
                                                    {{ $item->pangkat }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width='20%' align='center'><input type='hidden' name='isi_det[]'
                                            value=''></td>
                                </tr>

                                <tr>

                                    <td width='10%'>Golongan</td>
                                    <td width='7%' align='center'>
                                        <input type='hidden' name='jenis[]' value='golongan'>
                                        <select name='param[]' id='ck_golongan_param' class='form-control'>
                                            <option value='='>=</option>
                                        </select>
                                    </td>
                                    <td width='60%' align='center'>
                                        <input type='hidden' name='isi[]' id='isi_golongan'
                                            value="{{ @$valGolongan[0] }}">
                                        <select name='ck_golongan_value[]' id='ck_golongan_value'
                                            class='form-control select2' multiple
                                            onchange="updateIsi('isi_golongan',this.value)">
                                            <option value=''>Pilih Golongan</option>
                                            @foreach ($getGolongan as $key => $item)
                                                <option value='{{ $item->golongan }}'
                                                    {{ in_array($item->golongan, $arrGolongan) ? 'selected' : '' }}>
                                                    {{ $item->golongan }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width='20%' align='center'><input type='hidden' name='isi_det[]'
                                            value=''></td>
                                </tr>

                                <tr>

                                    <td width='10%'>TMT Pangkat</td>
                                    <td width='7%' align='center'>
                                        <input type='hidden' name='jenis[]' value='tmt_pangkat'>
                                        <select name='param[]' id='ck_tmt_pangkat_param' class='form-control'>
                                            <option value='=' {{ @$pTmt_pangkat == '-' ? 'selected' : '' }}>=
                                            </option>
                                            <option value='>=' {{ @$pTmt_pangkat == '>=' ? 'selected' : '' }}>Max
                                            </option>
                                            <option value='<=' {{ @$pTmt_pangkat == '<=' ? 'selected' : '' }}>Min
                                            </option>
                                        </select>
                                    </td>
                                    <td width='60%' align='center'>
                                        <input type='number' class='form-control' name='isi[]'
                                            id='ck_tmt_pangkat_value' placeholder="Masukkan batasan TMT Pangkat (Tahun)"
                                            value="{{ @$valTmt_pangkat }}">
                                    </td>
                                    <td width='20%' align='center'>
                                        <div class="input-group date display-years" data-date-format="dd-mm-yyyy"
                                            data-date="{{ '31-12-' . date('Y') }}">
                                            <input class="form-control" name='isi_det[]' id='ck_tmt_pangkat_dv'
                                                type="text" placeholder="{{ '31-12-' . date('Y') }}"
                                                value="{{ empty($dtTmt_pangkat) ? '31-12-' . date('Y') : $dtTmt_pangkat }}">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>

                                    <td width='10%'>Level Jabatan</td>
                                    <td width='7%' align='center'>
                                        <input type='hidden' name='jenis[]' value='level_jabatan'>
                                        <select name='param[]' id='ck_lvl_jabatan_param' class='form-control'>
                                            <option value='='>=</option>
                                        </select>
                                    </td>
                                    <td width='60%' align='center'>
                                        <input type='hidden' name='isi[]' id='isi_lvl_jabatan'
                                            value="{{ @$arrLvJabatan[0] }}">
                                        <select name='ck_lvl_jabatan_value[]' id='ck_lvl_jabatan_value'
                                            class='form-control select2' multiple
                                            onchange="updateIsi('isi_lvl_jabatan',this.value)">
                                            <option value=''>Pilih Level Jabatan</option>
                                            @foreach ($getLvlJabatan as $key => $item)
                                                <option value='{{ $item->level_jabatan }}'
                                                    {{ in_array($item->level_jabatan, $arrLvJabatan) ? 'selected' : '' }}>
                                                    {{ $item->level_jabatan }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width='20%' align='center'><input type='hidden' name='isi_det[]'
                                            value=''></td>
                                </tr>

                                <tr>

                                    <td width='10%'>TMT Jabatan</td>
                                    <td width='7%' align='center'>
                                        <input type='hidden' name='jenis[]' value='tmt_jabatan'>
                                        <select name='param[]' id='ck_tmt_jabatan_param' class='form-control'>
                                            <option value='=' {{ @$pTmt_jabatan == '-' ? 'selected' : '' }}>=
                                            </option>
                                            <option value='>=' {{ @$pTmt_jabatan == '>=' ? 'selected' : '' }}>Max
                                            </option>
                                            <option value='<=' {{ @$pTmt_jabatan == '<=' ? 'selected' : '' }}>Min
                                            </option>
                                        </select>
                                    </td>
                                    <td width='60%' align='center'>
                                        <input type='number' class='form-control' name='isi[]'
                                            id='ck_tmt_jabatan_value' placeholder="Masukkan batasan TMT Jabatan (Tahun)"
                                            value="{{ @$valTmt_jabatan }}">
                                    </td>
                                    <td width='20%' align='center'>
                                        <div class="input-group date display-years" data-date-format="dd-mm-yyyy"
                                            data-date="{{ '31-12-' . date('Y') }}">
                                            <input class="form-control" name='isi_det[]' id='ck_tmt_jabatan_dv'
                                                type="text" placeholder="{{ '31-12-' . date('Y') }}"
                                                value="{{ empty($dtTmt_jabatan) ? '31-12-' . date('Y') : $dtTmt_jabatan }}">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>

                                    <td width='10%'>Satker</td>
                                    <td width='7%' align='center'>
                                        <input type='hidden' name='jenis[]' value='satker'>
                                        <select name='param[]' id='ck_satker_param' class='form-control'>
                                            <option value='=' {{ @$pSatker == '-' ? 'selected' : '' }}>=</option>
                                            <option value='>=' {{ @$pSatker == '>=' ? 'selected' : '' }}>Max</option>
                                            <option value='<=' {{ @$pSatker == '<=' ? 'selected' : '' }}>Min</option>
                                        </select>
                                    </td>
                                    <td width='60%' align='center'>
                                        <input type='number' class='form-control' name='isi[]' id='ck_satker_value'
                                            placeholder="Masukkan batasan Satker (Tahun)" value="{{ @$valSatker }}">
                                    </td>
                                    <td width='20%' align='center'>
                                        <div class="input-group date display-years" data-date-format="dd-mm-yyyy"
                                            data-date="{{ '31-12-' . date('Y') }}">
                                            <input class="form-control" name='isi_det[]' id='ck_satker_dv'
                                                type="text" placeholder="{{ '31-12-' . date('Y') }}"
                                                value="{{ empty($dtSatker) ? '31-12-' . date('Y') : $dtSatker }}">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>

                                    <td width='10%'>Tipe Pegawai</td>
                                    <td width='7%' align='center'>
                                        <input type='hidden' name='jenis[]' value='tipe_pegawai'>
                                        <select name='param[]' id='ck_tipe_pegawai_param' class='form-control'>
                                            <option value='='>=</option>
                                        </select>
                                    </td>
                                    <td width='60%' align='center'>
                                        <input type='hidden' name='isi[]' id='isi_tipe_pegawai'
                                            value="{{ @$arrTpPegawai[0] }}">
                                        <select name='ck_tipe_pegawai_value[]' id='ck_tipe_pegawai_value'
                                            class='form-control select2' multiple
                                            onchange="updateIsi('isi_tipe_pegawai',this.value)">
                                            <option value=''>Pilih Tipe Pegawai</option>
                                            @foreach ($getTipePegawai as $key => $item)
                                                <option value='{{ $item->tipepegawai }}'
                                                    {{ in_array($item->tipepegawai, $arrTpPegawai) ? 'selected' : '' }}>
                                                    {{ $item->tipepegawai }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width='20%' align='center'><input type='hidden' name='isi_det[]'
                                            value=''></td>
                                </tr>

                                <tr>

                                    <td width='10%'>Status Pegawai</td>
                                    <td width='7%' align='center'>
                                        <input type='hidden' name='jenis[]' value='status_pegawai'>
                                        <select name='param[]' id='ck_status_pegawai_param' class='form-control'>
                                            <option value='='>=</option>
                                        </select>
                                    </td>
                                    <td width='60%' align='center'>
                                        <input type='hidden' name='isi[]' id='isi_status_pegawai'
                                            value="{{ @$arrStatPegawai[0] }}">
                                        <select name='ck_status_pegawai_value[]' id='ck_status_pegawai_value'
                                            class='form-control select2' multiple
                                            onchange="updateIsi('isi_status_pegawai',this.value)">
                                            <option value=''>Pilih Status Pegawai</option>
                                            @foreach ($getStatusPegawai as $key => $item)
                                                <option value='{{ $item->statuspegawai }}'
                                                    {{ in_array($item->statuspegawai, $arrStatPegawai) ? 'selected' : '' }}>
                                                    {{ $item->statuspegawai }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width='20%' align='center'><input type='hidden' name='isi_det[]'
                                            value=''></td>
                                </tr>
                                <tr>
                                    <td colspan='5' align='right'>
                                        <input type='submit' name='submit' value='submit'
                                            class='btn btn-primary mt-3 mb-3'>
                                    </td>
                                </tr>

                            </table>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>



@endsection

@section('page-js-script')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2({
                allowClear: true,
            });
        });

        function updateIsi(jenis, value) {
            $("#" + jenis + "").val(value);
        }
    </script>
@stop
