<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rrhhpermiso
 *
 * @property $id
 * @property $rrhhcontrato_id
 * @property $empleado_id
 * @property $rrhhtipopermiso_id
 * @property $fecha_inicio
 * @property $fecha_fin
 * @property $cantidad_horas
 * @property $motivo
 * @property $documento_adjunto
 * @property $activo
 * @property $created_at
 * @property $updated_at
 *
 * @property Empleado $empleado
 * @property Rrhhcontrato $rrhhcontrato
 * @property Rrhhtipopermiso $rrhhtipopermiso
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Rrhhpermiso extends Model
{
    
    static $rules = [
		'fecha_inicio' => 'required',
		'fecha_fin' => 'required',
		'activo' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['rrhhcontrato_id','empleado_id','rrhhtipopermiso_id','fecha_inicio','fecha_fin','cantidad_horas','motivo','documento_adjunto','activo'];


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
    public function rrhhcontrato()
    {
        return $this->hasOne('App\Models\Rrhhcontrato', 'id', 'rrhhcontrato_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rrhhtipopermiso()
    {
        return $this->hasOne('App\Models\Rrhhtipopermiso', 'id', 'rrhhtipopermiso_id');
    }
    

}
