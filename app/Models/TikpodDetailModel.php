<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TikpodDetailModel extends Model
{
    use HasFactory ;
    protected $table='talenta_tikpot_detail';
    protected $fillable=[
        'id_master',
        'nama',
        'min_potensial',
        'max_potensial',
        'min_kinerja',
        'max_kinerja',
        'warna',
        'nourut'

    ];
}
