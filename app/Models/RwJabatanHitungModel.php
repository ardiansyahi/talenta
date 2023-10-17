<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RwJabatanHitungModel extends Model
{
    use HasFactory;
    protected $table='talenta_rwjabatan_hitung';
    protected $fillable=[
        'nip',
        'nama',
        'total'
    ];
}
