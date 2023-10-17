<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RwDiklatKonfigModel extends Model
{
    use HasFactory;
    protected $table='talenta_rwdiklat_konfig';
    protected $fillable=[
        'nama','created_by','created_at','updated_at'
    ];

    public static function cekDiklat($key=null){
        $kueri=RwDiklatKonfigModel::where('nama','like','%'.$key.'%')->count();

    }

}
