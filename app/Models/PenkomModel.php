<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenkomModel extends Model
{
    use HasFactory;
    protected $table='penkom';
    protected $fillable=[
        'nip','nama','jenis','tahun',
        'pangkat','jabatan','unit_kerja','golongan',
        'mansoskul','teknis_generik','teknis_spesifik',
        'created_by','updated_by','hashname'
    ];
}
