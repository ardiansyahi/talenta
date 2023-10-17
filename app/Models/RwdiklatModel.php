<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RwdiklatModel extends Model
{
    use HasFactory;
    protected $table='talenta_rwdiklat';
    protected $fillable=[
        'pegawaiID','nip','nama','jenis','tgl','nama_diklat','diklat_struktural','created_by'
    ];
}
