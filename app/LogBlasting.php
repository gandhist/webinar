<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogBlasting extends Model
{
    //
    protected $table = "srtf_log_blasting";

    public function seminar() {
        return $this->hasOne('App\Seminar','id','id_seminar');
    }
}
