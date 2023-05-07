<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ausencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['fecha_inicio', 'fecha_fin'];
    protected $table = 'ausencias';
    protected $fillable = [
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'aceptada',
        'motivos'
    ];

    public $timestamps = false;

    /**
     * Obtiene el empleado al que esta asignada la ausencia.
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
