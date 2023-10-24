<?php

namespace App\Http\Controllers;

use App\Models\LogsModel;
use App\Models\PegawaiModel;
use App\Models\User;
use App\Models\AksesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index(){

        return redirect('https://orpeg.atrbpn.go.id/itms/');
        //return view('auth.login');

    }

    public function loginsuper(){

        return view('auth.login');

    }

    public function authLogin(Request $request){
        $request->validate([
            'nip'=>'required',
            'password'=>'required'
        ]);
        $user=User::whereUserid($request->nip)->first();
        if($user){
            if(Hash::check($request->password,$user->password)){
                Auth::login($user);
                    session(['nip' =>$request->nip]);
                    Session::put('id_akses', $user->id_akses);
                    //echo $pegawai->nip;
                    $rr=array('module'=>'login','action'=>'login','deskripsi'=>'sukses login','res'=>'success','userid'=>$request->nip);
                    LogsModel::saveLogs($rr);
                   // return redirect('/')->with('success','Selamat datang '.$pegawai->nama.' di Manajemen Talenta');
                   return redirect()->back();

            }else{
                $rr=array('module'=>'login','action'=>'login','deskripsi'=>'Password salah','res'=>'failed','userid'=>$request->nip);
                LogsModel::saveLogs($rr);
                session()->flash('respon','Password salah');
                return redirect('login');
            }
        }else{
            $rr=array('module'=>'login','action'=>'login','deskripsi'=>'User tidak ditemukan','res'=>'failed','userid'=>$request->nip);
            LogsModel::saveLogs($rr);
            session()->flash('respon','User tidak ditemukan');
            return redirect('login');
        }


    }

    public function authLoginFromTms($nip){
        
        if($nip ==""){
            return redirect(env('URL_API_TMS'));
        }else{
            $user=User::whereUserid($nip)->where('isActive','=',0)->first();
            if($user){
                Auth::login($user);
                session(['nip' =>$nip]);
                Session::put('id_akses', $user->id_akses);
                        //echo $pegawai->nip;
                $rr=array('module'=>'login','action'=>'login','deskripsi'=>'sukses login','res'=>'success','userid'=>$nip);
                LogsModel::saveLogs($rr);
                return redirect('/')->with('success','Selamat datang '.$user->name.' di Manajemen Talenta');
            }else{

                $dt=array(
                    'userid'=>$nip,
                    'name'=>'',
                    'password'=>bcrypt('password'),
                    'isActive'=>0,
                    'id_akses'=>5,
                    'email'=>'',
                );
                User::create($dt);

                $user=User::whereUserid($nip)->where('isActive','=',0)->first();
                Auth::login($user);
                session(['nip' =>$nip]);
                Session::put('id_akses', $user->id_akses);
                        //echo $pegawai->nip;
                $rr=array('module'=>'login','action'=>'login','deskripsi'=>'sukses login','res'=>'success','userid'=>$nip);
                LogsModel::saveLogs($rr);
                return redirect('/')->with('success','Selamat datang '.$user->name.' di Manajemen Talenta');

            }
        }
      
        


    }

    public function logout(){
        $rr=array('module'=>'logout','action'=>'logout','deskripsi'=>'Logout Aplikasi','res'=>'success','userid'=>session()->get('nip'));
        LogsModel::saveLogs($rr);
        session()->forget('nip');
        Auth::logout();
        //return redirect('login');
        return redirect('https://orpeg.atrbpn.go.id/itms/');
    }

}
