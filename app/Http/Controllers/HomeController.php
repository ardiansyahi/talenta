<?php

namespace App\Http\Controllers;

use App\Models\LogsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $rr=array('module'=>'home','action'=>'view','deskripsi'=>'Membuka halaman home','res'=>'success','userid'=>session()->get('nip'));
        LogsModel::saveLogs($rr);      
        return view('home');
    }
}
