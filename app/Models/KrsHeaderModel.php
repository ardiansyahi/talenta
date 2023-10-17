<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KrsHeaderModel extends Model
{
    use HasFactory;
    protected $table='talenta_krs_header';
    protected $fillable=[
        'id_krs',
        'pegawai',
        'potensial',
        'kinerja',
        'header',
        'created_by',

    ];
}
