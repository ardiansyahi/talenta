<?php

namespace App\Http\Controllers;

use App\Models\TikpodDetailModel;
use App\Models\TikpodModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Response;
use App\Query\QTikPotController;
use App\Models\LogsModel;
use App\Helpers\GlobalHelper;
class TikPotController extends Controller
{
    public function __construct(QTikPotController $QTikPotController)
    {
        //digunakan untuk memanggil fungsi getAll dari ContactRepository
        $this->QTikPotController = $QTikPotController;
    }

    public function index(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"5")){
            return view('master.tikpot.index');
        }else{
            return view('notfound');
        }
    }
    public function tambah(){
        $act='Tambah';
        if(GlobalHelper::cekAkses(Auth::user()->userid,"5")){
            return view('master.tikpot.form',compact('act'));
        }else{
            return view('notfound');
        }

    }
    public function store(Request $request){
        $request->validate([
            'nama'=>'required',
            ]);
        if($request->act=='Tambah'){
            try{
                DB::beginTransaction();
                $id=TikpodModel::insertGetId([
                    'nama'=>$request->nama,
                    'status'=>'a',
                    'created_by'=>Auth::user()->userid
                ]);

                $this->QTikPotController->storeDetail($id);

                $rr=array('module'=>'titik potong','action'=>'add','deskripsi'=>'Menambah Data Titik Potong Baru '.$request->nama.'','res'=>'success','userid'=>Auth::user()->userid);
                LogsModel::saveLogs($rr);
                DB::commit();
                return redirect('master/tikpot/edit/'.$id.'')->with(['result'=>'Tikpot berhasil disimpan, silahkan atur batas titik potong','restype'=>'success']);
            }
            catch (Throwable $e) {
                report($e);
                DB::rollback();
                return redirect()->back()->with(['result'=>'Gagal Menambah Data','restype'=>'danger']);
             }

        }else{
            try{
                DB::beginTransaction();
                TikpodModel::whereId($request->id)
                        ->update([
                            'nama'=>$request->nama,
                            'updated_at'=>now(),
                            'modified_by'=>Auth::user()->userid
                        ]);
                $rr=array('module'=>'titik potong','action'=>'edit','deskripsi'=>'Menambah Data Titik Potong Baru '.$request->nama.'','res'=>'success','userid'=>Auth::user()->userid);
                LogsModel::saveLogs($rr);
                DB::commit();
                return redirect('master/tikpot/edit/'.$request->id.'')->with(['result'=>'Tikpot berhasil diubah','restype'=>'success']);
            }
            catch (Throwable $e) {
                report($e);
                DB::rollback();
                return redirect()->back()->with(['result'=>'Gagal Ubah Data','restype'=>'danger']);
            }
        }
    }

    public function edit($id){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"5")){
            $act='Ubah';
            $data=TikpodModel::find($id);
            $dtDet=TikpodDetailModel::whereId_master($id)->orderBy('nama','ASC')->get();
            $dtDet2=TikpodDetailModel::whereId_master($id)->orderBy('nourut','Desc')->get();
            return view('master.tikpot.form',compact('data','act','id','dtDet','dtDet2'));
        }else{
            return view('notfound');
        }

   }
    public function destroy($id){
        TikpodDetailModel::whereId_master($id)->delete();
        TikpodModel::whereId($id)->delete();

        return redirect('master/tikpot')->with('message','Data berhasil di hapus');
    }
    public function simpanKonfig(Request $request){
        $posts=array();
        try{
            DB::beginTransaction();
            TikpodDetailModel::whereId($request->id)
                        ->update([
                            'warna'=>$request->warna,
                            'nama'=>$request->nama,
                            'min_potensial'=>$request->min_potensial,
                            'max_potensial'=>$request->max_potensial,
                            'min_kinerja'=>$request->min_kinerja,
                            'max_kinerja'=>$request->max_kinerja,
                            'updated_at'=>now()
            ]);
            DB::commit();
            return response()->json(array('respon' => 'success', 'message' =>'data berhasil di update'), 201);
        }
        catch (Throwable $e) {
            report($e);
            DB::rollback();
            return Response::json(['respon' => 'error', 'message' =>$e], 400);
        }
    }
    public function getTikpot(Request $request){
        if ($request->ajax()) {
            return $this->QTikPotController->QgetTikpot($request->nama);
        }
    }

    public function getDataDetail(Request $request){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");
        $kueri=TikpodDetailModel::find($request->id);
        return response()->json($kueri, 200);
    }

    public function cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"5")){
            $nama=$request->nama;
            return view('master.tikpot.index',compact('nama'));
        }else{
            return view('notfound');
        }
    }

}
