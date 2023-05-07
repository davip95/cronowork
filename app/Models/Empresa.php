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
    ];

    public $timestamps = false;

    /**
     * Obtiene los empleados de la empresa.
     */
    public function empleados()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Obtiene los horarios de la empresa.
     */
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
