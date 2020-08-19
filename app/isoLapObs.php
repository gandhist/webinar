<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class isoLapObs extends Model
{
    //
    use SoftDeletes;
    protected $table = "iso_lap_obs";
    protected $guarded = ['id'];

    // belongsto observasi
    public function observasi_r(){
        return $this->belongsTo('App\isoObservasi','id_obs');
    }
}
