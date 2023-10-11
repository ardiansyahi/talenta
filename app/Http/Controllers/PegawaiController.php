<?php

namespace App\Http\Controllers;

use App\Helpers\GlobalHelper;
use App\Models\PegawaiModel;
use App\Models\PegawaiTalentaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Query\QPegawaiController;

class PegawaiController extends Controller
{
    public function __construct(QPegawaiController $QPegawaiController)
    {
       $this->QPegawaiController = $QPegawaiController;
    }

    public function index(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"6")){
            return view('master.pegawai.pegawai');
        }else{
            return view('notfound');
        }
    }

    public function getPegawai(){
        return $this->QPegawaiController->getPegawai();
    }
    public function cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"6")){
            if($request->nip !=''){$nip= GlobalHelper::getNamaNipPegawai($request->nip);}
            else{$nip=$request->nip;}

            return view('master.pegawai.pegawai',compact('nip'));
        }else{
            return view('notfound');
        }
    }

    public function getNipPegawai(Request $param){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");

        return GlobalHelper::getNipPegawai($param->search);
    }
    public function getPegawaiDetail(Request $request){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");

        $kueri=PegawaiTalentaModel::whereNip($request->nip)->first();
        return json_encode($kueri);
    }

    public function getPegawaiJson(Request $request){
        if ($request->ajax()) {
            return $this->QPegawaiController->getData($request->nip);
        }
    }

}
