<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KrsAdminTemplateModel extends Model
{
    use HasFactory;
    protected $table='krs_pegawai_temp_admin';
    protected $fillable=[
        'id_krs',
        'id_krs_awal',
        'nip',
        'jenis',
        'pegawai',
        'potensial',
        'kinerja',
        'nilai',
        'created_by',
        'nomor_surat_usul',
        'tgl_surat',
        'gelombang_1',
        'dicalonkan_gelombang_2',
        'kotak_talent_pool',
        'created_by'
    ];
}
