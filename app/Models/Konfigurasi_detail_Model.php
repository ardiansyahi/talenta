<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konfigurasi_detail_Model extends Model
{
    use HasFactory;
    protected $table='konfigurasi_detail';
    protected $fillable=['jenis','kriteria','isidata'];
}
