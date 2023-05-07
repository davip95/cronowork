<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jornada extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jornadas';
    protected $fillable = [
        'dia',
        'minutos_descanso',
        'hora_inicio',
        'hora_fin',
    ];

    public $timestamps = false;

    /**
     * Obtiene el horario de la jornada.
     */
    public function horarios()
    {
        return $this->belongsTo(Horario::class);
    }
}
