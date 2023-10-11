<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View_Penilaian_Perilaku extends Model
{
    use HasFactory;
    protected $connection='pgsql2';
    protected $table='rekap_penilaianperilaku_nilai';
}
