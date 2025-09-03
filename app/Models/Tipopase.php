<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tipopase
 *
 * @property $id
 * @property $nombre
 * @property $descripcion
 * @property $estado
 * @property $created_at
 * @property $updated_at
 *
 * @property Paseingreso[] $paseingresos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Tipopase extends Model
{
    
    static $rules = [
		'nombre' => 'required',
		'descripcion' => 'required',
		'estado' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','descripcion','estado'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paseingresos()
    {
        return $this->hasMany('App\Models\Paseingreso', 'tipopase_id', 'id');
    }
    

}
