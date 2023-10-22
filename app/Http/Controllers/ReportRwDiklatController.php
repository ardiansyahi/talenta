<?php

namespace App\Http\Controllers;
use App\Helpers\GlobalHelper;
use App\Models\RwdiklatHitungModel;
use App\Models\RwDiklatKonfigModel;
use App\Models\RwdiklatModel;
use CreateRwdiklatHitung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Query\QRwDiklatController;
use Response;
use App\Exports\ReportRwDiklat;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;


ini_set('max_execution_time', 0); //0=NOLIMIT
ini_set('memory_limit', '-1');
set_time_limit(0);

class ReportRwDiklatController extends Controller
{
    public function __construct(QRwDiklatController $QRwDiklatController)
    {
       $this->QRwDiklatController = $QRwDiklatController;
    }
    public function index(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"15")){
            $sesakses=\Session::get('id_akses');
            $nip='';
            if($sesakses=='5'){
                $nip= GlobalHelper::getNamaRWByNip(Auth::user()->userid);
            }

            $dt=RwDiklatKonfigModel::orderBy("id","desc")->get();
            return view('report.diklat.rwdiklat',compact('dt','nip'));
        }else{
            return view('notfound');
        }

     }

     public function cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"15")){
            if($request->nip !=''){$nip= GlobalHelper::getNamaRWByNip($request->nip);}
            else{$nip=$request->nip;}

            $jenis=$request->jenis;
            $dt=RwDiklatKonfigModel::orderBy("id","desc")->get();

            return view('report.diklat.rwdiklat',compact('nip','jenis','dt'));
        }else{
            return view('notfound');
        }
    }

    public function getNIPRW(Request $param){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");
        return GlobalHelper::getNIPRW($param->search);
    }

    public function getRwDetail(Request $request){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");

        if($request->jenis !='all'){
            $kueri=RwdiklatModel::whereNip($request->nip)->whereJenis($request->jenis)->orderBy('id','asc')->get();
        }else{
            $kueri=RwdiklatModel::whereNip($request->nip)->orderBy('id','asc')->get();
        }
        return response()->json($kueri, 200);
    }

    public function getRWjson(Request $request){
        if ($request->ajax()) {
            return $this->QRwDiklatController->getData($request->nip,$request->jenis);
        }
    }
    public function export($nip,$jenis)
    {
        return Excel::download(new ReportRwDiklat($nip,$jenis), 'Report-Rw-Diklat.xlsx');
    }



}
