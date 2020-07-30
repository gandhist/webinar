<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeminarModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "srtf_seminar";
    protected $guarded = "id";

    // relasi ke table peserta
    public function peserta(){
        return $this->hasMany('App\SertModel','id_seminar');
    }

    // relasi ke instansi penyelenggara
    public function penyelenggara(){
        return $this->hasMany('App\SertModel','id_seminar');
    }
}
