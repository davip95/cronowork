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
        'minutos_descanso_intensiva',
        'hora_inicio',
        'hora_inicio_intensiva',
        'hora_fin',
        'hora_fin_intensiva',
        'horarios_id'
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
