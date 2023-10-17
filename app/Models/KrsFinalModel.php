<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KrsFinalModel extends Model
{
    use HasFactory;
    protected $table='talenta_krs_final';
    protected $fillable=[
        'id_krs',
        'nip',
        'jenis',
        'pegawai',
        'potensial',
        'kinerja',
        'nilai',
        'created_by',
        'status'

    ];
}
