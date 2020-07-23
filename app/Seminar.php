<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seminar extends Model
{
    //
    use SoftDeletes;
    protected $table = "srtf_seminar";
    protected $guarded = ['id'];

    // relasi many to many table peserta seminar pivot
    public function seminar_r(){
        return $this->hasMany('App\PesertaSeminar','id_seminar')->where('status',2);
    }
}
