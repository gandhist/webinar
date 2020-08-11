<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubKlasifikasiModel extends Model
{
    //
    protected $table = "ms_sub_bidang_keahlian_kbli";


    public function seminar_sub(){
        return $this->belongsTo('App\SeminarModel');
    }
}
