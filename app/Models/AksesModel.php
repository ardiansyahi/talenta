<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesModel extends Model
{
    use HasFactory;
    protected $table='akses';
    protected $fillable=['nama','id_form','isdeleted','created_by','modified_by'];
}
