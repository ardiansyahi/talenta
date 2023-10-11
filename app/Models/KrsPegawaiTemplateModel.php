<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KrsPegawaiTemplateModel extends Model
{
    use HasFactory;
    protected $table='krs_pegawai_template';
    protected $fillable=[
        'pegawaiID',
        'nip',
        'thnpns',
        'nama_lengkap',
        'tgl_lahir',
        'pendidikan',
        'eselon',
        'tmteselon',
        'pangkat',
        'golongan',
        'tmtpangkat',
        'level_jabatan',
        'nama_jabatan',
        'tmt_jabatan',
        'satker',
        'tipepegawai',
        'statuspegawai',
        'kedudukan',
        'id_krs',
        'tahun_krs',
        'jenis_krs',
        'tahun_penkom',
        'mansoskul',
        'generik',
        'spesifik',
        'created_by',
        'created_at',
        'modified_at'
    ];
}
