<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TikpodModel extends Model
{
    use HasFactory;
    protected $table='tikpot';
    protected $fillable=[
        'nama',
        'status',
        'created_by',
        'modified_by',
        'id'
    ];
}
