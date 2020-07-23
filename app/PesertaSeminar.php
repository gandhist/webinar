<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesertaSeminar extends Model
{
    //
    protected $table = "srtf_peserta_seminar";

    // relasi many to many table peserta 
    public function peserta_r(){
        return $this->belongsTo('App\Peserta','id_peserta');
    }
}
