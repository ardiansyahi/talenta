@php use App\Models\formModel; @endphp

@extends("layouts.app",["title"=>"Data Akses"])
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
    .box{
        width:10px;
        height:10px;
        padding: 10px;
        float:left;
        margin-right:10px;
    }
    .boxdetail{
        padding:25px;
        border:1px #000 solid;
    }
</style>
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>{{$act}} Data Akses</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Setting</li>
                            <li class="breadcrumb-item " aria-current="page">
                                <a href="{{route('setting/akses')}}">Data Akses</a>
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">{{$act}} Hak Akses</li>
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
                    <form action='{{route('setting/akses/simpan')}}' method='POST' >
                        @csrf
                        <div class='row mb-3 mt-3'>
                            <div class='col-lg-2'>Nama Akses</div>
                            <div class='col-lg-10'>
                                <input type='hidden' name='id' value='{{@$data->id;}}'>
                                <input type='hidden' name='act' value='{{@$act;}}'>
                                <input type='text' name='nama' class='form-control @error('nama') is-invalid @enderror' value="{{@$data->nama}}" >
                                @error('nama') <span class='invalid-feedback' style='font-size:15px;'>{{$message}}</span>  @enderror
                            </div>
                        </div>
                        <div class='row mb-3 mt-3'>
                            <div class='col-lg-2'>Akses</div>
                            <div class='col-lg-10'>
                                @foreach ($form as $rform)
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            {{$rform->nama}}
                                            <input type="checkbox" name="id_form[]" style='display:none'
                                            value="21" checked>

                                            <input type="checkbox" name="id_form[]" style='display:none'
                                            id="ck_root_{{$rform->id}}" value="{{$rform->id}}"
                                            @if($act=="Edit")
                                                @if(is_array(json_decode(@$data->id_form)) != null)
                                                    @if (array_search($rform->id, json_decode(@$data->id_form)))
                                                        checked
                                                    @endif
                                                @endif
                                            @endif
                                            style="width:20px;height:20px">

                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                            @php
                                                $det=formModel::whereId_root($rform->id)->get();
                                                $urutan=1;
                                                foreach($det as $key=>$val){

                                            @endphp
                                                    <div class="col-sm-3">

                                                        <input type="checkbox" name="id_form[]"  id="ck_{{$val->id_root}}_{{$urutan}}"
                                                        value="{{$val->id}}" style="width:20px;height:20px"
                                                        @if($act=="Edit")
                                                            @if(is_array(json_decode(@$data->id_form)) != null)
                                                                @if (array_search($val->id, json_decode(@$data->id_form)))
                                                                    checked
                                                                @endif
                                                            @endif
                                                        @endif
                                                        onchange="updateRoot('{{$val->id}}','{{$val->id_root}}','{{$det->count()}}')"
                                                        >

                                                        <label for="ck_{{$val->id_root}}_{{$urutan}}">{{$val->nama;}}</label>
                                                    </div>
                                            @php
                                                    $urutan++;
                                                }
                                            @endphp

                                            </div>
                                        </div>
                                    </div>
                                @endforeach

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


    })

function updateRoot(id,id_root,total){
    let cek=0;
    for(i=1;i <=total; i++){
        if($("#ck_"+id_root+"_"+i+"").is(':checked')){
            cek++;
        }
    }
    if (cek > 0){$("#ck_root_"+id_root+"").prop('checked','true')}
    else{
        document.getElementById("ck_root_"+id_root+"").checked=false;

    }
}
</script>
@stop
