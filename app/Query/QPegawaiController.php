<?php

namespace App\Query; // penamaan file sesuai dengan nama folder yang di simpan
use App\Models\PegawaiTalentaModel;
use App\Models\User;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\GlobalHelper;
use App\Models\LogsModel;
class QPegawaiController
{
    public function getPegawai(){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");

       // try{

            //get token
            $posts=array();
            $key=$key2=true;
            $token=null;
            $getToken=GlobalHelper::getUrlKonfig('token');
            $getUrl=GlobalHelper::getUrlKonfig('pegawai');
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

            //get api pegawai
            while($key2){
                $url=$getUrl->url;
                $type=$getUrl->method;
                $userAPI=$getUrl->uid;
                $passAPI=$getUrl->pass;

                $head=array('Content-Type: application/x-www-form-urlencoded');
                $paramBody='token='.$token;
                $api=GlobalHelper::getCURLwithAuth($url,$type,$head,$paramBody,$userAPI,$passAPI);

                $response = curl_exec($api);

                PegawaiTalentaModel::truncate();

                $err = curl_error($api);

                if ($err) {
                    $posts = array('respon' => 'error', 'message' => $err, 'tipe' => 'error_curl');
                    return response()->json($posts, 400);
                } else {
                    $json = json_decode($response, true);
                    if ($json['status'] == true) {
                        User::where('userid','!=','superadmin')->update([
                            'isActive'=>1,
                        ]);
                        for ($i = 0; $i < count($json['PegawaiKRS']); $i++) {
                            PegawaiTalentaModel::create([
                                'pegawaiID'=>$json['PegawaiKRS'][$i]['PEGAWAIID'],
                                'nip'=>$json['PegawaiKRS'][$i]['NIPBARU'],
                                'thnpns'=>(int)substr($json['PegawaiKRS'][$i]['NIPBARU'],8,6),
                                'nama'=>$json['PegawaiKRS'][$i]['NAMA'],
                                'nama_lengkap'=>$json['PegawaiKRS'][$i]['NAMA_LENGKAP'],
                                'tgl_lahir'=>GlobalHelper::changeDate('1',$json['PegawaiKRS'][$i]['TGLLAHIR']),
                                'pendidikan'=>$json['PegawaiKRS'][$i]['PENDIDIKAN'],
                                'eselon'=>$json['PegawaiKRS'][$i]['ESELON'],
                                'tmteselon'=>GlobalHelper::changeDate('1',$json['PegawaiKRS'][$i]['TMTESELON']),
                                'pangkat'=>$json['PegawaiKRS'][$i]['PANGKAT'],
                                'golongan'=>$json['PegawaiKRS'][$i]['GOLONGAN'],
                                'tmtpangkat'=>GlobalHelper::changeDate('1',$json['PegawaiKRS'][$i]['TMTPANGKAT']),
                                'level_jabatan'=>$json['PegawaiKRS'][$i]['LEVEL_JABATAN'],
                                'nama_jabatan'=>$json['PegawaiKRS'][$i]['NAMAJABATAN'],
                                'tmt_jabatan'=>GlobalHelper::changeDate('1',$json['PegawaiKRS'][$i]['TMTJABATAN']),
                                'satker'=>GlobalHelper::changeDate('1',$json['PegawaiKRS'][$i]['SATKER']),
                                'tipepegawai'=>$json['PegawaiKRS'][$i]['TIPEPEGAWAI'],
                                'statuspegawai'=>$json['PegawaiKRS'][$i]['STATUSPEGAWAI'],
                                'kedudukan'=>$json['PegawaiKRS'][$i]['KEDUDUKAN'],
                                'created_by'=>Auth::user()->userid,
                            ]);

                            $dt=array(
                                'userid'=>$json['PegawaiKRS'][$i]['NIPBARU'],
                                'name'=>$json['PegawaiKRS'][$i]['NAMA_LENGKAP'],
                                'password'=>bcrypt('password'),
                                'isActive'=>0,
                                'id_akses'=>5,
                                'email'=>'',
                            );
                            GlobalHelper::cekUser($dt,$json['PegawaiKRS'][$i]['NIPBARU']);

                        }
                        $rr=array('module'=>'master pegawai','action'=>'tarik data','deskripsi'=>'Tarik Data Pegawai terbaru','res'=>'success','userid'=>Auth::user()->userid);
                        LogsModel::saveLogs($rr);

                        $posts = array('respon' => 'success', 'message' => 'sukses get data', 'tipe' => 'success_curl');
                        $key2=false;

                    }else{
                        $rr=array('module'=>'master pegawai','action'=>'tarik data','deskripsi'=>'Tarik Data Pegawai terbaru '.$json['status'].'','res'=>'failed','userid'=>Auth::user()->userid);
                        LogsModel::saveLogs($rr);
                        $posts = array('respon' => 'error', 'message' => $json['status'] , 'tipe' => 'error_curl2');
                        //return json_encode($posts);
                    }

                }
            }

            return response()->json($posts, 201);
       // }
        // catch (Throwable $e) {

        //     $rr=array('module'=>'master pegawai','action'=>'tarik data','deskripsi'=>'Tarik Data Pegawai terbaru','res'=>'failed','userid'=>Auth::user()->userid);
        //     LogsModel::saveLogs($rr);
        //     $posts = array('respon' => 'error', 'message' =>$e , 'tipe' => 'error_curl');
        //     report($e);
        //     return response()->json($posts, 400);
        // }
    }

    public function getData($nip){
        $param="WHERE nip !='000' ";
            if($nip !=''){
                $param .=" AND nip ='".$nip."' ";
            }

            $data= DB::select("select nip,nama_lengkap,pangkat,statuspegawai,golongan,eselon,pendidikan,kedudukan
                             FROM talenta_pegawai ".$param."");

             return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nip', function ($data) {
                    return "<a href='#' class='text-primary' onclick=showGlobalModal('".$data->nip."')>".$data->nip."</a>";
                })
                ->addColumn('act',function($data){return '';})
                ->rawColumns(['nip','act'])
                ->make(true);
    }

}
