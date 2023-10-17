<?php

namespace App\Http\Controllers;

use App\Imports\PenkomImport;
use App\Imports\UsersImport;
use App\Models\PenkomModel;
use App\Models\LogsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\GlobalHelper;
use Auth;
class PenkomController extends Controller
{
    public function index(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"7")){
            $rr=array('module'=>'upload penkom','action'=>'view','deskripsi'=>'membuka halaman Upload Penkom','res'=>'success','userid'=>session()->get('nip'));
            LogsModel::saveLogs($rr);
            $data=DB::table('talenta_penkom')
                    ->select('jenis', 'tahun','hashname')
                    ->distinct()
                    ->orderBy('tahun','desc')
                    ->get(['hashname']);

            return view('master.penkom.list',compact('data'));
        }else{
            return view('notfound');
        }
    }

    public function store(Request $request){
      $request->validate([
         'tahun'=>'required',
         'jenis'=>'required',
         'fileupload'=>'required'

      ]);
      $hashname=Str::random(25);
      $file = $request->file('fileupload');

       // membuat nama file unik
       $nama_file = $file->hashName();

       //temporary file
       $path = $file->storeAs('public/excel/',$nama_file);

       // import data
       $import = Excel::import(new PenkomImport($request->jenis,$request->tahun,$hashname), storage_path('app/public/excel/'.$nama_file));

       //remove from server
       Storage::delete($path);

      if($import) {
         $rr=array('module'=>'upload penkom','action'=>'add','deskripsi'=>'upload penkom berhasil','res'=>'success','userid'=>session()->get('nip'));
         LogsModel::saveLogs($rr);
         return $this->responseUpload($request->tahun,$hashname,'success',$request->jenis);
       }else {
         $rr=array('module'=>'upload penkom','action'=>'add','deskripsi'=>'gagal upload penkom','res'=>'failed','userid'=>session()->get('nip'));
         LogsModel::saveLogs($rr);
         return $this->responseUpload($request->tahun,$hashname,'failed',$request->jenis);
      }
    }

   public function responseUpload($tahun,$hashname,$response,$jenis){
      if($response=='success'){
         $data=PenkomModel::where([
            'tahun'=>$tahun,
            'hashname'=>$hashname
         ])->orderBy('id','asc')->get();
         session()->flash('messageUpload','Upload Penkom berhasil');
         session()->flash('response','success');
         return view('master.penkom.responupload',compact('data','jenis'));
      }else{
         session()->flash('messageUpload','Gagal Upload Penkom');
         session()->flash('response','failed');
         return view('master.penkom.responupload',compact('data','jenis'));
      }

   }

    public function viewdetail($tahun,$pelaksana,$hashname){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"7")){
            $rr=array('module'=>'penkom-view','action'=>'view','deskripsi'=>'Membuka halaman Penkom view','res'=>'success','userid'=>session()->get('nip'));
            LogsModel::saveLogs($rr);
            return view('master.penkom.viewdata',compact('tahun','pelaksana','hashname'));
        }else{
            return view('notfound');
        }
    }

    public function destroy($tahun,$pelaksana,$hashname){
      PenkomModel::where([
         ['tahun','=',$tahun],
         ['jenis','=',$pelaksana],
         ['hashname','=',$hashname],

      ])->delete();

      session()->flash('message','Data Berhasil di Hapus');
      return back();
    }
    public function getPenkom(Request $request){
        if ($request->ajax()) {
            $kueri= DB::table('talenta_penkom');
            if($request->nip !=''){
            $kueri->where('nip','=',$request->nip);
            }
            if($request->tahun !=''){
                $kueri->where('tahun','=',$request->tahun);
            }
            if($request->jenis !=''){
                $kueri->where('jenis','=',$request->jenis);
            }
            $data= $kueri->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function getPenkomDetail(Request $request){
        if ($request->ajax()) {
            $kueri= DB::table('talenta_penkom');
            if($request->hashname !=''){
            $kueri->where('hashname','=',$request->hashname);
            }
            if($request->tahun !=''){
                $kueri->where('tahun','=',$request->tahun);
            }
            if($request->jenis !=''){
                $kueri->where('jenis','=',$request->jenis);
            }
            $data= $kueri->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
