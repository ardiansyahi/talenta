<?php

namespace App\Http\Controllers;

use App\Helpers\GlobalHelper;
use App\Models\PenkomModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
class ReportPenkomController extends Controller
{
    public function index(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"14")){
            $sesakses=\Session::get('id_akses');
            $nip='';
            if($sesakses=='5'){
                $nip= $nip=GlobalHelper::getNamaNipPegawai(Auth::user()->userid);
            }
            return view('report.penkom',compact('nip'));
        }else{
            return view('notfound');
        }
    }

    public function getNIP(Request $param){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");

        return GlobalHelper::getNipNama($param->search);
    }

    public function cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"14")){
            $tahun=$request->tahun;
            if($request->nip !=''){$nip=GlobalHelper::getNamaNipPegawai($request->nip); }
            else{$nip=$request->nip;}

            $jenis=$request->jenis;

            return view('report.penkom',compact('tahun','nip','jenis'));
        }else{
            return view('notfound');
        }
    }

}
