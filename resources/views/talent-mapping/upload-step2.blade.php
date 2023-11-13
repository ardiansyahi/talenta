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

        .span-danger {
            font-size: 15px;
        }
    </style>
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Talent Mapping Upload</h1>
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
                            <li class="breadcrumb-item " aria-current="page">
                                <a href="{{url('/talent-mapping/upload/'.$id.'')}}">Step 1</a>
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Step 2</li>
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
                    @if ($status == 'delete')
                        <div class='alert alert-inverse-danger mb-3 text-dark ' style='font-size:20px'>
                            <i class='fa fa-info-circle'></i> Talent Mapping ini sudah dihapus
                        </div>
                    @else
                        <form action='{{ route('talent-mapping/prosesupload/step2') }}' method='post'
                            enctype="multipart/form-data">
                            @csrf
                            <input type='hidden' name='id' value='{{ $id }}'>
                            <div class='row mb-3 mt-3'>
                                <div class='col-lg-2'>Talent Mapping Tahun</div>
                                <div class='col-lg-10'>{{ $data->tahun }}</div>
                            </div>
                            <div class='row mb-3'>
                                <div class='col-lg-2'>Talent Mapping KRS</div>
                                <div class='col-lg-10'>{{ str_ireplace("_"," ",$data->jenis) }}</div>
                            </div>
                            <div class='row mb-3'>
                                <div class='col-lg-2'>Batch</div>
                                <div class='col-lg-10'>{{ $data->batch }}</div>
                            </div>
                            <div class='row mb-3'>
                                <div class='col-lg-2'>Deskripsi</div>
                                <div class='col-lg-10'>{{ $data->deskripsi }}</div>
                            </div>
                            <div class='row mb-3'>
                                <div class='col-lg-2'>Data Pegawai</div>
                                <div class='col-lg-10'>

                                    <select name='pegawai[]' id='pegawai'
                                        class='form-control select2  @error('pegawai') is-invalid @enderror' multiple>
                                        <option value=''>Pilih Data Pegawai</option>
                                        @foreach ($headings[0][0] as $key => $item)
                                            <option value='{{ $key . '^' . $item }}'> {{ str_ireplace('_', ' ', $item) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pegawai')
                                        <span class='invalid-feedback span-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <div class='col-lg-2'>Data Potensial</div>
                                <div class='col-lg-10'>

                                    <select name='potensial[]' id='potensial'
                                        class='form-control select2  @error('potensial') is-invalid @enderror' multiple>
                                        <option value=''>Pilih Data Pegawai</option>
                                        @foreach ($headings[0][0] as $key => $item)
                                            <option value='{{ $key . '^' . $item }}'> {{ str_ireplace('_', ' ', $item) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('potensial')
                                        <span class='invalid-feedback span-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <div class='col-lg-2'>Data Kinerja</div>
                                <div class='col-lg-10'>

                                    <select name='kinerja[]' id='kinerja'
                                        class='form-control select2  @error('kinerja') is-invalid @enderror' multiple>
                                        <option value=''>Pilih Data Kinerja</option>
                                        @foreach ($headings[0][0] as $key => $item)
                                            <option value='{{ $key . '^' . $item }}'> {{ str_ireplace('_', ' ', $item) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kinerja')
                                        <span class='invalid-feedback span-danger'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <div class='col-lg-12'>
                                    <input type='submit' class='btn btn-primary float-right' name='submit' value='UPLOAD'>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class="col-lg-12">

        </div>


    </div>


    <!-- Vertical Center Modal -->
    <div class="modal fade" id="popUpUpload" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="popUpUploadTitle"></h5>
                </div>
                <div class="modal-body" align='center'>
                    <img src="{{ asset('assets/img/loader/loader.svg') }}" id='img1'><br />
                    <label id='lbl1' class='text-dark'>Mohon Menuggu</label><br>
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
        function closeModal() {
            $('#popUpUpload').modal('hide');
        }

        $(document).ready(function() {
            $('.select2').select2({
                allowClear: true,
            });
        });
    </script>
@stop
