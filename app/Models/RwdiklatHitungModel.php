<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RwdiklatHitungModel extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table='talenta_rwdiklat_hitung';
    protected $fillable=[
        'nip','diklat_teknis','diklat_struktural','created_by','total_ds'
    ];

}
