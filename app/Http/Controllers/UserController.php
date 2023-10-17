<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Response;
use App\Models\LogsModel;
use App\Models\AksesModel;
use App\Helpers\GlobalHelper;
class UserController extends Controller
{
    public function index(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"19")){
            return view('setting.user.list');
        }else{
            return view('notfound');
        }

    }

    public function getUser(Request $request){

        $data=DB::table('talenta_users')->select('talenta_users.id','talenta_users.userid','talenta_users.name','talenta_akses.nama');
        if($request->userid !=''){
            $data->where('userid','like','%'.$request->userid.'%');
        }
        if($request->name !=''){
            $data->where('name','like','%'.$request->name.'%');
        }
        $data->join('talenta_akses','talenta_users.id_akses','=','talenta_akses.id');
        $data->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
                        return '<a href="/setting/user/edit/'.$data->id.'" class="btn btn-primary">Ubah</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    public function cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"19")){
            $userid=$request->userid;
            $name=$request->name;

            return view('setting.user.list',compact('userid','name'));
        }else{
            return view('notfound');
        }
    }

    public function edit($id){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"19")){
            $data=User::find($id);
            $act='Edit';
            $akses=AksesModel::whereIsdeleted('0')->orderBy('nama','asc')->get();
            return view('setting.user.form',compact('data','act','akses'));
        }else{
            return view('notfound');
        }
    }

    public function store(Request $request){
        $request->validate([
            'id_akses'=>'required',
        ]);

        User::find($request->id)->update([
            "id_akses"=>$request->id_akses,
            'modified_by'=>Auth::user()->userid
        ]);

        $rr=array('module'=>'User','action'=>'edit','deskripsi'=>'Merubah Data User '.$request->name.'','res'=>'success','userid'=>Auth::user()->userid);
        LogsModel::saveLogs($rr);
        return redirect('setting/user')->with(['message'=>'Data berhasil diubah']);

    }
}
