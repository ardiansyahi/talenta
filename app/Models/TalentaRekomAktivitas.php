<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentaRekomAktivitas extends Model
{
    use HasFactory;
    protected $table='talenta_rekom_aktivitas';
    protected $fillable=[
        'id_rekom_aktivitas','kotak_talenta','lama_exposure','experience','lama_experience','education','created_at','updated_at','lama_education','strategi_retensi'
    ];
}
