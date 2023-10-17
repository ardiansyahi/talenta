<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RwJabatanModel extends Model
{
    use HasFactory;
    protected $table='talenta_rwjabatan';
    protected $fillable=[
        'nip','nama','eselon','tmteselon',
        'namajabatan','tmtjabatan','tglsk',
        'satker','nourut','created_by','updated_by'
    ];
}
