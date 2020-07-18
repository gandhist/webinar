<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProvinsiModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "ms_provinsi";

    // relasi has many kota
    public function kota(){
        return $this->hasMany('App\KotaModel','provinsi_id');
    }



}
