<?php

namespace App\Http\Controllers;


use App\Helpers\GlobalHelper;
use App\Models\RwJabatanHitungModel;
use App\Models\RwJabatanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Exports\ReportRwJabatan;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

use App\Query\QRwJabatanController;
use Response;
ini_set('max_execution_time', 0); //0=NOLIMIT
ini_set('memory_limit', '-1');
set_time_limit(0);

class ReportRwJabatanController extends Controller
{
    public function __construct(QRwJabatanController $QRwJabatanController)
    {
       $this->QRwJabatanController = $QRwJabatanController;
    }

    public function index(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"16")){
            return view('report.jabatan.rwjabatan');
        }else{
            return view('notfound');
        }
    }

    public function getNIPRWJ(Request $param){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");
        return GlobalHelper::getNIPRWJ($param->search);
    }

    public function cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"16")){
            if($request->nip !=''){$nip= GlobalHelper::getNamaRWJByNip($request->nip);}
            else{$nip=$request->nip;}

            $dt=RwJabatanModel::orderBy("id","desc")->get();

            return view('report.jabatan.rwjabatan',compact('nip','dt'));
        }else{
            return view('notfound');
        }
    }


    public function getRwJabatanJson(Request $request){
        $param='';
        if ($request->ajax()) {
            return $this->QRwJabatanController->getData($request->nip);

        }
    }

    public function getRwJabatanDetail(Request $request){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");
        $kueri=RwJabatanModel::whereNip($request->nip)->orderBy('id','asc')->get();
        return response()->json($kueri, 200);
    }
    public function export($nip)
    {
        return Excel::download(new ReportRwJabatan($nip), 'Report-Rw-Jabatan.xlsx');
    }

}
