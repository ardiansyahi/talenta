<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formModel extends Model
{
    use HasFactory;
    protected $table='form';
    protected $fillable=['nama','jenis','id_root','created_by'];
}
