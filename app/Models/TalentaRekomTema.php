<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentaRekomTema extends Model
{
    use HasFactory;
    protected $table='talenta_rekom_tema';
    protected $fillable=[
        'id_rekom_tema','kotak_talenta','strategy','Exposure','Experience','Education','created_at','updated_at','kesiapan_promosi'
    ];
}
