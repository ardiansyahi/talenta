
@extends("layouts.app",["title"=>"Konfigurasi KRS"])
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
    .fa-times{
        font-size:20px;
    }
</style>
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Talent Mapping Step 3</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i></a>
                            </li>
                            
                            <li class="breadcrumb-item " aria-current="page">
                                <a href="{{route('talent-mapping')}}">Talent Mapping</a>
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Step 3</li>
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
                    @foreach($data as $key => $value)
                        <div class='row mb-3 mt-3'>
                            <div class='col-lg-2'>Talent Mapping Tahun</div>
                            <div class='col-lg-10'>{{$value->tahun}}</div>
                        </div>
                        <div class='row mb-3'>
                            <div class='col-lg-2'>Jenis Talent Mapping</div>
                            <div class='col-lg-10'>{{str_ireplace("_"," ",$value->jenis)}}</div>
                        </div>
                        <div class='row mb-3'>
                            <div class='col-lg-2'>Batch</div>
                            <div class='col-lg-10'>{{$value->batch}}</div>
                        </div>
                        <div class='row mb-3'>
                            <div class='col-lg-2'>Deskripsi</div>
                            <div class='col-lg-10'>{{$value->deskripsi}}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class="col-lg-6">
            <div class="card card-statistics">
                <div class="card-header text-white bg-primary">Setting Penkom</div>
                <div class="card-body">
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-4'>Jenis Penkom </div>
                        <div class='col-sm-8'>
                            <select name='jenis_penkom' id='jenis_penkom'  class='form-control'>
                                <option value=''>Pilih Ujian Penkom yang akan digunakan</option>
                                <option value='pelaksana' {{(@$datapenkom->kriteria =='pelaksana') ? 'selected':'';}}>Pelaksana</option>
                                <option value='pengawas' {{(@$datapenkom->kriteria =='pengawas') ? 'selected':'';}}>Pengawas</option>
                                <option value='administrator' {{(@$datapenkom->kriteria =='administrator') ? 'selected':'';}}>Administrator</option>
                                <option value='jpt_pratama' {{(@$datapenkom->kriteria =='jpt_pratama') ? 'selected':'';}}>JPT Pratama</option>
                                <option value='jpt_madya' {{(@$datapenkom->kriteria =='jpt_madya') ? 'selected':'';}}>JPT Madya</option>
                            </select>
                        </div>
                    </div>   
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-4'>Tahun batas ujian</div>
                        <div class='col-sm-8'>
                            <select name='tahun_penkom' id='tahun_penkom' class='form-control'>
                                @for($a=date('Y');$a >= (date('Y') - 100);$a--)
                                    <option value={{$a;}} {{(@$datapenkom->value ==$a) ? 'selected':'';}}>{{$a}}</option>
                                @endfor
                               
                               
                            </select>
                        </div>
                    </div> 
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-12'>
                            <a href='#jenis_penkom' class='btn btn-primary float-right' onclick="update_penkom('add')">Update</a>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
   
        <div class="col-lg-6">
            <div class="card card-statistics">
                <div class="card-header  text-white bg-primary">Setting Bobot Diklat Struktural</div>
                <div class="card-body">
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-4'>Sesuai</div>
                        <div class='col-sm-8'>
                            <input type='number' class='form-control' value="{{@$dataDSS->isidata}}" name='setting_ds_sesuai' id='setting_ds_sesuai'>
                        </div>
                    </div>   
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-4'>Tidak Sesuai</div>
                        <div class='col-sm-8'><input type='number' class='form-control' value="{{@$dataDST->isidata}}" name='setting_ds_tidak' id='setting_ds_tidak'></div>
                    </div> 
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-12'>
                             <div class='col-sm-2 float-right'><a href='#setting_ds_tidak' onclick="update_ds()"  class='btn btn-primary float-right'>update</a></div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="col-lg-6">
            <div class="card card-statistics">
                <div class="card-header text-white bg-primary">Setting Skoring Pendidikan</div>
                <div class="card-body">
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-5'>Kriteria Pendidikan</div>
                        <div class='col-sm-5'>Value</div>
                         <div class='col-sm-2'></div>
                    </div>   
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-5'>
                            <select name='setting_sp_kriteria' id='setting_sp_kriteria' class='form-control select2' >
                                <option value=''>Pilih Pendidikan</option>
                                @foreach ($getPendidikan as $key => $item)
                                    <option value='{{$item->pendidikan}}'> {{$item->pendidikan}}</option>
                                @endforeach
                            </select>
                            
                        </div>
                        <div class='col-sm-5'><input type='number' class='form-control' name='setting_sp_value' id='setting_sp_value'></div>
                        <div class='col-sm-2'><a href='#setting_sp_kriteria' onclick="update_skp('add')" class='btn btn-primary'>Tambah</a></div>
                    </div> 
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-12' id='isi_skp'>
                            <table id='tablex1' class='display compact table table-striped table-bordered table-hovered' width='100%' border='1'>
                                <thead>
                                <tr>
                                    <th width='10%'>No </th>
                                    <th width='40%'>Kriteria </th>
                                    <th width='40%'>Value  </th>
                                    <th width='10%'>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataSKP as $key => $value)
                                        <tr>
                                            <td align='center'>{{$key+1}}</td>
                                            <td align='center'>{{$value->kriteria}}</td>
                                            <td align='center'>{{$value->isidata}}</td>
                                            <td align='center'>
                                                <a href='#setting_sp_kriteria' onclick="deleteSKP('{{$value->id}}')"  
                                                class='text-danger' title='Hapus Data'><i class='fa fa-times'></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>        
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    
        <div class="col-lg-6">
            <div class="card card-statistics">
                <div class="card-header text-white bg-primary">Setting Bobot Riwayat Jabatan</div>
                <div class="card-body">
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-5'>Jumlah Riwayat</div>
                        <div class='col-sm-5'>Bobot</div>
                         <div class='col-sm-2'></div>
                    </div>   
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-5'>
                            <div class="input-group  input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> > = </span>
                                </div>
                                <input type='text' class='form-control' name='setting_rwj_kriteria' id='setting_rwj_kriteria'>
                            </div>
                        </div>
                        <div class='col-sm-5'><input type='number' class='form-control' name='setting_rwj_value' id='setting_rwj_value'></div>
                        <div class='col-sm-2'><a href='#setting_rwj_kriteria' onclick="update_rwj('add')" class='btn btn-primary'>Tambah</a></div>
                    </div> 
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-12' id='isi_rwj'>
                            <table id='tablex2' class='display compact table table-striped table-bordered table-hovered' width='100%' border='1'>
                                <thead>
                                <tr>
                                    <th width='10%'>No </th>
                                    <th width='40%'>Jumlah Riwayat </th>
                                    <th width='40%'>Bobot  </th>
                                    <th width='10%'>Action</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                     @foreach($dataRWJ as $key => $value)
                                        <tr>
                                            <td align='center'>{{$key+1}}</td>
                                            <td align='center'>{{$value->kriteria}}</td>
                                            <td align='center'>{{$value->isidata}}</td>
                                            <td align='center'>
                                                <a href='#setting_rwj_value' onclick="deleteRWJ('{{$value->id}}')"  
                                                class='text-danger' title='Hapus Data'><i class='fa fa-times'></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>

   

    <div class='row'>
        <div class="col-lg-6">
            <div class="card card-statistics">
                <div class="card-header text-white bg-primary">Setting Bobot Diklat Teknis</div>
                <div class="card-body">
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-5'>Jumlah Riwayat</div>
                        <div class='col-sm-5'>Bobot</div>
                         <div class='col-sm-2'></div>
                    </div>   
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-5'>
                            <div class="input-group  input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> > = </span>
                                </div>
                                <input type='text' class='form-control' name='setting_dt_kriteria' id='setting_dt_kriteria'>
                            </div>
                        </div>
                        <div class='col-sm-5'><input type='number' class='form-control' name='setting_dt_value' id='setting_dt_value'></div>
                        <div class='col-sm-2'><a href='#setting_dt_value' onclick="update_dt('add')" class='btn btn-primary'>Tambah</a></div>
                    </div> 
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-12' id='isi_dt'>
                            <table id='tablex3' class='display compact table table-striped table-bordered table-hovered' width='100%' border='1'>
                                <thead>
                                <tr>
                                    <th width='10%'>No </th>
                                    <th width='40%'>Jumlah </th>
                                    <th width='40%'>Bobot  </th>
                                    <th width='10%'>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach(@$dataDT as $key => $value)
                                        <tr>
                                            <td align='center'>{{$key+1}}</td>
                                            <td align='center'>{{$value->kriteria}}</td>
                                            <td align='center'>{{$value->isidata}}</td>
                                            <td align='center'>
                                                <a href='#setting_dt_value' onclick="deleteDT('{{$value->id}}')"  
                                                class='text-danger' title='Hapus Data'><i class='fa fa-times'></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>        
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    
        <div class="col-lg-6">
            <div class="card card-statistics">
                <div class="card-header text-white bg-primary">Setting Skoring Pangkat</div>
                <div class="card-body">
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-5'>Pangkat </div>
                        <div class='col-sm-5'>Bobot</div>
                         <div class='col-sm-2'></div>
                    </div>   
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-5'>
                             <select name='setting_pangkat_kriteria' id='setting_pangkat_kriteria' class='form-control select2' >
                                <option value=''>Pilih Pangkat</option>
                                @foreach ($getGolongan as $key => $item)
                                    <option value='{{$item->golongan}}'> {{$item->golongan}}</option>
                                @endforeach
                            </select>
                           
                        </div>
                        <div class='col-sm-5'><input type='number' class='form-control' name='setting_pangkat_value' id='setting_pangkat_value'></div>
                        <div class='col-sm-2'><a href='#setting_pangkat_value' onclick="update_sp('add')" class='btn btn-primary'>Tambah</a></div>
                    </div> 
                    <div class='row mb-3 mt-3'>
                        <div class='col-sm-12' id='isi_sp'>
                            <table id='tablex4' class='display compact table table-striped table-bordered table-hovered' width='100%' border='1'>
                                <thead>
                                <tr>
                                    <th width='10%'>No </th>
                                    <th width='40%'>Pangkat </th>
                                    <th width='40%'>Bobot  </th>
                                    <th width='10%'>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataSP as $key => $value)
                                        <tr>
                                            <td align='center'>{{$key+1}}</td>
                                            <td align='center'>{{$value->kriteria}}</td>
                                            <td align='center'>{{$value->isidata}}</td>
                                            <td align='center'>
                                                <a href='#setting_pangkat_value' onclick="deleteSP('{{$value->id}}')"  
                                                class='text-danger' title='Hapus Data'><i class='fa fa-times'></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>        
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body">
                     <a href="{{url('/talent-mapping/step4/'.$id.'')}}" class='btn btn-primary btn-lg float-right '>Lanjut ke Step 4</a>
                </div>
            </div>
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
                        <img src="{{asset('assets/img/loader/loader.svg')}}" id='img1'><br/>
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
    function closeModal(){
         $('#popUpUpload').modal('hide');
    }
    $(document).ready(function() {
        $('.select2').select2({
            allowClear: true,
    });
    });


    function deleteSKP(id){
        if (confirm("Yakin Data mau dihapus ?") == true) {
            update_skp('delete',id)
        }
    }
    function update_skp(type,id=null){
        $("#popUpUploadTitle").html('Setting Konfigurasi Pendidikan')
        if (($("#setting_sp_kriteria").val() =='' || $("#setting_sp_value").val() =='') && type=='add' ){
            $("#lbl1").html('Masih ada field yang kosong');
            $("#img1").hide();
            $("#popUpUpload").modal('show');
        }else{
            $("#lbl1").html('Mohon Menunggu...');
            $("#img1").show();
            $("#popUpUpload").modal('show');
            $("#btn-close").hide();
            $.ajax({
                url:"{{route('talent-mapping/storekonfig')}}",
                type:'post',
                data:{
                    kriteria: $("#setting_sp_kriteria").val(),
                    isidata: $("#setting_sp_value").val(),
                    jenis : 'skoring_pendidikan',
                    id_krs:'{{$id}}',
                    id:id,
                    type:type,
                    created_by:'{{Auth::user()->userid}}',
                    _token: "{{ csrf_token() }}"
                },
                dataType:'JSON',
                success:function(result){
                    if(result.respon=='success'){
                        $("#isi_skp").empty();
                        $("#isi_skp").append(`
                            <table id='tablex1' class='display compact table table-striped table-bordered table-hovered' width='100%' border='1'>
                                <thead>
                                <tr>
                                    <th width='10%'>No </th>
                                    <th width='40%'>Kriteria </th>
                                    <th width='40%'>Value  </th>
                                    <th width='10%'>Action</th>
                                    
                                </tr>
                                </thead>
                                <tbody></tbody>
                                </table>
                            
                         `);
                            let a=1;
                            $.each(result.data,function(i,item){
                                $('#tablex1 > tbody:last-child').append(`
                                    <tr>
                                        <td width='10%' align='center'>`+a+`</td>
                                        <td width='10%' align='center'>`+item.kriteria+`</td>
                                        <td width='20%' align='center'>`+item.isidata+`</td>
                                        <td width='10%' align='center'>
                                            <a href='#setting_sp_value' onclick="deleteSKP('`+item.id+`')"  
                                                class='text-danger' title='Hapus Data'><i class='fa fa-times'></i></a>
                                        </td>
                                    </tr>
                                    
                                `);
                                a++;
                            })
                        $("#setting_sp_kriteria").val('');
                        $("#setting_sp_value").val('');
                        $('#setting_sp_kriteria').val(null).trigger('change');
                        setTimeout(function(){
                            $("#lbl1").html('Sukses Simpan Data');
                            $("#img1").hide();
                            $("#popUpUpload").modal('hide');
                            console.log(result)
                        }, 2000);
                    }else{
                        $("#lbl1").html('Gagal Simpan Data');
                        $("#img1").hide();
                        $("#btn-close").show();
                    }
                }
            })
            
                
        }
       
    }

    function deleteRWJ(id){
        if (confirm("Yakin Data mau dihapus ?") == true) {
            update_rwj('delete',id)
        }
    }
    function update_rwj(type,id=null){
        $("#popUpUploadTitle").html('Setting Konfigurasi Bobot Riwayat Jabatan')
        if (($("#setting_rwj_kriteria").val() =='' || $("#setting_rwj_value").val() =='') && type=='add' ){
            $("#lbl1").html('Masih ada field yang kosong');
            $("#img1").hide();
            $("#popUpUpload").modal('show');
        }else{
            $("#lbl1").html('Mohon Menunggu...');
            $("#img1").show();
            $("#popUpUpload").modal('show');
            $("#btn-close").hide();
            $.ajax({
                url:"{{route('talent-mapping/storekonfig')}}",
                type:'post',
                data:{
                    kriteria: $("#setting_rwj_kriteria").val(),
                    isidata: $("#setting_rwj_value").val(),
                    jenis : 'riwayat_jabatan',
                    id_krs:'{{$id}}',
                    id:id,
                    type:type,
                    created_by:'{{Auth::user()->userid}}',
                    _token: "{{ csrf_token() }}"
                },
                dataType:'JSON',
                success:function(result){
                    
                    if(result.respon=='success'){
                        $("#isi_rwj").empty();
                        $("#isi_rwj").append(`
                            <table id='tablex2' class='display compact table table-striped table-bordered table-hovered' width='100%' border='1'>
                                <thead>
                                <tr>
                                    <th width='10%'>No </th>
                                    <th width='40%'>Jumlah Riwayat </th>
                                    <th width='40%'>Bobot  </th>
                                    <th width='10%'>Action</th>
                                    
                                </tr>
                                </thead>
                                <tbody></tbody>
                                </table>
                            
                         `);
                            let a=1;
                            $.each(result.data,function(i,item){
                                $('#tablex2 > tbody:last-child').append(`
                                    <tr>
                                        <td width='10%' align='center'>`+a+`</td>
                                        <td width='10%' align='center'>`+item.kriteria+`</td>
                                        <td width='20%' align='center'>`+item.isidata+`</td>
                                        <td width='10%' align='center'>
                                            <a href='#setting_rwj_kriteria' onclick="deleteRWJ('`+item.id+`')"  
                                                class='text-danger' title='Hapus Data'><i class='fa fa-times'></i></a>
                                        </td>
                                    </tr>
                                    
                                `);
                                a++;
                            })
                        $("#setting_rwj_kriteria").val('');
                        $("#setting_rwj_value").val('');
                        setTimeout(function(){
                            $("#lbl1").html('Sukses Simpan Data');
                            $("#img1").hide();
                            $("#popUpUpload").modal('hide');
                            console.log(result)
                        }, 2000);
                    }else{
                        $("#lbl1").html('Gagal Simpan Data');
                        $("#img1").hide();
                        $("#btn-close").show();
                    }
                }
            })
            
                
        }
       
    }

    function update_ds(){
        $("#popUpUploadTitle").html('Setting Konfigurasi Diklat Struktural')
        if ($("#setting_ds_sesuai").val() =='' || $("#setting_ds_tidak").val() ==''){
            $("#lbl1").html('Masih ada field yang kosong');
            $("#img1").hide();
            $("#popUpUpload").modal('show');
        }else{
            $("#lbl1").html('Mohon Menunggu...');
            $("#img1").show();
            $("#popUpUpload").modal('show');
            $("#btn-close").hide();
            $.ajax({
                url:"{{route('talent-mapping/storekonfig')}}",
                type:'post',
                data:{
                    kriteria: "Sesuai",
                    isidata: $("#setting_ds_sesuai").val(),
                    kriteria_2: "Tidak Sesuai",
                    isidata_2: $("#setting_ds_tidak").val(),
                    jenis : 'diklat_struktural',
                    id_krs:'{{$id}}',
                    type:'add',
                    created_by:'{{Auth::user()->userid}}',
                    _token: "{{ csrf_token() }}"
                },
                dataType:'JSON',
                success:function(result){
                    if(result.respon=='success'){
                        setTimeout(function(){
                            $("#lbl1").html('Sukses Simpan Data');
                            $("#img1").hide();
                            $("#popUpUpload").modal('hide');
                            console.log(result)
                        }, 2000);
                        
                    }else{
                        $("#lbl1").html('Gagal Simpan Data');
                        $("#img1").hide();
                        $("#btn-close").show();
                    }
                }
            })
            
                
        }
       
    }

    function update_penkom(type){
        $("#popUpUploadTitle").html('Setting Konfigurasi Pendidikan')
        if ($("#tahun_penkom").val() =='' || $("#jenis_penkom").val() ==''){
            $("#lbl1").html('Masih ada field yang kosong');
            $("#img1").hide();
            $("#popUpUpload").modal('show');
        }else{
            $("#lbl1").html('Mohon Menunggu...');
            $("#img1").show();
            $("#popUpUpload").modal('show');
            $("#btn-close").hide();
            $.ajax({
                url:"{{route('talent-mapping/storekonfig')}}",
                type:'post',
                data:{
                    kriteria: $("#jenis_penkom").val(),
                    isidata: $("#tahun_penkom").val(),
                    jenis : 'penkom',
                    type:type,
                    id_krs:'{{$id}}',
                    created_by:"{{Auth::user()->userid}}",
                    _token: "{{ csrf_token() }}"
                },
                dataType:'JSON',
                
                success:function(result){
                    if(result.respon=='success'){
                        setTimeout(function(){
                            $("#lbl1").html('Sukses Simpan Data');
                            $("#img1").hide();
                            $("#popUpUpload").modal('hide');
                            console.log(result)
                        }, 2000);
                        
                    }else{
                        $("#lbl1").html('Gagal Simpan Data');
                        $("#img1").hide();
                        $("#btn-close").show();
                    }
                }
            })
            
                
        }
       
    }

    function deleteDT(id){
        if (confirm("Yakin Data mau dihapus ?") == true) {
            update_dt('delete',id)
        }
    }

    function update_dt(type,id=null){
        $("#popUpUploadTitle").html('Setting Bobot Diklat Teknis')
        if (($("#setting_dt_kriteria").val() =='' || $("#setting_dt_value").val() =='') && type=='add' ){
            $("#lbl1").html('Masih ada field yang kosong');
            $("#img1").hide();
            $("#popUpUpload").modal('show');
        }else{
            $("#lbl1").html('Mohon Menunggu...');
            $("#img1").show();
            $("#popUpUpload").modal('show');
            $("#btn-close").hide();
            $.ajax({
                url:"{{route('talent-mapping/storekonfig')}}",
                type:'post',
                data:{
                    kriteria: $("#setting_dt_kriteria").val(),
                    isidata: $("#setting_dt_value").val(),
                    jenis : 'diklat_teknis',
                    id_krs:'{{$id}}',
                    id:id,
                    type:type,
                    created_by:"{{Auth::user()->userid}}",
                    _token: "{{ csrf_token() }}"
                },
                dataType:'JSON',
                success:function(result){
                    if(result.respon=='success'){
                        $("#isi_dt").empty();
                        $("#isi_dt").append(`
                            <table id='tablex3' class='display compact table table-striped table-bordered table-hovered' width='100%' border='1'>
                                <thead>
                                <tr>
                                    <th width='10%'>No </th>
                                    <th width='40%'>Jumlah </th>
                                    <th width='40%'>Bobot  </th>
                                    <th width='10%'>Action</th>
                                    
                                </tr>
                                </thead>
                                <tbody></tbody>
                                </table>
                            
                         `);
                            let a=1;
                            $.each(result.data,function(i,item){
                                $('#tablex3 > tbody:last-child').append(`
                                    <tr>
                                        <td width='10%' align='center'>`+a+`</td>
                                        <td width='10%' align='center'>`+item.kriteria+`</td>
                                        <td width='20%' align='center'>`+item.isidata+`</td>
                                        <td width='10%' align='center'>
                                            <a href='#setting_dt_value' onclick="deleteDT('`+item.id+`')"  
                                                class='text-danger' title='Hapus Data'><i class='fa fa-times'></i></a>
                                        </td>
                                    </tr>
                                    
                                `);
                                a++;
                            })
                        $("#setting_dt_kriteria").val('');
                        $("#setting_dt_value").val('');
                        setTimeout(function(){
                            $("#lbl1").html('Sukses Simpan Data');
                            $("#img1").hide();
                            $("#popUpUpload").modal('hide');
                            console.log(result)
                        }, 2000);
                    }else{
                        $("#lbl1").html('Gagal Simpan Data');
                        $("#img1").hide();
                        $("#btn-close").show();
                    }
                }
            })
            
                
        }
       
    }

    function deleteSP(id){
        if (confirm("Yakin Data mau dihapus ?") == true) {
            update_sp('delete',id)
        }
    }

    function update_sp(type,id=null){
        $("#popUpUploadTitle").html('Setting Konfigurasi Skoring Pangkat')
        if (($("#setting_pangkat_kriteria").val() =='' || $("#setting_pangkat_value").val() =='') && type=='add' ){
            $("#lbl1").html('Masih ada field yang kosong');
            $("#img1").hide();
            $("#popUpUpload").modal('show');
        }else{
            $("#lbl1").html('Mohon Menunggu...');
            $("#img1").show();
            $("#popUpUpload").modal('show');
            $("#btn-close").hide();
            $.ajax({
                url:"{{route('talent-mapping/storekonfig')}}",
                type:'post',
                data:{
                    kriteria: $("#setting_pangkat_kriteria").val(),
                    isidata: $("#setting_pangkat_value").val(),
                    jenis : 'skoring_pangkat',
                    id_krs:'{{$id}}',
                    id:id,
                    type:type,
                    created_by:'{{Auth::user()->userid}}',
                    _token: "{{ csrf_token() }}"
                },
                dataType:'JSON',
                success:function(result){
                    if(result.respon=='success'){
                        $("#isi_sp").empty();
                        $("#isi_sp").append(`
                            <table id='tablex4' class='display compact table table-striped table-bordered table-hovered' width='100%' border='1'>
                                <thead>
                                <tr>
                                    <th width='10%'>No </th>
                                    <th width='40%'>Pangkat </th>
                                    <th width='40%'>Bobot  </th>
                                    <th width='10%'>Action</th>
                                    
                                </tr>
                                </thead>
                                <tbody></tbody>
                                </table>
                            
                         `);
                            let a=1;
                            $.each(result.data,function(i,item){
                                $('#tablex4 > tbody:last-child').append(`
                                    <tr>
                                        <td width='10%' align='center'>`+a+`</td>
                                        <td width='10%' align='center'>`+item.kriteria+`</td>
                                        <td width='20%' align='center'>`+item.isidata+`</td>
                                        <td width='10%' align='center'>
                                            <a href='#setting_pangkat_value' onclick="deleteSP('`+item.id+`')"  
                                                class='text-danger' title='Hapus Data'><i class='fa fa-times'></i></a>
                                        </td>
                                    </tr>
                                    
                                `);
                                a++;
                            })
                        $("#setting_pangkat_kriteria").val('');
                        $("#setting_pangkat_value").val('');
                        $('#setting_pangkat_kriteria').val(null).trigger('change');
                        setTimeout(function(){
                            $("#lbl1").html('Sukses Simpan Data');
                            $("#img1").hide();
                            $("#popUpUpload").modal('hide');
                            console.log(result)
                        }, 2000);
                    }else{
                        $("#lbl1").html('Gagal Simpan Data');
                        $("#img1").hide();
                        $("#btn-close").show();
                    }
                }
            })
            
                
        }
       
    }
   
</script>
@stop