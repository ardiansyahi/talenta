<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkpModel extends Model
{
    use HasFactory;
    protected $table='talenta_skp';
    protected $fillable=[
        'pegawaiID',
        'nip',
        'nama',
        'tahunPenilaian',
        'tglPenilaian',
        'nourut',
        'nilai_angka',
        'rangking',
        'created_by',
        'updated_by',
    ];
}
