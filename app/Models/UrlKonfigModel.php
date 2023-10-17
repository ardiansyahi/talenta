<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlKonfigModel extends Model
{
    use HasFactory;
    protected $table='talenta_urlkonfig';
    protected $fillable=[
        'url','port','method','uid','pass','jenis'
    ];
}
