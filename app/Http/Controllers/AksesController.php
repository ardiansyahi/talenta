<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Response;
use App\Models\LogsModel;
use App\Models\AksesModel;
use App\Models\formModel;
use App\Helpers\GlobalHelper;

class AksesController extends Controller
{
    public function index(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"20")){
            return view('setting.akses.list');
        }else{
            return view('notfound');
        }
    }

    public function getAkses(Request $request){

        $data=AksesModel::whereIsdeleted(0)->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
                        return '<a href="'.url("setting/akses/edit/".$data->id."").'" class="btn btn-primary">Ubah</a>
                                <a href="'.url("setting/akses/delete/".$data->id."").'"  onclick="return confirm(`Yakin Anda Ingin Menghapus Data '.$data->nama.'`)" class="btn btn-danger">Hapus</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    public function cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"20")){
            $nama=$request->nama;
            return view('setting.akses.list',compact('nama'));
        }else{
            return view('notfound');
        }
    }

    public function tambah(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"20")){
            $act='Tambah';
            $form=formModel::whereJenis('root')->get();
            return view('setting.akses.form',compact('act','form'));
        }else{
            return view('notfound');
        }
    }

    public function edit($id){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"20")){
            $data=AksesModel::find($id);
            $act='Edit';
            $form=formModel::whereJenis('root')->get();
            return view('setting.akses.form',compact('data','act','form'));
        }else{
            return view('notfound');
        }
    }

    public function store(Request $request){
        $request->validate([
            'nama'=>'required',
        ]);

        if($request->act=="Tambah"){

             AksesModel::create([
                 "nama"=>$request->nama,
                 "id_form"=>json_encode($request->id_form),
                 "created_by"=>Auth::user()->userid,
                 "isdeleted"=>0
             ]);

             $rr=array('module'=>'Akses','action'=>'add','deskripsi'=>'Menambah Data Akses '.$request->nama.'','res'=>'success','userid'=>Auth::user()->userid);
             LogsModel::saveLogs($rr);
             return redirect('setting/akses')->with(['message'=>'Data berhasil ditambah']);

        }else{
            AksesModel::find($request->id)->update([
                "nama"=>$request->nama,
                "id_form"=>json_encode($request->id_form),
                "modified_by"=>Auth::user()->userid,
                "isdeleted"=>0
            ]);

            $rr=array('module'=>'Akses','action'=>'edit','deskripsi'=>'Merubah Data Akses '.$request->nama.'','res'=>'success','userid'=>Auth::user()->userid);
            LogsModel::saveLogs($rr);
            return redirect('setting/akses')->with(['message'=>'Data berhasil diubah']);

        }
    }

    public function destroy($id){
        AksesModel::find($id)->update([
            "modified_by"=>Auth::user()->userid,
            "isdeleted"=>1
        ]);

        $rr=array('module'=>'Akses','action'=>'edit','deskripsi'=>'menghapus Data Akses '.$id.'','res'=>'success','userid'=>Auth::user()->userid);
        LogsModel::saveLogs($rr);
        return redirect('setting/akses')->with(['message'=>'Data berhasil dihapus']);
    }
}
