<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "badan_usaha";

    // relasi belongs to badan usaha
    public function bu_p_r(){
        return $this->belongsTo('App\BuKontakP','id','id_bu');
    }
}
