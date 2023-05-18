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
        'fecha_inicio_intensivo',
        'fecha_fin_intensivo',
        'empresas_id'
    ];

    public $timestamps = false;

    /**
     * Obtiene los empleados del horario.
     */
    public function empleados()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Obtiene los fichajes del horario.
     */
    public function fichajes()
    {
        return $this->hasMany(Fichaje::class);
    }

    /**
     * Obtiene las jornadas del horario.
     */
    public function jornadas()
    {
        return $this->hasMany(Jornada::class);
    }

    /**
     * Obtiene la empresa a la que pertenece el horario.
     */
    public function empresas()
    {
        return $this->belongsTo(Empresa::class);
    }
}
