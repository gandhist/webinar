<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class SubKlasifikasiModel extends Model
{
    //
    // use SoftDeletes;
    protected $table = "ms_sub_bidang_keahlian_kbli";


    public function seminar_sub(){
        return $this->belongsTo('App\SeminarModel');
    }
}
