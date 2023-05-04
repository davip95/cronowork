<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horario extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['fecha_inicio', 'fecha_fin'];
    protected $table = 'horarios';
    protected $fillable = [
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
    ];

    public $timestamps = false;
}
