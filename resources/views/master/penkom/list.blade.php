@extends("layouts.app",["title"=>"Penkom List"])
@section('section')
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Penkom</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Hitung KRS
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Upload Penkom</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
        </div>

    </div>
    @if(session()->has('message'))
        <div class='alert alert-inverse-success'>
            {{session()->get('message')}}
        </div><br>
    @endif
    <div class='row'>
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class='mr-auto'>
                        <a href='#' onclick='showModal()' class='btn btn-primary float-right'>Upload Penkom</a>
                    </div>
                    <div class="datatable-wrapper table-responsive">
                        <table width="100%" id="datatable" class="display compact table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" align="center">No</th>
                                    <th width="15%" align="center">Tahun</th>
                                    <th width="65%" align="center">Jenis Penkom</th>
                                    <th width="15%" align="center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($data))
                                     @foreach($data as $key => $item)
                                        <tr>
                                            <td align='center'>{{$key+1}}</td>
                                            <td align='center'>{{$item->tahun}}</td>
                                            <td>{{str_ireplace("_"," ",$item->jenis)}}</td>
                                            <td align='center'>
                                                <a href="{{url('master/penkom/penkom-view/'.$item->tahun.'/'.$item->jenis.'/'.$item->hashname.'')}}" class='btn btn-primary'>View</a>
                                                <a href="{{url('master/penkom/penkom-delete/'.$item->tahun.'/'.$item->jenis.'/'.$item->hashname.'')}}" onclick="return confirm('Yakin Anda Ingin Menghapus Data Penkom tahun  {{$item->tahun}} ?')" class='btn btn-danger'>Delete</a>
                                            </td>
                                        </tr>

                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Vertical Center Modal -->
    <div class="modal fade" id="popUpUpload" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" style='max-width: 80%';>
            <div class="modal-content ">
                <form action='{{route('master/penkom/penkom-upload')}}' method='post' enctype="multipart/form-data" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="popUpUploadTitle">Upload Penkom</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>

                                @csrf
                                <div class='row'>
                                    <div class='col-sm-12 text-dark'>Pilih Tahun</div>
                                    <div class='col-sm-12 mb-3'>
                                        <input type='number' name='tahun' id='tahun' class='form-control @error('tahun') is-invalid @enderror' value='{{old('tahun')}}'>
                                        @error('tahun') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                                    </div>
                                    <div class='col-sm-12 text-dark'>Pilih Jenis Penkom</div>
                                    <div class='col-sm-12 mb-4'>
                                        <select name='jenis' id='jenis' class='form-control  @error('jenis') is-invalid @enderror' onchange="cekJenis(this.value)">
                                            <option value=''>Pilih Jenis</option>
                                            <option value='pelaksana' {{(old('jenis')=='pelaksana')?'selected':''}}>Penkom Pelaksana</option>
                                            <option value='pengawas' {{(old('jenis')=='pengawas')?'selected':''}}>Penkom Pengawas</option>
                                            <option value='administrator' {{(old('jenis')=='administrator')?'selected':''}}>Penkom Administrator</option>
                                            <option value='jpt_pratama' {{(old('jenis')=='jpt_pratama')?'selected':''}}>JPT Pratama</option>
                                            <option value='jpt_madya' {{(old('jenis')=='jpt_madya')?'selected':''}}>JPT Madya</option>
                                        </select>
                                        @error('jenis') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                                    </div>
                                </div>
                                <div class="input-group mb-4">
                                    <div class="custom-file">
                                        <input type="file" id="fileupload" class='form-control  @error('fileupload') is-invalid @enderror' name='fileupload'  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                        @error('fileupload') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                                    </div>
                                </div>

                            <div class='row'>
                                <div class='col-sm-12 mt-5 mb-4'>
                                    <img src="{{asset('assets/img/import/penkom/format-upload-penkom-pelaksana.PNG')}}" id='img_1' style='width:100%;display:none'>
                                    <img src="{{asset('assets/img/import/penkom/format-upload-penkom-pengawas.PNG')}}" id='img_2' style='width:100%;display:none'>
                                    <img src="{{asset('assets/img/import/penkom/format-upload-penkom-administrator.PNG')}}" id='img_3' style='width:100%;display:none'>
                                    <img src="{{asset('assets/img/import/penkom/format-upload-penkom-jpt.PNG')}}" id='img_4' style='width:100%;display:none'><br>
                                    <br>
                                    <a href="{{asset('format/format-excel-penkom-pelaksana.xlsx')}}" class='btn btn-success' id='link_1'  style='display:none'>Download Format Excel Pelaksana</a>
                                    <a href="{{asset('format/format-excel-penkom-pengawas.xlsx')}}" class='btn btn-success' id='link_2'  style='display:none'>Download Format Excel Pengawas</a>
                                    <a href="{{asset('format/format-excel-penkom-administrator.xlsx')}}" class='btn btn-success' id='link_3'  style='display:none'>Download Format Excel Administrator</a>
                                    <a href="{{asset('format/format-excel-penkom-jpt.xlsx')}}" class='btn btn-success' id='link_4'  style='display:none'>Download Format Excel JPT</a>
                                </div>
                            </div>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-success" name='submit' value='Upload Data'></input>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-js-script')
<script type="text/javascript">
    $(document).ready(function() {
        <?php
            if(session()->has('message')){
                ?>$('#popUpUpload').modal('hide')<?php
            }else{
                ?>$('#popUpUpload').modal('show')<?php
            }

        ?>
    });
    function cekJenis(kode){
        $("#link_1").hide();
        $("#img_1").hide();
        $("#link_2").hide();
        $("#img_2").hide();
        $("#link_3").hide();
        $("#img_3").hide();
        $("#link_4").hide();
        $("#img_4").hide();

        switch(kode){
            case "pelaksana":
                $("#link_1").show();
                $("#img_1").show();
                break;
            case "pengawas":
                $("#link_2").show();
                $("#img_2").show();
                break;
            case "administrator":
                $("#link_3").show();
                $("#img_3").show();
                break;
            case "jpt":
                $("#link_4").show();
                $("#img_4").show();
                break;
        }
    }
    function showModal(){
        $("#jenis").val('');
        $("#tahun").val('');
        $("#fileupload").val('');
        $('#popUpUpload').modal('show')
    }

</script>
@stop
