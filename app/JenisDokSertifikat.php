<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisDokSertifikat extends Model
{
    protected $table = "ms_jns_dok_srtf";
    protected $guarded = ["id"];

    // relasi ke master bid_sertifikat_alat
    public function bid_srft_alat(){
        return $this->belongsTo('App\masterBidSertifikatAlat','id_srft_alat');
    }

}
