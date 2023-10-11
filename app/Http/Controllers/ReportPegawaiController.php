<?php

namespace App\Http\Controllers;

use App\Helpers\GlobalHelper;
use App\Models\PegawaiModel;
use App\Models\PegawaiTalentaModel;
use App\Models\KrsFinalModel;
use App\Models\KrsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ReportPegawaiController extends Controller
{
    public function index(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"13")){
            return view('report.pegawai.index');
        }else{
            return view('notfound');
        }

    }
    public function detailTalent($jenis,$id,$id_krs,$nip){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"13")){
            $dataKRS=KrsModel::select("id","tahun","deskripsi","batch","jenis","status","fileupload","id_tikpot")
                ->whereId($id_krs)->first();
                $dataPegawai=PegawaiTalentaModel::select('nip','nama_lengkap')->whereNip($nip)->first();
                $data=KrsFinalModel::find($id);
                $dataHeader=KrsFinalModel::whereId_krs($id_krs)->whereJenis('header')->first();
            return view('report.pegawai.detail',compact('data','dataHeader','dataKRS','dataPegawai'));
        }else{
            return view('notfound');
        }

    }
    public function cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"13")){
            if($request->nip !=''){$nip= GlobalHelper::getNamaNipPegawai($request->nip);}
            else{$nip=$request->nip;}

            return view('report.pegawai.index',compact('nip'));
        }else{
            return view('notfound');
        }
    }
    public function getNipPegawai(Request $param){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");

        return GlobalHelper::getNipPegawai($param->search);
    }
    public function getPegawaiHistory(Request $request){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");

        $kueri=PegawaiTalentaModel::whereNip($request->nip)->first();
        $pengawas=KrsFinalModel::select('krs_final.nilai','krs.tahun','krs.jenis','krs_final.id','krs_final.nip','krs_final.id_krs')
        ->join('krs','krs.id','=','krs_final.id_krs')
        ->where('krs_final.nip','=',$request->nip)
        ->where('krs.jenis','=','pengawas')
        ->get();

        $administrator=KrsFinalModel::select('krs_final.nilai','krs.tahun','krs.jenis','krs_final.id','krs_final.nip','krs_final.id_krs')
                    ->join('krs','krs.id','=','krs_final.id_krs')
                    ->where('krs_final.nip','=',$request->nip)
                    ->where('krs.jenis','=','administrator')
                    ->where('krs_final.status','=','publish')
                    ->get();
        $posts=array('pegawai'=>$kueri,'pengawas'=>$pengawas,'administrator'=>$administrator);

        return json_encode($posts);
    }

    public function getPegawaiJson(Request $request){
        if ($request->ajax()) {
            $param="WHERE nip !='000' ";
            if($request->nip !=''){
                $param .=" AND nip ='".$request->nip."' ";
            }

            $data= DB::select("select nip,nama_lengkap,pangkat,statuspegawai,golongan,eselon,pendidikan,kedudukan
                             FROM pegawai ".$param."");

             return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nip', function ($data) {
                    return "<a href='#' class='text-primary' onclick=showGlobalModal('".$data->nip."')>".$data->nip."</a>";
                })
                ->addColumn('act',function($data){return '';})
                ->rawColumns(['nip','act'])
                ->make(true);
        }
    }
}
