<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Hombrevivo
 *
 * @property $id
 * @property $intervalo_id
 * @property $fecha
 * @property $hora
 * @property $anotaciones
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @property Intervalo $intervalo
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Hombrevivo extends Model
{

  static $rules = [
    'intervalo_id' => 'required',
    'fecha' => 'required',
    'hora' => 'required',
    'status' => 'required',
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['intervalo_id', 'fecha', 'hora', 'anotaciones', 'lat', 'lng', 'status'];


  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function intervalo()
  {
    return $this->hasOne('App\Models\Intervalo', 'id', 'intervalo_id');
  }
}
