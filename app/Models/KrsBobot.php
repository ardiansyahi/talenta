<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KrsBobot extends Model
{
    use HasFactory;
    protected $table='krs_bobot';
    protected $fillable=[
            'id_krs',
            'jenis',
            'potensial',
            'kinerja',
            'created_by',
            
        
    ];
}
