<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KrsModel extends Model
{
    use HasFactory;
    protected $table='talenta_krs';
    protected $fillable=[
        'tahun','batch','jenis','deskripsi','created_by','updated_by','created_at','updated_at','fileupload','id_tikpot','id_krs_awal','status'
    ];
}
