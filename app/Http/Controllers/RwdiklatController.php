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
ini_set('max_execution_time', 0); //0=NOLIMIT
ini_set('memory_limit', '-1');
set_time_limit(0);

class RwdiklatController extends Controller
{
    public function __construct(QRwDiklatController $QRwDiklatController)
    {
       $this->QRwDiklatController = $QRwDiklatController;
    }
    public function index(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"8")){
            $dt=RwDiklatKonfigModel::orderBy("id","desc")->get();
            return view('master.diklat.rwdiklat',compact('dt'));
        }else{
            return view('notfound');
        }

     }
    public function getRW(){
       return $this->QRwDiklatController->getRW();
    }

    public function cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"8")){
            if($request->nip !=''){$nip= GlobalHelper::getNamaRWByNip($request->nip);}
            else{$nip=$request->nip;}

            $jenis=$request->jenis;
            $dt=RwDiklatKonfigModel::orderBy("id","desc")->get();

            return view('master.diklat.rwdiklat',compact('nip','jenis','dt'));
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

    public function postRwKonfig(Request $request){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");
        $data=array();
        $post=array();

        try{

            if($request->type=='delete'){
                DB::table('talenta_rwdiklat_konfig')->whereId($request->id)->delete();
            }else{
                DB::table('talenta_rwdiklat_konfig')->insert([
                    'nama'=>htmlspecialchars($request->nama),
                    'created_by'=>Auth::user()->userid,
                    'created_at'=>now()
                ]);
            }

            $data=DB::table('talenta_rwdiklat_konfig')->orderBy('id','desc')->get();
            $post=array('respon'=>'success','data'=>$data);
            return response()->json($post);

        }
        catch (Throwable $e) {
            report($e);
            $rr=array('module'=>'Rw Diklat','action'=>'postRwKonfig','deskripsi'=>'postRwKonfig','res'=>'failed','userid'=>Auth::user()->userid);
            LogsModel::saveLogs($rr);
            $posts = array('respon' => 'error', 'message' =>$e , 'tipe' => 'error_curl3');
            return response()->json($posts, 400);
        }
    }

    public function getRWjson(Request $request){
        if ($request->ajax()) {
            return $this->QRwDiklatController->getData($request->nip,$request->jenis);
        }
    }



}
