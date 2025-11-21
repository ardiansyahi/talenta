<?php

namespace App\Http\Controllers;

use App\Helpers\GlobalHelper;
use App\Models\SkpModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Query\QSkpController;
ini_set('max_execution_time', 0); //0=NOLIMIT
ini_set('memory_limit', '-1');
set_time_limit(0);

class SkpController extends Controller
{
    public function __construct(QSkpController $QSkpController)
    {
       $this->QSkpController = $QSkpController;
    }

    public function index(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"10")){
            return view('master.skp.skp');
        }else{
            return view('notfound');
        }
    }
    public function getSkp(){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");

        return $this->QSkpController->getSkp();
    }

    public function cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"10")){
            if($request->nip !=''){$nip= GlobalHelper::getNamaRWByNip($request->nip);}
            else{$nip=$request->nip;}
            $tahun=$request->tahun;
            $dt=SkpModel::orderBy("id","desc")->get();

            return view('master.skp.skp',compact('nip','tahun','dt'));
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


}
