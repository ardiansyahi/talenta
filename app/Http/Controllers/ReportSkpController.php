<?php

namespace App\Http\Controllers;

use App\Helpers\GlobalHelper;
use App\Models\SkpModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Query\QSkpController;
use App\Exports\ReportSkp;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
class ReportSkpController extends Controller
{
    public function __construct(QSkpController $QSkpController)
    {
       $this->QSkpController = $QSkpController;
    }

    public function index(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"17")){
            $sesakses=\Session::get('id_akses');
            $nip='';
            if($sesakses=='5'){
                $nip= GlobalHelper::getNamaNipPegawai(Auth::user()->userid);
            }

            return view('report.skp.skp',compact('nip'));
        }else{
            return view('notfound');
        }
    }

    public function cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"17")){
            if($request->nip !=''){$nip= GlobalHelper::getNamaRWByNip($request->nip);}
            else{$nip=$request->nip;}
            $tahun=$request->tahun;
            $dt=SkpModel::orderBy("id","desc")->get();

            return view('report.skp.skp',compact('nip','tahun','dt'));
        }else{
            return view('notfound');
        }

    }

    public function getSkpJson(Request $request){
        $param='';
        if ($request->ajax()) {
           return  $this->QSkpController->getData($request->nip,$request->tahun);

        }
    }

    public function getSkpDetail(Request $request){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");

        $kueri=SkpModel::whereNip($request->nip)->orderBy('id','asc')->get();
        return json_encode($kueri);
    }
    public function export($nip,$tahun)
    {
        return Excel::download(new ReportSkp($nip,$tahun), 'Report-SKP.xlsx');
    }


}
