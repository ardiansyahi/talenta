<?php

namespace App\Query; // penamaan file sesuai dengan nama folder yang di simpan
use App\Models\RwdiklatHitungModel;
use App\Models\RwDiklatKonfigModel;
use App\Models\RwdiklatModel;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\GlobalHelper;
use Illuminate\Support\Str;
use App\Models\LogsModel;
use Response;
class QRwDiklatController
{
    public function getRW(){

        try{
            $posts=array();
            $key=$key2=true;
            $token=null;
            $getToken=GlobalHelper::getUrlKonfig('token');
            $getUrl=GlobalHelper::getUrlKonfig('rwdiklat');
            while($key){
                $head=array();
                $paramBody=array();
                $url=$getToken->url;
                $type=$getToken->method;
                $userAPI=$getToken->uid;
                $passAPI=$getToken->pass;

                $api=GlobalHelper::getCURLwithAuth($url,$type,$head,$paramBody,$userAPI,$passAPI);
                $response = curl_exec($api);
                $err = curl_error($api);
                if ($err) {}else{
                    $json = json_decode($response, true);
                    if ($json['status'] == true) {
                        $token=$json['token'];
                        $key=false;
                    }
                }
            }

            while($key2){
                $url=$getUrl->url;
                $type=$getUrl->method;
                $userAPI=$getUrl->uid;
                $passAPI=$getUrl->pass;
                $head=array('Content-Type: application/x-www-form-urlencoded');
                $paramBody='token='.$token;

                $api=GlobalHelper::getCURLwithAuth($url,$type,$head,$paramBody,$userAPI,$passAPI);

                $response = curl_exec($api);

                RwdiklatModel::truncate();
                RwdiklatHitungModel::truncate();

                $err = curl_error($api);

                if ($err) {
                    $posts = array('respon' => 'error', 'message' => $err, 'tipe' => 'error_curl');
                    return json_encode($posts);
                } else {
                    $json = json_decode($response, true);
                    $kueri=RwDiklatKonfigModel::get();

                    if ($json['status'] == true) {
                        for ($i = 0; $i < count($json['PegawaiKRS']); $i++) {
                            $aa=0;
                            foreach($kueri as $key => $item){
                                $myString=$json['PegawaiKRS'][$i]['NAMADIKLAT'];
                                $contains = Str::contains($myString, $item->nama);
                                if($contains){$aa++;}
                            }

                            RwdiklatModel::create([
                                'pegawaiID'=>$json['PegawaiKRS'][$i]['PEGAWAIID'],
                                'nip'=>$json['PegawaiKRS'][$i]['NIPBARU'],
                                'nama'=>$json['PegawaiKRS'][$i]['NAMA'],
                                'jenis'=>$json['PegawaiKRS'][$i]['JENIS'],
                                'tgl'=>$json['PegawaiKRS'][$i]['TGL'],
                                'nama_diklat'=>$json['PegawaiKRS'][$i]['NAMADIKLAT'],
                                'diklat_struktural'=>($aa > 0) ? 'Sesuai':'Tidak Sesuai',
                                'created_by'=>Auth::user()->userid,
                            ]);


                        }

                        $kueri=DB::select(
                            "SELECT nip,
                            COUNT(CASE WHEN jenis = '2' THEN 1 END) as t1,
                            COUNT(CASE WHEN diklat_struktural = 'Sesuai'  THEN 1 END)  as dk
                            FROM talenta_rwdiklat group by nip order by nip asc"
                        );
                        foreach($kueri as $key => $item){
                            if($item->dk > 0){$diklat_s="Sesuai";}else{$diklat_s="Tidak Sesuai";}
                            RwdiklatHitungModel::create([
                                'nip'=>$item->nip,
                                'diklat_teknis'=>$item->t1,
                                'total_ds'=>$item->dk,
                                'diklat_struktural'=>$diklat_s,
                                'created_by'=>Auth::user()->userid,
                            ]);
                        }
                        $posts = array('respon' => 'success', 'message' => 'sukses get data', 'tipe' => 'success_curl');
                        $key2=false;

                    }else{
                        $posts = array('respon' => 'error', 'message' => $json['status'] , 'tipe' => 'error_curl2');

                    }

                }
            }
            return response()->json($posts, 201);
        }
        catch (Throwable $e) {
            $rr=array('module'=>'Rw Diklat','action'=>'tarik data','deskripsi'=>'Tarik Data RW Diklat terbaru','res'=>'failed','userid'=>Auth::user()->userid);
            LogsModel::saveLogs($rr);
            report($e);
            $posts = array('respon' => 'error', 'message' =>$e , 'tipe' => 'error_curl3');
            return response()->json($posts, 400);
        }


    }


    public function getData($nip,$jenis){
        $param="WHERE a.nip !='san' ";
        if($nip !=''){
            $param .=" AND a.nip ='".$nip."' ";
        }

        if($jenis !=''){
            $param .=" AND a.diklat_struktural ='".$jenis."' ";
        }


        $data= DB::select("select distinct(a.nip), b.nama ,a.diklat_teknis, a.diklat_struktural
                         from talenta_rwdiklat_hitung as a
                         JOIN talenta_rwdiklat as b on a.nip=b.nip ".$param."");

         return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nip', function ($data) {
                return "<a href='#' class='text-primary' onclick=showGlobalModal('".$data->nip."','all')>".$data->nip."</a>";
            })
            ->addColumn('diklat_teknis', function ($data) {
                return "<a href='#' class='text-primary' onclick=showGlobalModal('".$data->nip."','2')>".$data->diklat_teknis."</a>";
            })
            ->rawColumns(['nip','diklat_teknis'])
            ->make(true);
    }

}
