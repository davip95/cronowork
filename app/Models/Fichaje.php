<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fichaje extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['fecha_hora_fichaje'];
    protected $table = 'fichajes';
    protected $fillable = [
        'tipo',
        'fecha_hora_fichaje',
        'modificado',
        'empleados_id',
        'horarios_id'
    ];

    public $timestamps = false;

    /**
     * Obtiene el empleado que realiza el fichaje.
     */
    public function empleados()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene el horario del fichaje.
     */
    public function horarios()
    {
        return $this->belongsTo(Horario::class);
    }
}
