<?php

namespace App\Http\Controllers;

use App\Models\Konfigurasi_detail_Model;
use App\Models\KonfigurasiModel;
use App\Models\LogsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class KonfigurasiController extends Controller
{
    public function index(){
        $rr=array('module'=>'konfigurasi','action'=>'view','deskripsi'=>'membuka halaman konfigurasi','res'=>'success','userid'=>session()->get('nip'));
        LogsModel::saveLogs($rr); 
        $data=KonfigurasiModel::get();
        return view('konfigurasi.index',compact('data'));
   }

   public function store(Request $request){
        $request->validate([
            'skoring_pendidikan'=>'required',
            'bobot_rj'=>'required',
            'bobot_ds'=>'required',
            'bobot_dt'=>'required',
            'skoring_pangkat'=>'required'

        ]);
        
        try{
            $sk1 = explode(';',$request->skoring_pendidikan);
            $t1=$t2=$t3=$t4=$t5=0;
            Konfigurasi_detail_Model::whereJenis('skoring_pendidikan')->delete();
            foreach($sk1 as $key) {
                if($key !=""){
                    $t1++;
                    $tk1 = explode('=>',trim(preg_replace('/\s+/', '', $key)));
                    Konfigurasi_detail_Model::create([
                            "jenis"=>'skoring_pendidikan',
                            "kriteria"=>$tk1[0],
                            "isidata"=>$tk1[1]
                        ]);
                }    
            }
            KonfigurasiModel::whereJenis('skoring_pendidikan')->update([
                'deskripsi'=>$request->skoring_pendidikan,
                'updated_by'=> Auth::user()->userid,
                'updated_at'=>now()
            ]);
            

            $sk2 = explode(';',$request->bobot_rj);
            foreach($sk2 as $key) {
                if($key !=""){
                    $t2++;
                    $tk1 = explode('=>',trim(preg_replace('/\s+/', '', $key)));
                    Konfigurasi_detail_Model::create([
                            "jenis"=>'bobot_rj',
                            "kriteria"=>$tk1[0],
                            "isidata"=>$tk1[1]
                        ]);    
                }    
            }
            KonfigurasiModel::whereJenis('bobot_rj')->update([
                'deskripsi'=>$request->bobot_rj,
                'updated_by'=> Auth::user()->userid,
                'updated_at'=>now()
            ]);

            $sk3 = explode(';',$request->bobot_ds);
            foreach($sk3 as $key) {
                if($key !=""){
                    $t3++;
                    $tk1 = explode('=>',trim(preg_replace('/\s+/', '', $key)));
                    Konfigurasi_detail_Model::create([
                            "jenis"=>'bobot_ds',
                            "kriteria"=>$tk1[0],
                            "isidata"=>$tk1[1]
                        ]);       
                }    
            }
            KonfigurasiModel::whereJenis('bobot_ds')->update([
                'deskripsi'=>$request->bobot_ds,
                'updated_by'=> Auth::user()->userid,
                'updated_at'=>now()
            ]);

            $sk4 = explode(';',$request->bobot_dt);
            foreach($sk4 as $key) {
                if($key !=""){
                    $t4++;
                    $tk1 = explode('=>',trim(preg_replace('/\s+/', '', $key)));
                    Konfigurasi_detail_Model::create([
                            "jenis"=>'bobot_dt',
                            "kriteria"=>$tk1[0],
                            "isidata"=>$tk1[1]
                        ]);       
                }    
            }
            KonfigurasiModel::whereJenis('bobot_dt')->update([
                'deskripsi'=>$request->bobot_dt,
                'updated_by'=> Auth::user()->userid,
                'updated_at'=>now()
            ]);

            $sk5 = explode(';',$request->skoring_pangkat);
            foreach($sk5 as $key) {
                if($key !=""){
                    $t5++;
                    $tk1 = explode('=>',trim(preg_replace('/\s+/', '', $key)));
                    Konfigurasi_detail_Model::create([
                            "jenis"=>'skoring_pangkat',
                            "kriteria"=>$tk1[0],
                            "isidata"=>$tk1[1]
                        ]);     
                }    
            }
            KonfigurasiModel::whereJenis('skoring_pangkat')->update([
                'deskripsi'=>$request->skoring_pangkat,
                'updated_by'=> Auth::user()->userid,
                'updated_at'=>now()
            ]);
            session()->flash('respon','success');
            session()->flash('message','Data berhasil diperbaharui');
            return back();
        }catch (Throwable $e) {
            report($e);
            session()->flash('respon','failed');
            session()->flash('message','Data gagal diperbaharui, Ada format pengisian yang salah');
            return back();
        }
            

       
   }
}
