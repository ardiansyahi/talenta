<?php

namespace App\Http\Controllers;

use App\Models\LogsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GlobalHelper;
use App\Models\KrsModel;
class HomeController extends Controller
{
    public function index(){
        $rr=array('module'=>'home','action'=>'view','deskripsi'=>'Membuka halaman home','res'=>'success','userid'=>session()->get('nip'));
        LogsModel::saveLogs($rr);
        $sesakses=\Session::get('id_akses');
        switch($sesakses){
            case "1":
            case "2":
                $tkrs_fp=GlobalHelper::getCountKrs('pengawas',date('Y'),'publish');
                $tkrs_fa=GlobalHelper::getCountKrs('administrator',date('Y'),'publish');
                $tkrs_fk=GlobalHelper::getCountKrs('kjp',date('Y'),'publish');

                $tkrs_ip=GlobalHelper::getCountKrs('pengawas',date('Y'),'in_progress');
                $tkrs_ia=GlobalHelper::getCountKrs('administrator',date('Y'),'in_progress');
                $tkrs_ik=GlobalHelper::getCountKrs('kjp',date('Y'),'in_progress');

                return view('dashboard.admin',compact('tkrs_fp','tkrs_fa','tkrs_fk','tkrs_ip','tkrs_ia','tkrs_ik'));
                break;

            case "5":
                $nip=Auth::user()->userid;
                return view('dashboard.user',compact('nip'));
                break;
            default:
                return view('dashboard.home');
                break;
        }

    }
}
