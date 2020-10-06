<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisUsaha extends Model
{
    //
    //
    protected $table = "ms_jenis_usaha";

    // relasi ke master badan usaha
    public function badan_usaha(){
        return $this->belongsTo('App\BUModel','id','jns_usaha');
    }
}
