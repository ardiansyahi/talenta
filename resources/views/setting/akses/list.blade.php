
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
</style>
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Data Akses</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Setting
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Hak Akses</li>
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
                    <form action='{{route('setting/akses/cari')}}' method='POST'>
                        @csrf
                        <div class='row mb-4'>
                            <div class='col-lg-2 text-center'>Nama</div>
                            <div class='col-lg-2'></div>
                            <div class='col-lg-8'></div>

                            <div class='col-lg-2 text-center'>
                                <input type='text' class='form-control' name='nama' id='nama' value='{{@$nama;}}'>
                            </div>

                            <div class='col-lg-2'>
                                <input type='submit' class='btn btn-primary' value='Filter' name='submit'>
                            </div>
                            <div class='col-lg-8 mr-auto float-right'>
                                <a href="{{route('setting/akses/tambah')}}" class='btn btn-primary float-right'>Tambah Akses</a>
                            </div>
                        </form>
                    </div>
                     <div class="datatable-wrapper table-responsive">
                        <table id="datatable2" class="display compact table table-striped table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="75%">Nama Akses</th>
                                    <th width="20%">Action</th>

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
            "searching": false,
            "ordering":false,
            processing: true,
            serverSide: true,

                    ajax: {
                       url:'{{ route('ajx-getAkses') }}',
                        data:{nama:$("#nama").val()}
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama', name: 'akses'},
                        {data: 'action', name: 'action'}


                    ],
                    columnDefs: [
                        { className: 'text-center', targets: [0,2] },
                    ]

        });
    })

</script>
@stop
