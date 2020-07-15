<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drivers extends Model
{
  protected $table = 'drivers';
  protected $fillable = [
  	'nik',
  	'name',
  	'username',
  	'password',
		'picture',
		'no_telp',
		'default_car_id',
		'is_available',
		'is_ontrip',
		'created_by',
		'is_active'
	];

  public function car()
  {
      return $this->belongsTo('App\Cars', 'default_car_id');
  }

  public function task()
  {
      return $this->hasMany('App\Tasks', 'driver_id');
  }

}
