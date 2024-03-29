<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $dates = ['fecha_alta'];

    protected $table = 'empleados';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo',
        'apellidos',
        'telefono',
        'direccion',
        'codpostal',
        'fecha_alta',
        'horarios_id',
        'empresas_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Obtiene los fichaes del usuario.
     */
    public function fichajes()
    {
        return $this->hasMany(Fichaje::class);
    }

    /**
     * Obtiene las ausencias del usuario.
     */
    public function ausencias()
    {
        return $this->hasMany(Ausencia::class);
    }

    /**
     * Obtiene la empresa a la que pertenece el empleado.
     */
    public function empresas()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Obtiene el horario al que esta asignado el empleado.
     */
    public function horarios()
    {
        return $this->belongsTo(Horario::class);
    }
}
