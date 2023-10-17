<?php

namespace App\Query; // penamaan file sesuai dengan nama folder yang di simpan
use App\Models\RwJabatanHitungModel;
use App\Models\RwJabatanModel;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\GlobalHelper;
use Illuminate\Support\Str;
use App\Models\LogsModel;
use Response;
class QRwJabatanController

{
    public function getRwJabatan(){

        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");

       // try{

            //get token
            $posts=array();
            $key=$key2=true;
            $token=null;
            $getToken=GlobalHelper::getUrlKonfig('token');
            $getUrl=GlobalHelper::getUrlKonfig('rwjabatan');
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

            //get RWJabatan
            while($key2){
                $url=$getUrl->url;
                $type=$getUrl->method;
                $userAPI=$getUrl->uid;
                $passAPI=$getUrl->pass;

                $head=array('Content-Type: application/x-www-form-urlencoded');
                $paramBody='token='.$token;

                $api=GlobalHelper::getCURLwithAuth($url,$type,$head,$paramBody,$userAPI,$passAPI);

                $response = curl_exec($api);

                RwJabatanModel::truncate();
                RwJabatanHitungModel::truncate();
                $err = curl_error($api);

                if ($err) {
                    $posts = array('respon' => 'error', 'message' => $err, 'tipe' => 'error_curl');
                    return response()->json($posts, 400);
                } else {
                    $json = json_decode($response, true);
                    if ($json['status'] == true) {
                        for ($i = 0; $i < count($json['PegawaiKRS']); $i++) {
                        //  $nm=GlobalHelper::getNamaNipPegawai($json['PegawaiKRS'][$i]['NIPBARU']);
                            RwJabatanModel::create([
                                'nip'=>$json['PegawaiKRS'][$i]['NIPBARU'],
                                'nama'=>$json['PegawaiKRS'][$i]['NAMA'],
                                'eselon'=>$json['PegawaiKRS'][$i]['ESELON'],
                                'tmteselon'=>$json['PegawaiKRS'][$i]['TMTESELON'],
                                'nama_jabatan'=>$json['PegawaiKRS'][$i]['NAMAJABATAN'],
                                'tmtjabatan'=>$json['PegawaiKRS'][$i]['TMTJABATAN'],
                                'tglsk'=>$json['PegawaiKRS'][$i]['TGLSK'],
                                'satker'=>$json['PegawaiKRS'][$i]['SATKER'],
                                'nourut'=>$json['PegawaiKRS'][$i]['NOURUT'],
                                'created_by'=>Auth::user()->userid,
                            ]);


                        }
                        $kueri=DB::select(
                            "SELECT nip,count(nip) as total
                            FROM rwjabatan group by nip"
                        );
                        foreach($kueri as $key => $item){
                            $nm=GlobalHelper::getNamaNipPegawai($item->nip);
                            $nama='-';
                            if($nm!=null){$nama=$nm->nama_lengkap;}
                            RwJabatanHitungModel::create([
                                'nip'=>$item->nip,
                                'nama'=>$nama,
                                'total'=>$item->total,

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
        // }
        // catch (Throwable $e) {
        //     report($e);
        //     $posts = array('respon' => 'error', 'message' =>$e , 'tipe' => 'error_curl3');
        //     return response()->json($posts, 400);
        // }


    }


    public function getData($nip){
        $param='';
        if($nip !=''){
            $param .=" Where  nip ='".$nip."' ";
        }

        $data= DB::select("select nip,nama,total FROM talenta_rwjabatan_hitung ".$param."");

         return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nip', function ($data) {
                return "<a href='#' class='text-primary' onclick=showGlobalModal('".$data->nip."')>".$data->nip."</a>";
            })
            ->rawColumns(['nip','diklat_teknis'])
            ->make(true);
    }

}
