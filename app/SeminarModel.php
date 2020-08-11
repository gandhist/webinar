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

    // relasi many to many table peserta seminar pivot
    public function seminar_r(){
        return $this->hasMany('App\PesertaSeminar','id_seminar')->where('status',1);
    }

    // relasi many to many table peserta seminar pivot
    public function seminar_paid(){
        return $this->hasMany('App\PesertaSeminar','id_seminar')->where('status',1)->where('is_paid',1);
    }

    // relasi ke table peserta
    public function seminar_klas(){
        return $this->hasOne('App\KlasifikasiModel','ID_Bidang_Profesi','klasifikasi');
    }
    // relasi ke table peserta
    public function seminar_sub(){
        return $this->hasOne('App\SubKlasifikasiModel','ID_Sub_Bidang_Keahlian','sub_klasifikasi');
    }
}
