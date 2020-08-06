<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    //
    use SoftDeletes;
    protected $table = "srtf_peserta";
    protected $guarded = ['id'];

    // relasi ke table user
    public function user_r(){
        return $this->belongsTo('App\User','user_id');
    }

    // relasi many to many table peserta seminar pivot
    public function seminar_r(){
        return $this->hasMany('App\PesertaSeminar','id_peserta');
    }

    // relasi ke table badan usaha
    public function badan_usaha(){
        return $this->belongsTo('App\BuModel','instansi', 'id');
    }
}
