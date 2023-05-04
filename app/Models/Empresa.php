<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['fecha_alta'];
    protected $table = 'empresas';
    protected $fillable = [
        'nombre',
        'cif',
        'email',
        'direccion',
        'telefono',
        'fecha_alta',
    ];

    public $timestamps = false;
}
