<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class isoLapScope extends Model
{
    //
    use SoftDeletes;
    protected $table = "iso_lap_scope";

    // belongsto observasi
    public function scope_r(){
        return $this->belongsTo('App\isoScope','id_scope');
    }
}
