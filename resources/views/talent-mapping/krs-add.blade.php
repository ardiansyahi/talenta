@extends("layouts.app",["title"=>"Tambah talent mapping"])
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
    .invalid-feedback{
        font-size:16px
    }
</style>
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Talent Mapping</h1>
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
                            <li class="breadcrumb-item active text-primary" aria-current="page">Tambah</li>
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
                    <form action='{{route('talent-mapping/simpan')}}' method='POST'  enctype="multipart/form-data" >
                        @csrf
                        <div class='row mb-3'>
                            <div class='col-lg-2'>Deskripsi</div>
                            <div class='col-lg-10'>
                                <textarea class='form-control  @error('deskripsi') is-invalid @enderror' name='deskripsi' rows='4'>{{old('deskripsi')}}</textarea>
                                @error('deskripsi') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                            </div>
                        </div>
                        <div class='row mb-3 mt-3'>
                            <div class='col-lg-2'>Talent Mapping Tahun</div>
                            <div class='col-lg-10'>
                                <select name='tahun' class='form-control @error('tahun') is-invalid @enderror'>
                                    <option value="">Pilih Tahun</option>
                                    <?php
                                        for($a=date('Y');$a >= (date('Y') - 3);$a--){
                                           ?><option value="{{$a}}" {{(old('tahun')==$a) ? "Selected" : "" }} >{{$a}}</option><?php
                                        }
                                    ?>
                                </select>
                                @error('tahun') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                            </div>
                        </div>
                        <div class='row mb-3'>
                            <div class='col-lg-2'>Batch</div>
                            <div class='col-lg-10'>
                                <select name='batch' id='batch' class='form-control @error('batch') is-invalid @enderror' onchange="cekKrs()">
                                    <option value="">Pilih batch</option>
                                    <option value="1" {{(old('batch')=="1") ? "Selected" : "" }}>Batch 1</option>
                                    <option value="2" {{(old('batch')=="2") ? "Selected" : "" }}>Batch 2</option>
                                </select>
                                @error('batch') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                            </div>
                        </div>
                        <div class='row mb-3'>
                            <div class='col-lg-2'>Jenis Talent Mapping</div>
                            <div class='col-lg-10'>
                                <select name='jenis' id='jenis' class='form-control @error('jenis') is-invalid @enderror'  onchange="cekKrs()">
                                    <option value="">Pilih Jenis</option>
                                    <option value="pelaksana"  {{(old('jenis')=="pelaksana") ? "Selected" : "" }}>Pelaksana</option>
                                    <option value="pengawas"  {{(old('jenis')=="pengawas") ? "Selected" : "" }}>Pengawas</option>
                                    <option value="administrator"  {{(old('jenis')=="administrator") ? "Selected" : "" }}>Administrator</option>
                                    <option value="jpt_pratama"  {{(old('jenis')=="jpt_pratama") ? "Selected" : "" }}>JPT Pratama</option>
                                    <option value="jpt_madya"  {{(old('jenis')=="jpt_madya") ? "Selected" : "" }}>JPT Madya</option>
                                </select>
                                @error('jenis') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                            </div>
                        </div>
                        <div class='row mb-3' id='divbatch' style='display:none'>
                            <div class='col-lg-2'>Talent Mapping Batch 1</div>
                            <div class='col-lg-10'>
                                <select name='id_krs_awal'id='id_krs_awal' class='form-control @error('id_krs_awal') is-invalid @enderror'>
                                    <option value="">Pilih Talent Mapping Batch 1</option>
                                    @foreach($dt1 as $key => $value)
                                        <option value="{{$value->id}}" {{($value->id===old('id_krs_awal')) ? "Selected" : "" }}>{{$value->deskripsi}}</option>
                                    @endforeach
                                </select>
                                @error('id_krs_awal') <span class='invalid-feedback'>{{$message}}</span>  @enderror
                            </div>
                        </div>
                        <div class='row mb-3'>
                            <div class='col-lg-12 '>
                                <input type='submit' name='submit' value='submit' class='btn btn-primary float-right'>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js-script')

<script type="text/javascript">
    $(document).ready(function(){
        cekKrs();

    })

    function cekKrs(){
        $("#id_krs_awal").val('');
        $("#fileupload").val('');
        if($("#batch").val()=="2" && ($("#jenis").val()=="administrator" || $("#jenis").val()=="jpt_pratama" || $("#jenis").val()=="jpt_madya") ){
            $("#divbatch").show();
            $("#divFile").show();
            $("#id_krs_awal").empty();
            $("#id_krs_awal").append(`<option value="">Pilih Talent Mapping Batch 1</option>`);
            $.ajax({
                url:'{{ route('ajx-cekkrs') }}',
                type:'post',
                data:{jenis:$("#jenis").val(), _token: "{{ csrf_token() }}",},
                dataType:'json',
                success:function(result){
                    
                    $.each(result,function(i,item){
                        $("#id_krs_awal").append(`<option value="`+item.id+`">`+item.deskripsi+`</option>`);
                    })
                },
                error:function(){
                    alert('gagal menampilkan talent mapping batch 1')
                }
            })
        }else{
            $("#divbatch").hide();
            $("#divFile").hide();
            $("#id_krs_awal").val('');
        }
    }

</script>
@stop
