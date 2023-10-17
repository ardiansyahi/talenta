<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs_temp_model extends Model
{
    use HasFactory;
    protected $table='talenta_krs_temp_proses';
    protected $fillable=[
                'id_krs',
                'jenis',
                'nip',
                'nama',
                'tgl_lahir',
                'pendidikan',
                'eselon',
                'level_jabatan',
                'provisi',
                'satker',
                'nama_jabatan',
                'tmt_jabatan',
                'pangkat',
                'golongan',
                'cek_penkom',
                'skoring_mansoskul',
                'skoring_generik',
                'skoring_spesifik',
                'skoring_pendidikan',
                'total_rw_jabatan',
                'bobot_rw_jabatan',
                'bobot_rw_jabatan_total',
                'diklat_struktural',
                'bobot_ds',
                'diklat_teknis',
                'bobot_dt',
                'total_bobot',
                'total_bobot_persen',
                'skoring_pangkat',
                'year2',
                'year1',
                'penilaian_perilaku',
                'created_by',
    ];
}
