<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BidangModel extends Model
{
    //
    //
    protected $table = "ms_bidang";
    protected $guarded = ["id"];

        // relasi ke master bidang
        public function jenis_usaha(){
            return $this->belongsTo('App\JenisUsaha','id_jns_usaha');
        }

}
