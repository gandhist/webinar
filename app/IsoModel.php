<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IsoModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "iso";
    protected $guarded = ["id"];

    // relasi provinsi
    public function prov_r(){
        return $this->belongsTo('App\ProvinsiModel','id_prov');
    }

    // relasi kota
    public function kota_r(){
        return $this->belongsTo('App\KotaModel','id_kota');
    }

    // relasi negara
    public function negara_r(){
        return $this->belongsTo('App\NegaraModel','id_negara');
    }

    // relasi belongsto iso
    public function iso_r(){
        return $this->belongsTo('App\isoStandard','tipe_iso');
    }

    // relasi belongsto iso
    public function lap_r(){
       return  $this->belongsTo('App\Laporan','id_laporan');
    }

    // belongs to status
    public function status_r(){
        return $this->belongsTo('App\StatusModel','status');
    }
}
