<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Residencia
 *
 * @property $id
 * @property $cliente_id
 * @property $propietario_id
 * @property $cedula_propietario
 * @property $numeropuerta
 * @property $calle
 * @property $nrolote
 * @property $manzano
 * @property $notas
 * @property $created_at
 * @property $updated_at
 *
 * @property Propietario $propietario
 * @property Propietario $propietario
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Residencia extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['cliente_id','propietario_id','cedula_propietario','numeropuerta','calle','nrolote','manzano','notas'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'cliente_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function propietario()
    {
        return $this->belongsTo('App\Models\Propietario', 'propietario_id', 'id');
    }
    

}
