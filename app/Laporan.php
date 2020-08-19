<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
    //
    use SoftDeletes;
    protected $table = "iso_laporan";

    // relasi hasmany scope
    public function scope_r(){
        return $this->hasMany('App\isoLapScope','id_laporan');
    }

    // relasi belongs to badan usaha
    public function bu_r(){
        return $this->belongsTo('App\IsoBuModel','id_bu');
    }

    // has many satf
    public function obs_r(){
        return $this->hasMany('App\isoLapObs','id_laporan');
    }

    // belongs to doc
    public function doc_r(){
        return $this->belongsTo('App\isoDoc','doc');
    }

    // belongs to doc
    public function iso_r(){
        return $this->belongsTo('App\isoStandard','iso_standard');
    }

    // belongs to status
    public function status_r(){
        return $this->belongsTo('App\StatusModel','status');
    }

}
