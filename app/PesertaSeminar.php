<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PesertaSeminar extends Model
{
    //
    use SoftDeletes;
    public $timestamps = false;
    protected $table = "srtf_peserta_seminar";
    protected $fillable = ['id_seminar,id_peserta,status,no_srtf,no_urut_peserta'];

    // relasi many to many table peserta 
    public function peserta_r(){
        return $this->belongsTo('App\Peserta','id_peserta');
    }

    // relasi many to many table peserta 
    public function seminar_p(){
        return $this->belongsTo('App\Seminar','id_seminar','id');
    }
}
