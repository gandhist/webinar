<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class isoStandard extends Model
{
    //
    use SoftDeletes;
    protected $table = "iso_standard";

    // relasi ke table iso doc 
    public function doc_r(){
        return $this->hasMany('App\isoDoc','id_iso');
    }

    // relasi ket able observasi 
    public function observasi_r(){
        return $this->hasMany('App\isoObservasi','id_iso');
    }
}
