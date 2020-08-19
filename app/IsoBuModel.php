<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class IsoBuModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "iso_badan_usaha";

    // relasi belongs to badan usaha
    public function bu_p_r(){
        return $this->belongsTo('App\IsoBuKontakP','id','id_bu');
    }
}
