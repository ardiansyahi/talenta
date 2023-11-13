@extends("layouts.app",["title"=>"RW Jabatan"])
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
                    <h1>Riwayat Jabatan</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Master
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">RW Jabatan</li>
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
                    <form action='{{route('master/rw-jabatan/cari')}}' method='POST'>
                        @csrf
                        <div class='row mb-4'>
                            <div class='col-lg-3 text-center'>NIP</div>
                            <div class='col-lg-2'></div>
                            <div class='col-lg-7'></div>

                            <div class='col-lg-3 text-center'>
                                <select name='nip' id='nip' class='form-control select2'>
                                    @php
                                     
                                        if(!empty($nip)){
                                            echo "<option value='".$nip->nip."'>".$nip->nip."-".$nip->nama."</option>";
                                        }else{
                                            echo "<option value=''>Pilih NIP</option>";
                                        }
                                    @endphp
                                   

                                </select>
                            </div>
                            
                            <div class='col-lg-2'>
                                <input type='submit' class='btn btn-primary' value='Filter' name='submit'>
                            </div>
                            <div class='col-lg-7 mr-auto float-right'>
                                <a href='#' onclick='getRwJabatan()' class='btn btn-dark  mr-auto float-right'>Tarik Data RW Jabatan</a>
                            </div>
                        </form>
                    </div>
                     <div class="datatable-wrapper table-responsive">
                        <table id="datatable2" class="display compact table table-striped table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">NIP</th>
                                    <th width="50%">Nama</th>
                                    <th width="25%">Total</th>
                                 
                                </tr>
                            </thead>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!-- Vertical Center Modal -->
    <div class="modal fade" id="popUpUpload" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
               
                    <div class="modal-header">
                        <h5 class="modal-title" id="popUpUploadTitle">Tarik Data</h5>
                    </div>
                    <div class="modal-body" align='center'>
                        <img src="{{asset('assets/img/loader/loader.svg')}}" id='img1'><br/>
                        <label id='lbl1'>Mohon Menuggu</label><br>
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
    $(document).ready(function(){
        
         $('#datatable2').dataTable({
            processing: true,
            serverSide: true,
                    ajax: {
                       url:'{{ route('ajx-getRwJabatanJson') }}',
                       type:'post',
                        data:{nip:$("#nip").val(), _token: "{{ csrf_token() }}"}
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nip', name: 'nip'},
                        {data: 'nama', name: 'nama'},
                        {data: 'total', name: 'total'}
                        
                        
                    ],
                    columnDefs: [
                        { className: 'text-center', targets: [1,3] },
                    ]
                            
        }); 
    })
    
    $(function(){
       $('#nip').select2({
           minimumInputLength: 3,
           allowClear: true,
           placeholder: 'masukkan NIP / Nama',
           ajax: {
              dataType: 'json',
              type:'post',
              url: "{{route('ajx-getNIPRWJ')}}",
              delay: 800,
              data: function(params) {
                return {
                  _token: "{{ csrf_token() }}",
                  search: params.term
                }
              },
              processResults: function (data, page) {
              return {
                results: data
              };
            },
          }
      }).on('select2:select', function (evt) {
         var data = $("#nip option:selected").text();
        
      });
    });

    function closeModal(){
         $('#popUpUpload').modal('hide');
         location.reload(); 
    }
    function getRwJabatan(){
        if (confirm("Yakin akan menarik data Riwayat Jabatan ?") == true) {
            $('#popUpUpload').modal({backdrop: 'static', keyboard: false}) 
            $('#btn-close').hide();
            $.ajax({
                url:'{{route('ajx-getRwJabatan')}}',
                type:'GET',
                dataType:'JSON',
                success:function(result){
                    if(result.respon=='success'){
                        $('#img1').hide();
                        $('#lbl1').html('Sukses Ambil Data');
                        $('#btn-close').show();
                    }else{
                        $('#img1').hide();
                        $('#lbl1').html('Gagal Ambil Data');
                        $('#btn-close').show();
                    }
                },error:function(){
                    $('#img1').hide();
                    $('#lbl1').html('Gagal Ambil Data');
                    $('#btn-close').show();
                }
            })
        }
       
    }

    function showGlobalModal(nip,jenis){
        $("#modal-body-detail").empty();
        $("#modalGlobalTitle").html('Detail Riwayat Jabatan');
        $("#modal-body-detail").append(`
                <table id='tablex1' class='display compact table table-striped table-bordered table-hovered' width='100%' border='1'>
                    <thead>
                    <tr>
                        <th width='20%'>NIP </th>
                        <th width='20%'>Nama </th>
                        <th width='30%'>Satker  </th>
                        <th width='10%'>Tgl SK</th>
                        <th width='10%'>TMT Jabatan</th>
                        <th width='10%'>TMT Eselon </th>
                        
                    </tr>
                    </thead>
                    <tbody></tbody>
                    </table>
                  
        `);

        $.ajax({
            url:"{{route('ajx-getRwJabatanDetail')}}",
            type:"GET",
            dataType:"JSON",
            data:{ nip: nip, jenis:jenis},
            cache: false,
            async: false,
            success:function(result){
                
             $.each(result,function(i,item){
                $('#tablex1 > tbody:last-child').append(`
                    <tr>
                        <td align='center'>`+item.nip+`</td>
                        <td>`+item.nama+`</td>
                        <td>`+item.satker+`</td>
                        <td align='center' >`+item.tglsk+`</td>
                        <td align='center'>`+item.tmtjabatan+`</td>
                        <td align='center''>`+item.tmteselon+`</td>
                    </tr>
                    
                `);
            })

            $("#modalGlobal").modal('show');
            },error:function(){
                
            }
        })
         
      
    }

</script>
@stop