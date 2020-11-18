<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GolHargaProd extends Model
{
    //
    protected $table = "gol_harga_prod";
    protected $guarded = ['id'];

    // relasi ke Master Bidang Sertifikat Alat
    public function sertifikat_r(){
        return $this->belongsTo('App\masterBidSertifikatAlat','id_sertifikat');
    }

    // relasi ke Master Bidang Sertifikat Alat
    public function bidang_r(){
        return $this->belongsTo('App\BidangModel','id_bidang');
    }

    // relasi ke Master Bidang Sertifikat Alat
    public function jenis_usaha_r(){
        return $this->belongsTo('App\JenisUsaha','jenis_usaha');
    }
}
