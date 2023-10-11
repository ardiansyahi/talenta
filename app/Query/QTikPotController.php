<?php

namespace App\Query; // penamaan file sesuai dengan nama folder yang di simpan
use App\Models\TikpodDetailModel;
use Throwable;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LogsModel;
class QTikPotController
{
    public function storeDetail($id){
        try{
            DB::beginTransaction();
            for($a=1;$a<=9;$a++){
                switch($a){
                    case '1':$nama='Kotak 6';$warna="#ffff00";break;
                    case '2':$nama='Kotak 3';$warna="#ffff00";break;
                    case '3':$nama='Kotak 1';$warna="#ff9900";break;
                    case '4':$nama='Kotak 8';$warna="#33ccff";break;
                    case '5':$nama='Kotak 5';$warna="#ffff00";break;
                    case '6':$nama='Kotak 2';$warna="#ffff00";break;
                    case '7':$nama='Kotak 9';$warna="#33ccff";break;
                    case '8':$nama='Kotak 7';$warna="#33ccff";break;
                    case '9':$nama='Kotak 4';$warna="#ffff00";break;

                }
                TikpodDetailModel::create([
                    'id_master'=>$id,
                    'nama'=>$nama,
                    'min_potensial'=>0,
                    'max_potensial'=>0,
                    'min_kinerja'=>0,
                    'max_kinerja'=>0,
                    'warna'=>$warna,
                    'nourut'=>$a
                ]);
            }
            DB::commit();
            return true;
        }
        catch (Throwable $e) {
            report($e);
            DB::rollback();
            return false;

        }

    }

    public function QgetTikpot($nama){
        $param='';
        if($nama !=''){
            $param .=" Where  nama LIKE '%".$nama."%' ";
        }

        $data= DB::select("select id,nama FROM tikpot ".$param."");

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
                        return '<a href="/master/tikpot/edit/'.$data->id.'" class="btn btn-primary">Ubah</a>
                                <a href="tikpot/delete/'.$data->id.'" onclick="return confirm(`Yakin Anda Ingin Menghapus Data '.$data->nama.'`)" class="btn btn-danger">Hapus</a>
                                ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

}
