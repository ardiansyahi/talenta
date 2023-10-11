@extends("layouts.app",["title"=>"Pegawai"])
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
                    <h1>Template Calon Krs</h1>
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
                            <li class="breadcrumb-item active text-primary" aria-current="page">KRS</li>
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
                    
                </div>
            </div>
        </div>
    </div>
    
     
@endsection

@section('page-js-script')

<script type="text/javascript">
    
</script>
@stop