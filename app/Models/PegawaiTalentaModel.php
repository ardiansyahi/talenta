<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiTalentaModel extends Model
{
    use HasFactory;
    protected $table='talenta_pegawai';
    protected $fillable=[
        'pegawaiID',
        'nip',
        'thnpns',
        'nama',
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
        'created_by',
        'updated_by',
    ];
}
