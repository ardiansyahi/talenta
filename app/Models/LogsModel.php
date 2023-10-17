<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogsModel extends Model
{
    use HasFactory;
    protected $table='talenta_logs';
    protected $fillable=[
        'module',
        'action',
        'deskripsi',
        'res',
        'userid'
    ];

    public static function saveLogs($request){
        return static::create([
            'module'=>$request['module'],
            'action'=>$request['action'],
            'deskripsi'=>$request['deskripsi'],
            'res'=>$request['res'],
            'userid'=>$request['userid'],
            'created_at'=>now()
        ]);


    }
}
