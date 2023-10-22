<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\View_Penilaian_Perilaku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Response;
use App\Models\LogsModel;
use App\Helpers\GlobalHelper;

class ReportPenilaianPerilakuController extends Controller
{
    //
    public function index(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"18")){
            $sesakses=\Session::get('id_akses');
            $nip='';
            if($sesakses=='5'){
                $nip= Auth::user()->userid;
            }
            return view('report.penilaian-perilaku.list',compact('nip'));
        }else{
            return view('notfound');
        }
    }

    public function getPenilaianPerilaku(Request $request){
        $data=View_Penilaian_Perilaku::where('pegawai_dinilai','!=','superadmin');
        if($request->pegawai_dinilai !=''){
            $data->where('pegawai_dinilai','like','%'.$request->pegawai_dinilai.'%');
        }
        if($request->nama_dinilai !=''){
            $data->where('nama_dinilai','like','%'.$request->nama_dinilai.'%');
        }
        if($request->tahun !=''){
            $data->where('tahun','=',$request->tahun);
        }
        $data->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"18")){
            $pegawai_dinilai=$request->pegawai_dinilai;
            $nama_dinilai=$request->nama_dinilai;
            $tahun=$request->tahun;

            return view('report.penilaian-perilaku.list',compact('pegawai_dinilai','nama_dinilai','tahun'));
        }else{
            return view('notfound');
        }
    }


}
