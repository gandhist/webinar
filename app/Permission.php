<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
  protected $table = 'permission';

  public function role()
  {
    return $this->hasMany('App\RolePermission', 'permission_id');
  }
}
