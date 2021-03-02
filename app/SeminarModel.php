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

    // public function getLokasiPenyelenggaraAttribute($value)
	// {
	// 	return iconv('utf-8//TRANSLIT', 'UTF-8', $value);
	// }

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
    public function narasumber(){
        return $this->hasMany('App\PesertaSeminar','id_seminar')->where('status',2);
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

    public function peserta_sem()
    {
        return $this->hasMany('App\PesertaSeminar', 'id_seminar', 'id');
    }

    public function getJumlahPesertaAttribute()
    {
        return $this->peserta_sem()->whereNull('deleted_at')->whereNull('deleted_by')->count();
    }

    public function getJumlahPesertaTerdaftarAttribute()
    {
        return $this->peserta_sem()->whereNull('deleted_at')->whereNull('deleted_by')->count();
    }

    public function getJumlahPesertaMembayarAttribute()
    {
        return $this->peserta_sem()->whereNull('deleted_at')->whereNull('deleted_by')->where('is_paid', 1)->count();
    }

    public function provinsi_r()
    {
        return $this->hasOne('App\ProvinsiModel', 'id', 'prov_penyelenggara');
    }

    public function kota_r()
    {
        return $this->hasOne('App\KotaModel', 'id', 'kota_penyelenggara');
    }

    public function tuk_r()
    {
        return $this->hasOne('App\TUKModel', 'id', 'tuk');
    }
}
