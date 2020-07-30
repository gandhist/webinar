<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenyModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "srtf_penyelenggara";
    protected $guarded = "id";

    public function bu_peny(){
        return $this->belongsTo('App\BuModel', 'id_instansi');
    }

}
