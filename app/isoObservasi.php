<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class isoObservasi extends Model
{
    //
    use SoftDeletes;
    protected $table = "iso_observasi";

    // relasi belongsto ke table iso standard
    public function iso_r(){
        return $this->belongsTo('App\isoStandard','id_iso');
    }
}
