<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbsensiModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "absen";
    protected $guarded = ["id"];

    // relasi ke table peserta
    public function peserta_r(){
        return $this->belongsTo('App\Peserta','id_peserta');
    }


    // relasi many to many table peserta seminar pivot
    public function peserta_seminar_r(){
        return $this->belongsTo('App\PesertaSeminar','id_peserta_seminar');
        // return $this->hasMany('App\PesertaSeminar','id','id_peserta_seminar');
    }
}
