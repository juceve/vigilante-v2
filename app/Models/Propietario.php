<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Propietario
 *
 * @property $id
 * @property $nombre
 * @property $cedula
 * @property $telefono
 * @property $email
 * @property $direccion
 * @property $ciudad
 * @property $activo
 * @property $created_at
 * @property $updated_at
 *
 * @property Residencia[] $residencias
 * @property Residencia[] $residencias
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Propietario extends Model
{
    
    static $rules = [
		'nombre' => 'required',
		'cedula' => 'required',
		'activo' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','cedula','telefono','email','direccion','ciudad','activo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function residencias()
    {
        return $this->hasMany('App\Models\Residencia', 'cliente_id', 'id');
    }
    
    
}
