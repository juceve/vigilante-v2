<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Designacione
 *
 * @property $id
 * @property $empleado_id
 * @property $turno_id
 * @property $fechaInicio
 * @property $fechaFin
 * @property $estado
 * @property $created_at
 * @property $updated_at
 *
 * @property Designaciondia[] $designaciondias
 * @property Empleado $empleado
 * @property Turno $turno
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Designacione extends Model
{

    static $rules = [
        'empleado_id' => 'required',
        'turno_id' => 'required',
        'fechaInicio' => 'required',
        'fechaFin' => 'required',
        'intervalo_hv' => 'required',
        'estado' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['empleado_id', 'turno_id', 'fechaInicio', 'fechaFin', 'intervalo_hv', 'observaciones', 'estado'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function designaciondias()
    {
        return $this->hasMany('App\Models\Designaciondia', 'designacione_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function empleado()
    {
        return $this->hasOne('App\Models\Empleado', 'id', 'empleado_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function turno()
    {
        return $this->hasOne('App\Models\Turno', 'id', 'turno_id');
    }

    public function regrondas()
    {
        return $this->hasMany('App\Models\Regronda', 'designacione_id', 'id');
    }

    public function marcaciones()
    {
        return $this->hasMany('App\Models\Marcacione', 'designacione_id', 'id');
    }

    public function asistencias()
    {
        return $this->hasMany('App\Models\Asistencia', 'designacione_id', 'id');
    }

    public function intervalos()
    {
        return $this->hasMany('App\Models\Intervalo', 'designacione_id', 'id');
    }

    public function novedades()
    {
        return $this->hasMany('App\Models\Novedade', 'designacione_id', 'id');
    }
}
