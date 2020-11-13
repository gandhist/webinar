<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SkpAk3 extends Model
{
    use SoftDeletes;
    protected $table = "skp_ak3";
    protected $guarded = ["id"];

    // relasi ke table skp_pjk3
    public function skp_pjk3(){
        return $this->belongsTo('App\SkpPjk3','id_skp_pjk3','id');
    }

    // relasi ke table personal
    public function personal(){
        return $this->belongsTo('App\Personal','id_personal','id');
    }

    // relasi ke table ms_bid_sertifikat_alat
    public function bid_sertifikat_alat(){
        return $this->belongsTo('App\masterBidSertifikatAlat','id_srtf_alat','id');
    }

    // relasi ke master bidang
    public function bidang_ak3(){
        return $this->belongsTo('App\BidangModel','id_bid_skp');
    }

    // relasi ke master jenis_dok
    public function jenisdok_ak3(){
        return $this->belongsTo('App\JenisDok','jns_dok');
    }

    // relasi ke table skp_pjk3
    public function skp_pjk3_inst(){
        return $this->belongsTo('App\SkpPjk3','id_skp_pjk3','id');
    }

    // relasi ke table badan_usaha
    public function badan_usaha_ak3(){
        return $this->belongsTo('App\BuModel','id_skp_pjk3','id');
    }

    // relasi ke table badan_usaha
    public function instansi_ak3(){
        return $this->belongsTo('App\BuModel','instansi_skp','id');
    }

    // Link ke table user dari field created_by
    public function created_r()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    // Link ke table user dari field updated_by
    public function updated_r()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }

}
