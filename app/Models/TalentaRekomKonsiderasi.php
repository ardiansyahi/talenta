<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentaRekomKonsiderasi extends Model
{
    use HasFactory;
    protected $table='talenta_rekom_konsiderasi';
    protected $fillable=[
        'id_rekom_konsidersai','kotak_talenta','aspek_potensial_kinerja','aspek_kebutuhan_dasar'
    ];
}
