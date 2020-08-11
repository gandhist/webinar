<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KlasifikasiModel extends Model
{
    //
    protected $table = "ms_bidang_klasifikasi_profesi";

    public function seminar_klas(){
        return $this->belongsTo('App\SeminarModel');
    }
}
