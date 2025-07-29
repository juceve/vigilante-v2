<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Intervalo
 *
 * @property $id
 * @property $designacione_id
 * @property $hora
 * @property $created_at
 * @property $updated_at
 *
 * @property Designacione $designacione
 * @property Hombrevivo[] $hombrevivos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Intervalo extends Model
{
    
    static $rules = [
		'designacione_id' => 'required',
		'hora' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['designacione_id','hora'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function designacione()
    {
        return $this->hasOne('App\Models\Designacione', 'id', 'designacione_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hombrevivos()
    {
        return $this->hasMany('App\Models\Hombrevivo', 'intervalo_id', 'id');
    }
    

}
