<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonfigurasiModel extends Model
{
    use HasFactory;
    protected $table='konfigurasi_krs';
    protected $fillable=[
        'id_krs',
        'jenis',
        'kriteria',
        'isidata',
        'created_by',
        'updated_by'
    ];
   

}
