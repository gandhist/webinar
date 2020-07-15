<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SpftDeletes;

class Peserta extends Model
{
    //
    use SpftDeletes;
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
}
