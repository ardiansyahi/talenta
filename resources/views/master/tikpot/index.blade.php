@extends("layouts.app",["title"=>"Titik Potong"])
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
                    <h1>Titik Potong</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Data Master
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Titik Potong</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
        </div>

    </div>

    @if(session()->has('message'))
        <div class='alert alert-inverse-success text-dark'>
            {{session()->get('message')}}
        </div><br>
    @endif
    <div class='row'>
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body">
                    <form action='{{route('master/tikpot/cari')}}' method='POST'>
                        @csrf
                        <div class='row mb-4'>
                            <div class='col-lg-3 text-center'>Judul</div>
                            <div class='col-lg-2'></div>
                            <div class='col-lg-7'></div>

                            <div class='col-lg-3 text-center'>
                                <input type='text' class='form-control' name='nama' id='nama' value='{{@$nama;}}'>
                            </div>

                            <div class='col-lg-2'>
                                <input type='submit' class='btn btn-primary' value='Filter' name='submit'>
                            </div>
                            <div class='col-lg-7 mr-auto float-right'>
                                <a href='{{route('master/tikpot/tambah')}}' class='btn btn-primary float-right'>Tambah Titik Potong</a>
                            </div>
                        </form>
                    </div>
                     <div class="datatable-wrapper table-responsive">
                        <table id="datatable2" class="display compact table table-striped table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="70%">Judul</th>
                                    <th width="25%">Action</th>

                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js-script')

<script type="text/javascript">
    $(document).ready(function(){

         $('#datatable2').dataTable({
            search:false,
            processing: true,
            serverSide: true,

                    ajax: {
                       url:'{{ route('ajx-getTikpot') }}',
                       type:'POST',
                        data:{nama:$("#nama").val(), _token: "{{ csrf_token() }}"}
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama', name: 'nama'},
                        {data: 'action', name: 'action'}


                    ],
                    columnDefs: [
                        { className: 'text-center', targets: [0,2] },
                    ]

        });
    })

</script>
@stop
