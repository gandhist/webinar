<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GolHargaMkt extends Model
{
    protected $table = "gol_harga_mkt";
    protected $guarded = ['id'];

    // relasi ke Master Bidang Sertifikat Alat
    public function sertifikat_r(){
        return $this->belongsTo('App\masterBidSertifikatAlat','id_sertifikat');
    }

    // relasi ke Master Bidang Sertifikat Alat
    public function bidang_r(){
        return $this->belongsTo('App\masterBidang','id_bidang');
    }

    // relasi ke Master Bidang Sertifikat Alat
    public function jenis_usaha_r(){
        return $this->belongsTo('App\JenisUsaha','jenis_usaha');
    }
}
