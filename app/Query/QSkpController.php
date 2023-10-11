<?php

namespace App\Query; // penamaan file sesuai dengan nama folder yang di simpan

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\GlobalHelper;
use Illuminate\Support\Str;
use App\Models\LogsModel;
use Response;
use App\Models\SkpModel;
use Throwable;
class QSkpController

{
    public function getSkp(){

        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");

        try{

            //get token
            $posts=array();
            $key=$key2=true;
            $token=null;
            $getToken=GlobalHelper::getUrlKonfig('token');
            $getUrl=GlobalHelper::getUrlKonfig('skp');
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
                //print_r($response)
                if ($err) {
                    print_r($err);
                }else{
                    $json = json_decode($response, true);
                    if ($json['status'] == true) {
                        $token=$json['token'];
                        $key=false;
                    }
                }
            }



            // //get RWJabatan
             while($key2){
                $url=$getUrl->url;
                $type=$getUrl->method;
                $userAPI=$getUrl->uid;
                $passAPI=$getUrl->pass;
                $head=array('Content-Type: application/x-www-form-urlencoded');
                $paramBody='token='.$token;

                $api=GlobalHelper::getCURLwithAuth($url,$type,$head,$paramBody,$userAPI,$passAPI);

                $response = curl_exec($api);

                SkpModel::truncate();
                $err = curl_error($api);
                if ($err) {
                    $posts = array('respon' => 'error', 'message' => $err, 'tipe' => 'error_curl');
                    return json_encode($posts);
                } else {
                    $json = json_decode($response, true);
                    if ($json['status'] == true) {
                        for ($i = 0; $i < count($json['DataSKP']); $i++) {
                        //  $nm=GlobalHelper::getNamaNipPegawai($json['DataSKP'][$i]['NIPBARU']);
                            SkpModel::create([
                                'pegawaiID'=>$json['DataSKP'][$i]['PEGAWAIID'],
                                'nip'=>$json['DataSKP'][$i]['NIPBARU'],
                                'nama'=>$json['DataSKP'][$i]['NAMA'],
                                'tahunPenilaian'=>$json['DataSKP'][$i]['TAHUNPENILAIAN'],
                                'tglPenilaian'=>$json['DataSKP'][$i]['TANGGALPENILAIAN'],
                                'nourut'=>$json['DataSKP'][$i]['NOURUT'],
                                'nilai_angka'=>($json['DataSKP'][$i]['NILAIANGKA']!=null) ? $json['DataSKP'][$i]['NILAIANGKA']:'0',
                                'rangking'=>$json['DataSKP'][$i]['RANKING'],
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
             report($e);
             $posts = array('respon' => 'error', 'message' =>$e , 'tipe' => 'error_curl3');
             return response()->json($posts, 400);
         }
    }


    public function getData($nip,$tahun){
        $data=SkpModel::where('id','>','0');
        if($nip !=''){
            $data->whereNip($nip);
        }
        if($tahun !=''){
            $data->where('tahunPenilaian','like','%'.$tahun.'%');
        }


        $data->get();


         return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nip', function ($data) {
                return "<a href='#' class='text-primary' onclick=showGlobalModal('".$data->nip."')>".$data->nip."</a>";
            })
            ->rawColumns(['nip'])
            ->make(true);

    }

}
