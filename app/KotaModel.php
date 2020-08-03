<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KotaModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "ms_kota";

    // relasi belongs to provinsi
    public function provinsi(){
        return $this->belongsTo('App\ProvinsiModel','provinsi_id');
    }

}
