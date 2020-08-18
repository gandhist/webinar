<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class KlasifikasiModel extends Model
{
    //
    // use SoftDeletes;
    protected $table = "ms_bidang_klasifikasi_profesi";

    public function seminar_klas(){
        return $this->belongsTo('App\SeminarModel');
    }
}
