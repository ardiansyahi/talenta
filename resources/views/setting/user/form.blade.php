@extends("layouts.app",["title"=>"Ubah User"])
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
                    <h1>{{$act}} Data User</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Setting</li>
                            <li class="breadcrumb-item " aria-current="page">
                                <a href="{{route('setting/user')}}">Data User</a>
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">{{$act}} User</li>
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
                    <form action='{{route('setting/user/simpan')}}' method='POST' >
                        @csrf
                        <div class='row mb-3 mt-3'>
                            <div class='col-lg-2'>User Id</div>
                            <div class='col-lg-10'>
                                <input type='hidden' name='id' value='{{@$data->id;}}'>
                                <input type='hidden' name='act' value='{{@$act;}}'>
                                <input type='text' name='userid' class='form-control @error('userid') is-invalid @enderror' readonly value="{{@$data->userid}}" >
                                @error('userid') <span class='invalid-feedback' style='font-size:15px;'>{{$message}}</span>  @enderror
                            </div>
                        </div>
                        <div class='row mb-3 mt-3'>
                            <div class='col-lg-2'>User Name</div>
                            <div class='col-lg-10'>
                                <input type='text' name='name' class='form-control @error('name') is-invalid @enderror' readonly value="{{@$data->name}}">
                                @error('name') <span class='invalid-feedback' style='font-size:15px;'>{{$message}}</span>  @enderror
                            </div>
                        </div>
                        <div class='row mb-3 mt-3'>
                            <div class='col-lg-2'>Akses</div>
                            <div class='col-lg-10'>
                                <select name='id_akses' class='form-control @error('id_akses') is-invalid @enderror' >
                                    <option value="">Pilih Akses</option>
                                    @foreach ($akses as $rakses)
                                        <option value="{{$rakses->id}}"
                                            {{($rakses->id==$data->id_akses) ? "Selected" :""}}
                                        >{{$rakses->nama}}</option>
                                    @endforeach
                                </select>
                                @error('id_akses') <span class='invalid-feedback' style='font-size:15px;'>{{$message}}</span>  @enderror
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

</script>
@stop
