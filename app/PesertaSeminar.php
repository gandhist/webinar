<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesertaSeminar extends Model
{
    //
    protected $table = "srtf_peserta_seminar";
    protected $fillable = ['id_seminar,status'];

    // relasi many to many table peserta 
    public function peserta_r(){
        return $this->belongsTo('App\Peserta','id_peserta');
    }
}
