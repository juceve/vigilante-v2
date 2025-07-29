<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rrhhdotacion
 *
 * @property $id
 * @property $rrhhcontrato_id
 * @property $fecha
 * @property $detalle
 * @property $rrhhestadodotacion_id
 * @property $empleado_id
 * @property $cantidad
 * @property $estado
 * @property $created_at
 * @property $updated_at
 *
 * @property Empleado $empleado
 * @property Rrhhcontrato $rrhhcontrato
 * @property Rrhhestadodotacion $rrhhestadodotacion
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Rrhhdotacion extends Model
{
    
    static $rules = [
		'fecha' => 'required',
		'detalle' => 'required',
		'cantidad' => 'required',
		'estado' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['rrhhcontrato_id','fecha','detalle','rrhhestadodotacion_id','empleado_id','cantidad','estado'];


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
    public function rrhhestadodotacion()
    {
        return $this->hasOne('App\Models\Rrhhestadodotacion', 'id', 'rrhhestadodotacion_id');
    }
    

}
